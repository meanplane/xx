<?php
/**
 * Created by IntelliJ IDEA.
 * User: xiaoer
 * Date: 2019/1/28
 * Time: 11:50
 */

namespace App\Http\Controllers\Admin;


class IndexController extends Controller {

    public function index(){

        return view('admin.index');
    }

    // 修改自己信息
    public function updateInfo(){
        if(!request()->ajax()){
            return view('admin.updateInfo');
        }
        return $this->success('xx');
    }

    // 修改自己密码
    public function updatePass(){

//        if(!request()->ajax()){
//            return view('admin.updatePass');
//        }
        return $this->error('404 权限不够');
    }
}