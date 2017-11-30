<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Files management class
 */
class Files extends CI_Controller {
    
    public function index(){
        redirect('home');
    }
	//upload_files($path, $title='', $files)
	public function upload_files($path, $files){
		
		if(!is_dir($path)){
			mkdir($path,0777);
		}
        $config['upload_path'] = $path;
		$config['allowed_types'] = 'doc|docx|jpg|jpeg|png|pdf';
		$config['max_size'] = 2048000;
		$config['max_width'] = 3048;
		$config['max_height'] = 2048;

        $this->load->library('upload', $config);
		$this->upload->overwrite = false;
		
        $images = array();
		$uploaded = false;

        foreach ($files['name'] as $key => $image) {
            $_FILES['images[]']['name']= $files['name'][$key];
            $_FILES['images[]']['type']= $files['type'][$key];
            $_FILES['images[]']['tmp_name']= $files['tmp_name'][$key];
            $_FILES['images[]']['error']= $files['error'][$key];
            $_FILES['images[]']['size']= $files['size'][$key];

            //$fileName = $title .'_'. $image;

            //$images[] = $fileName;

            //$config['file_name'] = $fileName;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('images[]')) {
                $this->upload->data();
				$uploaded = true;
            } else {
                $uploaded = false;
            }
        }
		if($uploaded){
			return true;
		}else{
			return false;
		}
        
    }
	
    public function download($message_id = '', $id = ''){
        if(!empty($message_id) && !empty($id)){
           
            //get file info from database
            $fileInfo = $this->file->getRows(array('id' => $id));
            
            //file path
            $file = 'uploads/files/'.$message_id.'/'.$fileInfo['file_name'];
            
            //download file from directory
            force_download($file, NULL);
        }
    }
	
	
	
	
}