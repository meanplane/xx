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
if(!function_exists('list_to_tree')){
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
}

if(!function_exists('node_tree')){
    function node_tree($arr, $id = 0, $level = 0)
    {
        static $array = array();
        foreach ($arr as $v) {
            if ($v['parentid'] == $id) {
                $v['level'] = $level;
                $array[] = $v;
                node_tree($arr, $v['id'], $level + 1);
            }
        }
        return $array;
    }
}


/**
 * GET 请求
 * @param string $url
 */
if (! function_exists('https_get')) {
    function https_get($url)
    {
        //  echo $url;
        //初始化
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $curl_options = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1, //返回原生的（Raw）输出
            CURLOPT_HEADER => 0,
            CURLOPT_TIMEOUT => 120, //超时时间
            CURLOPT_FOLLOWLOCATION => 1, //是否允许被抓取的链接跳转
            CURLOPT_POST => 0, //GET
            CURLOPT_ENCODING=>'gzip,deflate'
        );
        if (strpos($url,"https")!==false) {
            $curl_options[CURLOPT_SSL_VERIFYPEER] = false; // 对认证证书来源的检查
        }
        //执行命令
        curl_setopt_array($curl, $curl_options);
        $res = curl_exec($curl);
        $data = json_decode($res, true);
        if(json_last_error() != JSON_ERROR_NONE){
            $data = $res;
        }
        curl_close($curl);
        return $data;
    }
}
