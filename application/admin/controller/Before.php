<?php
/**
 * Created by PhpStorm.
 * User: yuange
 * Date: 2018/11/18
 * Time: 16:30
 */

namespace app\admin\controller;


use think\Controller;

/**
 * 前置控制器
 * Class Before
 * @package app\admin\controller
 */
class Before extends Controller
{
    protected $beforeActionList = [
        'verifyAdmin' =>  ['only'=>''],
    ];

    /**
     * 前置操作，判断是否为管理员身份
     */
    public function verifyAdmin(){
        if(session('identity','','login') != 1){
            $this->error('您不是管理员，请先登录！',url('index/login/login'));
        }
    }
}