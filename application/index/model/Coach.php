<?php
/**
 * Created by PhpStorm.
 * User: yuange
 * Date: 2018/11/16
 * Time: 14:35
 */

namespace app\index\model;

use think\Model;
class Coach extends Model
{
    public function login($coach){
        $resCoach = $this->where('name',$coach->name)->find();
        if($resCoach == null){
            //姓名不存在的时候也返回用户名或密码错误
            $resArr = config('ID_OR_PASSWORD_ERROR');
        }else{
            if($coach->password != $resCoach->password){
                $resArr = config('ID_OR_PASSWORD_ERROR');
            }else{
                $resArr = config('SUCCESS');
                session('name', $coach->name,'login');
                session('identity',$resCoach->identity,'login');
                session('identity',$resCoach->identity);
            }
        }
        return $resArr;
    }
}