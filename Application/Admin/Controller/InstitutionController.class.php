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
    /**
     * 登录页面
     * @see \Common\Controller\BaseController::index()
     */
    public function index() {
        if($this->isLogin() && $this->reqInstituion()){
            $this->redirect('admin/institution/manage');
        }
        $this->display();
    }
    /**
     * 注册
     */
    public function signIn(){
        $this->display();
    }

    /**
     * 管理主页
     */
    public function manage() {
        $this->reqInstituion();
        $this->display();
    }
    /**
     * 更新信息页
     */
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
    /**
     * 发布/编辑课程页
     * @param number $institution_id 机构的id
     */
    public function postCourse($institution_id = 0) {
        $this->reqInstituion();
        if(is_numeric(I('get.institution_id')) && (int)(I('get.institution_id')) > 0){
             $res_course = D('Course')->info(I('get.institution_id'));
             $this->assign('course', $res_course['msg']);
             //当前的补贴项目
             $res_subsidy = D('Subsidy')->getById( $res_course['msg']['subsidy_id']);
             if($res_subsidy['status']){
                 $this->assign('subsidy',$res_subsidy['msg']);
             }
        }
        //补贴项目item
        $certificateTypes = D('Subsidy')->getSigleFieldType('certificate_type');
        $kinds = D('Subsidy')->getSigleFieldType('kind');
       
        $this->assign('certificateTypes',$certificateTypes['msg']);
        $this->assign('kinds',$kinds['msg']);
       
        $this->display();
    }
    /**
     * 课程列表页
     * @param unknown $display 是否已发布
     * @param number $page 页码
     */
    public function courseList($display = CourseModel::VISIBILITY_DISPLAY, $page = 1) {
        $this->reqInstituion();
        $display = I('get.display',CourseModel::VISIBILITY_DISPLAY);
        $res = D('Course')->search($this->institution['uid'], null, null,$display, $page);
        $this->assign('courses', $res['msg']);
        $this->assign('page',$page);
        $this->assign('display',$display);
        $this->display();
    }
}

 