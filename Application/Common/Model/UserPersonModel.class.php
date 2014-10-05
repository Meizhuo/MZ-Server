<?php
namespace Common\Model;
use Common\Model\BaseModel;

/**
 * 
 * @author Jayin
 *
 */
class UserPersonModel extends BaseModel {
    protected $_validate = array(
        //插入，更新时必须有:
        array('uid','require','缺少uid',self::MUST_VALIDATE),
    	//插入时唯一性验证
    	array('uid','','uid不唯一',self::EXISTS_VALIDATE,'unique',self::MODEL_INSERT),
        array('sex','checkSex','性别为:男或女',self::EXISTS_VALIDATE,'callback',self::MODEL_BOTH)
    );
    
    protected $_auto = array(
    	array('sex','男'),
        array('work_place','')
    );
    /**
     * 检查性别时候符合格式
     * @param unknown $sex
     * @return boolean
     */
    protected function checkSex($sex){
         if($sex === '男' || $sex === '女'){
             return true;
         }
         return false;
    }
    /**
     * 添加一个用户
     * @param unknown $data
     * @return Ambigous <multitype:number string , string>
     */
    public function addPerson($data){
        $res = $this->_getResult();
        if($this->create($data)){
            if($this->add()){
                $res['status'] = 1;
            }else{
                $res['msg'] = 'System Error: Not able to insert';
            }
        }else{
            $res['msg'] = $this->getError();
        }
        return $res;   
    }
    
    /**
     * 更新个人用户信息
     * 
     * @param unknown $data            
     * @return Ambigous <string, multitype:number string >
     */
    public function updateInfo($data) {
        $res = $this->_getResult();
        if ($this->create($data)) {
            if (count($this->data) > 1) {
                $this->save();
                $res['status'] = 1;
            }
        } else {
            $res['msg'] = $this->getError();
        }
        return $res;
    }
   
}

 