<?php
namespace Home\Controller;
use Common\Controller\BaseController;

/**
 * 管理员接口
 * @author Jayin
 *
 */
class AdminController extends BaseController {
    //post nickname email psw  
//     per_categorys_post  有权限起草/编辑的栏目(json)  （可空
//     per_categorys_check  有权限管理的群组(json) （可空
//     per_institution_check 有权限审核培训机构(0无权 1有权) （可空
    
 
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
    public function postDocument(){}
    public function updateDocument(){}
    public function checkDocument(){}
    public function checkInstitution(){}
    public function upload(){}
}

 