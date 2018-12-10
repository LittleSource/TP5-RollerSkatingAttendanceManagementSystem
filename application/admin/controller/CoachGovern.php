<?php
/**
 * Created by PhpStorm.
 * User: yuange
 * Date: 2018/11/17
 * Time: 18:28
 */

namespace app\admin\controller;


use app\admin\model\Coach;

class CoachGovern extends Before
{
    public function allList(){
        $coachList = Coach::all();
        $this->assign('coachList',$coachList);
        return $this->fetch();
    }

    public function add(){
        if($this->request->isPost()){
            //将json字符串转化为数组 用strip_tags过滤请求参数
            $data = json_decode(input('data','strip_tags'),true);
            $coach = new Coach();
            return json($coach->add($data));
        }else{
            return $this->fetch('add');
        }
    }

    public function del(){
        if($this->request->isPost()){
            $coach = new Coach();
            $id = intval(input('id'));
            return json($coach->del($id));
        }
    }

    public function edit(){
        if($this->request->isPost()){
            //将json字符串转化为数组 用strip_tags过滤请求参数
            $data = json_decode(input('data','strip_tags'),true);
            $coach = new Coach();
            return json($coach->edit($data));
        }else{
            $coach = new Coach();
            $this->assign('data',$coach->get(input('id')));
            return $this->fetch();
        }
    }
}