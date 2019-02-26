<?php
/**
 * Created by IntelliJ IDEA.
 * User: xiaoer
 * Date: 2019/1/28
 * Time: 11:50
 */

namespace App\Http\Controllers\Admin;

use App\Traits\ResTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class LoginController extends BaseController{

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests,
        ResTrait;

    public function index(){
        if(isset(request()->user('admin')->id)){
            return redirect('admin/index/index');
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

        if (Auth::guard('admin')->attempt($params, $is_remember)) {
            if(request()->user('admin')->status==2){
                Auth::guard('admin')->logout();
                return $this->error('账号已停用');
            }
            return $this->success('登录成功!');
        } else {
            return $this->error('账号,密码错误');
        }
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return $this->success('退出登录！',['url'=>'/admin/login/index']);
    }
}
