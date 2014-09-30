<?php
namespace Common\Model;
use Think\Model;

/**
 * base model
 * @author Jayin
 *
 */
class BaseModel extends Model {
    protected function _getResult(){
        return array('status'=>0,'msg'=>'');
    }
}

