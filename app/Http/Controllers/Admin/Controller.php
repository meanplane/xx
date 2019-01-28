<?php
/**
 * Created by IntelliJ IDEA.
 * User: xiaoer
 * Date: 2019/1/28
 * Time: 12:25
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController{

    protected $login_user;
    protected $m = 'admin';//模块
    protected $c, $a, $q, $path_info;
    protected $menu_info;//菜单详情
//    protected $city_id;//城市ID
    protected $site = '后台管理系统';//站点信息

    //初始化
    public function __construct()
    {
        DB::enableQueryLog();
        $this->middleware(function ($request, $next) {
            //登陆验证
            $this->login_user = $request->user('admin');
            if (!$this->login_user) {
                return $this->error('请登陆', '/login/index');
            }
            //城市信息
//            $this->city_id = session('city_id');
            //站点信息
//            $this->site = M('Site')->find(1);

            $this->_getPathInfo();//获取请求信息

            //当前请求菜单详情
            $this->menu_info = m('Menu')->where([['c', $this->c], ['a', $this->a]])->first();
            if ((!$this->menu_info) && (!preg_match('/^public/', $this->a))) {
                return $this->error('请求地址不存在,请添加!');
            }

            //检查请求权限
            if (!$this->_checkRole()) {
                return $this->error('没有权限');
            }
            //获取请求的module信息
            //$this->module_id = m('Module')->where('tablename',$this->c)->value('id');


            //记录日志
            if (isset($this->menu_info) && $this->menu_info->write_log == 1) {
                $this->_saveLog($this->menu_info->id);
            }


            return $next($request);
        });

    }


}