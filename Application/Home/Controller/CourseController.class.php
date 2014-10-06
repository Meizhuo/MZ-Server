<?php
namespace Home\Controller;
use Common\Controller\BaseController;

/**
 * 课程接口
 * @author Jayin
 *
 */
class CourseController extends BaseController {
    
    public function post(){
        // TODO 检查权限
        if(!IS_POST){
            $this->ajaxReturn(mz_json_error_request());
            return;
        }
        $res = D('Course')->post();
        if($res['status']){
            $this->ajaxReturn(mz_json_success('post successfully'));
        }else{
            $this->ajaxReturn(mz_json_error($res['msg']));
        }
    }
    
    public function update(){
        // TODO 检查权限
        if(!IS_POST){
            $this->ajaxReturn(mz_json_error_request());
            return;
        }
        $res = D('Course')->update(I('post.'));
        if($res['status']){
            $this->ajaxReturn(mz_json_success('update successfully'));
        }else{
            $this->ajaxReturn(mz_json_error($res['msg']));
        }
    }
    public function delete($course_id){
        // TODO 检查权限
        if(!IS_POST){
            $this->ajaxReturn(mz_json_error_request());
            return;
        }
        $res = D('Course')->delete($course_id);
        if($res['status']){
            $this->ajaxReturn(mz_json_success('delete successfully'));
        }else{
            $this->ajaxReturn(mz_json_error($res['msg']));
        }
    }

    public function search($institution_id='',$subsidy_id='',$name='',$page=1,$limit=10){
    	$res = D('Course')->search($institution_id,$subsidy_id,$name,$page,$limit);
    	if($res['status']){
    	    $this->ajaxReturn(mz_json_success($res['msg']));
    	}else{
    	    $this->ajaxReturn(mz_json_error($res['msg']));
    	}
    }
}

 