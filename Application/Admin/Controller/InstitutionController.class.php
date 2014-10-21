<?php
namespace Admin\Controller;
use Common\Controller\BaseController;
use Common\Model\UserInstitutionModel;
use Common\Model\CourseModel;

/**
 * 机构用户管理
 * 
 * @author Jayin
 *        
 */
class InstitutionController extends BaseController {

    private $institution = null;

    /**
     * 需要获得机构用户信息
     * 
     * @return \Admin\Controller\InstitutionController
     */
    protected function reqInstituion() {
        $this->institution = (new UserInstitutionModel())->createInsById(
                session('uid'));
        if (! $this->institution) {
            $this->logout();
            $this->redirect('admin/institution/index');
        }
        $this->institution = $this->institution->getData();
        $this->assign('institution', $this->institution);
        return $this;
    }

    public function index() {
        if($this->isLogin() && $this->reqInstituion()){
            $this->redirect('admin/institution/manage');
        }
        $this->display();
    }
    
    public function signIn(){
        $this->display();
    }

    /**
     * POST 登录
     */
    public function login() {
        $this->reqPost();
        
        $account = I('post.account');
        $psw = md5(I('post.psw'));
        $User = D('User');
        if (strstr($account, '@')) {
            $res = $User->login('email', $account, $psw);
        } else {
            $res = $User->login('phone', $account, $psw);
        }
        if ($res['status']) {
            session('uid', $res['msg']['uid']);
            $this->ajaxReturn(mz_json_success(U('admin/institution/manage')));
        } else {
            $this->ajaxReturn(mz_json_error($res['msg']));
        }
    }

    public function manage() {
        $this->reqInstituion();
        $this->display();
    }

    public function updateInfo() {
        $this->reqInstituion();
        
        $res = D('User')->getInsInfo(session('uid'));
        if ($res['status']) {
            $institution = $res['msg'];
            $this->assign('institution', $institution);
            foreach ($institution['files'] as $file) {
                $file_ids[$file['id']] = $file['id'];
            }
            $this->assign('file_ids', json_encode($file_ids));
        }
        
        $this->assign('uid', session('uid'));
        $this->display();
    }

    public function postCourse($institution_id = 0) {
        $this->reqInstituion();
        if(is_numeric(I('get.institution_id')) && (int)(I('get.institution_id')) > 0){
             $res = D('Course')->info(I('get.institution_id'));
             $this->assign('course', $res['msg']);
        }
        $this->display();
    }

    public function courseList($display = CourseModel::VISIBILITY_DISPLAY, $page = 1) {
        $this->reqInstituion();
        $res = D('Course')->search($this->institution['uid'], null, null,I('get.display'), $page);
        print_r(I('get.display'));
        $this->assign('courses', $res['msg']);
        $this->assign('page',$page);
        $this->assign('display',$display);
        $this->display();
    }
}

 