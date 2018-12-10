<?php
/**
 * Created by PhpStorm.
 * User: yuange
 * Date: 2018/11/1
 * Time: 21:39
 */

namespace app\index\controller;

use \think\Controller;

/**
 * 此控制器闲置 本项目没有使用
 * Class Upload
 * @package app\user\controller
 */
class Upload extends Controller{
    public function goodsImage(){
        //商品图片上传路径
        $path = '../public/static/uploads/goods/';
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        // 移动到框架应用根目录/uploads/ 目录下
        $info = $file->rule('md5')->validate(['size'=>5242880,'ext'=>'jpg,png,jpeg'])->move($path);
        if($info){
            //保存的图片路径
            $imgPath=str_replace('\\','/',$info->getSaveName());
            //裁剪图片
            $image = \think\Image::open($path.$imgPath);
            $image->thumb(346,200,\think\Image::THUMB_CENTER)->save($path.$imgPath);

            $json=array(
                'code'=>1,
                'msg'=>'success',
                //这里输出的地址不带/static/uploads/goods/，用图片的话得加上路径
                'data'=>$imgPath
                );
            echo json_encode($json);
        }else{
            $json=array(
                'code'=>0,
                'msg'=>'error',
                'data'=>$file->getError()
            );
            echo json_encode($json);
        }
    }
}