<?php
namespace Home\Controller;
use Common\Controller\BaseController;

/**
 * 管理员接口
 * @author Jayin
 *
 */
class AdminController extends BaseController {
    /**
     * 创建一个管理员
     */
    public function create(){
    	$this->reqPost(array('nickname','email','psw','per_categorys_post','per_categorys_check','per_institution_check'))->reqSuperAdmin();
        $nickname = I('post.nickname');
        $phone = I('post.phone',null);
        $email = I('post.email');
        $psw = I('post.psw');
        $per_categorys_post = I('post.per_categorys_post');
        $per_categorys_check = I('post.per_categorys_check');
        $per_institution_check = I('post.per_institution_check');
        $res = D('UserAdmin')->createAdmin($nickname,$phone,$email,$psw,$per_categorys_post,$per_categorys_check,$per_institution_check);
        if($res['status']){
            $this->ajaxReturn(mz_json_success());
        }else{
            $this->ajaxReturn(mz_json_error($res['msg']));
        }
    }
    
    /**
     * 获得管理员的信息
     * @param unknown $admin_id
     */
    public function getInfo($admin_id){
        $this->reqAdmin();
        $res = D('UserAdmin')->info($admin_id);
        if($res['status']){
            $this->ajaxReturn(mz_json_success($res['msg']));
        }else{
            $this->ajaxReturn(mz_json_error($res['msg']));
        }
    }
    /**
     * 获得管理员列表
     * @param string $status
     * @param string $nickname
     * @param number $page
     * @param number $limit
     */
    public function lists($status=null,$nickname=null,$page=1,$limit=10){
        $res = D('UserAdmin')->search($status,$nickname,$page,$limit);
        $this->ajaxReturn(mz_json_success($res['msg']));
    }
}

 