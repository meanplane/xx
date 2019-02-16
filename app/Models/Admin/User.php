<?php
/**
 * Created by IntelliJ IDEA.
 * User: xiaoer
 * Date: 2019/1/28
 * Time: 16:40
 */

namespace App\Models\Admin;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable{
    protected $table = 'admin_user';
    public $status_arr = [1 => '正常', 2 => '禁用'];
    public $level_arr = [1 => '普通', 2 => '主管',3 => '经理'];
    public $dateFormat = 'U';
    public $timestamps = true;
    protected $guarded = []; //不可以注入

    public $messages = [
        'name.required' => '账号不能为空',
        'password.required' => '密码不能为空',
        'groups.required'=>'角色不能为空'
    ];
    public $rules = [
        'name' => 'required|string|max:100|min:2',
        'password' => 'required|min:3|max:10',
        'groups'=>'required'
    ];

    public function getLists($where,$limit,$page)
    {
        $query = static::where($where)->orderBy('id', 'desc');


        $count = $query->count();
        $tableData = $query->offset(($page-1)*$limit)
                            ->limit($limit)->get()->toArray();

        foreach ($tableData as $k => $v) {
            if ($tmp = m('admin.groupAccess')->getAdminGroupAccess($v['id'])) {
                $tableData[$k]['groups'] = $tmp;
            }
        }
        return compact('count','tableData');
    }

}