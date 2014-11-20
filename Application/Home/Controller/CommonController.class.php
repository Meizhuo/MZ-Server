<?php

namespace Home\Controller;

use Common\Controller\BaseController;
/*
 * 常用接口
 * @author Jayin Ton
 *
 */
class CommonController extends BaseController {
	/**
	 * 清除垃圾文件
	 * 需要超级管理员权限
	 * <br>
	 * 满足以下条件就删除：
	 *<pre>
	 * doc_id 为0 or 空
	 * ins_id 为0 or 空
	 * </pre>
	 */
	public function cleanFile() {
		$this->reqSuperAdmin();
		$map['doc_id'] = 0;
		$map['ins_id'] = 0;
		$DocumentFile = D('DocumentFile');
		$files =$DocumentFile->where($map)->select();
		 
		foreach ($files as $f){
			$DocumentFile->remove($f['id']);
		}
		$this->ajaxReturn(mz_json_success('清理完毕'));
	}
	/**
	 * 生成二维码
	 * @param string $text 二维码内容
	 * @param number $size 二维码长宽,一般为25的倍数,单位：px
	 * @param number $margin 外边距 单位:px
	 */
	public function createQRcode($text = '',$size = 50, $margin = 1){
		vendor('QRcode.phpqrcode');
		\QRcode::png($text,false,QR_ECLEVEL_L,$size/25,$margin);
	}
}


