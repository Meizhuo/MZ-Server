<?php
namespace Common\Model;
use Common\Model\BaseModel;

/**
 * 广告模型
 * 
 * @author Jayin
 *        
 */
class AdvertisementModel extends BaseModel {

    /**
     * 不显示
     */
    const STATUS_UNDISPLAY = 0;

    /**
     * 显示
     */
    const STATUS_DISPLAY = 1;

    protected $_validate = array(
            //插入时必须有:
            array('description','require','缺少广告描述',self::MUST_VALIDATE,'',self::MODEL_INSERT),
            array('url','require','缺少广告链接',self::MUST_VALIDATE,'',self::MODEL_INSERT),
            array('pic_url','require','缺少图片链接',self::MUST_VALIDATE,'',self::MODEL_INSERT),
    );

    protected $_auto = array(
            array(
                    'display',
                    self::STATUS_UNDISPLAY,
                    self::MODEL_INSERT
            )
    );

    public function post($description, $url, $pic_url, 
            $display = self::STATUS_UNDISPLAY) {
        $res = $this->_getResult();
        $data['description'] = $description;
        $data['url'] = $url;
        $data['pic_url'] = $pic_url;
        $data['display'] = $display;
        
        if ($this->create($data)) {
            if ($this->add()) {
                $res['status'] = 1;
            } else {
                $res['msg'] = "System Error :not able to insert";
            }
        } else {
            $res['msg'] = $this->getError();
        }
        return $res;
    }
    // most is 5
    public function getCurrent($limit = 5) {
        $res = $this->_getResult();
        $res['msg'] = $this->where("display='%s'", self::STATUS_DISPLAY)
            ->field('id,description,url,pic_url')
            ->limit($limit)
            ->select();
        if ($res['msg']) {
            $res['status'] = 1;
        } else {
            $res['msg'] = array();
        }
        return $res;
    }

    public function displayAd($ad_id) {
        $res = $this->_getResult();
        $data['id'] = $ad_id;
        $data['display'] = self::STATUS_DISPLAY;
        if ($this->save($data) >= 0) {
            $res['status'] = 1;
        } else {
            $res['msg'] = 'System Error: not able to update';
        }
        return $res;
    }

    public function unDisplayAd($ad_id) {
        $res = $this->_getResult();
        $data['id'] = $ad_id;
        $data['display'] = self::STATUS_UNDISPLAY;
        if ($this->save($data) >= 0) {
            $res['status'] = 1;
        } else {
            $res['msg'] = 'System Error: not able to update';
        }
        return $res;
    }

    public function deleteAd($ad_id) {
        $this->where("id='%s'", $ad_id)->delete();
    }

    public function createByDoc($doc_id) {
        $data = array();
        $res = $this->_getResult();
        $doc = (new DocumentModel())->getDocumentInfo($doc_id);
        $doc_img_files = (new DocumentFileModel())->getDocFiles($doc_id, 
                'image');
        if ($doc) {
            // 至少有1图片附件
            if ($doc_img_files['status'] && count($doc_img_files['msg'])>0) {
                $data['description'] = $doc['title'];
                $data['url'] = 'http://' . $_SERVER['HTTP_HOST'] .U('admin/index/viewDocument', 
                        array('doc_id' => $doc_id));
                $data['pic_url'] = 'http://' . $_SERVER['HTTP_HOST'] .
                         C('UPLOAD_PATH_ABS') . $doc_img_files['msg'][0]['save_path'] .
                         $doc_img_files['msg'][0]['save_name'];
                $this->add($data);
                $res['status'] = 1;
            } else {
                $res['msg'] = '文档缺少图片';
            }
        } else {
            $res['msg'] = 'document not found.';
        }
        
        return $res;
    }
}

