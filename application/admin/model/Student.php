<?php
/**
 * Created by PhpStorm.
 * User: yuange
 * Date: 2018/11/18
 * Time: 16:26
 */

namespace app\admin\model;


use think\Db;
use think\Exception;
use think\exception\PDOException;
use think\Model;

class Student extends Model
{
    public function del($id){
        try {
            Db::table('ymlh_student')->delete($id);
            $resArr = config('SUCCESS');
        } catch (PDOException $e) {
            $resArr = config('PARAMS_ERROR');
        } catch (Exception $e) {
            $resArr = config('EXCEPTION');
        }
        return $resArr;
    }
    public function add($data){
        $data['residual_count'] = $data['max_count'];
        $student = new Student($data);
        if($student->save()){
            return config('SUCCESS');
        }else{
            return config('PARAMS_ERROR');
        }
    }

    /**
     * @param $data array
     * @return  array $resArr 返回状态码 和 message
     */
    public function edit($data){
        try {
            Db::name('student')->where('id',$data['id'])->update($data);
            $resArr = config('SUCCESS');
        } catch (PDOException $e) {
            $resArr = config('PARAMS_ERROR');
        } catch (Exception $e) {
            $resArr = config('EXCEPTION');
        }
        return $resArr;
    }
    public function findInvalid()
    {
        return $this->whereOr([
            ['end_time', '<', date('Y-m-d')],
            ['residual_count', '=', 0]
        ])->select();
    }
}