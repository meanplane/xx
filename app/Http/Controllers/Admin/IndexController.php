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
        $menuTree = m('admin.menu')->myMenuTree();
        return view('admin.index',compact('menuTree'));
    }

    // 修改自己信息
    public function updateInfo(){
        if(!request()->ajax()){
            $userInfo = request()->user('admin')->toArray();
            return view('admin.updateInfo',compact('userInfo'));
        }

        $id = request('id');
        $params = request(['mobile','realname','email']);
        m('admin.user')->where('id',$id)->update($params);

        return $this->success('修改成功');
    }

    // 修改自己密码
    public function updatePass(){
        if(!request()->ajax()){
            $userInfo = request()->user('admin')->toArray();
            return view('admin.updatePass',compact('userInfo'));
        }

        $id = request('id');
        $password = request('password');

        if(empty($password) || strlen($password)<4){
            return $this->error('新密码不能为空,且必须大于 4 位!');
        }

        m('admin.user')->where('id',$id)->update(['password'=> bcrypt(request('password'))]);
        return $this->success('修改成功');
    }
}