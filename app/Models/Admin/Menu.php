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

    public function getMenuName($where)
    {
        return static::where($where)->value('name');
    }
}