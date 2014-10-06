<?php
namespace Home\Controller;
use Common\Controller\BaseController;

class UserController extends BaseController {
    
    /**
     * POST 注册
     */
    public function register(){
       if(!IS_POST){
           $this->ajaxReturn(mz_json_error_request());
       } 
       
       $User = D('User');
       $result = $User->regPerson();
       if($result['status']){
           $this->ajaxReturn(mz_json_success('register successfully'));
       }else{
            $this->ajaxReturn(mz_json_error($result['msg']));
       }
    }

    /**
     *GET 获得用户信息
     */ 
    public function info(){
        $uid = session('uid');
        if(!$uid){
            $this->ajaxReturn(mz_json_error('login please'));
        }
        //?
        $res = D('User')->getUserInfo($uid);
        $this->ajaxReturn($res['msg']);
    }
    /**
     * POST 更新个人用户信息
     */
    public function update(){
        if(!IS_POST){
            $this->ajaxReturn(mz_json_error_request());
            return;
        }
        if(!session('uid')){
            $this->ajaxReturn(mz_json_error("login please!"));
            return;
        }
        $uid = session('uid');
        $data['uid'] = session('uid');
        $res = D('User')->updateUserInfo(array_merge($data,I('post.')));
        if($res['status']){
            $this->ajaxReturn(mz_json_success('update info success'));
        }else{
            $this->ajaxReturn(mz_json_error($res['msg']));
        }
        
    }
    /**
     * POST 登录
     */
    public function login(){
        if(!IS_POST){
            $this->ajaxReturn(mz_json_error_request());
            return;
        }
        $account = I('post.account');
        $psw = md5(I('post.psw'));
        $User = D('User');
        if(strstr($account,'@')){
            $res = $User->login('email',$account,$psw);
        }else{
            $res = $User->login('phone',$account,$psw);
        }
        if($res['status']){
            session('uid',$res['msg']['uid']);
            $this->ajaxReturn(mz_json_success('login success'));
        }else{
            $this->ajaxReturn(mz_json_error($res['msg']));
        }
    }
    /**
     * GET 登出
     */
    public function logout(){
       session('uid',null);
       $this->ajaxReturn(mz_json_success('logout successfully'));
    }
}

