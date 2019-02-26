<?php
/**
 * Created by IntelliJ IDEA.
 * User: xiaoer
 * Date: 2019/2/26
 * Time: 13:03
 */

namespace App\Exceptions;
// 自定义错误

class BaseException extends \Exception{
    protected $title = '自定义异常';
    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code ?: $code, $previous);
    }

    public function getTitle(){
        return $this->title;
    }
}
