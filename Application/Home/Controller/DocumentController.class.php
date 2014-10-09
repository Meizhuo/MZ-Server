<?php
namespace Home\Controller;
use Common\Controller\BaseController;
use Common\Model\UserAdminModel;
use Common\Model\DocumentModel;

/**
 * 文档接口
 * 
 * @author Jayin
 *        
 */
class DocumentController extends BaseController {
    /**
     *POST 发布一文档
     */
    public function post() {
        $this->reqPost(array('category_id'))->reqLogin();

    	$uid = session('uid');
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
        $this->reqPost(array('doc_id'))->reqLogin();

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
     * GET 模糊查询
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
    /**
     * GET 获得文档的栏目信息
     */
    public function getCategory() {
    	$res = M('DocumentCategory')->select();
    	$this->ajaxReturn(mz_json_success($res));
    }
    /**
     * POST 上传附件
     */
    public function upload() {
        $this->reqPost('doc_id');
        $config = array(
            'maxSize'    =>  3145728,// 设置附件上传大小 3M
            'rootPath'   =>  './Uploads/', // 设置附件上传根目录
            'savePath'   =>  '',// 设置附件上传（子）目录
            'saveName'   =>  array('uniqid',''),//上传文件的保存名称
            'exts'       =>  array('doc','docx','xls','jpg', 'gif', 'png', 'jpeg'),// 设置附件上传类型
            'subName'    =>  array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
        );
        $upload = new \Think\Upload($config);// 实例化上传类
        // 上传文件
        $info   =   $upload->upload();
        if(!$info) { 
            // 上传错误提示错误信息
            $this->ajaxReturn(mz_json_error($upload->getError()));
        }else{
            // 上传成功 获取上传文件信息
            //单文件
            foreach($info as $file){
                $res = D('DocumentFile')->post(I('doc_id'),$file);
                if($res['status']){
                    $this->ajaxReturn(mz_json_success($res['msg']));
                }else{
                    $this->ajaxReturn(mz_json_error($res['msg']));
                }
            }
        }
    }
}

 