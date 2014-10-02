<?php
namespace Home\Controller;
use Common\Controller\BaseController;

/**
 * 补贴项目(课程)
 * @author Jayin
 *
 */
class SubsidyController extends BaseController {
    /**
     * 发布
     */
    public function post(){
        //TODO 检查是否有权限
       if(!IS_POST){
           $this->ajaxReturn(mz_json_error_request());
       }
       $res = D('Subsidy')->post();
       if($res['status']){
           $this->ajaxReturn(mz_json_success('post successfully'));
       }else{
           $this->ajaxReturn(mz_json_error($res));
       }
    }
    /**
     * 更新
     */
    public function update(){
        //TODO 检查是否有权限
        if(!IS_POST){
            $this->ajaxReturn(mz_json_error_request());
        }
        $res = D('Subsidy')->update();
        if($res['status']){
            $this->ajaxReturn(mz_json_success('update successfully'));
        }else{
            $this->ajaxReturn(mz_json_error($res));
        }
    }
    /**
     * 删除
     */
    public function remove(){
        //TODO 检查是否有权限
        if(!IS_POST){
            $this->ajaxReturn(mz_json_error_request());
        }
        if(I('post.id')){
            D('Subsidy')->remove(I('post.id'));
            $this->ajaxReturn(mz_json_success('remove successfuly'));
        }else{
            $this->ajaxReturn(mz_json_error("require params `id`"));
        }
    }
    /**
     * @return [{"certificate_type":"xxx"}.....,{"certificate_type":"xxx"}]
     */
    public function getCertificateTypes() {
        $res = D('Subsidy')->getSigleFieldType('certificate_type');
        $this->ajaxReturn($res['msg']);
    }
    
    public function getKinds(){
        $res = D('Subsidy')->getSigleFieldType('kind');
        $this->ajaxReturn($res['msg']);
    }
    
    public function getLevels(){
        $res = D('Subsidy')->getSigleFieldType('level');
        $this->ajaxReturn($res['msg']);
    }
    
    public function getSeries(){
        $res = D('Subsidy')->getSigleFieldType('series');
        $this->ajaxReturn($res['msg']);
    }
    
    public function getTitles(){
        $res = D('Subsidy')->getSigleFieldType('title');
        $this->ajaxReturn($res['msg']);
    }
    /**
     * 模糊搜索
     * @param string $certificate_type
     * @param string $kind
     * @param string $level
     * @param string $series
     * @param string $title
     * @param number $page
     * @param number $limt
     */
    public function search($certificate_type = '', $kind = '', $level = '', $series = '', 
            $title = '', $page = 1, $limt = 10) {
        $res = D('Subsidy')->search($certificate_type, $kind, $level, $series, 
                $title, $page, $limt);
        if ($res['status']) {
            $this->ajaxReturn(mz_json_success($res['msg']));
        } else {
            $this->ajaxReturn(mz_json_error($res['msg']));
        }
    }
}

