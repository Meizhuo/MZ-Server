<?php
namespace Common\Controller;
use Think\Controller;

/**
 * base controller
 * @author Jayin
 *
 */
class BaseController extends Controller {
   

    protected function _empty(){
        $this->ajaxReturn(mz_json_error("No interface for this."));
    }
    
    public function index(){
        $this->ajaxReturn(mz_json_success('Hi'));
    }
    
}

