<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;

class RulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('rules')->insert([
            ['title' => '权限管理', 'href' => null, 'rule' => null, 'pid' => 0, 'check' => 1, 'status' => 1, 'level' => 1, 'icon' => '&#xe614;', 'sort' => 0],
            ['title' => '权限列表', 'href' => '/admin/rules', 'rule' => null, 'pid' => 1, 'check' => 1, 'status' => 1, 'level' => 2, 'icon' => null, 'sort' => 0],
            ['title' => '用户组列表', 'href' => '/admin/roles', 'rule' => null, 'pid' => 1, 'check' => 1, 'status' => 1, 'level' => 2, 'icon' => null, 'sort' => 0],
            ['title' => '管理员列表', 'href' => '/admin/usersList', 'rule' => null, 'pid' => 1, 'check' => 1, 'status' => 1, 'level' => 2, 'icon' => null, 'sort' => 0],
            ['title' => '权限列表', 'href' => '/admin/rules', 'rule' => 'rulecontroller@rules', 'pid' => 2, 'check' => 1, 'status' => 0, 'level' => 3, 'icon' => null, 'sort' => 0],
            ['title' => '添加权限', 'href' => '/admin/rule/create', 'rule' => 'rulecontroller@addrule', 'pid' => 2, 'check' => 1, 'status' => 0, 'level' => 3, 'icon' => null, 'sort' => 0],
            ['title' => '编辑权限', 'href' => '/admin/rule/{id}/edit', 'rule' => 'rulecontroller@editrule', 'pid' => 2, 'check' => 1, 'status' => 0, 'level' => 3, 'icon' => null, 'sort' => 0],
            ['title' => '删除权限', 'href' => '/admin/rule', 'rule' => 'rulecontroller@deleterule', 'pid' => 2, 'check' => 1, 'status' => 0, 'level' => 3, 'icon' => null, 'sort' => 0],
            ['title' => '验证显示排序权限', 'href' => '/admin/rule', 'rule' => 'rulecontroller@editrulestatus', 'pid' => 2, 'check' => 1, 'status' => 0, 'level' => 3, 'icon' => null, 'sort' => 0],
            ['title' => '用户组列表', 'href' => '/admin/roles', 'rule' => 'rulecontroller@roles', 'pid' => 3, 'check' => 1, 'status' => 0, 'level' => 3, 'icon' => null, 'sort' => 0],
            ['title' => '添加用户组', 'href' => '/admin/role/create', 'rule' => 'rulecontroller@addrole', 'pid' => 3, 'check' => 1, 'status' => 0, 'level' => 3, 'icon' => null, 'sort' => 0],
            ['title' => '编辑用户组', 'href' => '/admin/role/{id}/edit', 'rule' => 'rulecontroller@editrole', 'pid' => 3, 'check' => 1, 'status' => 0, 'level' => 3, 'icon' => null, 'sort' => 0],
            ['title' => '删除用户组', 'href' => '/admin/role', 'rule' => 'rulecontroller@deleterole', 'pid' => 3, 'check' => 1, 'status' => 0, 'level' => 3, 'icon' => null, 'sort' => 0],
            ['title' => '配置用户组权限', 'href' => '/admin/role/{role_id}/rules', 'rule' => 'rulecontroller@setrules', 'pid' => 3, 'check' => 1, 'status' => 0, 'level' => 3, 'icon' => null, 'sort' => 0],
            ['title' => '保存用户组权限', 'href' => '/admin/role/{role_id}/rules', 'rule' => 'rulecontroller@storerules', 'pid' => 3, 'check' => 1, 'status' => 0, 'level' => 3, 'icon' => null, 'sort' => 0],
            ['title' => '管理员列表', 'href' => '/admin/usersList', 'rule' => 'rulecontroller@adminspage', 'pid' => 4, 'check' => 1, 'status' => 0, 'level' => 3, 'icon' => null, 'sort' => 0],
            ['title' => '管理员分页数据', 'href' => '/admin/users', 'rule' => 'rulecontroller@getadmins', 'pid' => 4, 'check' => 1, 'status' => 0, 'level' => 3, 'icon' => null, 'sort' => 0],
            ['title' => '添加管理员', 'href' => '/admin/user/create', 'rule' => 'rulecontroller@addadmin', 'pid' => 4, 'check' => 1, 'status' => 0, 'level' => 3, 'icon' => null, 'sort' => 0],
            ['title' => '编辑管理员', 'href' => '/admin/user/{id}/edit', 'rule' => 'rulecontroller@editadmin', 'pid' => 4, 'check' => 1, 'status' => 0, 'level' => 3, 'icon' => null, 'sort' => 0],
            ['title' => '启用管理员', 'href' => '/admin/user', 'rule' => 'rulecontroller@activeadmin', 'pid' => 4, 'check' => 1, 'status' => 0, 'level' => 3, 'icon' => null, 'sort' => 0],
            ['title' => '修改密码', 'href' => '/admin/user/password/edit', 'rule' => 'indexcontroller@editpassword', 'pid' => 0, 'check' => 0, 'status' => 0, 'level' => 1, 'icon' => null, 'sort' => 0],
        ]);

        $roleId = DB::table('roles')->insertGetId([
            'name' => '超级管理员',
            'sort' => 0
        ]);
        $roleId = 1;
        $rules = DB::table('rules')->pluck('id');
        $arr = [];
        foreach ($rules as $row) {
            $arr[] = [
                'role_id' => $roleId,
                'rule_id' => $row
            ];
        }
        DB::table('role_rule')->insert($arr);

        $adminId = DB::table('admins')->value('id');
        DB::table('admin_role')->insert([
            'admin_id' => $adminId,
            'role_id' => $roleId
        ]);

    }
}
