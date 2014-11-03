<?php
namespace Home\Controller;
use Common\Controller\BaseController;
use Common\Model\UserModel;

/**
 *用人单位(企业)用户接口
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
     * 更新用人单位信息
     */
    public function update() {
        $this->reqPost()->reqEmployer();
        
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
        $this->reqLogin()->reqEmployer();
        
        $data['uid'] = session('uid');
        $res = D('User')->getEmployerInfo(array_merge($data, I('post.')));
        if ($res['status']) {
            $this->ajaxReturn(mz_json_success($res['msg']));
        } else {
            $this->ajaxReturn(mz_json_error($res['msg']));
        }
    }
    /**
     * 获得企业用户的信息
     * @param unknown $employer_id
     */
    public function getInfo($employer_id){
        $this->reqAdmin();
        $res = D('UserEmployer')->info($employer_id);
        if($res['status']){
            $this->ajaxReturn(mz_json_success($res['msg']));
        }else{
            $this->ajaxReturn(mz_json_error($res['msg']));
        }
    }

    /**
     * 验证（更换权限）
     * 需要管理员有管理企业用户的权限 per_employer_man
     * @post user_id
     * @post 1正常 -2锁定
     */
    public function vertify(){
        $this->reqPost(array('employer_id','op'))->reqAdmin();
        //检验权限
        if(! D('UserAdmin')->createAdminById(session('uid'))->hasPerEmployerMan()){
            $this->ajaxReturn(mz_json_error("权限不足!"));
            return;
        }
        $res = D('UserEmployer')->vertify(I('post.employer_id'),I('post.op'));
        if($res['status']){
            $this->ajaxReturn(mz_json_success('vertify successfully'));
        }else{
            $this->ajaxReturn(mz_json_error($res['msg']));
        }
        
    }

    /**
     * 删除企业用户
     * 需要管理员有管理企业用户的权限 per_employer_man
     */
    public function delete(){
        $this->reqPost(array('employer_id'))->reqAdmin();
         
        //检验权限
        if(! D('UserAdmin')->createAdminById(session('uid'))->hasPerEmployerMan()){
            $this->ajaxReturn(mz_json_error("权限不足!"));
            return;
        }
         
        //调用model
        $res = D('User')->deleteUser(I('post.employer_id'),UserModel::LEVEL_EMPLOYER);
        if($res['status']){
            $this->ajaxReturn(mz_json_success());
        }else{
            $this->ajaxReturn(mz_json_error($res['msg']));
        }
        
    }
}

 