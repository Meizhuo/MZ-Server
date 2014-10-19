<?php
namespace Home\Controller;
use Common\Controller\BaseController;

class IndexController extends BaseController {

    public function index() {
        $this->redirect('admin/institution/index');
    }

    public function upload() {
        $this->display();
    }

    public function test() {
        $this->display();
    }

    public function mytest() {
        // print_r(json_encode(D('Document')->getDocumentInfo(166)));
        // print_r(D('DocumentFile')->linkToDoc(2,array(67,68)));
        // print_r(D('DocumentCategory')->getCategoryById(1));
        print_r(D('Document')->getDocumentInfo(166));
    }
    //issue#51 机构用户：有效日期字段为字符串，格式为“Y-M-D”
    public function change() {
//         $user_ins = D('UserInstitution')->select();
//         foreach ($user_ins as $ins) {
//             $ins['validity_date'] = date('Y-m-d', $ins['validity_date']);
//             D('UserInstitution')->save($ins);
//         }
    }
    
    public function sendEmailTest(){
        $res = think_send_mail("273942569@qq.com", "Jayin Ton","欢迎使用东莞技能培训平台","欢迎使用东莞技能培训平台,祝你生活愉快！");
        if(is_bool($res) && $res){
            $this->ajaxReturn(mz_json_success('send email successfully.'));
        }else{
            $this->ajaxReturn(mz_json_error('send email faild.'));
        }
    }
}