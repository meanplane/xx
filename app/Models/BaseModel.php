<?php
/**
 * Created by IntelliJ IDEA.
 * User: xiaoer
 * Date: 2019/2/23
 * Time: 23:38
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model{
    // 通用table data
    protected function tableLists($where=[],$orderKey=null){

        $limit = request('limit',10);
        $page = request('page',1);

        $query = static::where($where);
        if($orderKey){
            $query = $query->orderBy($orderKey, 'desc');
        }

        $count = $query->count();
        $tableData = $query->offset(($page-1)*$limit)
            ->limit($limit)->get()->toArray();

        return compact('count','tableData');
    }
}
