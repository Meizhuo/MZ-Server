<?php
namespace Common\Model;
use Common\Model\BaseModel;
/**
 * 课程模型
 * @author Jayin
 *
 */
class CourseModel extends BaseModel{
//     institution_id | 所属的培训机构id (一般不能改)| N
//     subsidy_id |对应的补贴项目id  | N
//     name |课程名称 (可空  | N
//     start_time |开课时间 时间戳 可空 | N
//     address |开课地址  可空 | N
//     teacher |授课老师 可空 | N
//     introduction |课程介绍 可空 | N
//     cost |课程费用  可空 | N
    protected $_validate = array(
    	array('start_time','number','开课时间 应该为时间戳timestamp'),
        array('cost','number','课程费用应为数字')
    );

    public function post() {
        $res = $this->_getResult();
        if ($this->create()) {
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

    public function update($data) {
        $res = $this->_getResult();
        if ($this->create($data)) {
            if (count($this->data) > 1 || $this->save() >= 0) {
                $res['status'] = 1;
            } else {
                $res['msg'] = 'System Error: Not able to update';
            }
        } else {
            $res['msg'] = $this->getError();
        }
        return $res;
    }
    
    public function remove($course_id){
        $res = $this->_getResult();
        if(empty($course_id)){
            $res['msg']  = 'require `course id`';
            return $res;
        }
        if($this->where("id=%d",$course_id)->delete()>=0){
            $res['status'] =1;
        }else{
            $res['msg']  = 'System Error: Not able to delete';
        }     
        return $res;
    }

    public function search($institution_id,$subsidy_id,$name,$page=1,$limit=10){
        $res = $this->_getResult();
        $map = array();
        if(!empty($institution_id)){
            $map['institution_id'] = array('eq',$institution_id);
        }
        if(!empty($subsidy_id)){
            $map['subsidy_id'] = array('eq',$subsidy_id);
        }
        if(!empty($name)){
            $map['name'] = array('likc','%'.$name.'%');
        }
        // 保证为正数
        $limit = $limit > 0 ? $limit : 10;
        $page = $page > 0 ? $page : 1;
        $res['msg']  = $this->where($map)->limit(($page-1)*$limit,$limit)->select();
        if(empty($res['msg'])){
            $res['msg'] = array();
        }
        $res['status'] = 1;
        return $res;
    }
}

 