<?php
namespace Common\Model;

/**
 * 文档类型
 * 
 * @author Jayin
 *        
 */
class DocumentCategoryModel extends BaseModel {

    /**
     * 根据id获得caterogy信息
     * 
     * @param unknown $category_id            
     * @return Ambigous <string, multitype:number string >
     */
    public function getCategoryById($category_id) {
        $res = $this->_getResult();
        $categorys = $this->where("category_id='%s'", $category_id)->select();
        if ($categorys) {
            $res['status'] = 1;
            $res['msg'] = $categorys[0];
        } else {
            $res['msg'] = 'Category is not found.';
        }
        return $res;
    }
}

