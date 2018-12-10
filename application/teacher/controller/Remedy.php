<?php
/**
 * Created by PhpStorm.
 * User: yuange
 * Date: 2018/12/9
 * Time: 18:27
 */

namespace app\teacher\controller;

use think\Db;

/**
 * 补签 and 查询某个学员签到记录的控制器
 * Class Remedy
 * @package app\teacher\controller
 */
class Remedy extends Before
{
    /**
     * 渲染首页
     * @return mixed
     */
    public function index(){
        return $this->fetch('/teacher/view/remedy/index');
    }

    /**
     * 根据id查询学员签到记录
     * 异步调用
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function findById(){
        $id = input('id');
        $list = Db::name('sign')->where("id = '$id'")->select();
        $this->assign('signList',$list);
        return $this->fetch('/teacher/view/remedy/page_query2');
    }

    public function RemedySign(){
        $data = json_decode(input('data'),true);
        $sign = new \app\teacher\Model\Sign();
        return $sign->RemedySign($data);
    }
}