<?php
namespace Admin\Controller;
use Common\Controller\BaseController;

/**
 * 查看接口
 * @author Jayin
 *
 */
class ViewController extends BaseController {

    public function insIntro ($ins_id){
        //TODO MZ:: 检查机构不存在的情况
        $res = D('User')->getInsInfo($ins_id);
        $this->assign('institution',$res['msg']);
    	$this->display();
    }
    
    public function courseIntro($course_id){
        //TODO MZ:: 检查课程不存在的情况
        $res = D('Course')->info($course_id);
        $this->assign('course',$res['msg']);
        $this->display();
    }
}

