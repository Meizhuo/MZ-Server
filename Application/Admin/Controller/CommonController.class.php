<?php
namespace Admin\Controller;
use Common\Controller\BaseController;

/**
 * 公共常用的后台接口
 * 
 * @author Jayin
 *        
 */
class CommonController extends BaseController {

    /**
     * 清除垃圾文件
     * <br>
     * 满足以下条件就删除：
     *<pre>
     * doc_id 为0 or 空
     * ins_id 为0 or 空
     * </pre>
     */
    public function cleanFile() {
        $map['doc_id'] = 0;
        $map['ins_id'] = 0;
        $DocumentFile = D('DocumentFile');
    	$files =$DocumentFile->where($map)->select();
    	
    	foreach ($files as $f){
    	    $DocumentFile->remove($f['id']);
    	}
    	$this->ajaxReturn(mz_json_success('清理完毕'));
    }
}

