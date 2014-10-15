<?php
namespace Home\Controller;
use Common\Controller\BaseController;
use Common\Model\UserModel;

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
            $this->ajaxReturn(mz_json_error('Permission Refused:   你不是机构用户  or 机构未通过审核'));
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
     * GET 查询
     * @param string $institution_id 机构id 
     * @param string $subsidy_id  补贴项目id
     * @param string $name 课程名称
     * @param number $page 页码 默认1
     * @param number $limit 返回数 默认10
     */
    public function search($institution_id='',$subsidy_id='',$name='',$page=1,$limit=10){
    	$res = D('Course')->search($institution_id,$subsidy_id,$name,$page,$limit);
    	if($res['status']){
    	    $this->ajaxReturn(mz_json_success($res['msg']));
    	}else{
    	    $this->ajaxReturn(mz_json_error($res['msg']));
    	}
    }
}

 