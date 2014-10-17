<?php 
 
require_once 'response.php';
function mz_get_docfile_path($save_path,$save_name){
    return C('UPLOAD_PATH_ABS').$save_path.$save_name;
}