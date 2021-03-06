<?php
namespace Home\Controller;
use Common\Controller\BaseController;

class AppController extends BaseController {

    /**
     * GET 获取当前版本信息
     */
    public function getVersionInfo() {
        $new_version = M('appinfo');
        $data = $new_version->order('id desc')->limit(1)->select();
        if(count($data) > 0){
            $this->ajaxReturn($data[0]);
        }else{
            $this->ajaxReturn(mz_json_error("not any version info right now"));
        }
    }
    /**
     * GET 获得当前最新版本的下载链接
     */
    public function lastDownloadUrl(){
    	$new_version = M('appinfo');
    	$data = $new_version->order('id desc')->limit(1)->select();
    	if(count($data) > 0){
			 header('Location: ' . $data[0]['url']);
    	}else{
    		$this->redirect('/admin/view/download');
    	}
    }
    /**
     * POST 添加版本信息
     */
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

