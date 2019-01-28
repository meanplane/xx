<?php
/**
 * Created by IntelliJ IDEA.
 * User: xiaoer
 * Date: 2019/1/28
 * Time: 11:50
 */

namespace App\Http\Controllers\Admin;


class IndexController extends Controller {

    public function home(){
        return $this->view('admin/index');
    }
}