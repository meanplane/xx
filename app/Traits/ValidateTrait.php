<?php
/**
 * Created by IntelliJ IDEA.
 * User: xiaoer
 * Date: 2019/1/30
 * Time: 10:54
 */

namespace App\Traits;

// 处理返回消息 判断ajax或者页面

use App\Exceptions\ValidateException;
use Illuminate\Support\Facades\Validator;

trait ValidateTrait{

    // 成功不返回view （以后有需要在处理）
    public function validate($rules,$messages){
        $validator = Validator::make(request()->all(), $rules, $messages);
        if ($validator->fails()) {
            $errors = $validator->errors();

            throw new ValidateException($this->error2message($errors->messages()));
        }
    }

    // 转化错误消息为 string
    private function error2message($errors){
        $str = '<br>';

        foreach ($errors as $key => $value){
            $str .= $key.' -> [' ;
            $str .= implode(' , ',$value);
            $str .= ']<br>';
        }

        return $str;
    }
}
