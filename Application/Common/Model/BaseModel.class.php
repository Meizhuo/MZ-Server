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
    /**
     * 所需的参数是否为空
     * @param unknown $params
     * @return boolean 返回true 当任一参数为空
     */
    public function emptyParams($params) {
        $num_args = func_num_args();
        for ($i = 0; $i < $num_args; $i ++) {
            $v = func_get_arg($i);
            if (empty($v)) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * 这才是真正获取data
     * @return multitype:
     */
    public function getData(){
    	return $this->data;
    }
}

