<?php
/**
 * Created by IntelliJ IDEA.
 * User: xiaoer
 * Date: 2019/1/28
 * Time: 11:50
 */

namespace App\Http\Controllers\Admin;

class GroupController extends Controller
{
    public function lists()
    {
        if (!request()->ajax()) {
            $allMenus = m('admin.menu')->allMenuTree([])['allMenus'];
            return $this->view(compact('roles', 'levels', 'statuss','allMenus'));
        }

        $where = [];

        if (request('name')) {
            $where[] = ['name', 'like', '%' . request('name') . '%'];
        }

        $limit = request('limit',10);
        $page = request('page',1);

        $query = m('admin.group')->where($where)->orderBy('id','desc');
        $count = $query->count();
        $tableData = $query->offset(($page-1)*$limit)
            ->limit($limit)->get()->toArray();

        return $this->success('', compact('count','tableData'));
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
        if(empty(request('name')) )
            return $this->error('权限名不能为空!');

        $m = m('admin.group');
        $data = request()->all();

        if ($id = request('id')) {
            $rs = $m->where('id', $id)->update($data);
        } else {
            //添加
            if ($m->where('name', $data['name'])->value('id')) {
                return $this->error('用户组已存在');
            }

            $rs = $m->create($data);
        }

        if ($rs) {
            return $this->success();
        } else {
            return $this->error();
        }
    }

    public function del()
    {
        m('admin.groupAccess')->where('group_id',request('id'))->delete();
        $res = m('admin.group')->where('id', request('id'))->delete();
        if ($res) {
            return $this->success('删除成功!');
        }
        return $this->error();
    }

}