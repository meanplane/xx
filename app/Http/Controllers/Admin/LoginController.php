<?php
/**
 * Created by IntelliJ IDEA.
 * User: xiaoer
 * Date: 2019/1/28
 * Time: 11:50
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller as BaseController;

class LoginController extends BaseController{

    public function index(){
        if(isset(request()->user('admin')->id)){
//            return redirect('/')
        }
    }
}