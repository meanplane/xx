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
            return $this->view();
        }

        $params = request()->all();

        $data = m('admin.menu')->allMenuTree($params);

        return $this->success('',$data);
    }

    public function del(){
        $id = request('id');

        if(is_array($id)){
            $res = m('admin.menu')->whereIn('id',$id)->delete();
        }else{
            $res = m('admin.menu')->where('id',$id)->delete();
        }

        if($res){
            return $this->success('删除成功!');
        }
        return $this->error();
    }

    public function add(){
        $m = m('admin.menu');
        $params = request($m->fillable); //可以添加或修改的参数

        if($params['parentid']===null){
            $params['parentid']=0;
        }
        $res = $m->create($params);
        if($res->a=='lists'){
            $params['parentid']=$res->id;
            $params['icon']='';
            $params['status']=2;

            $params['name']='添加';
            $params['a']='add';
            $m->create($params);

            $params['name']='修改';
            $params['a']='edit';
            $m->create($params);

            $params['name']='删除';
            $params['a']='del';
            $m->create($params);
        }

        if($res){
            return $this->success('添加成功');
        }
        return $this->error();
    }

    public function edit(){
        $m = m('admin.menu');
        $params = request($m->fillable); //可以添加或修改的参数
        if($params['parentid']===null){
            $params['parentid']=0;
        }
        $rs = $m->where('id', request('id'))->update($params);
        if ($rs) {
            return $this->success('修改成功');
        } else {
            return $this->error();
        }
    }

}