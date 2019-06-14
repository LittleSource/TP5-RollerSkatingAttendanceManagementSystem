<?php
/**
 * Created by PhpStorm.
 * User: yuange
 * Date: 2018/11/23
 * Time: 23:01
 */

namespace app\teacher\controller;

use app\admin\model\Student;
use think\Db;

/**
 * Class Sign
 * 管理员和教练为学员签到
 * @package app\trainer\controller
 */
class Sign extends Before
{
    /**
     * 查询所有学生并输出到视图
     */
    public function studentList(){
        $student = new Student();
        $list = $student->all();
        $this->assign('studentList',$list);
        $this->assign('nowTime',time());
        return $this->view->fetch('/teacher/view/sign/student_list');
    }

    /**
     * 开始签到（异步）
     */
    public function startSign(){
        if($this->request->isPost()){
            $idArr = json_decode(input('data','strip_tags'),true);
            $sign = new \app\teacher\Model\Sign();
            return json($sign->startSign($idArr));
        }
    }

    /**
     * 签到记录分步查询
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function pageQuery(){
        if($this->request->has('page')){
            //上次加载的序号
            $page = input('page/d');
            //条数
            //$count = input('?limt') ? input('limt/d') : 100;
            $list = Db::field('ymlh_sign.sign_id,ymlh_sign.id,ymlh_sign.qd_time,ymlh_sign.name,ymlh_sign.message,ymlh_sign.status,ymlh_student.name_')
                ->table(['ymlh_sign','ymlh_student'])
                ->where('ymlh_sign.id = ymlh_student.id')
                ->order('ymlh_sign.sign_id','DESC')
                ->page($page,20)
              	->select();
            $this->assign('signList',$list);
            return $this->fetch('/teacher/view/sign/page_query');
        }
    }

    /**
     * 签到管理
     */
    public function allList(){
        $counts = Db::table('ymlh_student')->count();
        $this->assign('counts',$counts);
        return $this->view->fetch('//teacher/view/sign/all_list');
    }

    /**
     * 删除一条签到记录
     */
    public function delSign(){
        if($this->request->isPost()){
            $sign =  new \app\teacher\Model\Sign();
            return json($sign->deleteBySignId(input('sign_id')));
        }
    }
}