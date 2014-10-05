<?php
namespace Common\Model;
use Common\Model\BaseModel;
/**
 * 机构模型
 * @author Jayin
 *
 */
class UserInstitutionModel extends BaseModel {

    protected $_validate = array(
    	array('validity_date','number','有效期为时间戳timestamp')
    );
    
    protected $_auto = array();
    
    /**
     * 添加一个培训机构用户
     * @param unknown $data
     * @return Ambigous <string, multitype:number string >
     */
    public function addInstitution($data){
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
     * 更新机构信息
     * @param unknown $data
     * @return Ambigous <string, multitype:number string >
     */
    public function updateInfo($data){
        $res = $this->_getResult();
        if($this->create($data)){
            // 除了uid还有更新其他项,那么更新，不然会报SQL错误
            if(count($this->data)>1){
                $this->save();
                $res['status'] = 1; 
            }
        }else{
            $res['msg'] = $this->getError();
        }
        return $res;
    }
    /**
     * 模糊查询
     * @param unknown $status
     * @param unknown $name
     * @param unknown $type
     * @param number $page
     * @param number $limt
     * @return unknown
     */
    public function search($status, $name, $type, $page = 1, $limt = 10) {
        $res = $this->_getResult();
        $map = array();
        $map['level'] = UserModel::LEVEL_INSTITUTION;
        if (! empty($status)) {
            $map['status'] = $status;
        }
        if (! empty($name)) {
            $map['name'] = array('like','%' . $name . '%' );
        }
        if (! empty($type)) {
            $map['type'] = array('like','%' . $type . '%');
        }
        // 保证为正数
        $limit = $limit > 0 ? $limit : 10;
        $page = $page > 0 ? $page : 1;
        $users_ins = M('User')->join('mz_user_institution ON mz_user.uid = mz_user_institution.uid')->where($map)
            ->field( 'mz_user_institution.uid,nickname,phone,email,reg_time,level,status,name,address,type,description')
            ->limit(($page - 1) * $limt, $limt)
            ->select();
        if(!$users_ins){
            $res['msg'] = array();
        }else{
            $res['msg'] = $users_ins;
        }
        $res['status'] = 1;
        return $res;
    }
}
 