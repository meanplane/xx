<?php
/**
 * Created by IntelliJ IDEA.
 * User: xiaoer
 * Date: 2019/1/28
 * Time: 11:50
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function lists()
    {
        if (!request()->ajax()) {
            $roles = m('admin.group')->pluck('name', 'id')->toArray();
            $levels = [1 => '普通', 2 => '主管', 3 => '经理'];
            $statuss = [1 => '正常', 2 => '禁用'];

            return $this->view(compact('roles', 'levels', 'statuss'));
        }

        $where = [];

        if (request('title')) {
            $where[] = ['title', 'like', '%' . request('title') . '%'];
        }
        if (request('type')) {
            $where[] = ['type', request('type')];
        }
        if (request('status')) {
            $where[] = ['status', request('status')];
        }

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
            $rs = $m->where('id', $id)->update($data);
            $admin_id = $id;
        } else {
            //添加
            if ($m->where('name', $data['name'])->value('id')) {
                return $this->error('用户已存在');
            }

            // 自定义 验证消息
            $validator = Validator::make(request()->all(), $m->rules, $m->messages);
            if ($validator->fails()) {
                return ($this->error($validator->errors()));
            }

            $data['password'] = bcrypt($data['password']);
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

        $validator = Validator::make(request()->all(), [
            'password' => 'required|min:3|max:20',
        ], [
            'password.required' => '密码不能为空',
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $res = m('admin.user')->where('id', request('id'))->update(['password' => bcrypt(request('password'))]);
        if ($res) {
            return $this->success('修改成功');
        }
        return $this->error();
    }
}