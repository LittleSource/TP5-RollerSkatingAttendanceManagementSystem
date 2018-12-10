<?php
/**
 * Created by PhpStorm.
 * User: yuange
 * Date: 2018/11/24
 * Time: 14:41
 */
namespace app\teacher\Model;
use Exception;
use \think\Model;

class Student extends Model
{
    /**
     * 查询学员是否已到期
     * @param $id
     * @return bool
     */
    public function isExpired($id){
        try{
            if($this->where("id=$id AND end_time < DATE(NOW())")->find()){
                return true;
            }else{
                return false;
            }
        }catch (Exception $e){
            return false;
        }
    }

    /**
     * 查询学员是否没次数(次数<=0)
     * @param $id
     * @return bool
     */
    public function isNoCount($id){
        try{
            if($this->where("id=$id AND residual_count <= 0")->find()){
                return true;
            }else{
                return false;
            }
        }catch (Exception $e){
            return false;
        }
    }

}