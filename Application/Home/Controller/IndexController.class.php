<?php
namespace Home\Controller;
use Common\Controller\BaseController;

class IndexController extends BaseController {

    public function index() {
        $this->display();
    }
    
    public function test(){
//         print_r(D('User')->createPersonById($uid)->data());
       $this->reqPost(array("name",'id'));
       $this->ajaxReturn("ok");
    }
}