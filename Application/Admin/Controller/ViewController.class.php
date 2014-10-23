<?php
namespace Admin\Controller;
use Common\Controller\BaseController;

/**
 * 查看接口
 * @author Jayin
 *
 */
class ViewController extends BaseController {
    /**
     * 查看机构介绍
     * @param unknown $ins_id
     */
    public function insIntro ($ins_id){
        //TODO MZ:: 检查机构不存在的情况
        $res = D('User')->getInsInfo($ins_id);
        $this->assign('institution',$res['msg']);
    	$this->display();
    }
    /**
     * 查看课程介绍
     * @param unknown $course_id
     */
    public function courseIntro($course_id){
        //TODO MZ:: 检查课程不存在的情况
        $res = D('Course')->info($course_id);
        $this->assign('course',$res['msg']);
        $this->display();
    }
    /**
     * 下载页面
     */
    public function download(){
        $res = M('Appinfo')->order('id desc')->limit(1)->select();
        $this->assign('app',$res[0]);
        $this->display();
    }
}

