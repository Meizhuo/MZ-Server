<?php
namespace Home\Controller;
use Common\Controller\BaseController;
use Common\Model\DocumentFileModel;

class IndexController extends BaseController {

    public function index() {
        $this->display();
    }
    
    public function upload(){
        $this->display();
    }
    
    public function test(){
        $D = new DocumentFileModel();
        
        $D->remove(5);
    }
}