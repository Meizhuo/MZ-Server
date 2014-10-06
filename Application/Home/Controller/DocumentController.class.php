<?php
namespace Home\Controller;
use Common\Controller\BaseController;
use Common\Model\UserAdminModel;
use Common\Model\DocumentModel;

/**
 * 文档
 * 
 * @author Jayin
 *        
 */
class DocumentController extends BaseController {
    /**
     *POST 发布一文档
     */
    public function post() {
        if(!IS_POST){
            $this->ajaxReturn(mz_json_error_request());
            return;
        }
    	if(!session('uid')){
    	    $this->ajaxReturn(mz_json_error("login please"));
    	    return;
    	}
    	$uid = session('uid');
    	
    	if(!I('post.category_id')){
    	    $this->ajaxReturn(mz_json_error("require params `category_id`"));
    	    return;
    	}
    	//检验权限
    	$Admin = new UserAdminModel();
    	if(! $Admin->createAdminById($uid)->hasPerPost(I('post.category_id'))){
    	    $this->ajaxReturn(mz_json_error("You have not permission!"));
    	    return;
    	}
    	
    	$res = D('Document')->addDocument($uid);
    	if($res['status']){
    	    $this->ajaxReturn(mz_json_success("post successfully"));
    	}else{
    	    $this->ajaxReturn(mz_json_error($res['msg']));
    	}
    	
    }
    /**
     *POST 更新文档
     */
    public function update() {
    	if(!IS_POST){
    	    $this->ajaxReturn(mz_json_error_request());
    	    return;
    	}
	    if(!session('uid')){
	        $this->ajaxReturn(mz_json_error("login please"));
	        return;
	    }
	    if(!I('post.doc_id')){
	        $this->ajaxReturn(mz_json_error("require params `doc_id`"));
	        return;
	    }
	    //查询获得category_id
	    $category_id = (new DocumentModel())->createDocumentById(I('post.doc_id'))->data()['category_id'];
	    $Admin = new UserAdminModel();
	    //检验权限
    	if(! $Admin->createAdminById(session('uid'))->hasPerPost($category_id)){
    	    $this->ajaxReturn(mz_json_error("You have not permission!"));
    	    return;
    	}
	    $res = D('Document')->updateDocument(I('post.doc_id'),I('post.'));
	    if($res['status']) {
	        $this->ajaxReturn(mz_json_success("update successfully"));
	    }else{
	        $this->ajaxReturn(mz_json_error($res['msg']));
	    }
    }
    /**
     * GET 获得文档的信息 
     * NOTE 在这里进行统计View
     * @param number $doc_id 文档id
     */
    public function info($doc_id=0) {
        //TODO 在这里进行统计浏览量View
    	if($doc_id === 0){
    	    $this->ajaxReturn(mz_json_error("require params `doc_id`"));
    	    return;
    	}
    	$res = D('Document')->getDocumentInfo($doc_id);
    	if($res['status']) {
    	    $this->ajaxReturn(mz_json_success($res['msg']));
    	}else{
    	    $this->ajaxReturn(mz_json_error($res['msg']));
    	}
    }
    /**
     * POST 审核文章
     */
    public function vertify(){
        if(!IS_POST){
    	    $this->ajaxReturn(mz_json_error_request());
    	    return;
    	}
    	if(!session('uid')){
    	    $this->ajaxReturn(mz_json_error("login please"));
    	    return;
    	}
    	if(!I('post.doc_id')){
    	    $this->ajaxReturn(mz_json_error("require params `doc_id`"));
    	    return;
    	}
        //查询获得category_id
        $category_id = (new DocumentModel())->createDocumentById(I('post.doc_id'))->data()['category_id'];
        $Admin = new UserAdminModel();
        //检验权限
        if(! $Admin->createAdminById(session('uid'))->hasPerPost($category_id)){
            $this->ajaxReturn(mz_json_error("You have not permission!"));
            return;
        }
        $res = (new DocumentModel())->verify(I('post.doc_id'),I('post.op',DocumentModel::VERiFY_PASS));
        if($res['status']){
            $this->ajaxReturn(mz_json_success('vertify successfully'));
        }else{
            $this->ajaxReturn(mz_json_error($res['msg']));
        }
    }
    /**
     * 模糊查询
     * @param string $category_id
     * @param string $title
     * @param string $content
     * @param number $page
     * @param number $limit
     */
    public function search($category_id='',$title='',$content='',$page=1,$limit=10) {
    	$res = D('Document')->search($category_id,$title,$content,$page,$limit);
    	if($res['status']){
    	    $this->ajaxReturn(mz_json_success($res['msg']));
    	}else{
    	    $this->ajaxReturn(mz_json_error($res['msg']));
    	}
    }

    public function getCategory() {
    	$res = M('DocumentCategory')->select();
    	$this->ajaxReturn(mz_json_success($res));
    }

    public function upload() {}
}

 