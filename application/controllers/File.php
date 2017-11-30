<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Files management class
 */
class File extends CI_Controller {
    
    public function index(){
        redirect('main');
    }

    public function download($message_id = '', $id = '', $rnd = ''){
		
        if(!empty($message_id) && !empty($id)){
           
            //get file info from database
            $fileInfo = $this->Files->getRows(array('id' => $id));
            
            //file path
            $file = 'uploads/files/'.$message_id.'/'.$fileInfo['file_name'];
            
            //download file from directory
            force_download($file, NULL);
        }
    }
	
	
	
	
}