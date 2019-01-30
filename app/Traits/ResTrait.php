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


    protected function success($msg=''){
        $msg = empty($msg)?'成功':$msg;

        if(request()->ajax()){
            return ['code'=>1,'msg'=>$msg];
        }
        return view('admin.success');
    }

    protected function error($msg=''){
        $msg = empty($msg)?'出错了':$msg;

        if(request()->ajax()){
            return ['code'=>0,'msg'=>$msg];
        }
        return view('admin.error');
    }

}