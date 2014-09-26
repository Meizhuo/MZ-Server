<?php
/**
 * 封装(处理)错误的json格式
 * @param string $msg 错误提示消息
 * @param number $error_code 错误码
 * @return multitype:number string
 */
function mz_json_error($msg='operate error',$error_code=40000){
    return array('error_code'=> 500,'msg'=>$msg);
}

/**
 *  封装处理成功的json格式
 * @param unknown $data  array
 * @param number $code  默认20000
 * @return multitype:number unknown
 */
function mz_json_success($data,$code =20000){
    return array('code'=> 200,'response'=>$data);
}
