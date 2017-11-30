<?php

class Files_model extends MY_Model {
		
		const DB_TABLE = 'files';
		const DB_TABLE_PK = 'id';

		var $table = 'files';
		
		var $column_order = array(null, 'message_id','file_name','created','status'); //set column field database for datatable orderable
		
		var $column_search = array('message_id','file_name','created','status'); //set column field database for datatable searchable 
		
		var $order = array('id' => 'desc'); // default order 
	 

		/**
		 * Message id.
		 * @var id 
		 */
		public $message_id;
		
		/**
		 * User Email.
		 * @var string 
		 */
		public $user_email;
				
		/**
		 * File Name.
		 * @var string 
		 */
		public $file_name;
				
		/**
		 * File Size.
		 * @var string 
		 */
		public $file_size;
				
		/**
		 * Date Created.
		 * @var string 
		 */
		public $created;
		
		/**
		 * Status.
		 * @var enum 
		 */
		public $status;

		
		private function _get_datatables_query()
		{
			 
			$this->db->from($this->table);
	 
			$i = 0;
		 
			foreach ($this->column_search as $item) // loop column 
			{
				if($_POST['search']['value']) // if datatable send POST for search
				{
					 
					if($i===0) // first loop
					{
						$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
						$this->db->like($item, $_POST['search']['value']);
					}
					else
					{
						$this->db->or_like($item, $_POST['search']['value']);
					}
	 
					if(count($this->column_search) - 1 == $i) //last loop
						$this->db->group_end(); //close bracket
				}
				$i++;
			}
			 
			if(isset($_POST['order'])) // here order processing
			{
				$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			} 
			else if(isset($this->order))
			{
				$order = $this->order;
				$this->db->order_by(key($order), $order[key($order)]);
			}
		}
		
		function get_datatables()
		{
			$this->_get_datatables_query();
			if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
			$query = $this->db->get();
			return $query->result();
		}
	 
		function count_filtered()
		{
			$this->_get_datatables_query();
			$query = $this->db->get();
			return $query->num_rows();
		}
	 
		public function count_all()
		{
			$this->db->from($this->table);
			return $this->db->count_all_results();
		}	
	
			
		/**
		* Function to insert new file
		*
		*/	
		public function insert_file($data){
				
			$this->db->insert($this->table, $data);
			$insert_id = $this->db->insert_id();
			if ($insert_id){
				return $insert_id;
			}else {
				return false;
			}
		}
		
		 
		/** 
		 * Function to upload multiple image files
		 * @variable string
		 */
		public function upload_image_files($vehicle_id = '', $path = '', $files = ''){
			
			if($vehicle_id != '' && $path != '' && $files != ''){
					
				if(!is_dir($path)){
					mkdir($path,0777);
				}
				$config['upload_path'] = $path;
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size'] = 2048000;
				$config['max_width'] = 3048;
				$config['max_height'] = 2048;

				$this->load->library('upload', $config);
				$this->upload->overwrite = false;
				
				$images = array();
				$uploaded = false;
				$upload_error = array();
				
				$existing_images_count = $this->Vehicles->count_vehicle_images($vehicle_id);
				
				if($existing_images_count == '' || $existing_images_count < 1){
					$append = 1;
				}else{
					$append = $existing_images_count + 1;
				}
				

				foreach ($files['name'] as $key => $image) {
					
					$_FILES['images[]']['name']= $files['name'][$key];
					$_FILES['images[]']['type']= $files['type'][$key];
					$_FILES['images[]']['tmp_name']= $files['tmp_name'][$key];
					$_FILES['images[]']['error']= $files['error'][$key];
					$_FILES['images[]']['size']= $files['size'][$key];
					
					$file = $_FILES['images[]']['name'];
					$ext = $this->Files->getFileExtension($file);
	
					$fileName = $vehicle_id.'-'.$append.''.$ext;

				//$images[] = $fileName;

					$config['file_name'] = $fileName;

					$this->upload->initialize($config);
					
					//upload the files
					if ($this->upload->do_upload('images[]')) {
						$this->upload->data();
						$upload_data = $this->upload->data();
						
						//get the file name
						$file_name = '';
						
						if (isset($upload_data['file_name'])){
							$file_name = $upload_data['file_name'];
						}
						
						//sanitize filenames
						$file_name = $this->security->sanitize_filename($file_name);
						//convert default file size to bytes
						 //$bytes = filesize($full_path);
						//store in gallery as well
						$gallery_data = array(
							'vehicle_id' => $vehicle_id,
							'image_name'=> $file_name,
							'created' => date('Y-m-d H:i:s'), 
						);
						//save in db
						$this->db->update('vehicle_images', $gallery_data);
						$uploaded = true;
					} else {
						$uploaded = false;
						$upload_error[] = $this->upload->display_errors();
					}
					
					$append++;
				}
				if($uploaded){
					return true;
				}else{
					return $upload_error;
				}
			
			}
			
		}
				 
