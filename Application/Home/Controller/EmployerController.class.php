<?php
namespace Home\Controller;
use Common\Controller\BaseController;

/**
 *
 * @author Jayin
 *        
 */
class EmployerController extends BaseController {
    /**
     * POST 注册
     */
    public function register() {
        $this->reqPost();
        
        $res = D('User')->regEmployer();
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
        $this->reqPost();
        
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
     * 更新用人单位信息
     */
    public function update() {
        $this->reqPost()->reqLogin();
        
        $uid = session('uid');
        $data['uid'] = session('uid');
        $res = D('User')->updateEmployerInfo(array_merge($data, I('post.')));
        if ($res['status']) {
            $this->ajaxReturn(mz_json_success('update info success'));
        } else {
            $this->ajaxReturn(mz_json_error($res['msg']));
        }
    }

    /**
     * GET 获取当前用人单位信息
     */
    public function info() {
        $this->reqLogin();
        
        $data['uid'] = session('uid');
        $res = D('User')->getEmployerInfo(array_merge($data, I('post.')));
        if ($res['status']) {
            $this->ajaxReturn(mz_json_success($res['msg']));
        } else {
            $this->ajaxReturn(mz_json_error($res['msg']));
        }
    }
}

 