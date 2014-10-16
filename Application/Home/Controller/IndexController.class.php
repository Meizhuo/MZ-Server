<?php
namespace Home\Controller;
use Common\Controller\BaseController;

class IndexController extends BaseController {

    public function index() {
        $this->redirect('admin/institution/index');
    }
    
    public function upload(){
        $this->display();
    }
    
    public function test(){
        $this->display();
    }
}