<?php
/**
 * Created by PhpStorm.
 * User: yuange
 * Date: 2018/10/29
 * Time: 20:09
 */

namespace app\index\controller;

use \think\Controller;
use think\Session;

class Login extends Controller
{
    //登录页面
    public function login(){
        $session = new Session();
        if($session->has('name','login') || $session->has('name_','login')){
            $this->loginAssign();
        }else{
            return $this->fetch();
        }
    }

    //登录表单异步处理
    public function loginAjax(){
        if($this->request->isAjax()){
            $resArr = array();
            $user = json_decode(input('data'));
            if(!captcha_check($user->code)){
                $resArr = config('CAPTCHA_ERROR');
            }
            elseif($user->identity == 1){
                $coach = model('Coach');
                $resArr = $coach->login($user);
            }else if($user->identity == 0){
                $student = model('Student');
                $resArr = $student->login($user);
            }
            return json(json_encode($resArr,JSON_UNESCAPED_UNICODE));
        }
    }

    //登录成功分发页面
    public function loginAssign(){
        $session = new Session();
        if($session->has('name','login')){
            if($session->get('identity','login') == 1){
                $this->redirect('admin/statistics/statisticsList');//管理员
            }elseif ($session->get('identity','login') == 0){
                $this->redirect('/teacher/sign/studentlist');//教练
            }else{
                var_dump($session->get('identity'));
            }
        }
        elseif ($session->has('name_','login')){
            $this->redirect('user/user/index');//用户
        }else{
            $this->redirect('user/user/login');//都没有则返回登录
        }
    }

    //退出登录
    public function loginOut(){
        session(null,'login');
        $this->success('已退出登录！',\url('/'));
    }
//    //注册页面
//    public function register(){
//        return $this->fetch();
//    }
//    //注册表单处理
//    public function regForm(){
//        //验证验证码
//        if(!captcha_check(input('code'))){
//            $this->error('验证码错误！');
//        //验证post参数
//        }else if(input('?post.code')){
//            $user = model('User');
//            //判断账号是否存在
//            if($user->where('phone',input('phone'))->find() != null){
//                $this->error('手机号'.input('phone').'已注册,请直接登录！');
//            }
//            $user->phone = input('phone');
//            $user->password = input('password');
//            $user->reg_time = date('Y-m-d h:i:s');
//            if($user->save()){
//                session('phone',input('phone'));
//                $this->success('注册成功！',url('user/user/user'));
//            }else{
//                $this->error($user);
//            }
//        }else{
//            $this->error('请求异常!');
//        }
//    }
}