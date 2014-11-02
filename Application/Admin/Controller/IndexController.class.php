<?php
namespace Admin\Controller;

use Common\Controller\BaseController;
use Common\Model\UserModel;
use Common\Model\UserAdminModel;
use Common\Model\AdvertisementModel;
/**
 * 管理员页面控制
 * @author Jayin
 *
 */
class IndexController extends BaseController {

    private $admin = null;

    /**
     * 需要获得管理员用户信息
     *
     * @return \Admin\Controller\IndexController
     */
    protected function reqAdmin() {
        $this->admin = (new UserAdminModel())->createAdminById(session('uid'));
        if (! $this->admin) {
            $this->logout();
            $this->redirect('admin/index/index');
        }
        $this->admin = $this->admin->getData();
        $this->assign('admin', $this->admin);
        return $this;
    }
    /**
     * 登录页
     * @see \Common\Controller\BaseController::index()
     */
    public function index() {
        if ($this->isLogin() && $this->reqAdmin()) {
            $this->redirect('admin/index/manage');
        }
        $this->display();
    }

    /**
     * 管理员管理页
     */
    public function manage() {
        $this->reqAdmin();
        
        $this->display();
    }
    /**
     * 审核机构页面
     * @param number $checked -1审核未通过 0待审核 1已审核
     * @param number $page 页码
     */
    public function checkInstitution($status = 1,$page = 1) {
        $this->reqAdmin();
        
        //默认为等待审核
        if($status != 0 && $status != 1 && $status != -1){
            $status = 1;
        }
        $res = D('UserInstitution')->search($status,null,null,$page);
        $institutions = $res['msg'];
        if($institutions){
            for($i =0;$i<count($institutions);$i++){
                $tmp =  M('User')->field('psw',true)->where("uid='%s'",$institutions[$i]['vertify_uid'])
                                                    ->limit(1)->select();
                $institutions[$i]['vertifyer'] = $tmp[0];
            }
        }
        $this->assign('institutions', $institutions);
        $this->assign('status',$status);
        $this->assign('page',$page);
        $this->display();
    }
    /**
     * 审核文档页面
     * @param number $checked -1审核未通过 0待审核 1已审核
     * @param number $categoryId 文档目录id
     * @param number $page 页码
     */
    public function checkDocument($checked = 0, $categoryId = 1, $page = 1) {
        // TODO MZ:: 注意文档状态
        $this->reqAdmin();
        // 默认为等待审核
        if ($checked != 0 && $checked != 1 && $checked != - 1) {
            $checked = 0;
        }
        $categoryId = (int)$categoryId;
        if($categoryId <1 || $categoryId > 7 ){
            $categoryId = 1;
        }
        $res = D('Document')->search($categoryId, null, null, 
                $checked,null, $page);
        $documents = $res['msg'];
        for($i=0;$i<count($documents);$i++){
            $authors = D('UserAdmin')->createAdminById($documents[$i]['uid'])->getData();
            $vertifyer =null;
            if(!empty($documents[$i]['vertify_uid'])){
                $vertifyer = D('UserAdmin')->createAdminById($documents[$i]['vertify_uid'])->getData();
            }
            if($authors){
                $documents[$i]['author'] = $authors;
                
            }else{
                $documents[$i]['author'] = null;
            }
           
            if($vertifyer){
                $documents[$i]['vertifyer'] = $vertifyer;
            }else{
                $documents[$i]['vertifyer'] = null;
            }
        }
        
        $this->assign('documents', $documents);
        $this->assign('checked',$checked);
        $this->assign('categoryId', $categoryId);
        $this->assign('page', $page);
        $this->display();
    }
    /**
     * 发布/编辑 文档
     * @param number $doc_id 文档id
     */
    public function postDocument($doc_id = 0) {
        $this->reqAdmin();
        if($doc_id || $doc_id !== 0) {
            $res = D('Document')->getDocumentInfo($doc_id);
            if($res['status']){
                $doc = $res['msg'];
                $this->assign('document',$doc);
                foreach ($doc['files'] as $file){
                    $file_ids[$file['id']] =  $file['id'];
                }
                $this->assign('file_ids',json_encode($file_ids));
                
            }
        }
        $this->display();
    }
    /**
     * 查看文档详情页
     * @param number $doc_id 文档id
     */
    public function viewDocument($doc_id = 0) {
        //document
        $res = D('Document')->getDocumentInfo($doc_id);
        //1.找不到该文章 or 禁止显示的均返回404
        if($res['status'] && $res['msg']['display'] == 1){
            $document = $res['msg'];
        }else{
            $this->display('404.html');
            return;            
        }
        //category
        $res = D('DocumentCategory')->getCategoryById($document['category_id']);
        $category = $res['msg'];
        //doc files
        $res = D('DocumentFile')->getDocFiles($document['id'],'application');
        $files = $res['msg'];
        for($i=0;$i<count($files);$i++){
            $files[$i]['url'] = mz_get_docfile_path($files[$i]['save_path'], $files[$i]['save_name']);
        }
        //image
        $res = D('DocumentFile')->getDocFiles($document['id'],'image');
        $images = $res['msg'];
        for($i=0;$i<count($images);$i++){
            $images[$i]['url'] = mz_get_docfile_path($images[$i]['save_path'], $images[$i]['save_name']);
        }
        $this->assign('document', $document);
        $this->assign('category', $category);
        $this->assign('files', $files);
        $this->assign('images', $images);
        $this->display();
    }

