<?php
namespace Common\Model;

/**
 * 用人单位模型
 * 
 * @author Jayin
 *        
 */
class UserEmployerModel extends BaseModel {

    /**
     * 添加一个用人用户
     * 
     * @param unknown $data            
     * @return Ambigous <multitype:number string , string>
     */
    public function addPerson($data) {
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
     * 更新机构信息
     * 
     * @param unknown $data            
     * @return Ambigous <string, multitype:number string >
     */
    public function updateInfo($data) {
        $res = $this->_getResult();
        if ($this->create($data)) {
            // 除了uid还有更新其他项,那么更新，不然会报SQL错误
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
 