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
        
        print_r($D->linkToDoc(3,array(10,11)));
    }
}