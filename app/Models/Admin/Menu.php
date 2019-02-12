<?php
namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

/**
 * Created by IntelliJ IDEA.
 * User: xiaoer
 * Date: 2019/1/31
 * Time: 11:30
 */

class Menu extends Model
{
    public $dateFormat = 'U';
    public $timestamps = true;
    protected $table = 'admin_menu';
    public $status_arr = ['1' => '显示', '2' => '不显示'];
    public $write_log_arr = ['1' => '记录', '2' => '不记录'];
    protected $guarded = []; //不可以注入
    public $fillable = ['name', 'parentid', 'icon', 'm', 'c', 'a', 'data', 'status', 'listorder', 'write_log']; //可以注入
    public $messages = [
        'name.required' => '名称不能为空',
        'c.required' => '文件不能为空',
        'a.required' => '方法不能为空',
        'status.required' => '状态不能为空'
    ];
    public $rules = [
        'name' => 'required|string|max:100|min:2',
        'c' => 'required|string',
        'a' => 'required|string',
        'status' => 'required|int',
    ];

//    public function getMenuName($where)
//    {
//        return static::where($where)->value('name');
//    }

    public function myMenu($status = 1)
    {
        $where = array();
        if ($status == 1) {
            $where[] = ['status', '=', 1];
        }
        $loginUser = request()->user('admin');

        $admin_id = $loginUser->id;

        //查看此人是否超级管理员组,如果是返回所有权限
        if ($loginUser->is_super == 1) {
            //超级管理员
            $menus = static::where($where)->orderBy('listorder', 'asc')->get()->toArray();
        } else {
            //查出用户所在组Id拥有的menus
            //select menus from erp_admin_group_access t1 left join erp_admin_group t2 on t1.group_id=t2.id where t1.admin_id=11
            $menu_arr = m('admin.groupAccess')
                ->from('admin_group_access as t1')
                ->leftJoin('admin_group as t2', 't1.group_id', '=', 't2.id')
                ->where('t1.admin_id', $admin_id)
                ->pluck('menus')->toArray();
            $menu_ids = array();
            foreach ($menu_arr as $k => $v) {
                if ($v) {
                    $menu_ids = array_unique(array_merge($menu_ids, explode(',', $v)));
                }
            }

            //菜单大于0查出
            if (count($menu_ids) > 0) {
                $menus = static::where($where)->wherein('id', $menu_ids)->orderBy('listorder', 'asc')->get()->toArray();
            } else {
                return false;
            }

        }
        return $menus;
    }


    public function myMenuTree(){
        $myMenu = $this->MyMenu(1);
        return list_to_tree($myMenu);
    }

    public function allMenuTree(){
        $menus = static::orderBy('listorder', 'asc')->get()->toArray();
        return list_to_tree($menus);
    }

    //下拉框菜单选择
    public function selectMenu()
    {
        $menus = static::orderBy('listorder', 'asc')->get()->toArray();
        $menus = node_tree($menus);

        $data = array();
        foreach ($menus as $k => $v) {
            $name = $v['level'] == 0 ? '<b>' . $v['name'] . '</b>' : '├─' . $v['name'];
            $name = str_repeat("│        ", $v['level']) . $name;
            $data[$v['id']] = $name;
        }
        $data[0] = '作为顶级菜单';
        return $data;
    }
}