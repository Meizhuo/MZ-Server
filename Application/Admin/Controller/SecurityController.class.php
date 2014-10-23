<?php
namespace Admin\Controller;
use Common\Controller\BaseController;

/**
 * 安全相关(修改密码)
 * @author Jayin
 *
 */
class SecurityController extends BaseController {
    /**
     * 更换密码页
     */
    public function changePsw(){
        $this->assign('code',I('get.code'));
        $this->assign('e',I('get.e'));
        $this->display();
    }
    /**
     * 忘记密码页
     */
    public function forgetPsw(){
        $this->display();
    }

}

