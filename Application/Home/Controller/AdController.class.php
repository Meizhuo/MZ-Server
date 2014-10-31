<?php
namespace Home\Controller;
use Common\Controller\BaseController;
use Common\Model\UserAdminModel;
use Common\Model\AdvertisementModel;

/**
 * 广告接口
 * @author Jayin
 *
 */
class AdController extends BaseController {

    /**
     * 获得当前的广告，最多5个
     */
    public function current(){
        $res = (new AdvertisementModel())->getCurrent();
        $this->ajaxReturn(mz_json_success($res['msg']));
    }
    /**
     * 发布一条广告
     */
    public function  post(){
        $this->reqPost(array('description','url','pic_url'))->reqAdmin();
        $res = (new AdvertisementModel())->post(I('post.description'), I('post.url'), I('post.pic_url'));
        if($res['status']){
            $this->ajaxReturn(mz_json_success());
        }
        $this->ajaxReturn(mz_json_error($res['msg']));
    }
    /**
     * 显示一个广告
     */
    public function  diplayAd(){
        $this->reqPost(array('ad_id'))->reqAdmin();
        $res = (new AdvertisementModel())->displayAd(I('post.ad_id'));
        if($res['status']){
            $this->ajaxReturn(mz_json_success());
        }
        $this->ajaxReturn(mz_json_error($res['msg']));
    }
    /**
     * 不显示一广告
     */
    public function  undisplayAd(){
        $this->reqPost(array('ad_id'))->reqAdmin();
        $res = (new AdvertisementModel())->unDisplayAd(I('post.ad_id'));
        if($res['status']){
            $this->ajaxReturn(mz_json_success());
        }
        $this->ajaxReturn(mz_json_error($res['msg']));
    }
    /**
     * 删除一广告
     */
    public function  delete(){
        $this->reqPost(array('ad_id'))->reqAdmin();
        $res = (new AdvertisementModel())->deleteAd(I('post.ad_id'));
        if($res['status']){
            $this->ajaxReturn(mz_json_success());
        }
        $this->ajaxReturn(mz_json_error($res['msg']));
    }
    /**
     * 根据文档创建广告
     */
    public function createByDoc(){
        $this->reqPost(array('doc_id'))->reqAdmin();
        
        $res = (new AdvertisementModel())->createByDoc(I('post.doc_id'));
        if($res['status']){
            $this->ajaxReturn(mz_json_success());
        }else{
            $this->ajaxReturn(mz_json_error($res['msg']));
        }
        
    }
    
}

