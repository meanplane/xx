<?php
/**
 * Created by IntelliJ IDEA.
 * User: xiaoer
 * Date: 2019/2/26
 * Time: 13:19
 */
namespace App\Exceptions;

class ValidateException extends \Exception{
    protected $title = '验证错误';

    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code ?: $code, $previous);
    }

    public function getTitle(){
        return $this->title;
    }
}
