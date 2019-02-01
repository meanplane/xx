<?php
/**
 * Created by IntelliJ IDEA.
 * User: xiaoer
 * Date: 2019/2/1
 * Time: 15:14
 */

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'admin_group';
    public $dateFormat = 'U';
    public $timestamps = true;
    public $fillable = ['name', 'description','menus'];
    public $messages = [
        'name.required' => '名不能为空',
    ];
    public $rules = [
        'name' => 'required|string|max:100|min:2',
        'description' => 'required',
    ];

    public function getIdName()
    {
        return static::pluck('name', 'id')->toArray();
    }
}