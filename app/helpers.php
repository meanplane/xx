<?php
/**
 * Created by IntelliJ IDEA.
 * User: xiaoer
 * Date: 2019/1/28
 * Time: 15:43
 */

// 获取 数据表orm
if (!function_exists('m')){
    function m($model)
    {
        $models = explode(".",$model);
        $models = array_map(function($item){
            return ucfirst(trim($item));
        },$models);
        $model = implode("\\",$models);

        static $arr = [];
        $path = "\\App\\Models\\" . $model;
        if (!isset($arr[$path])) {
            $class = new ReflectionClass($path);
            $arr[$path] = $class->newInstance();
        }
        return $arr[$path];
    }
}

function xx(){
    echo '<h1>xxx</h1>';
}

