<?php
/**
 * Created by IntelliJ IDEA.
 * User: xiaoer
 * Date: 2019/1/28
 * Time: 16:40
 */

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class GroupAccess extends Model{
    protected $table = 'admin_group_access';
    public $dateFormat = 'U';
    public $timestamps = false;
    public $fillable = ['admin_id', 'group_id'];
    public $rules = [
        'admin_id' => 'required',
        'group_id' => 'required',
    ];

    /**
     *保存分组
     * @param type int $admin_id
     * @param type Array $group_ids
     */
    public function store($admin_id, $group_ids)
    {
        $this->del($admin_id);
        foreach ($group_ids as $group_id) {
            static::create(['admin_id' => $admin_id, 'group_id' => $group_id]);
        }
    }

    /**
     * 删除表中用户
     * @param type $admin_id
     */
    public function del($admin_id)
    {
        static::where('admin_id', $admin_id)->delete();
    }

    /**
     * 根据类型id获取信息
     */
    public function getAdminGroupAccess($id, $type = 'admin_id')
    {

        $where = [];
        if ($id) {
            if ($type == 'admin_id') {
                $where[] = ['t1.admin_id', $id];
            } else {
                $where[] = ['t1.group_id', $id];
            }
        }

        $res = static::select('t2.id', 't2.name')
            ->from('admin_group_access as t1')
            ->leftJoin('admin_group as t2', 't1.group_id', '=', 't2.id')
            ->where($where)->get()->toArray();
        //echo implode(',',array_column($res,'id'));

        return $res;
    }
}