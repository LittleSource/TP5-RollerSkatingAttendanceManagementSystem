<?php
/**
 * Created by PhpStorm.
 * User: yuange
 * Date: 2018/11/28
 * Time: 18:28
 */

namespace app\admin\model;


use think\Model;

class Count extends Model
{
    /**
     * 获取分月统计信息列表
     * @return array 当前月之前14个月的月份为key，count表的值为value
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getList(){
        $resArr = json_decode(json_encode($this->find()), true);
        //定义日期数组
        $times=array();
        $i=0;
        foreach ($resArr as $value){
            if($i<-13)
                break;
            $times[date("Y-m", strtotime($i." month"))] = $value;
            $i--;
        }
        return $times;
    }

    /**
     * 编辑更新分月统计信息
     * @param $data array
     * @return array 配置文件中的操作状态信息
     * @throws \think\Exception\DbException
     */
    public function edit($data){
        $count = $this::get(0);
        $count->timermb = $data[0];
        $count->timermb1 = $data[1];
        $count->timermb2 = $data[2];
        $count->timermb3 = $data[3];
        $count->timermb4 = $data[4];
        $count->timermb5 = $data[5];
        $count->timermb6 = $data[6];
        $count->timermb7 = $data[7];
        $count->timermb8 = $data[8];
        $count->timermb9 = $data[9];
        $count->timermb10 = $data[10];
        $count->timermb11 = $data[11];
        $count->timermb12 = $data[12];
        $count->timermb12 = $data[13];
        if($count->save()){
            return config('SUCCESS');
        }else{
            return config('EXCEPTION');
        }
    }
}