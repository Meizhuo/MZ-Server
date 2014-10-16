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
    
    public function mytest(){
//         print_r(json_encode(D('Document')->getDocumentInfo(166)));
        print_r(D('DocumentFile')->linkToDoc(2,array(67,68)));
    }
}