<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = [];

    public function admins()
    {
        return $this->belongsToMany('App\Models\Admin', 'admin_role', 'role_id', 'admin_id');
    }

    public function rules()
    {
        return $this->belongsToMany('App\Models\Rule', 'role_rule', 'role_id', 'rule_id');
    }

    /**
     * 获得该角色权限
     * @param $roleId
     * @return array
     */
    public function ztreeRules(int $roleId) : array
    {
        $rulesIdArr = $this->find($roleId)->rules()->pluck('rules.id')->toArray();
        $allRulesArr = Rule::select('id', 'title', 'pid')->orderBy('sort', 'asc')->get()->toArray();
        $rules = $this->ztreeData($allRulesArr, $rulesIdArr);
        $rules[] = [
            "id"=>0,
            "pid"=>0,
            "title"=>"全部",
            "open"=>true
        ];
        return $rules;
    }

    public function ztreeData(array $data, array $checked, int $pid = 0) : array
    {
        $arr = [];
        foreach ($data as $k => $v) {
            if ($v['pid'] == $pid) {
                if (in_array($v['id'], $checked)) {
                    $v['checked'] = true;
                }
                $v['open'] = true;
                $arr[] = $v;
                unset($data[$k]);
                $arr = array_merge($arr, $this->ztreeData($data, $checked, $v['id']));
            }
        }
        return $arr;
    }
}
