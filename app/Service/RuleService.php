<?php
/**
 * Created by PhpStorm.
 * User: chentairen
 * Date: 2017/11/16
 * Time: 上午10:49
 */

namespace App\Service;


use App\Common\Enum\HttpCode;
use App\Models\Role;
use App\Models\Rule;
use Illuminate\Support\Facades\DB;

class RuleService extends BaseService
{
    /**
     * 添加权限
     * @param $param
     * @return bool
     */
    public function addRule(array $param) : bool
    {
        if ($param['rule']) {
            $has = Rule::where('rule', $param['rule'])->count();
            if ($has > 0) {
                $this->error = '该权限已存在';
                $this->httpCode = HttpCode::CONFLICT;
                return false;
            }
        }
        $level = Rule::where('id', $param['pid'])->value('level');
        if ($level >= 3) {
            $this->error = '权限最多只能三级';
            $this->httpCode = HttpCode::CONFLICT;
            return false;
        }
        $param['check'] = 1;
        $param['status'] = 0;
        if ($param['pid'] == 0) {
            $param['level'] = 1;
        } else {
            $param['level'] = $level + 1;
        }
        $param['sort'] = 0;
        $param['rule'] = strtolower($param['rule']);
        $rule = Rule::create($param);
        if (!$rule) {
            $this->error = '添加失败';
            $this->httpCode = HttpCode::BAD_REQUEST;
            return false;
        }
        return true;

    }

    /**
     * 更新权限
     * @param $param
     * @return bool
     */
    public function updateRule(array $param) : bool
    {
        if ($param['rule']) {
            $rule = Rule::where('rule', $param['rule'])->first();
            if ($rule && ($rule['id'] != $param['id'])) {
                $this->error = '该权限已存在';
                $this->httpCode = HttpCode::CONFLICT;
                return false;
            }
        }
        $save = [
            'title' => $param['title'],
            'href' => strtolower($param['href']),
            'rule' => $param['rule'],
            'icon' => $param['icon'],
        ];
        $re = Rule::where('id', $param['id'])->update($save);
        if (!$re) {
            $this->error = '更新失败';
            $this->httpCode = HttpCode::BAD_REQUEST;
            return false;
        }
        return true;

    }

    /**
     * 删除权限
     * @param $id
     * @return bool
     */
    public function deleteRule(int $id) : bool
    {
        $hasChild = Rule::where('pid', $id)->count();
        if ($hasChild > 0) {
            $this->error = '该权限存在子权限,不能被删除';
            $this->httpCode = HttpCode::FORBIDDEN;
            return false;
        }
        $rule = Rule::find($id);
        DB::beginTransaction();
        $re1 = $rule->roles()->detach();
        $re2 = $rule->delete();
        if (($re1 === false) || !$re2) {
            DB::rollBack();
            $this->error = '删除失败';
            $this->httpCode = HttpCode::BAD_REQUEST;
            return false;
        }
        DB::commit();
        return true;
    }

    /**
     * 删除角色
     * @param $roleId
     * @return bool
     */
    public function deleteRole(int $roleId) : bool
    {
        $role = Role::find($roleId);
        $has = $role->admins->count();
        if ($has > 0) {
            $this->error = '该角色下存在用户,不能删除';
            $this->httpCode = HttpCode::FORBIDDEN;
            return false;
        }
        DB::beginTransaction();
        $re1 = $role->admins()->detach();
        $re2 = $role->rules()->detach();
        $re3 = $role->delete();
        if (($re1 === false) || ($re2 === false) || !$re3) {
            DB::rollBack();
            $this->error = '删除失败';
            $this->httpCode = HttpCode::BAD_REQUEST;
            return false;
        }
        DB::commit();
        return true;
    }

}