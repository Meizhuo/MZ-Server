<?php
namespace Home\Controller;
use Common\Controller\BaseController;

/**
 * 安全相关(修改密码)
 * @author Jayin
 *
 */
class SecurityController extends BaseController {
    /**
     * POST 修改密码
     */
    public function changePsw(){
        $this->reqPost('old_psw,new_psw')->reqLogin();
        $uid = session('uid');
        if(strlen(I('post.new_psw')) < 8 || strlen(I('post.new_psw')) >16){
            $this->ajaxReturn(mz_json_error('密码长度为8-16'));
        }
        $User = M('User');
        if($User->where("uid='%s' AND psw='%s'",$uid,md5(I('post.old_psw')))
                ->save(array('psw' => md5(I('post.new_psw')))) > 0){
            $this->ajaxReturn(mz_json_success('修改成功'));
        }else{
            $this->ajaxReturn(mz_json_error('修改失败'));
        }
        
    }
    
    /**
     * 验证修改密码请求是否正确(2小时内有效)
     */
    public function vertify(){
        $this->reqPost(array('code','e','psw'));
        $e = I('post.e');
        $code = I('post.code');
        $psw = I('post.psw');
         
        $F = M('UserForget');
        $record = $F->where("email='%s'",$e)->limit(1)->select();
        if($record){
            $rand_str = $record[0]['$rand_str'];
            $create_time = $record[0]['create_time'];
            //2小时内有效
            if(NOW_TIME - $create_time > 2*60*60){
                $this->ajaxReturn(mz_json_error('更改密码请求已失效,请重试'));
            }
            //密码长度
            if(strlen($psw) <8 || strlen($psw) >16){
               $this->ajaxReturn(mz_json_error('密码长度8-16,数字+字符'));
            }
            if(md5($create_time+$rand_str) === $code){
                if(M('User')->where("email='%s'",$e)->save(array('psw' => md5($psw)))>=0){
                    $this->ajaxReturn(mz_json_success('修改密码成功！'));
                }else{
                    $this->ajaxReturn(mz_json_error('修改密码失败,请重试'));
                }
            }else{
                $this->ajaxReturn(mz_json_error('验证错误,请重试'));
            }
        }else{
            $this->ajaxReturn(mz_json_error('找不到该用户信息,请重试'));
        }
    }
    /**
     * 创建链接+发送邮件到用户
     * @param unknown $email 用户的email
     */
    public function createLink($email){
        $this->reqPost(array('email'));
        $rand_str = randCode();
        $data['create_time'] = NOW_TIME;
        $data['rand_str'] = $rand_str;
        $F = M('UserForget');
        $record = $F->where("email='%s'",$email)->limit(1)->select();
        if($record){
            $F->where("email='%s'",$email)->save($data);
        }else{
            $data['email'] = $email;
            $F->add($data);
        }
        $key = md5($data['create_time'] + $data['rand_str']);
        $url = U('admin/security/changePsw','code='.$key.'&e='.$email,'',true);
        think_send_mail($email, '用户','东莞技能培训-修改密码','点击这个链接完成修改密码操作(或复制到浏览器,2小时内有效):'.$url);
        $this->ajaxReturn(mz_json_success('已发送修改密码链接到你邮箱，请注意查收！'));
    }
}

