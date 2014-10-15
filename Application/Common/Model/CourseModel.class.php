<?php
namespace Common\Model;
use Common\Model\BaseModel;
/**
 * 课程模型
 * @author Jayin
 *
 */
class CourseModel extends BaseModel{


    protected $_validate = array(
    	array('start_time','number','开课时间 应该为时间戳timestamp'),
        array('cost','number','课程费用应为数字')
    );
    /**
     * 发布课程
     * @param unknown $data
     * @return Ambigous <string, multitype:number string >
     */
    public function post($data) {
        $res = $this->_getResult();
        if ($this->create($data)) {
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
    public function search($institution_id = '', $subsidy_id = '', $name = '', $page = 1, 
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
        // 保证为正数
        $limit = $limit > 0 ? $limit : 10;
        $page = $page > 0 ? $page : 1;
        $res['msg'] = $this->where($map)
            ->limit(($page - 1) * $limit, $limit)
            ->select();
        if (empty($res['msg'])) {
            $res['msg'] = array();
        }
        $res['status'] = 1;
        return $res;
    }
}

 