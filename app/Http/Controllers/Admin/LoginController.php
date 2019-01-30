<?php
/**
 * Created by IntelliJ IDEA.
 * User: xiaoer
 * Date: 2019/1/28
 * Time: 11:50
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginController extends BaseController{

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    public function index(){
        if(isset(request()->user('admin')->id)){
            dd(request()->user('admin'));
        }else{
            return view('admin.login');
        }
    }

    public function login(){
        $this->validate(request(), [
            'name' => 'required',
            'password' => 'required'
        ]);
        $params = request(['name', 'password']);

        $is_remember = boolval(request('is_remember'));
//        dd($params);
        if (Auth::guard('admin')->attempt($params, $is_remember)) {

            if(request()->user('admin')->status==2){
                Auth::guard('admin')->logout();
                //return $this->error('账号已停用','/login/index');
                return Redirect::back()->withErrors('账号已停用');
            }
            return redirect('admin/adminHome/publicIndex');
        } else {
            return Redirect::back()->withErrors('账号密码不匹配');
        }
    }

    public function logout(){

    }
}