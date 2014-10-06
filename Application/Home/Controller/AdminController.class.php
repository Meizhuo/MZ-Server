<?php
namespace Home\Controller;
use Common\Controller\BaseController;

/**
 * 管理员接口
 * @author Jayin
 *
 */
class AdminController extends BaseController {
    
    public function create(){
    	//TODO 保留
    }
    
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
    public function logout(){
        session('uid',null);
        $this->ajaxReturn(mz_json_success('logout successfully'));
    }

    /**
     * 上传附件
     */
    public function upload(){}
}

 