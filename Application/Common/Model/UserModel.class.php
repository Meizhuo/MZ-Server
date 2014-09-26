<?php
namespace Common\Model;
use Think\Model;

/**
 *
 * @author Jayin
 *        
 */
class UserModel extends Model {
    /** 个人用户*/
    const LEVEL_PERSON = 1;
    /** 用人单位*/
    const LEVEL_EMPLOYER = 2;
    /** 管理员*/
    const LEVEL_ADMIN = 4;
    /** 培训机构用户*/
    const LEVEL_INSTITUTION = 8;
   
    /** 审核不通过*/
    const STATUS_UNPASS = -1;
    /** 未审核*/
    const STATUS_NOT_VERTIFY = 0;
    /** 审核通过*/
    const STATUS_PASS = 1;
    

    protected $_validate = array(
            array(
                    'sex',
                    'checkSex',
                    '性别:男或女',
                    self::EXISTS_VALIDATE,
                    'function'
            )
    );

    protected function _add($level,$status) {
        load('check', APP_PATH . 'Common/Common');
        if ($this->create()) {
            $this->data['level'] = $level;
            $this->data['psw'] = md5($this->data['psw']);
            $this->data['status'] = $status;
            return $this->add();
        } else {
            return false;
        }
    }

    public function addUser() {
//         return $this->_add(self::LEVEL_PERSON,);
    }

    public function addAdmin() {}
}

