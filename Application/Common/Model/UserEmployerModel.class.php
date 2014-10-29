<?php
namespace Common\Model;

/**
 * 企业用户模型
 * 
 * @author Jayin
 *        
 */
class UserEmployerModel extends BaseModel {
    
    /**
     * 添加一个企业用户用户
     * 
     * @param unknown $data            
     * @return Ambigous <multitype:number string , string>
     */
    public function addEmployer($data) {
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
     * 更新企业信息
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
    /**
     * 模糊查询企业用户
     * @param string $status
     * @param string $nickname
     * @param string $address
     * @param number $page
     * @param number $limit
     * @return multitype:number string
     */
    public function search($status=null,$nickname=null,$address=null,$page=1,$limit=10){
        $res  = $this->_getResult();
        $map = array();
        $map['level'] = UserModel::LEVEL_EMPLOYER;
        if(!is_null($status)){
            $map['status'] = $status;
        }
        if(!is_null($nickname)){
            $map['nickname'] = array('like','%'.$nickname.'%');
        }
        if(!is_null($address)){
            $map['address'] = array('like','%'.$address.'%');;
        }
        // 保证为正数
        $limit = $limit > 0 ? $limit : 10;
        $page = $page > 0 ? $page : 1;
        $users_employer= M('User')->join('mz_user_employer ON mz_user.uid = mz_user_employer.uid')
                                ->where($map)
                                ->field('mz_user.uid,nickname,phone,email,reg_time,level,status,contact_phone,address')
                                ->limit(($page - 1) * $limit, $limit)
                                ->select();
        if(!$users_employer){
            $res['msg'] = array();
        }else{
            $res['msg'] =$users_employer;
        }
        $res['status'] = 1;
        
        return $res;
    }
}



 