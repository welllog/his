<?php

namespace App\Service;


use App\Common\Enum\HttpCode;
use App\Model\Admin;
//use App\Model\Loan;
//use App\Model\LoanPeriods;
//use App\Model\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class AdminService extends BaseService
{
    protected $pwdCost = 12;

    /**
     * 后台用户登录
     */
    public function login(string $username, string $password, bool $remember) : bool
    {
        $admin = Admin::where('username', $username)->first();
        if (!$admin) {
            $this->error = '账号或密码错误';
            $this->httpCode = HttpCode::NOT_FOUND;
            return false;
        }
        if ($admin->status != Admin::ACTIVE_STATUS) {
            $this->error = '该账号未激活';
            $this->httpCode = HttpCode::FORBIDDEN;
            return false;
        }
        $re = password_verify($password, $admin->password);
        if (!$re) {
            $this->error = '账号或密码错误';
            $this->httpCode = HttpCode::BAD_REQUEST;
            return false;
        }
        Auth::guard('admin')->login($admin, $remember);
        (new Admin())->cacheRules($admin->id);
        return true;

    }

    /**
     * 添加后台管理员
     * @param $data
     * @return array|bool
     */
    public function addAdmin(array $data) : bool
    {
        if ($data['password'] != $data['password_confirmation']) {
            $this->error = '两次输入的密码不一致';
            $this->httpCode = HttpCode::BAD_REQUEST;
            return false;
        }
        unset($data['password_confirmation']);
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT, ['cost' => $this->pwdCost]);
        $has = Admin::where('tel', $data['tel'])->count();
        if ($has > 0) {
            $this->error = '该手机号已存在';
            $this->httpCode = HttpCode::CONFLICT;
            return false;
        }
        $has = Admin::where('username', $data['username'])->count();
        if ($has > 0) {
            $this->error = '该用户名已存在';
            $this->httpCode = HttpCode::CONFLICT;
            return false;
        }
        DB::beginTransaction();
        $admin = Admin::create($data);
        $re = $admin->roles()->sync($data['role_id']);
        if (!$admin || $re === false) {
            $this->error = '添加失败';
            $this->httpCode = HttpCode::BAD_REQUEST;
            DB::rollBack();
            return false;
        }
        DB::commit();
        return true;

    }

    /**
     * 编辑管理员
     * @param $data
     * @return bool
     */
    public function editAdmin(array $data) : bool
    {
        $has = Admin::where('tel', $data['tel'])->where('id', '!=', $data['id'])->count();
        if ($has > 0) {
            $this->error = '该手机号已存在';
            $this->httpCode = HttpCode::CONFLICT;
            return false;
        }
        $has = Admin::where('username', $data['username'])->where('id', '!=', $data['id'])->count();
        if ($has > 0) {
            $this->error = '该用户名已存在';
            $this->httpCode = HttpCode::CONFLICT;
            return false;
        }
        $admin = Admin::find($data['id']);
        DB::beginTransaction();
        $admin->username = $data['username'];
        $admin->email = $data['email'];
        $admin->tel = $data['tel'];
        $re1 = $admin->save();
        $re2 = $admin->roles()->sync($data['role_id']);
        if ($re1 === false || $re2 === false) {
            $this->error = '添加失败';
            $this->httpCode = HttpCode::BAD_REQUEST;
            DB::rollBack();
            return false;
        }
        DB::commit();
        return true;
    }

    public function delAdmin(int $adminId) : bool
    {
        $admin = Admin::find($adminId);
        if (!$admin) {
            $this->error = '用户不存在';
            $this->httpCode = HttpCode::GONE;
            return false;
        }
        DB::beginTransaction();
        $re1 = $admin->roles()->detach();
        $re2 = $admin->delete();
        if ($re1 === false || $re2 === false) {
            $this->error = '删除失败';
            $this->httpCode = HttpCode::BAD_REQUEST;
            DB::rollBack();
            return false;
        }
        DB::commit();
        return true;
    }

    /**
     * @param $tel
     */
    public function changeTel(string $tel, int $adminId) : bool
    {
        $has = Admin::where('tel', $tel)->where('id', '!=', $adminId)->count();
        if ($has > 0) {
            $this->error = '该手机号已被占用';
            return false;
        }
        $re = Admin::where('id', $adminId)->update(['tel' => $tel]);
        if (!$re) {
            $this->error = '修改失败';
            return false;
        }
        return true;
    }

    /**
     * 修改密码
     * @param $password
     * @param $passwordConfirm
     * @param $adminId
     * @return bool
     */
    public function changePassword(array $data, int $adminId) : bool
    {
        if ($data['newpwd'] != $data['pwdconfirm']) {
            $this->error = '两次密码输入不一致';
            $this->httpCode = HttpCode::BAD_REQUEST;
            return false;
        }
        $admin = Admin::find($adminId);
        if (!password_verify($data['oldpwd'], $admin->password)) {
            $this->error = '原始密码输入错误';
            $this->httpCode = HttpCode::BAD_REQUEST;
            return false;
        }
        $admin->password = password_hash($data['newpwd'], PASSWORD_DEFAULT, ['cost' => $this->pwdCost]);
        $re = $admin->save();
        if (!$re) {
            $this->error = '修改失败';
            $this->httpCode = HttpCode::NOT_ACCEPTABLE;
            return false;
        }
        return true;
    }

    public function getSystemInfo() : array
    {
        $mysqlVs = DB::select('SELECT VERSION() AS ver'); // mysql 版本
        $redisInfo = Redis::info();

        $systemInfo = [
            'url'             => $_SERVER['HTTP_HOST'],   // 域名
            'document_root'   => $_SERVER['DOCUMENT_ROOT'], // 网站目录
            'server_os'       => PHP_OS,                    // 服务器系统
            'server_port'     => $_SERVER['SERVER_PORT'],   // web服务端口号
            'server_ip'       => $_SERVER['SERVER_ADDR'],   // 服务器ip
            'server_soft'     => $_SERVER['SERVER_SOFTWARE'], // web运行环境
            'php_version'     => PHP_VERSION,               // php版本
            'mysql_version'   => $mysqlVs[0]->ver,          // mysql版本
            'redis_version'   => $redisInfo['redis_version'], // redis版本
            'max_upload_size' => ini_get('upload_max_filesize') // 上传文件大小
        ];
        return $systemInfo;
    }

}