		/** 
		 * Function to upload multiple files
		 * @variable string
		 */
		//upload_files($path, $title='', $files)
		public function upload_files($path = '', $files = '', $data = ''){
			
			if(!is_dir($path)){
				mkdir($path,0777);
			}
			$config['upload_path'] = $path;
			$config['allowed_types'] = 'doc|docx|gif|jpg|jpeg|png|pdf';
			$config['max_size'] = 2048000;
			$config['max_width'] = 3048;
			$config['max_height'] = 2048;

			$this->load->library('upload', $config);
			$this->upload->overwrite = false;
			
			$images = array();
			$uploaded = false;
			$upload_error = array();
			
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
				
				//upload the files
				if ($this->upload->do_upload('images[]')) {
					$this->upload->data();
					$upload_data = $this->upload->data();
					
					//get the file name
					$file_name = '';
					
					//get the file size
					$file_size = '';
					
					//get the file path
					$full_path = '';
					
					if (isset($upload_data['file_name'])){
						$file_name = $upload_data['file_name'];
						$file_size = $upload_data['file_size'];
						$full_path = $upload_data['full_path'];
					}
					
					//sanitize filenames
					$file_name = $this->security->sanitize_filename($file_name);
					//convert default file size to bytes
					 //$bytes = filesize($full_path);
					 
					//convert file size to string
					$file_size_string = $this->filesize_formatted($full_path);
					//$file_size_string = $this->formatSizeUnits($bytes);
					
					//save in db
					$insert_id = $this->insert_file($data);
					if($insert_id){
						$this->db->where('id', $insert_id);
						$this->db->update('files', array('file_name' => $file_name,'file_size' => $file_size_string));
					}
					$uploaded = true;
				} else {
					$uploaded = false;
					$upload_error[] = $this->upload->display_errors();
				}
			}
			if($uploaded){
				return true;
			}else{
				return $upload_error;
			}
			
		}
		
		/*
		 * file value and type check during validation
		 */
		public function file_check($files = ''){
			
			//allowed file types
			$allowed_mime_type_arr = array('application/doc','application/docx','application/pdf','image/jpg','image/jpeg','image/png');
			
			//get file ext
			$mime = get_mime_by_extension($files['name']);
			
			if(isset($files['name']) && $files['name']!=""){
				
				//check ext is in array
				if(in_array($mime, $allowed_mime_type_arr)){
					return true;
				}else{
					return false;
				}
			}else{
				//empty file
				return false;
			}
		}
		
		/**
		 * Function to check
		 * that the file is an image
		 */
		public function file_is_image($files = ''){
			
			//allowed file types
			$allowed_mime_type_array = array('image/gif','image/jpg','image/jpeg','image/png');
			
			//get file ext
			$mime = get_mime_by_extension($files['name']);
			
			if(isset($files['name']) && $files['name']!=""){
				
				//check ext is in array
				if(in_array($mime, $allowed_mime_type_array)){
					return true;
				}else{
					return false;
				}
			}else{
				//empty file
				return false;
			}
		}

		
		/**
		 * Function to xss clean file
		 * 
		 */
		public function file_xss_clean($files = ''){
			
			if(isset($files['name']) && $files['name']!=""){
				if ($this->security->xss_clean($files['name'], TRUE) === FALSE){
					// file failed the XSS test
					return false;
				}else{
					return true;
				}
			}else{
				//empty file
				return false;
			}
			
		}
				
		  
		/*
		 * get rows from the files table
		 */
		function getRows($params = array()){
			
			$this->db->select('*');
			$this->db->from('files');
			$this->db->where('status','1');
			$this->db->order_by('created','desc');
			if(array_key_exists('id',$params) && !empty($params['id'])){
				$this->db->where('id',$params['id']);
				//get records
				$query = $this->db->get();
				$result = ($query->num_rows() > 0)?$query->row_array():FALSE;
			}else{
				//set start and limit
				if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
					$this->db->limit($params['limit'],$params['start']);
				}elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
					$this->db->limit($params['limit']);
				}
				//get records
				$query = $this->db->get();
				$result = ($query->num_rows() > 0)?$query->result_array():FALSE;
			}
			//return fetched data
			return $result;
		}

		  
		/** 
		 * Function to get user files
		 * @variable string
		 */
		function get_user_files($email = ''){
			
			if(!empty($email)){
				$this->db->where('user_email', $email);
			}
			
			$q = $this->db->get($this->table);
			
			if($q->num_rows() > 0){
				
			  // we will store the results in the form of class methods by using $q->result()
			  // if you want to store them as an array you can use $q->result_array()
			  foreach ($q->result() as $row)
			  {
				$data[] = $row;
			  }
			  return $data;
			}
		}

		 
		/** 
		 * Function to get files for message
		 * @variable id
		 */
		function get_message_files($message_id = ''){
			
			if(!empty($message_id)){
				$this->db->where('message_id', $message_id);
			}
			
			$q = $this->db->get($this->table);
			
			if($q->num_rows() > 0){
				
			  // we will store the results in the form of class methods by using $q->result()
			  // if you want to store them as an array you can use $q->result_array()
			  foreach ($q->result() as $row)
			  {
				$data[] = $row;
			  }
			  return $data;
			}
		}		
		
		
		/**
		 * Formats filesize in human readable way.
		 *
		 * @param file $file
		 * @return string Formatted Filesize, e.g. "113.24 MB".
		 */
		function filesize_formatted($file)
		{
			$bytes = filesize($file);

			if ($bytes >= 1073741824) {
				return number_format($bytes / 1073741824, 2) . 'GB';
			} elseif ($bytes >= 1048576) {
				return number_format($bytes / 1048576, 2) . 'MB';
			} elseif ($bytes >= 1024) {
				return number_format($bytes / 1024, 2) . 'KB';
			} elseif ($bytes > 1) {
				return $bytes . ' bytes';
			} elseif ($bytes == 1) {
				return '1 byte';
			} else {
				return '0 bytes';
			}
		}
		
				 
		/** 
		 * Function to convert file size
		 * @variable string
		 */
		function formatSizeUnits($bytes)
		{
			if ($bytes >= 1073741824)
			{
				$bytes = number_format($bytes / 1073741824, 2) . ' GB';
			}
			elseif ($bytes >= 1048576)
			{
				$bytes = number_format($bytes / 1048576, 2) . ' MB';
			}
			elseif ($bytes >= 1024)
			{
				$bytes = number_format($bytes / 1024, 2) . ' KB';
			}
			elseif ($bytes > 1)
			{
				$bytes = $bytes . ' bytes';
			}
			elseif ($bytes == 1)
			{
				$bytes = $bytes . ' byte';
			}
			else
			{
				$bytes = '0 bytes';
			}

			return $bytes;
		}
		
		function formatbytes($file, $type){
			switch($type){
			  case "KB":
				 $filesize = filesize($file) * .0009765625; // bytes to KB
			  break;
			  case "MB":
				 $filesize = (filesize($file) * .0009765625) * .0009765625; // bytes to MB
			  break;
			  case "GB":
				 $filesize = ((filesize($file) * .0009765625) * .0009765625) * .0009765625; // bytes to GB
			  break;
			}
			if($filesize <= 0){
				return $filesize = 'unknown file size';}
			else{
				return round($filesize, 2).' '.$type;
			}
		}
		
		public function sizeFilter($bytes='')
		{
			$label = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
			for( $i = 0; $bytes >= 1024 && $i < ( count( $label ) -1 ); $bytes /= 1024, $i++ );
			return( round( $bytes, 2 ) . " " . $label[$i] );
		}
		
				 
		/** 
		 * Function to get file extension
		 * @variable string
		 */
		public function getFileExtension($path) { 
			$ext = pathinfo($path, PATHINFO_EXTENSION); 
			return $ext; 
		}

		
		
		
		
		
		
	
}