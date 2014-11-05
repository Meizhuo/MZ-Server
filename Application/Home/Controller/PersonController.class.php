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
        $this->reqPost(array('nickname','email','phone','psw'));
        
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
     * 需要管理员有管理个人用户的权限 per_person_man
     * @post user_id
     * @post op 1正常 -2锁定
     */
    public function vertify(){
        $this->reqPost(array('user_id','op'))->reqAdmin();
         
         //检验权限
        if(! D('UserAdmin')->createAdminById(session('uid'))->hasPerPersonMan()){
            $this->ajaxReturn(mz_json_error("权限不足!"));
            return;
        }
         
        $res = D('UserPerson')->vertify(I('post.user_id'),I('post.op'));
        if($res['status']){
            $this->ajaxReturn(mz_json_success('vertify successfully'));
        }else{
            $this->ajaxReturn(mz_json_error($res['msg']));
        }
        
    }

    /**
     * 删除个人用户
     * 需要管理员有管理个人用户的权限 per_person_man
     */
    public function delete(){
        $this->reqPost(array('user_id'))->reqAdmin();
         
        //检验权限
        if(! D('UserAdmin')->createAdminById(session('uid'))->hasPerPersonMan()){
            $this->ajaxReturn(mz_json_error("权限不足!"));
            return;
        }
         
        //调用model
        $res = D('User')->deleteUser(I('post.user_id'),UserModel::LEVEL_PERSON);
        if($res['status']){
            $this->ajaxReturn(mz_json_success());
        }else{
            $this->ajaxReturn(mz_json_error($res['msg']));
        }
        
    }

}
 