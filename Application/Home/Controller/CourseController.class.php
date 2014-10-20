<?php
namespace Home\Controller;
use Common\Controller\BaseController;
use Common\Model\UserModel;
use Common\Model\CourseModel;

/**
 * 课程接口
 * @author Jayin
 *
 */
class CourseController extends BaseController {
    /**
     * 需要验证权限 1.是机构用户 2.机构未通过审核
     * @return \Home\Controller\CourseController
     */
    protected function reqPermission(){
        $person = D('User')->createInstution(session('uid'))->getData();
        //注意这里是字符与数字的比较 用==
        if(!($person['level'] == UserModel::LEVEL_INSTITUTION && $person['status'] == UserModel::STATUS_PASS)){
            $this->ajaxReturn(mz_json_error('操作失败 :机构未通过审核'));
        }
        return $this;
    }
    /**
     * POST 发布一课程
     */
    public function post(){
        $this->reqPost()->reqLogin()->reqPermission();
        $data['institution_id'] = session('uid');
        $res = D('Course')->post(array_merge($data,I('post.')));
        if($res['status']){
            $this->ajaxReturn(mz_json_success('post successfully'));
        }else{
            $this->ajaxReturn(mz_json_error($res['msg']));
        }
    }
    /**
     * POST 更新一课程
     */
    public function update(){
        $this->reqPost(array('course_id'))->reqLogin()->reqPermission();
        //只能更新自己的
        $data['institution_id'] = session('uid');
        $data['id'] = I('post.course_id');
        $res = D('Course')->update(array_merge($data,I('post.')));
        if($res['status']){
            $this->ajaxReturn(mz_json_success('update successfully'));
        }else{
            $this->ajaxReturn(mz_json_error($res['msg']));
        }
    }
    /**
     * POST 删除以课程
     * @param int $course_id 课程id
     */
    public function delete(){
        $this->reqPost(array('course_id'))->reqLogin()->reqPermission();
        
        $res = D('Course')->remove(session('uid'),I('post.course_id'));
        if($res['status']){
            $this->ajaxReturn(mz_json_success('delete successfully'));
        }else{
            $this->ajaxReturn(mz_json_error($res['msg']));
        }
    }
    /**
     * POST 显示课程
     */
    public function displayCourse(){
        $this->reqPost(array('course_id'))->reqLogin()->reqPermission();
        
        $res = D('Course')->displayCourse(session('uid'),I('post.course_id'));
        if($res['status']){
            $this->ajaxReturn(mz_json_success());
        }else {
            $this->ajaxReturn(mz_json_error($res['msg']));
        }
    }
    /**
     * POST 不显示课程
     */
    public function unDisplayCourse(){
        $this->reqPost(array('course_id'))->reqLogin()->reqPermission();
    
        $res = D('Course')->unDisplayCourse(session('uid'),I('post.course_id'));
        if($res['status']){
            $this->ajaxReturn(mz_json_success());
        }else {
            $this->ajaxReturn(mz_json_error($res['msg']));
        }
    }
    /**
     * 查询
     * 基础接口，请调用 lists()
     * @param unknown $institution_id 机构id
     * @param unknown $subsidy_id 补贴项目id
     * @param unknown $name 课程名称
     * @param unknown $diplay 是否上线的课程
     * @param unknown $page 页码 默认1
     * @param unknown $limit 返回数 默认10
     */
    private function search($institution_id='',$subsidy_id='',$name='',$display='',$page=1,$limit=10){
    	$res = D('Course')->search($institution_id,$subsidy_id,$name,$display,$page,$limit);
    	if($res['status']){
    	    $this->ajaxReturn(mz_json_success($res['msg']));
    	}else{
    	    $this->ajaxReturn(mz_json_error($res['msg']));
    	}
    }
    /**
     * 获得课程列表
     * 返回均上线的课程
     * @param unknown $institution_id 机构id
     * @param unknown $subsidy_id 补贴项目id
     * @param unknown $name 课程名称
     * @param unknown $page 页码 默认1
     * @param unknown $limit 返回数 默认10
     */
    public function lists($institution_id='',$subsidy_id='',$name='',$page=1,$limit=10){
        //默认是上线的课程
        return $this->search($institution_id='',$subsidy_id='',$name='',CourseModel::VISIBILITY_DISPLAY,$page=1,$limit=10);
    }
}

 