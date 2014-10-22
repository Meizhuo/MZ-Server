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
     * POST 发布
     */
    public function post(){
       $this->reqPost()->reqLogin()->reqAdmin();

       $res = D('Subsidy')->post();
       if($res['status']){
           $this->ajaxReturn(mz_json_success('post successfully'));
       }else{
           $this->ajaxReturn(mz_json_error($res));
       }
    }
    /**
     *POST 更新
     */
    public function update(){
        $this->reqPost()->reqLogin()->reqAdmin();
        
        $res = D('Subsidy')->update();
        if($res['status']){
            $this->ajaxReturn(mz_json_success('update successfully'));
        }else{
            $this->ajaxReturn(mz_json_error($res['msg']));
        }
    }
    /**
     * POST 删除
     */
    public function remove(){
        $this->reqPost()->reqLogin()->reqAdmin();
         
        if(I('post.id')){
            D('Subsidy')->remove(I('post.id'));
            $this->ajaxReturn(mz_json_success('remove successfuly'));
        }else{
            $this->ajaxReturn(mz_json_error("require params `id`"));
        }
    }
    /**
     * GET 证书类别
     * @return [{"certificate_type":"xxx"}.....,{"certificate_type":"xxx"}]
     */
    public function getCertificateTypes() {
        $res = D('Subsidy')->getSigleFieldType('certificate_type');
        $this->ajaxReturn(mz_json_success($res['msg']));
    }
    /** GET 类别*/
    public function getKinds(){
        $res = D('Subsidy')->getSigleFieldType('kind');
        $this->ajaxReturn(mz_json_success($res['msg']));
    }
    /** GET 等级*/
    public function getLevels($certificate_type=null,$kind=null){
        $res = D('Subsidy')->getSigleFieldType('level',$certificate_type,$kind);
        $this->ajaxReturn(mz_json_success($res['msg']));
    }
    /** GET 系列*/
    public function getSeries(){
        //TODO MZ:: 还没有数据
        $res = D('Subsidy')->getSigleFieldType('series');
        $this->ajaxReturn(mz_json_success($res['msg']));
    }
    /** GET 资格名称*/
    public function getTitles($certificate_type=null,$kind=null,$level=null){
        $res = D('Subsidy')->getSigleFieldType('title',$certificate_type,$kind,$level);
        $this->ajaxReturn(mz_json_success($res['msg']));
    }
    /**
     * GET 模糊搜索
     * @param string $certificate_type
     * @param string $kind
     * @param string $level
     * @param string $series
     * @param string $title
     * @param number $page
     * @param number $limt
     */
    public function search($certificate_type = null, $kind = null, $level = null, $series = null, 
            $title = null, $page = 1, $limit = 10) {
        $res = D('Subsidy')->search($certificate_type, $kind, $level, $series, 
                $title, $page, $limit);
        if ($res['status']) {
            $this->ajaxReturn(mz_json_success($res['msg']));
        } else {
            $this->ajaxReturn(mz_json_error($res['msg']));
        }
    }
}

