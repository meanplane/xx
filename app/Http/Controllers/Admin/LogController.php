<?php
/**
 * Created by IntelliJ IDEA.
 * User: xiaoer
 * Date: 2019/1/28
 * Time: 11:50
 */

namespace App\Http\Controllers\Admin;


class LogController extends Controller {

    public function index(){
//        $menuTree = m('admin.menu')->myMenuTree();
//        return view('admin.index',compact('menuTree'));
        if(!request()->ajax()){
            return view('admin.log');
        }

        $xx = m('admin.xx');
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