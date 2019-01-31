<?php
/**
 * Created by IntelliJ IDEA.
 * User: xiaoer
 * Date: 2019/1/30
 * Time: 10:54
 */

namespace App\Traits;

// 处理返回消息 判断ajax或者页面
trait ResTrait{

    // 成功不返回view （以后有需要在处理）
    protected function success($msg='',$data=[]){
        $msg = empty($msg)?'成功':$msg;
        $data = empty($data)?[]:$data;

//        if(request()->ajax()){
            return ['code'=>1,'msg'=>$msg,'data'=>$data];
//        }

//        $data['msg']=$msg;
//        return response()->view('admin.success',$data);
    }

    protected function error($msg='',$data=[]){
        $msg = empty($msg)?'出错了':$msg;
        $data = empty($data)?[]:$data;

        if(request()->ajax()){
            return ['code'=>0,'msg'=>$msg,'data'=>$data];
        }

        $data['msg']=$msg;
        return response()->view('admin.error',$data);
    }

}