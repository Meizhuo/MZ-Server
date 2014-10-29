<?php
namespace Home\Controller;
use Common\Controller\BaseController;

/**
 * 个人用户接口
 * 
 * @author Jayin
 *        
 */
class PersonController extends BaseController {

    /**
     * POST 注册
     */
    public function register() {
        $this->reqPost();
        
        $User = D('User');
        $result = $User->regPerson();
        if ($result['status']) {
            $this->ajaxReturn(mz_json_success('register successfully'));
        } else {
            $this->ajaxReturn(mz_json_error($result['msg']));
        }
    }

    /**
     * GET 获得用户信息
     */
    public function info() {
        $this->reqPerson();
        $res = D('User')->getUserInfo(session('uid'));
        $this->ajaxReturn($res['msg']);
    }

    /**
     * POST 更新个人用户信息
     */
    public function update() {
        $this->reqPost()->reqPerson();
        
        $data['uid'] = session('uid');
        $res = D('UserPerson')->updateInfo(array_merge($data, I('post.')));
        if ($res['status']) {
            $this->ajaxReturn(mz_json_success('update info success'));
        } else {
            $this->ajaxReturn(mz_json_error($res['msg']));
        }
    }
}
 