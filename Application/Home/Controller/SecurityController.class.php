<?php
namespace Home\Controller;
use Common\Controller\BaseController;

/**
 * 安全相关(修改密码)
 * @author Jayin
 *
 */
class SecurityController extends BaseController {
    
    public function changePsw(){
        $this->reqPost('old_psw,new_psw')->reqLogin();
        $uid = session('uid');
        if(strlen(I('post.new_psw')) < 8 && strlen(I('post.new_psw')) >16){
            $this->ajaxReturn(mz_json_error('密码长度为8-16'));
        }
        $User = M('User');
        if($User->where("uid='%s' AND psw='%s'",$uid,md5(I('post.old_new')))
                ->save(array('psw' => md5(I('post.new_psw')))) >= 0){
            $this->ajaxReturn(mz_json_success('修改成功'));
        }else{
            $this->ajaxReturn(mz_json_error('修改失败'));
        }
        
    }
}

