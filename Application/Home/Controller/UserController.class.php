<?php
namespace Home\Controller;
use Common\Controller\BaseController;
/**
 * 用户操作公共接口
 * @author Jayin
 *
 */
class UserController extends BaseController {
 
    /**
     * POST 登录
     */
    public function login(){
        $this->reqPost();
        
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
       session(null);
       $this->ajaxReturn(mz_json_success('logout successfully'));
    }
}

