<?php
namespace Common\Model;
use Common\Model\BaseModel;
/**
 * 课程模型
 * @author Jayin
 *
 */
class CourseModel extends BaseModel{
    /** 不可见(下线)*/
    const VISIBILITY_UNDISPLAY = -1;
    /** 可见(上线)*/
    const VISIBILITY_DISPLAY = 1;

    protected $_validate = array(
        array('cost','number','课程费用应为数字'),
        array('start_time', '/^\d{4}-\d{1,2}-\d{1,2}$/','时间格式不正确',self::EXISTS_VALIDATE,'regex')
    );
    /**
     * 发布课程
     * @param unknown $data
     * @return Ambigous <string, multitype:number string >
     */
    public function post($data) {
        $res = $this->_getResult();
        //任何课程已发布都是默认未上线
        $data['display'] = self::VISIBILITY_UNDISPLAY;
        if ($this->create($data)) {
            //前端已处理转义
            if(!is_null($this->data['introduction'])){
                $this->data['introduction'] = I('post.introduction','','');
            }
            if ($this->add()) {
                $res['status'] = 1;
            } else {
                $res['msg'] = 'System Error: Not able to insert';
            }
        } else {
            $res['msg'] = $this->getError();
        }
        return $res;
    }
    /**
     * 更新
     * @param unknown $data
     * @return unknown
     */
    public function update($data) {
        $res = $this->_getResult();
        if ($this->create($data)) {
            //前端已处理转义
            if(!is_null($this->data['introduction'])){
                $this->data['introduction'] = I('post.introduction','','');
            }
            if (count($this->data) === 1 || $this->save() >= 0) {
                $res['status'] = 1;
            } else {
                $res['msg'] = 'System Error: Not able to update';
            }
        } else {
            $res['msg'] = $this->getError();
        }
        return $res;
    }
    /**
     * 显示(上线)课程
     * @param unknown $course_id
     */
    public function displayCourse($institution_id,$course_id){
        $res = $this->_getResult();
        $data['display'] = self::VISIBILITY_DISPLAY;
        if($this->where("id='%s' AND institution_id='%s'",$course_id,$institution_id)->save($data)>=0){
            $res['status'] = 1;
        }else{
            $res['msg'] = $this->getError();
        }
        return $res;
        
    }
    /**
     * 不显示(不上线)课程
     * @param unknown $course_id
     */
    public function unDisplayCourse($institution_id,$course_id){
        $res = $this->_getResult();
        $data['display'] = self::VISIBILITY_UNDISPLAY;
        if($this->where("id='%s' AND institution_id='%s'",$course_id,$institution_id)->save($data)>=0){
            $res['status'] = 1;
        }else{
            $res['msg'] = $this->getError();
        }
        return $res;
    }
    /**
     * 删除  (根据机构id)
     * @param unknown $institution_id
     * @param unknown $course_id
     * @return string
     */
    public function remove($institution_id,$course_id){
        $res = $this->_getResult();
        if($this->emptyParams($institution_id,$course_id)){
            $res['msg']  = 'Missing parames';
            return $res;
        }
        if($this->where("id=%d and institution_id=%d",$course_id,$institution_id)->delete()){
            $res['status'] =1;
        }else{
            $res['msg']  = 'System Error: Not able to delete';
        }     
        return $res;
    }
    /**
     * 根据课程id获得课程信息
     * @param unknown $course_id
     * @return Ambigous <number, string, multitype:number string >
     */
    public function info($course_id){
        $res = $this->_getResult();
        $res['msg'] = $this->where("id='%s'",$course_id)->select()[0];
        if($res['msg']){
            $res['status'] =1;
        }else{
            $res['msg'] = "找不到该课程";
        }
        return $res;
    }

    /**
     * 查询
     * 
     * @param unknown $institution_id            
     * @param unknown $subsidy_id            
     * @param unknown $name            
     * @param number $page            
     * @param number $limit            
     * @return unknown
     */
    public function search($institution_id = null, $subsidy_id = null, $name = null,$display=null, $page = 1, 
            $limit = 10) {
        $res = $this->_getResult();
        $map = array();
        if (! empty($institution_id)) {
            $map['institution_id'] = array('eq', $institution_id);
        }
        if (! empty($subsidy_id)) {
            $map['subsidy_id'] = array('eq',$subsidy_id);
        }
        if (! empty($name)) {
            $map['name'] = array('like','%' . $name . '%');
        }
        if (! empty($display)) {
            $map['display'] = array('eq',$display);
        }
        // 保证为正数
        $limit = $limit > 0 ? $limit : 10;
        $page = $page > 0 ? $page : 1;
        $res['msg'] = $this->join('mz_subsidy_standary ON (mz_course.subsidy_id =mz_subsidy_standary.id)')->where($map)
            ->field('mz_course.id,institution_id,subsidy_id,name,start_time,address,teacher,cost,display,certificate_type,kind,level,money,series,title')
            ->limit(($page - 1) * $limit, $limit)
            ->select();
        if (empty($res['msg'])) {
            $res['msg'] = array();
        }
        $res['status'] = 1;
        return $res;
    }
}

 