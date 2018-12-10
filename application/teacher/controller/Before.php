<?php
/**
 * Created by PhpStorm.
 * User: yuange
 * Date: 2018/11/24
 * Time: 13:39
 */

namespace app\teacher\controller;

use think\App;
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
        if(session('identity','','login') != 1 && session('identity','','login') != 0){
            $this->error('权限不足！源梦科技 www.ym998.cn',url('index/login/login'));
        }
    }

    /**
     * 重写父类Controller的构造方法
     */
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        //定义模板根目录
        $this->view->config('view_path', dirname($_SERVER['DOCUMENT_ROOT'],1).'/application/');
    }
}