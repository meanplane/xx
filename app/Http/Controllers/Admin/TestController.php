<?php
/**
 * Created by IntelliJ IDEA.
 * User: xiaoer
 * Date: 2019/1/28
 * Time: 11:50
 */

namespace App\Http\Controllers\Admin;

use App\Traits\RequestTrait;
use App\Traits\ValidateTrait;

class TestController extends Controller
{
    use ValidateTrait,RequestTrait;
    public function lists()
    {
        if (!request()->ajax()) {
            $roles = m('admin.group')->pluck('name', 'id')->toArray();
            $levels = [1 => '普通', 2 => '主管', 3 => '经理'];
            $statuss = [1 => '正常', 2 => '禁用'];

            return $this->view(compact('roles', 'levels', 'statuss'));
        }

        $where = $this->getWhere(['like'],['type','status']);
        $res = m('admin.user')->getLists($where, request('limit'), request('page'));

        return $this->success('', $res);
    }

    public function add()
    {
        return $this->storage();
    }

    public function edit()
    {
        return $this->storage();
    }

    private function storage()
    {
        $m = m('admin.user');
        $data = request()->all();
        unset($data['groups']);
        if ($id = request('id')) {
            $this->validate($m->rules,$m->messages);
            $rs = $m->where('id', $id)->update($data);
            $admin_id = $id;
        } else {
            //添加
            if ($m->where('name', $data['name'])->value('id')) {
                return $this->error('用户已存在');
            }

            $this->validate($m->rules,$m->messages);

            // 初始密码全部为 账号名
            $data['password'] = bcrypt($data['name']);
            $rs = $m->create($data);
            $admin_id = $rs->id;
        }

        if (request('groups')) {
            m('admin.groupAccess')->store($admin_id, request('groups'));
        } else {
            m('admin.groupAccess')->del($admin_id);
        }

        if ($rs) {
            return $this->success('添加成功');
        } else {
            return $this->error();
        }
    }

    public function del()
    {
        $res = m('admin.user')->where('id', request('id'))->delete();
        if ($res) {
            return $this->success('删除成功!');
        }
        return $this->error();
    }

    public function changePwd()
    {
        $info = m('admin.user')->find(request('id'));

        if (!$info) {
            return $this->error('非法请求');
        }

        $this->validate([
            'password' => 'required|min:3|max:20',
        ], [
            'password.required' => '密码不能为空',
        ]);

        $res = m('admin.user')->where('id', request('id'))->update(['password' => bcrypt(request('password'))]);
        if ($res) {
            return $this->success('修改成功');
        }
        return $this->error();
    }
}
