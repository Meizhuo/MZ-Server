<?php
namespace Home\Controller;
use Common\Controller\BaseController;

/**
 * 文档
 * 
 * @author Jayin
 *        
 */
class DocumentController extends BaseController {
    /**
     * 发布一文档
     */
    public function post() {
    	//TODO 检查权限
        if(!IS_POST){
            $this->ajaxReturn(mz_json_error_request());
            return;
        }
    	if(!session('uid')){
    	    $this->ajaxReturn(mz_json_error("login please"));
    	    return;
    	}
    	$uid = session('uid');
    	$res = D('Document')->addDocument($uid);
    	if($res['status']){
    	    $this->ajaxReturn(mz_json_success("post successfully"));
    	}else{
    	    $this->ajaxReturn(mz_json_error($res['msg']));
    	}
    	
    }
    /**
     * 更新文档
     */
    public function update() {
    	//TODO 检查权限
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
	    $res = D('Document')->updateDocument(I('post.doc_id'),I('post.'));
	    if($res['status']) {
	        $this->ajaxReturn(mz_json_success("update successfully"));
	    }else{
	        $this->ajaxReturn(mz_json_error($res['msg']));
	    }
    }
    /**
     * 获得文档的信息 
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
    
//     public function vertify($doc_id,$op){}

    public function search() {}

    public function getCategory() {}

    public function upload() {}
}

 