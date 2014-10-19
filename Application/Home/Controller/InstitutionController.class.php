<?php
namespace Home\Controller;
use Common\Controller\BaseController;
use Common\Model\UserAdminModel;
use Common\Model\UserModel;


/**
 * 机构用户接口
 * @author Jayin
 *        
 */
class InstitutionController extends BaseController {
    /**
     * POST 注册
     */
    public function register() {
        $this->reqPost();
        
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
        session(null);
        $this->ajaxReturn(mz_json_success('logout successfully'));
    }
    /**
     * POST 更新机构用户信息
     */
    public function update() {
    	$this->reqPost()->reqLogin();

    	$uid = session('uid');
    	$data['uid'] = session('uid');
        $res = D('UserInstitution')->updateInfo(array_merge($data,I('post.')));
    	if($res['status']){
    	    $this->ajaxReturn(mz_json_success('update info success'));
    	}else{
    	    $this->ajaxReturn(mz_json_error($res['msg']));
    	}
    }

    /**
     * GET 获取机构用户信息
     * 基础接口,不直接暴露给客户端
     * @param number $institution_id 机构id         
     * @param unknown $status  -1审核不通过  0未审核 1审核通过  2包含全部
     */
    public function info($institution_id = 0, $status = 2) {
        $res = D('User')->getInsInfo($institution_id);
        if ($res['status']) {
            if ($res['msg']['status'] == $status || $status == 2) {
                $this->ajaxReturn(mz_json_success($res['msg']));
            } else {
                $this->ajaxReturn(mz_json_success(null));
            }
        } else {
            $this->ajaxReturn(mz_json_error($res['msg']));
        }
    }
    /**
     * GET 获取机构用户信息
     * @param number $institution_id
     */
    public function getInfo($institution_id = 0){
        return $this->info($institution_id, UserModel::STATUS_PASS);
    }
    
    /**
     * POST 审核机构
     */
    public function vertify(){
        $this->reqPost(array('institution_id'))->reqLogin();
    
        //查询获得category_id
        $Admin = new UserAdminModel();
        //检验权限
        if(! $Admin->createAdminById(session('uid'))->hasPerCheckInstitution()){
            $this->ajaxReturn(mz_json_error("You have not permission!"));
            return;
        }
        $res = D('UserInstitution')->verify(I('post.institution_id'),I('post.op',UserModel::STATUS_PASS));
        if($res['status']){
            $this->ajaxReturn(mz_json_success('vertify successfully'));
        }else{
            $this->ajaxReturn(mz_json_error($res['msg']));
        }
    }

    /**
     * 获取机构列表
     * 这是基础接口，客户端不要调用
     * @see list()
     * @param string $status
     * @param string $name
     * @param string $type
     * @param number $page
     * @param number $limit
     */
    private function search($status='',$name='',$type='',$page=1, $limit=10) {
        $res = D('UserInstitution')->search($status, $name, $type, $page, $limit);
        if($res['status']){
           $this->ajaxReturn(mz_json_success($res['msg']));
        }else{
            $this->ajaxReturn(mz_json_error($res['msg']));
        }
    }
    /**
     * 获得已通过审核的机构
     * @param string $name
     * @param string $type
     * @param number $page
     * @param number $limit
     */
    public function lists($name='',$type='',$page=1, $limit=10){
        $this->search(UserModel::STATUS_PASS,$name,$type,$page,$limit);
    }
}

