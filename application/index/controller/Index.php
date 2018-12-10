<?php
namespace app\index\controller;

use think\Controller;

class Index extends Controller {
    public function index()
    {
        return $this->fetch();
    }
    /**
     * 文章页面
     */
    public function article(){
        return $this->fetch();
    }
}