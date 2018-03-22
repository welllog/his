<?php

namespace App\Http\Controllers\Admin;

use App\Common\Enum\HttpCode;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Service\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        $user = Auth::guard('admin')->user();
        return view('admin.index.index', ['user' => $user]);
    }

    public function getMenu()
    {
        $id = Auth::guard('admin')->id();
        if (!$id) return ajaxError('您未登录', HttpCode::UNAUTHORIZED);
        $res = (new Admin())->getMenu($id);
        return $res;
    }

    public function forbidden()
    {
        return view('admin.403');
    }

    /**
     * 首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function main()
    {
        $systemInfo = (new AdminService())->getSystemInfo();
        return view('admin.index.main', ['system_info' => $systemInfo]);
    }

    /**
     * 修改密码
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editPassword(Request $request)
    {
        if ($request->isMethod('put')) {
            $id = Auth::guard('admin')->id();
            $service = new AdminService();
            $re = $service->changePassword($request->all(), $id);
            if (!$re) return ajaxError($service->getError(), $service->getHttpCode());
            return ajaxSuccess();
        } else {
            return view('admin.index.editPassword');
        }
    }


}
