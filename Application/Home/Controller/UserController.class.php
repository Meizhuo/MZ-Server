<?php
namespace Home\Controller;
use Common\Controller\BaseController;
use Common\Model\UserModel;
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
        $this->reqPost(array('account','psw'));
        
        $account = I('post.account');
        $psw = md5(I('post.psw'));
        $User = D('User');
        if(strstr($account,'@')){
            $res = $User->login('email',$account,$psw);
        }else{
            $res = $User->login('phone',$account,$psw);
        }
        if($res['status']){
        	//被冻结
        	if($res['msg']['status'] == UserModel::STATUS_STOP){
        		$this->ajaxReturn(mz_json_error('无法登录,账号被已被冻结',43001));
        	}
            session('uid',$res['msg']['uid']);
            $this->ajaxReturn(mz_json_success($res['msg']));
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

