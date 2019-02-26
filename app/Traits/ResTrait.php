<?php
/**
 * Created by IntelliJ IDEA.
 * User: xiaoer
 * Date: 2019/1/30
 * Time: 10:54
 */

namespace App\Traits;

// 处理返回消息 判断ajax或者页面
use App\Exceptions\ErrorResException;

trait ResTrait{

    // 成功不返回view （以后有需要在处理）
    protected function success($msg='',$data=[]){
        $msg = empty($msg)?'成功':$msg;
        $data = empty($data)?[]:$data;

        return ['code'=>1,'msg'=>$msg,'data'=>$data];
    }

    protected function error($msg='',$data=[]){
        $msg = empty($msg)?'出错了':$msg;
        $data = empty($data)?[]:$data;

        if(request()->ajax()){
            throw new ErrorResException($msg);
        }

        $data['msg']=$msg;
        return response()->view('admin.error',$data);
    }

}
