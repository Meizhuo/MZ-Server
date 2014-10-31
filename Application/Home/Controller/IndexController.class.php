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
        
    // issue#56 课程:start_time不为时间戳而是格式为‘Y-m-d’的字符串
    public function changeCourse() {
//         $courses = D('Course')->select();
//         foreach ($courses as $c) {
//             $c['start_time'] = date('Y-m-d', $c['start_time']);
//             echo $c['start_time'] . "<br>";
//             D('Course')->save($c);
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
    
    public function rperson(){
        $this->reqPerson();
        echo "111";
    }
    
    public function rcommonadmin(){
        $this->reqCommonAdmin();
        echo "222222";
    }
    
    public function radmin(){
        $this->reqAdmin();
        echo "23333";
    }
    public function rins(){
        $this->reqInstitution();
        echo "!!";
    }
    
    public function tt(){
        $res = D('User')->getInsInfo(94);
        $this->ajaxReturn($res);
    }
}