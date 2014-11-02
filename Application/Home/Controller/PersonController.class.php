<?php
namespace Home\Controller;
use Common\Controller\BaseController;
use Common\Model\UserModel;

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

    /**
     * 验证（更换权限）
     * 需要管理员权限
     * @post user_id
     * @post 1正常 -2锁定
     */
    public function vertify(){
        $this->reqPost(array('user_id','op'))->reqAdmin();
         
         //todo 检查权限
         
        $res = D('UserPerson')->vertify(I('post.user_id'),I('post.op'));
        if($res['status']){
            $this->ajaxReturn(mz_json_success('vertify successfully'));
        }else{
            $this->ajaxReturn(mz_json_error($res['msg']));
        }
        
    }

    /**
     * 删除一个个人用户
     */
    public function deleteUser(){
        $this->reqPost(array('user_id'))->reqAdmin();
         
         //todo:检查权限
         
        //调用model
        $res = D('User')->deleteUser(I('post.user_id'),UserModel::LEVEL_PERSON);
        if($res['status']){
            $this->ajaxReturn(mz_json_success());
        }else{
            $this->ajaxReturn(mz_json_error($res['msg']));
        }
        
    }

}
 