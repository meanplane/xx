<?php
/**
 * Created by IntelliJ IDEA.
 * User: xiaoer
 * Date: 2019/1/30
 * Time: 10:54
 */

namespace App\Traits;

// 处理request

trait RequestTrait{

    public function getWhere($likes=[],$sures=[]){
        $where = [];

        foreach ($likes as $like){
            if (request($like)) {
                $where[] = [$like, 'like', '%' . request($like) . '%'];
            }
        }

        foreach ($sures as $sure){
            if (request($sure)) {
                $where[] = [$sure, request($sure)];
            }
        }
        return $where;
    }


}
