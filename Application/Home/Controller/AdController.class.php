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
     * 需要获得管理员权限
     *
     * @return \Admin\Controller\IndexController
     */
    protected function reqAdmin() {
        $this->admin = (new UserAdminModel())->createAdminById(session('uid'));
        if (! $this->admin) {
            $this->ajaxReturn(mz_json_error('你的权限不足'));
        }
        return $this;
    }
    
    public function current(){
        $res = (new AdvertisementModel())->getCurrent();
        $this->ajaxReturn(mz_json_success($res['msg']));
    }

    public function  post(){
        $this->reqPost(array('description','url','pic_url'))->reqAdmin();
        $res = (new AdvertisementModel())->post(I('post.description'), I('post.url'), I('post.pic_url'));
        if($res['status']){
            $this->ajaxReturn(mz_json_success());
        }
        $this->ajaxReturn(mz_json_error($res['msg']));
    }
    public function  diplayAd(){
        $this->reqPost(array('ad_id'))->reqAdmin();
        $res = (new AdvertisementModel())->displayAd(I('post.ad_id'));
        if($res['status']){
            $this->ajaxReturn(mz_json_success());
        }
        $this->ajaxReturn(mz_json_error($res['msg']));
    }
    
    public function  undisplayAd(){
        $this->reqPost(array('ad_id'))->reqAdmin();
        $res = (new AdvertisementModel())->unDisplayAd(I('post.ad_id'));
        if($res['status']){
            $this->ajaxReturn(mz_json_success());
        }
        $this->ajaxReturn(mz_json_error($res['msg']));
    }
    public function  delete(){
        $this->reqPost(array('ad_id'))->reqAdmin();
        $res = (new AdvertisementModel())->deleteAd(I('post.ad_id'));
        if($res['status']){
            $this->ajaxReturn(mz_json_success());
        }
        $this->ajaxReturn(mz_json_error($res['msg']));
    }
    
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

