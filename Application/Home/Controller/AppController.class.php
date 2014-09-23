<?php
namespace Home\Controller;
use Think\Controller;

class AppController extends Controller {

    public function index() {
        $this->ajaxReturn(mz_json_error("request method error"));
    }

    public function getVersionInfo() {
        $new_version = M('appinfo');
        $data = $new_version->order('id desc')->limit(1)->select();
        if(count($data) > 0){
            $this->ajaxReturn($data[0]);
        }else{
            $this->ajaxReturn(mz_json_error("not any version info right now"));
        }
    }

    public function addNewVersion() {
        if (!IS_POST) {
            $this->ajaxReturn(mz_json_error("request method error"));
        }
        $new_version = M('appinfo');
        $new_version->create();
        if($new_version->add()){
            $this->ajaxReturn(mz_json_success());
        }else{
            $this->ajaxReturn(mz_json_error());
        }
    }   
}

