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

/**
 * 数组转树
 * @param type $list
 * @param type $root
 * @param type $pk
 * @param type $pid
 * @param type $child
 * @return type
 */
function list_to_tree($list, $root = 0, $pk = 'id', $pid = 'parentid', $child = '_child')
{
    // 创建Tree
    $tree = array();
    if (is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] = &$list[$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId = 0;
            if (isset($data[$pid])) {
                $parentId = $data[$pid];
            }
            if ((string)$root == $parentId) {
                $tree[] = &$list[$key];
            } else {
                if (isset($refer[$parentId])) {
                    $parent = &$refer[$parentId];
                    $parent[$child][] = &$list[$key];
                }
            }
        }
    }
    return $tree;
}
