<?php
/**
 * Created by IntelliJ IDEA.
 * User: xiaoer
 * Date: 2019/1/28
 * Time: 11:50
 */

namespace App\Http\Controllers\Admin;


class MenuController extends Controller {

    public function index(){

        if(!request()->ajax()){
            return view('admin.menu');
        }
        $allMenus = m('admin.menu')->allMenuTree();
        $selectMenus = m('admin.menu')->selectMenu();

        return $this->success('',compact('allMenus','selectMenus'));
    }


}