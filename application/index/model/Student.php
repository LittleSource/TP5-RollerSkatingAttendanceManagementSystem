<?php
/**
 * Created by PhpStorm.
 * User: yuange
 * Date: 2018/11/16
 * Time: 16:40
 */

namespace app\index\model;

use think\Model;

class Student extends Model
{
    /**
     * @param $student
     * @return array 登录状态码code和message
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function login($student){
        $resStudent = $this->where('name_',$student->name)->find();
        if($resStudent == null){
            $resArr = config('NOT_HAS_USER');
        }else {
            if ($student->password != $resStudent->password) {
                $resArr = config('ID_OR_PASSWORD_ERROR');
            } else {
                $resArr = config('SUCCESS');
                session('name_', $resStudent->name_,'login');
            }
        }
        return $resArr;
    }
}