<?php
/**
 * Created by IntelliJ IDEA.
 * User: xiaoer
 * Date: 2019/1/28
 * Time: 16:40
 */

namespace App\Models\Admin;

use App\Models\BaseModel;

class Log extends BaseModel {
    public $dateFormat = 'U';
    public $timestamps = true;
    protected $table = 'admin_log';
    protected $guarded = []; //不可以注入

    /**
     * 获取日志详情
     * @param $id
     * @return mixed
     */
    public function getInfo($id){
        $info = $this->select(
            't1.id',
            't1.menu_id',
            't1.querystring',
            't1.data',
            't1.ip',
            't3.name as user',
            't1.created_at',
            't1.primary_id',
            't2.c',
            't2.a',
            't2.name'
        )
            ->where('t1.id',$id)
            ->from('admin_log as t1')
            ->leftJoin('admin_menu as t2','t2.id','=','t1.menu_id')
            ->leftJoin('admin_user as t3','t1.admin_id','=','t3.id')
            ->first();
        return $info;
    }
}