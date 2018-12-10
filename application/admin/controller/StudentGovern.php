<?php
/**
 * Created by PhpStorm.
 * User: yuange
 * Date: 2018/11/18
 * Time: 16:25
 */

namespace app\admin\controller;

use app\admin\model\Student;
use think\Db;

class StudentGovern extends Before
{
    public function allList(){
        $counts = Db::table('ymlh_student')->count();
        $this->assign('counts',$counts);
        return $this->fetch();
    }
    /**
     * 分页查询
     */
    public function pageQuery(){
        if($this->request->has('lastIndex')){
            //上次加载的序号
            $lastIndex = input('lastIndex/d');
            //条数
            $count = input('?limt') ? input('limt/d') : 20;
            $list = Db::table('ymlh_student')->order('id','DESC')->limit($lastIndex,$count)->select();
            $this->assign('studentList',$list);
            return $this->fetch();
        }
    }

    /**
     * 查询已失效学员
     * ！！！未做分页
     */
    public function findInvalid(){
        if($this->request->isPost()){
            $student = new Student();
            $list = $student->findInvalid();
            $this->assign('studentList',$list);
            return $this->fetch('page_query');
        }
    }

    /**
     * 根据姓名模糊查询
     * 用于搜索学员
     */
    public function findByName(){
        if(input('?name')){
            //将json字符串转化为数组 用strip_tags过滤请求参数
            $name = input('name','strip_tags');
            $list = Db::name('student')->where('name_', 'like', '%'.$name.'%')->select();
            $this->assign('studentList',$list);
            return $this->fetch('page_query');
        }
    }

    public function add(){
        if($this->request->isPost()){
            $data = json_decode(input('data','strip_tags'),true);
            $student = new Student();
            return json($student->add($data));
        }else{
            return $this->fetch();
        }
    }

    public function del(){
        if($this->request->isPost()){
            $student = new Student();
            $id = intval(input('id'));
            return json($student->del($id));
        }
    }

    public function edit(){
        if($this->request->isPost()){
            //将json字符串转化为数组 用strip_tags过滤请求参数
            $data = json_decode(input('data'),true);
            $student = new Student();
            return json($student->edit($data));
        }else{
            $student = new Student();
            $this->assign('data',$student->get(input('id')));
            return $this->fetch();
        }
    }
}