    /**
     * 查看机构页
     * @param number $institutionId 机构id
     */
    public function viewInstitution($institutionId = 0) {
        $this->reqAdmin();
        if($institutionId !== 0){
            $res = D('User')->getInsInfo($institutionId);
            $ins = $res['msg'];
            $this->assign('ins',$ins);
            //附件
            $res = D('DocumentFile')->getDocFilesByIns($institutionId);
            $files = $res['msg'];
            
            for($i=0;$i<count($files);$i++){
                $files[$i]['url'] = mz_get_docfile_path($files[$i]['save_path'], $files[$i]['save_name']);
            }
            $this->assign('files',$files);
        }
        $this->display();
    }

    /**
     * 查看管理员页
     * @param number $adminId 管理员id
     */
    public function viewAdmin($admin_id = 0) {
        $this->reqAdmin();
       
        if($admin_id !== 0){
            $res = D('UserAdmin')->info($admin_id);
            $admin = $res['msg'];
            $admin['per_categorys_post'] = json_decode($admin['per_categorys_post']);
            $admin['per_categorys_check'] = json_decode($admin['per_categorys_check']);
            $this->assign('adm',$admin);
        }
        $this->display();
    }

    /**
     * 查看个人用户页
     * @param number $user_id 管理员id
     */
    public function viewUser($user_id = 0) {
        $this->reqAdmin();
         //todo 权限判断
        if($user_id !== 0){
            $res = D('UserPerson')->info($user_id);
            $admin = $res['msg'];
            $this->assign('usr',$admin);
        }
        $this->display();
    }
     
     
    /**
     * 查看企业用户页
     * @param number $adminId 管理员id
     */
    public function viewEmpoyer($emplyoer_id = 0)
		{
		}
    /**
     * 广告管理页
     */
    public function advertisements(){
        $this->reqAdmin();
        
        $ad_model = new AdvertisementModel();
        $ad_display = $ad_model->search(AdvertisementModel::STATUS_DISPLAY);
        $ad_undisplay = $ad_model->search(AdvertisementModel::STATUS_UNDISPLAY);
        
        $this->assign('ad_display',$ad_display['msg']);
        $this->assign('ad_undisplay',$ad_undisplay['msg']);
        $this->display();
    }
    /**
     * 用户列表页
     * @param unknown $status 审核状态,默认审核通过1
     * @param number $page
     * @param number $limit
     */
    public function userList($status=UserModel::STATUS_PASS,$page=1,$limit=10){
        $this->reqAdmin();
        $res = D('UserPerson')->search($status,null,null,null,$page,$limit);
        $this->assign('status',$status);
        $this->assign('page',$page);
        $this->assign('users',$res['msg']);
        $this->display();
    }
    /**
     * 管理员列表页
     * @param unknown $status  审核状态,默认审核通过1
     * @param number $page
     * @param number $limit
     */
    public function adminList($status=UserModel::STATUS_PASS,$page=1,$limit=10){
        $this->reqAdmin();
        $res = D('UserAdmin')->search($status,null,$page,$limit);
        $admins = $res['msg'];
        for($i=0;$i<count($admins);$i++){
            $admins[$i]['per_categorys_post'] = json_decode($admins[$i]['per_categorys_post']);
            $admins[$i]['per_categorys_check'] = json_decode($admins[$i]['per_categorys_check']);
        }
        $this->assign('status',$status);
        $this->assign('page',$page);
        $this->assign('admins',$admins);
        $this->display();
    }
    /**
     * 企业用户列表页
     * @param string $status 审核状态,默认审核通过1
     * @param unknown $page
     * @param number $limit
     */
    public function employerList($status=UserModel::STATUS_PASS,$page=1,$limit=10){
        $this->reqAdmin();
        $res = D('UserEmployer')->search($status,null,null,$page,$limit);
        $this->assign('status',$status);
        $this->assign('page',$page);
        $this->assign('employers',$res['msg']);
        $this->display();
    }
    /**
     * 系统设置页
     */
    public function setting(){
        $this->reqAdmin();
    	$this->display();
    }
    /**
     * 创建管理员页
     */
    public function createAdmin(){
        $this->reqAdmin();
        $this->display();
    }
    
}