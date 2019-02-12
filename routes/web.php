<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Admin\LoginController@index');

Route::get('/info',function (){
    echo phpinfo();
});

if (!isset($_SERVER['argv'])) {
    $act = explode('?', $_SERVER['REQUEST_URI'])[0]; //请求

    if ($act != '/') {
        $method = strtolower($_SERVER['REQUEST_METHOD']); //方法
        $path = explode('/', trim($act, '/'));
        if(count($path)==3){
            Route::$method($act, ucfirst($path[0]).'\\' . ucfirst($path[1]) . 'Controller@' . $path[2]);
        }
    }
}


//Route::get('/xx',function (){
////    return view('/index');
//    echo m(' admin. xx .admin_user');
//});
//
//Route::get('/login',function (){
//    return view('admin.login');
//});

Route::get('/xx',function(){
    for($i=1;$i<137;$i++){
        $url = 'http://w3.jbzcjsj.rocks/pw/thread-htm-fid-106-page-'.$i.'.html';
        $query = \QL\QueryList::get($url);

        $res = $query->rules([
            'title'=>['h3>a','text'],
            'href'=>['h3>a','href']
        ])->query()->getData()->all();

        m('admin.xx')->insert($res);
    }



    echo 'ok';
});

Route::get('/vv',function(){
   $res = m('admin.xx')->count();
   dd($res);
});
