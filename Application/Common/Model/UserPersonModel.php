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
   
}

 