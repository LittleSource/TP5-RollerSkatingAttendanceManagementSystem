<?php
/**
 * Created by PhpStorm.
 * User: yuange
 * Date: 2018/12/3
 * Time: 17:55
 */

namespace app\user\controller;


use think\Db;

class User extends Before
{
    public function index(){
        $student = Db::name('student')->where('name_',session('name_','','login'))->find();
        $this->assign('vo',$student);
        return $this->fetch();
    }
}