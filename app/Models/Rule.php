<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'role_rule', 'rule_id', 'role_id');
    }

    /**
     * 获取权限数据
     * @return array
     */
    public function getRulesSelector()
    {
        $rules = $this
            ->orderBy('sort', 'asc')
            ->select('id', 'title', 'pid', 'level')
            ->get()->toArray();
        return $this->tree($rules);
    }

    /**
     * 获取所有权限
     * @param string $field
     * @return array
     */
    public function getRules()
    {
        $rules = $this
            ->orderBy('sort', 'asc')
            ->get()->toArray();
        return $this->tree($rules);
    }


    public function tree($data , $lefthtml = '|— ' , $pid=0 , $lvl=0)
    {
        $arr = [];
        foreach ($data as $k => $v) {
            if ($v['pid'] == $pid) {
                $v['ltitle'] = str_repeat($lefthtml, $lvl) . $v['title'];
                $arr[] = $v;
                unset($data[$k]);
                $arr = array_merge($arr, $this->tree($data, $lefthtml, $v['id'], $lvl + 1));
            }
        }

        return $arr;
    }

}
