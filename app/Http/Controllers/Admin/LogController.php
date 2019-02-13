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

//        $where = [];
//        if (request('start_time') && request('end_time')) {
//            $where[] = ['t1.created_at', '>=', strtotime(request('start_time'))];
//            $where[] = ['t1.created_at', '<=', strtotime(request('end_time'))];
//        }
//        if (request('name')) {
//            $where[] = ['t2.name', 'like', '%' . request('name') . '%'];
//        }
//        if (request('admin_name')) {
//            $where[] = ['t3.admin_name', request('admin_name')];
//        }
//        if (request('ip')) {
//            $where[] = ['t1.ip', request('ip')];
//        }
//
//
//        $lists = $this->M->from('admin_log as t1')
//            ->select('t2.name as menu_name','t2.c','t2.a','t1.id','t1.querystring','t1.ip','t1.admin_id','t1.created_at','t1.data','t3.name as admin_name','t3.realname')
//            ->where($where)
//            ->leftJoin('admin_menu as t2','t1.menu_id','=','t2.id')
//            ->leftJoin('admin_user as t3','t1.admin_id','=','t3.id')
//            ->orderBy('t1.id', 'desc')
//            ->paginate(20);
//        return $this->view(compact('lists'));


        // 分页
        $limit = request()->input('limit',10);
        $page = request()->input('page',1);

        $title = request()->input('title','');

        $query = $xx->where('title','like','%'.$title.'%');

        $count = $query->count();
        $data = $query->offset(($page-1)*$limit)
            ->limit($limit)
            ->get()->toArray();

        return $this->success('',compact('count','data'));
    }


}