<?php
/**
 * 封装(处理)错误的json格式
 * @param string $msg 错误提示消息
 * @param number $error_code 错误码
 * @return multitype:number string
 */
function mz_json_error($msg='operate error',$error_code=40000){
    return array('error_code'=> $error_code,'msg'=>$msg);
}

/**
 *  封装处理成功的json格式
 * @param unknown $data string array
 * @param number $code  默认20000
 * @return multitype:number unknown
 */
function mz_json_success($data='operate successfully',$code =20000){
    return array('code'=> 20000,'response'=>$data);
}
/**
 * 常用的请求方法错误
 * @return Ambigous <multitype:number, multitype:number string >
 */
function mz_json_error_request(){
    return mz_json_error('Request method error',40001);
}
