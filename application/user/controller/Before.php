<?php
/**
 * Created by PhpStorm.
 * User: yuange
 * Date: 2018/12/3
 * Time: 17:35
 */

namespace app\user\controller;


use think\Controller;

class Before extends Controller
{
    protected $beforeActionList = [
        'verifyAdminOrCoach'=>''
    ];

    /**
     * 前置操作，判断是否为管理员或教练身份
     */
    public function  verifyAdminOrCoach(){
        if(!session('?name_','','login')){
            $this->error('权限不足！源梦科技 www.ym998.cn',url('user/login/login'));
        }
    }
}