<?php
/**
 * Created by PhpStorm.
 * User: yuange
 * Date: 2018/10/31
 * Time: 8:23
 */

namespace app\admin\controller;

class Index extends Before {

    //首页 统计页面
    public function index(){
        return $this->fetch();
    }
}