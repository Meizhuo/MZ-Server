<?php
namespace Common\Model;
use Think\Model;

/**
 * base model
 * 
 * @author Jayin
 *        
 */
class BaseModel extends Model {

    protected $_res = array(
            'status' => 0,
            'msg' => ''
    );

    protected function _getResult() {
        return $this->_res;
    }
}

