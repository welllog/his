<?php

namespace App\Http\Controllers\Admin;

use App\Common\Enum\HttpCode;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use App\Models\Rule;
use App\Service\AdminService;
use App\Service\RuleService;
use Illuminate\Http\Request;

class RuleController extends Controller
{
    /**
     * 权限列表页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function rules()
    {
        $ruleModel = new Rule();
        $rules = $ruleModel->getRules();
        return view('admin.rule.rules', ['rules' => $rules]);
    }

    /**
     * 添加权限
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addRule(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'title' => 'required',
            ]);
            $ruleService = new RuleService();
            $re = $ruleService->addRule($request->all());
            if (!$re) return ajaxError($ruleService->getError(), $ruleService->getHttpCode());
            return ajaxSuccess([], '', 'success', HttpCode::CREATED);

        } else {
            $ruleModel = new Rule();
            $rules = $ruleModel->getRulesSelector();
            return view('admin.rule.addRule', ['rules' => $rules]);
        }
    }

    /**
     * 编辑权限
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editRule(Request $request)
    {
        if ($request->isMethod('put')) {
            $this->validate($request, [
                'title' => 'required',
            ]);
            $ruleService = new RuleService();
            $re = $ruleService->updateRule($request->all());
            if (!$re) return ajaxError($ruleService->getError(), $ruleService->getHttpCode());
            return ajaxSuccess();
        } else {
            $rule = Rule::find($request->id);
            $rules = (new Rule())->getRulesSelector();
            return view('admin.rule.editRule', ['rule' => $rule, 'rules' => $rules]);
        }
    }

    /**
     * 删除权限
     * @param Request $request
     * @return array
     */
    public function deleteRule(Request $request, RuleService $ruleService)
    {
        $re = $ruleService->deleteRule($request->id);
        if (!$re) return ajaxError($ruleService->getError(), $ruleService->getHttpCode());
        return ajaxSuccess();
    }

    /**
     * 添加角色
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addRole(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'name' => 'required',
            ]);
            $role = Role::create($request->all());
            if (!$role) return ajaxError('添加失败', HttpCode::BAD_REQUEST);
            return ajaxSuccess();
        } else {
            return view('admin.rule.addRole');
        }
    }

    /**
     * 编辑角色
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editRole(Request $request)
    {
        if ($request->isMethod('put')) {
            $this->validate($request, [
                'name' => 'required',
            ]);
            $re = Role::where('id', $request->id)->update(['name' => $request->name]);
            if (!$re) return ajaxError('修改失败', HttpCode::BAD_REQUEST);
            return ajaxSuccess();
        } else {
            $role = Role::find($request->id);
            return view('admin.rule.editRole', ['role' => $role]);
        }
    }

    /**
     * 删除角色
     * @param Request $request
     * @param RuleService $ruleService
     * @return array
     */
    public function deleteRole(Request $request, RuleService $ruleService)
    {
        $re = $ruleService->deleteRole($request->id);
        if (!$re) return ajaxError($ruleService->getError(), $ruleService->getHttpCode());
        return ajaxSuccess();
    }

    /**
     * 角色列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function roles()
    {
        $roles = Role::get();
        return view('admin.rule.roles', ['roles' => $roles]);
    }

    /**
     * 配置角色权限页面
     * @param Request $request
     * @param Role $role
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function setRules(Request $request, Role $role)
    {
        $rules = $role->ztreeRules($request->role_id);
        return view('admin.rule.setRules', ['rules' => json_encode($rules), 'role_id' => $request->role_id]);
    }


    /**
     * 配置角色权限
     * @param Request $request
     * @return array
     */
    public function storeRules(Request $request)
    {
        $re = Role::find($request->id)->rules()->sync($request->rules);
        if (!$re) return ajaxError('配置失败', HttpCode::BAD_REQUEST);
        return ajaxSuccess();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editRuleStatus(Request $request)
    {
        $re = Rule::where('id', $request->id)->update([$request->key => $request->val]);
        if (!$re) return ajaxError('修改失败', HttpCode::BAD_REQUEST);
        return ajaxSuccess();
    }

    /**
     * 后台用户列表页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminsPage()
    {
        return view('admin.rule.users');
    }

    /**
     * 获取后台用户分页数据
     * @param Request $request
     * @param Admin $admin
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAdmins(Request $request, Admin $admin)
    {
        $res = $admin->getAdmins($request->all());
        return ajaxSuccess($res['data'], $res['count']);
    }

    /**
     * 添加后台管理员
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addAdmin(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'username' => 'required',
                'password' => 'required',
                'password_confirmation' => 'required',
            ]);
            $adminService = new AdminService();
            $re = $adminService->addAdmin($request->all());
            if (!$re) return ajaxError($adminService->getError(), $adminService->getHttpCode());
            return ajaxSuccess([], '', 'success', HttpCode::CREATED);
        } else {
            $roles = Role::all();
            return view('admin.rule.addUser', ['roles' => $roles]);
        }
    }

    /**
     * 编辑后台管理员
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editAdmin(Request $request)
    {
        if ($request->isMethod('put')) {
            $this->validate($request, [
                'username' => 'required'
            ]);
            $adminService = new AdminService();
            $re = $adminService->editAdmin($request->all());
            if (!$re) return ajaxError($adminService->getError(), $adminService->getHttpCode());
            return ajaxSuccess();
        } else {
            $roles = Role::all()->toArray();
            $admin = Admin::with('roles')->find($request->id)->toArray();
            $hasRoles = array_column($admin['roles'], 'id');
            foreach ($roles as &$role) {
                if (in_array($role['id'], $hasRoles)) {
                    $role['checked'] = 1;
                } else {
                    $role['checked'] = 0;
                }
            }
            return view('admin.rule.editUser', ['roles' => $roles, 'admin' => $admin]);
        }
    }

    /**
     * 激活后台管理员
     */
    public function activeAdmin(Request $request)
    {
        $re = Admin::where('id', $request->id)->update(['status' => $request->status]);
        if (!$re) return ajaxError('修改失败', HttpCode::BAD_REQUEST);
        return ajaxSuccess();
    }

    public function delAdmin(Request $request)
    {
        $service = new AdminService();
        $re = $service->delAdmin($request->id);
        if (!$re) return ajaxError($service->getError(), $service->getHttpCode());
        return ajaxSuccess();
    }
}
