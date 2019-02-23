<?php
/**
 * Created by IntelliJ IDEA.
 * User: xiaoer
 * Date: 2019/1/28
 * Time: 11:50
 */

namespace App\Http\Controllers\Admin;


class LogController extends Controller {

    public function lists(){

        if(!request()->ajax()){
            return $this->view();
        }

        $where = [];
        if (request('timeRange') ) {
            $where[] = ['t1.created_at', '>=', strtotime(request('timeRange')[0])];
            $where[] = ['t1.created_at', '<=', strtotime(request('timeRange')[1])];
        }
        if (request('menu')) {
            $where[] = ['t2.name', 'like', '%' . request('menu') . '%'];
        }
        if (request('user')) {
            $where[] = ['t3.name','like' ,'%'. request('user') . '%'];
        }
        if (request('ip')) {
            $where[] = ['t1.ip','like','%'. request('ip').'%'];
        }

        // 分页
        $limit = request()->input('limit',10);
        $page = request()->input('page',1);

        $query = m('admin.log')->from('admin_log as t1')
            ->select('t2.name as menu_name','t2.c','t2.a','t1.id','t1.querystring','t1.ip','t1.admin_id','t1.created_at','t1.data','t3.name as admin_name','t3.realname')
            ->leftJoin('admin_menu as t2','t1.menu_id','=','t2.id')
            ->leftJoin('admin_user as t3','t1.admin_id','=','t3.id')
            ->where($where)
            ->orderBy('t1.id', 'desc');

        $count = $query->count();
        $query->offset(($page-1)*$limit)
            ->limit($limit);

        $tableData = $query->get()->toArray();

        return $this->success('',compact('count','tableData'));
    }

    //详情
    public function info()
    {
        $m = m('admin.log');
        $info = $m->getInfo(request('id'));

        //上次信息
        $where=[];
        $where[]=['menu_id',$info->menu_id];
        $where[]=['primary_id',$info->primary_id];
        $where[] = ['id','<',$info->id];
        $last_id = $m->where($where)->orderBy('id','desc')->value('id');

        if($last_id){
            $last_info = $m->getInfo($last_id);
        }else{
            $last_info=[];
        }

        $info->data = json_decode($info->data,true);

        if($info->data && $last_info && $last_info->data){
            $last_info->data = @json_decode($last_info->data,true);
            $last_info->data = $this->diffArr($info->data,$last_info->data);
        }

        return $this->success('',compact('info','last_info'));

    }

    //对比
    private function diffArr($info,$last_info,$key=''){
        static $arr;
        foreach($info as $k=>$v){
            if(!is_array($v)){
                if($v!=$last_info[$k]){
                    if($key){
                        $arr[$key][$k] ='<font color="red">'.$last_info[$k].'</font>';
                    }else{
                        $arr[$k] ='<font color="red">'.$last_info[$k].'</font>';
                    }
                }else{
                    $arr[$k]=$last_info[$k];
                }
            }else{
                return $this->diffArr($v,$last_info[$k],$k);
            }
        }
        return $arr;
    }
}