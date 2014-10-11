<?php
namespace Admin\Controller;
use Common\Controller\BaseController;
use Common\Model\UserAdminModel;
use Common\Model\UserModel;
use Common\Model\DocumentModel;

class IndexController extends BaseController {
    
    private $admin = null;

    /**
     * 需要获得用户信息
     * 
     * @return \Admin\Controller\IndexController
     */
    protected function reqAdmin() {
        $this->admin = (new UserAdminModel())->createAdminById(session('uid'));
        if (! $this->admin) {
            $this->ajaxReturn(mz_json_error("Login please!"));
        }
        $this->assign('admin',$this->admin->getData());
        return $this;
    }
    
    public function index() {
        if($this->isLogin()){
            $this->redirect('admin/index/manage');
        }
        $this->display();
    }
    
    /**
     * POST 登录
     */
    public function login(){
        $this->reqPost();
        
        $account = I('post.account');
        $psw = md5(I('post.psw'));
        $User = D('User');
        if(strstr($account,'@')){
            $res = $User->login('email',$account,$psw);
        }else{
            $res = $User->login('phone',$account,$psw);
        }
        if($res['status']){
            session('uid',$res['msg']['uid']);
            $this->ajaxReturn(mz_json_success(U('admin/index/manage')));
        }else{
            $this->ajaxReturn(mz_json_error($res['msg']));
        }
    }

    public function manage() {
       $this->reqAdmin();
      
       $this->display();
    }
    
    public function checkInstitution(){
        $this->reqAdmin();
        //TODO MZ::改为watting
        $res = D('UserInstitution')->search(UserModel::STATUS_PASS);
        $institutions = $res['msg'];
        $this->assign('institutions', $institutions);
        $this->display();
    }

    public function checkDocument($categoryId = 1) {
        // TODO MZ:: 注意文档状态
        $this->reqAdmin();
        $res = D('Document')->search($category_id = $categoryId, 
                $status = DocumentModel::VERIFY_WAITING);
        $documents = $res['msg'];
        $this->assign('documents',$documents);
        $this->display();
    }
    
    public function postDocument($categoryId = 1){
        $this->reqAdmin();
        $this->display();
    }
}