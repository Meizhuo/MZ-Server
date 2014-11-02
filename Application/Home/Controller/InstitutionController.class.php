<?php
namespace Home\Controller;
use Common\Controller\BaseController;
use Common\Model\UserAdminModel;
use Common\Model\UserModel;


/**
 * 机构用户接口
 * @author Jayin
 *        
 */
class InstitutionController extends BaseController {
    /**
     * POST 注册
     */
    public function register() {
        $this->reqPost();
        
        $res = D('User')->regInstitution();
        if ($res['status']) {
            $this->ajaxReturn(mz_json_success('register successfully'));
        } else {
            $this->ajaxReturn(mz_json_error($res['msg']));
        }
    }
    /**
     * POST 更新机构用户信息
     */
    public function update() {
    	$this->reqPost()->reqLogin();

    	$uid = session('uid');
    	$data['uid'] = session('uid');
        $res = D('UserInstitution')->updateInfo(array_merge($data,I('post.')));
    	if($res['status']){
    	    $this->ajaxReturn(mz_json_success('update info success'));
    	}else{
    	    $this->ajaxReturn(mz_json_error($res['msg']));
    	}
    }

    /**
     * GET 获取机构用户信息
     * 基础接口,不直接暴露给客户端
     * @param number $institution_id 机构id         
     * @param unknown $status  -1审核不通过  0未审核 1审核通过  2包含全部
     */
    public function info($institution_id = 0, $status = 2) {
        $res = D('User')->getInsInfo($institution_id);
        if ($res['status']) {
            if ($res['msg']['status'] == $status || $status == 2) {
                $this->ajaxReturn(mz_json_success($res['msg']));
            } else {
                $this->ajaxReturn(mz_json_success(null));
            }
        } else {
            $this->ajaxReturn(mz_json_error($res['msg']));
        }
    }
    /**
     * GET 获取机构用户信息
     * @param number $institution_id
     */
    public function getInfo($institution_id = 0){
        return $this->info($institution_id, UserModel::STATUS_PASS);
    }
    
    /**
     * POST 审核机构
     */
    public function vertify(){
        $this->reqPost(array('institution_id'))->reqLogin();
    
        //查询获得category_id
        $Admin = new UserAdminModel();
        //检验权限
        if(! $Admin->createAdminById(session('uid'))->hasPerCheckInstitution()){
            $this->ajaxReturn(mz_json_error("You have not permission!"));
            return;
        }
        $res = D('UserInstitution')->verify(I('post.institution_id'),I('post.op',UserModel::STATUS_PASS));
        if($res['status']){
            $this->ajaxReturn(mz_json_success('vertify successfully'));
        }else{
            $this->ajaxReturn(mz_json_error($res['msg']));
        }
    }
    /**
     * 删除一机构
     * NOTE:需要管理员拥有管理机构的权限
     */
    public function delete(){
    	$this->reqPost(array('ins_id'))->reqAdmin();
    	if(!D('UserAdmin')->createAdminById(session('uid'))->hasPerCheckInstitution()){
    		$this->ajaxReturn(mz_json_error("权限不足"));
    	}
   		$res = D('User')->deleteUser(I('post.ins_id'),UserModel::LEVEL_INSTITUTION);
   		if($res['status']){
   			$this->ajaxReturn(mz_json_success());
   		}else{
   			$this->ajaxReturn(mz_json_error($res['msg']));
   		}
    }

    /**
     * 获取机构列表
     * 这是基础接口，客户端不要调用
     * @see list()
     * @param string $status
     * @param string $name
     * @param string $type
     * @param number $page
     * @param number $limit
     */
    private function search($status='',$name='',$type='',$page=1, $limit=10) {
        $res = D('UserInstitution')->search($status, $name, $type, $page, $limit);
        if($res['status']){
           $this->ajaxReturn(mz_json_success($res['msg']));
        }else{
            $this->ajaxReturn(mz_json_error($res['msg']));
        }
    }
    /**
     * 获得已通过审核的机构
     * @param string $name
     * @param string $type
     * @param number $page
     * @param number $limit
     */
    public function lists($name='',$type='',$page=1, $limit=10){
        $this->search(UserModel::STATUS_PASS,$name,$type,$page,$limit);
    }
    
    public function upload(){
        $config = array(
                'maxSize'    =>  4194304,// 设置附件上传大小 4M
                'rootPath'   =>  './Uploads/', // 设置附件上传根目录
                'savePath'   =>  '',// 设置附件上传（子）目录
                'saveName'   =>  array('uniqid',''),//上传文件的保存名称
                'exts'       =>  array('zip','doc','docx','xls','jpg', 'gif', 'png', 'jpeg'),// 设置附件上传类型
                'subName'    =>  array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
        );
        //创建新目录的同时创建index.html
        $a = C('UPLOAD_PATH').date('Y-m-d');
        if(!file_exists($a)){
            mkdir($a);
            $filename  = $a.DIRECTORY_SEPARATOR."index.html";
            $fp=fopen($filename , "w+"); //打开文件指针，创建文件
            if ( !is_writable($filename) ){
                die("文件:" .$filename. "不可写，请检查！");
            }
            fclose($fp);
        }
        $upload = new \Think\Upload($config);// 实例化上传类
        // 上传文件
        $info   =   $upload->upload();
        if(!$info) {
            // 上传错误提示错误信息
            $this->ajaxReturn(mz_json_error($upload->getError()));
        }else{
            // 上传成功 获取上传文件信息
            //单文件
            foreach($info as $file){
                //默认为0
                $res = D('DocumentFile')->postByIns(session('uid'),$file);
                if($res['status']){
                    $this->ajaxReturn(mz_json_success($res['msg']));
                }else{
                    $this->ajaxReturn(mz_json_error($res['msg']));
                }
            }
        }
    }
}

