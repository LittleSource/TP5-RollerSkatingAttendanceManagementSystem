<?php
/**
 * Created by PhpStorm.
 * User: yuange
 * Date: 2018/11/24
 * Time: 20:08
 */

namespace app\teacher\Model;

use think\Db;
use think\Exception;
use think\facade\Session;
use \think\Model;
class Sign extends Model
{
    /**
     * 批量签到
     * @param $idArr
     * @return int|string 签到成功的个数
     */
    public function startSign($idArr)
    {
        $data=[];
        $student = new Student();
        foreach ($idArr as $key => $value) {
            //初始化
            $data[$key]['status'] = 1;
            $data[$key]['message'] = '签到成功';
            //判断今天是否已签到
            if ($this->isSignToday($value)) {
                $data[$key]['status'] = 0;
                $data[$key]['message'] = '今日已签到';
            }
            //判断该生是否已到期
            if ($student->isExpired($value)) {
                $data[$key]['status'] = 0;
                $data[$key]['message'] = '已到期';
            }
            //判断该生是否次数用完
            if($student->isNoCount($value)){
                $data[$key]['status'] = 0;
                $data[$key]['message'] = '次数已用完';
            }
            //其他字段数据
            $data[$key]['id'] = $value;
            $data[$key]['name'] = Session::get('name','login');
            $data[$key]['qd_time'] = date('Y-m-d H:i:s');
        }
        return Db::name('sign')->insertAll($data);
    }

    /**
     * 查询学生今日是否签到
     * @param $id
     * @return bool
     */
    protected function isSignToday($id){
        try{
            if($this->where("id=$id AND qd_time > DATE(NOW()) AND status=1")->find()){
                return true;
            }else{
                return false;
            }
        }catch (Exception $e){
            return false;
        }
    }

    public function deleteBySignId($signId){
        if($this->where('sign_id',$signId)->delete()){
            return config('SUCCESS');
        }else{
            return config('EXCEPTION');
        }
    }

    //批量补签
    public function RemedySign($dataArr){
        $data['id'] = $dataArr['id'];
        $data['qd_time'] = $dataArr['date'];
        $data['status'] = 1;
        $data['message'] = '补签成功';
        $data['name'] = Session::get('name','login');

        $count = intval($dataArr['count']);

        if($count === 1){
            if(Db::name('sign')->insert($data)){
                return config('SUCCESS');
            }else{
                return config('EXCEPTION');
            }
        }else {
            for ($i = 0; $i < $count - 1; $i++) {
                Db::name('sign')->insert($data);
            }
            if(Db::name('sign')->insert($data)){
                return config('SUCCESS');
            }else{
                return config('EXCEPTION');
            }
        }
    }
}