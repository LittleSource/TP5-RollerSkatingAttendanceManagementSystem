<?php
/**
 * Created by PhpStorm.
 * User: yuange
 * Date: 2018/11/27
 * Time: 17:34
 */

namespace app\admin\controller;

use app\admin\model\Count;
use think\Controller;
use think\Db;
use think\Exception\DbException;

class Statistics extends Controller
{
    /**
     * 统计
     * @return mixed
     * @throws DbException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function statisticsList(){
        $count = new Count();
        $this->assign('mothList',$count->getList());
        //学费总收入
        $sql='select sum(money) from ymlh_student';
        $this->assign('sum_money',$this->getSum($sql)['sum(money)']);
        //学生总数
        $sql='select count(*) from ymlh_student';
        $this->assign('sum_student',$this->getSum($sql)['count(*)']);
        //共计课时数
        $sql='select sum(max_count) from ymlh_student';
        $this->assign('sum_max_count',$this->getSum($sql)['sum(max_count)']);
        //共上课时数
        $sql='select count(*) from ymlh_sign';
        $this->assign('sum_sed',$this->getSum($sql)['count(*)']);


        //共计定金数
        $this->assign('sum_dingjin',$this->getCount('定金'));
        //共计次卡数
        $this->assign('sum_cika',$this->getCount('次卡'));
        //共计月卡数
        $this->assign('sum_yueka',$this->getCount('月卡'));
        //共计年卡数
        $this->assign('sum_yearka',$this->getCount('年卡'));
        //共计寒假数
        $this->assign('sum_hanjia',$this->getCount('寒假班'));
        //共计暑假数
        $this->assign('sum_shujia',$this->getCount('暑假班'));

        return $this->fetch();
    }

    /**
     * 更新
     * @return \think\response\Json
     */
    public function edit(){
        if($this->request->isPost()){
            $count = new Count();
            try {
                return json($count->edit(json_decode(input('data', true))));
            } catch (DbException $e) {
                return json(config('EXCEPTION'));
            }
        }
    }


    protected function getSum($sql){
        return Db::query($sql)[0];
    }

    protected function getCount($type){
        $sql="select count(*) from ymlh_student where type='$type'";
        return Db::query($sql)[0]['count(*)'];
    }
}