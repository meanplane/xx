<?php
/**
 * Created by IntelliJ IDEA.
 * User: xiaoer
 * Date: 2019/1/28
 * Time: 11:50
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
{
    public function lists()
    {
        if (!request()->ajax()) {
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

}