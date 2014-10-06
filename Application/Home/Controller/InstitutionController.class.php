<?php
namespace Home\Controller;
use Common\Controller\BaseController;

/**
 *机构用户接口
 * @author Jayin
 *        
 */
class InstitutionController extends BaseController {
    /**
     * POST 注册
     */
    public function register() {
        if (! IS_POST) {
            $this->ajaxReturn(mz_json_error_request());
        }
        $res = D('User')->regInstitution();
        if ($res['status']) {
            $this->ajaxReturn(mz_json_success('register successfully'));
        } else {
            $this->ajaxReturn(mz_json_error($res['msg']));
        }
    }

    /**
     * POST 登录
     */
    public function login() {
        if (! IS_POST) {
            $this->ajaxReturn(mz_json_error_request());
            return;
        }
        $account = I('post.account');
        $psw = md5(I('post.psw'));
        $User = D('User');
        if (strstr($account, '@')) {
            $res = $User->login('email', $account, $psw);
        } else {
            $res = $User->login('phone', $account, $psw);
        }
        if ($res['status']) {
            session('uid', $res['msg']['uid']);
            $this->ajaxReturn(mz_json_success('login success'));
        } else {
            $this->ajaxReturn(mz_json_error($res['msg']));
        }
    }

    /**
     * GET 登出
     */
    public function logout() {
        session('uid', null);
        $this->ajaxReturn(mz_json_success('logout successfully'));
    }
    /**
     * POST 更新机构用户信息
     */
    public function update() {
    	if(!IS_POST){
    	    $this->ajaxReturn(mz_json_error_request());
    	    return;
    	}
    	if(!session('uid')){
    	    $this->ajaxReturn(mz_json_error('login please'));
    	}
    	$uid = session('uid');
    	$data['uid'] = session('uid');
    	$res = D('User')->updateInsInfo(array_merge($data,I('post.')));
    	if($res['status']){
    	    $this->ajaxReturn(mz_json_success('update info success'));
    	}else{
    	    $this->ajaxReturn(mz_json_error($res['msg']));
    	}
    }
    /**
     * 获取当前机构用户信息
     */
    public function info() {
    	if(!session('uid')){
    	    $this->ajaxReturn(mz_json_error("login please"));
    	}
    	$data['uid'] = session('uid');
        $res = D('User')->getInsInfo(array_merge($data,I('post.')));
        if($res['status']){
            $this->ajaxReturn(mz_json_success($res['msg']));
        }else {
            $this->ajaxReturn(mz_json_error($res['msg']));
        }
        
    }

    /**
     * 获取机构列表
     * 
     * @param unknown $page            
     * @param unknown $limit            
     */
    public function search($status='',$name='',$type='',$page=1, $limit=10) {
        $res = D('UserInstitution')->search($status, $name, $type, $page, $limit);
        if($res['status']){
           $this->ajaxReturn(mz_json_success($res['msg']));
        }else{
            $this->ajaxReturn(mz_json_error($res['msg']));
        }
    }
}

