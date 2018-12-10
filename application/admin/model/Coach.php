<?php
/**
 * Created by PhpStorm.
 * User: yuange
 * Date: 2018/11/17
 * Time: 18:31
 */

namespace app\admin\model;


use think\Db;
use think\Exception;
use think\exception\PDOException;
use think\Model;

class Coach extends Model
{
    public function add($data){
        $data['add_time'] = date('Y-m-d');
        if(Db::name('coach')->insert($data, true)){
            return config('SUCCESS');
        }else{
            return config('PARAMS_ERROR');
        }
    }

    public function del($id){
        try {
            Db::table('ymlh_coach')->delete($id);
            $resArr = config('SUCCESS');
        } catch (PDOException $e) {
            $resArr = config('PARAMS_ERROR');
        } catch (Exception $e) {
            $resArr = config('EXCEPTION');
        }
        return $resArr;
    }

    public function edit($data){
        try {
            Db::name('coach')->update($data);
            $resArr = config('SUCCESS');
        } catch (PDOException $e) {
            $resArr = config('PARAMS_ERROR');
        } catch (Exception $e) {
            $resArr = config('EXCEPTION');
        }
        return $resArr;
    }
}