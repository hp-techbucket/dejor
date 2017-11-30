<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle extends CI_Controller {

		/**
		 * Index Page for this controller.
		 *
		 */
		public function index()
		{
			redirect('vehicles');
		}
		
			

		/**
		* Function to get models
		* 
		*/			
		public function get_models(){
		
			if(!empty($this->input->post('id')) || $this->input->post('id') != ''){
				
				//escaping the post values
				$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
				$pid = html_escape($this->input->post('id'));
				$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers

				//$options = '';
				//$options .= '<select name="state" id="state" class="form-control select2 states">';
				$options = '<option value="0" selected="selected">Select Model</option>';
						
				$this->db->from('vehicle_models');
				$this->db->where('make_id', $id);
				$result = $this->db->get();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row){
						$options .= '<option value="'.$row['title'].'">'.$row['title'].'</option>';			
					}
				}
				//$options .= '</select>';
				$data['options'] = $options;	
				$data['success'] = true;
			}else {
					$data['success'] = false;
			}
			echo json_encode($data);
			
		}		

	
		/**
		* Function to handle
		* vehicle view and edit
		* display
		*/	
		public function vehicle_details(){
			
			//escaping the post values
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
				
			//escaping the post values
			$pid = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers

			$detail = $this->db->select('*')->from('vehicles')->where('id',$id)->get()->row();
			
			if($detail){

					$data['id'] = $detail->id;
					
					$data['headerTitle'] = $detail->vehicle_make.' '.$detail->vehicle_model;	
					
					$image = '';
					$thumbnail = '';
					
					$filename = FCPATH.'uploads/vehicles/'.$detail->id.'/'.$detail->vehicle_image;
				
					if($detail->vehicle_image == '' || $detail->vehicle_image == null || !file_exists($filename)){
						
						$result = $this->db->select('*, MIN(id) as min_id', false)->from('vehicle_images')->where('vehicle_id', $detail->id)->get()->row();
						
						if(!empty($result)){
							
							//THUMBNAIL
							$thumbnail = '<img src="'.base_url().'uploads/vehicles/'.$result->vehicle_id.'/'.$result->image_name.'" class="" />';
							
							//IMAGE
							$image = '<img alt="" src="'.base_url().'uploads/vehicles/'.$result->vehicle_id.'/'.$result->image_name.'" class="img-responsive main-img" id="main-img" />';
							
						}else{
							
							//THUMBNAIL
							$thumbnail = '<img src="'.base_url().'assets/images/img/no-default-thumbnail.png" class="" />';
							
							//IMAGE
							$image = '<img alt="" src="'.base_url().'assets/images/img/no-default-thumbnail.png" class="img-responsive main-img" id="main-img" />';
						}
							
					}
					else{
						
						//THUMBNAIL
						$thumbnail = '<img src="'.base_url().'uploads/vehicles/'.$detail->id.'/'.$detail->vehicle_image.'" class=""/>';
						
						//IMAGE
						$image = '<img alt="" src="'.base_url().'uploads/vehicles/'.$detail->id.'/'.$detail->vehicle_image.'" class="img-responsive main-img" id="main-img" />';
							
					}
					$data['image'] = $image;
					
					$data['thumbnail'] = $thumbnail;
					
					$vehicle_images = $this->Vehicles->get_vehicle_images($detail->id);
					
					//count and display the number of images stored
					$images_count = $this->Vehicles->count_vehicle_images($detail->id);
					
					if($images_count == '' || $images_count == null){
						$images_count = 0;
					}
					$data['images_count'] = $images_count;
					
					//start portfolio gallery view
					$gallery = '<div class="p_gallery">';
					
					//start gallery edit group
					$image_group = '<div class="">';
					
					if(!empty($vehicle_images)){
						//item count initialised
						$i = 0;
						//gallery edit row
						$image_group .= '<div class="row">';
							
							
						foreach($vehicle_images as $image){
							
							//portfolio gallery view
							$gallery .= '<a href="javascript:void(0)" title="View">';
							$gallery .= '<img src="'.base_url().'uploads/vehicles/'.$detail->id.'/'.$image->image_name.'" id="'.$image->image_name.'" class="img-responsive" onclick="changeImage(\''.base_url().'uploads/vehicles/'.$detail->id.'/'.$image->image_name.'\')"/>';
							$gallery .= '</a>';
							
							//gallery edit group
							$image_group .= '<div class="col-sm-3 nopadding">';
							
							//gallery edit group
							$image_group .= '<div class="image-group">';
							
							$image_group .= '<img src="'.base_url().'uploads/vehicles/'.$detail->id.'/'.$images->image_name.'" id="'.$image->image_name.'" class="img-responsive" />';
							//image path
							$path = 'uploads/vehicles/'.$detail->id.'/'.$image->image_name;
							$image_group .= '<a href="#" class="remove_image" onclick="deleteVehicleImage(this,'.$detail->id.','.$image->id.',\''.$path.'\')"><span aria-hidden="true"><i class="fa fa-trash-o"></i> Remove</span></a>';
							$image_group .= '</div>';
							$image_group .= '</div>';
							$i++;
							if($i % 4 == 0){
								$image_group .= '</div><br/><div class="row">';
							}
							//$image_group .= '<div style="clear:both;"></div>';
						}
					}
					
					//end gallery edit group
					$image_group .= '</div>';
					$data['image_group'] = $image_group;
					
					//end portfolio gallery view
					$gallery .= '</div>';
					$data['vehicle_gallery'] = $gallery;
					
					$data['vehicle_title'] = $detail->vehicle_make.' '.$detail->vehicle_model;
					$data['vehicle_type'] = $detail->vehicle_type;
					$data['vehicle_make'] = $detail->vehicle_make;
					$data['vehicle_model'] = $detail->vehicle_model;
					$data['year_of_manufacture'] = $detail->year_of_manufacture;
					$data['vehicle_odometer'] = $detail->vehicle_odometer;
					$data['vehicle_lot_number'] = $detail->vehicle_lot_number;
					$data['vehicle_vin'] = $detail->vehicle_vin;
					$data['vehicle_colour'] = $detail->vehicle_colour;
					$data['vehicle_price'] = $detail->vehicle_price;
					$data['vehicle_location_city'] = $detail->vehicle_location_city;
					$data['vehicle_location_country'] = $detail->vehicle_location_country;
					$data['vehicle_description'] = $detail->vehicle_description;
					$data['sale_status'] = $detail->sale_status;
					$data['trader_email'] = $detail->trader_email;
					$data['discount'] = $detail->discount;
					$data['price_after_discount'] = $detail->price_after_discount;
					$data['date_added'] = date("F j, Y", strtotime($detail->date_added));
					$data['last_updated'] = date("F j, Y, g:i a", strtotime($detail->last_updated));
										

					//SELECT VEHICLE TYPE DROPDOWN
					//$vehicle_type = '<div class="form-group">';
					//$vehicle_type .= '<select name="vehicle_type" id="vehicle_type" class="form-control">';
					
					$vehicle_type = '<option value="0">Select Type</option>';
							
					$this->db->from('vehicle_types');
					$this->db->order_by('id');
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							$default = (strtolower($row['name']) == strtolower($detail->vehicle_type))?'selected':'';
							$vehicle_type .= '<option value="'.$row['name'].'" '.$default.'>'.$row['name'].'</option>';
						}
					}
					
					//$vehicle_type .= '</select>';
					//$vehicle_type .= '</div>';	
					$data['vehicle_type_options'] = $vehicle_type;
					//*********END SELECT VEHICLE TYPE DROPDOWN**********//
					
					
					
					//*********SELECT VEHICLE MAKE DROPDOWN**********//
					//$vehicle_make = '<div class="form-group">';
					//$vehicle_make .= '<select name="vehicle_make" id="vehicle_make" class="form-control select2">';
					
					$vehicle_make = '<option value="0">Select Make</option>';
							
					$this->db->from('vehicle_makes');
					$this->db->order_by('id');
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							$default2 = (strtolower($row['title']) == strtolower($detail->vehicle_make))?'selected':'';
							$vehicle_make .= '<option value="'.$row['title'].'" '.$default2.'>'.$row['title'].'</option>';
						}
					}
					
					//$vehicle_make .= '</select>';
					//$vehicle_make .= '</div>';	
					$data['vehicle_make_options'] = $vehicle_make;
					//*********END SELECT VEHICLE MAKE DROPDOWN**********//
					
					
					//*********SELECT VEHICLE MODEL DROPDOWN**********//
					//$vehicle_model = '<div class="form-group">';
					//$vehicle_model .= '<select name="vehicle_model" id="vehicle_model" class="form-control select2">';
					
					$vehicle_model = '<option value="0">Select Model</option>';
							
					$this->db->from('vehicle_models');
					$this->db->order_by('id');
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							$default3 = (strtolower($row['title']) == strtolower($detail->vehicle_model))?'selected':'';
							$vehicle_type .= '<option value="'.$row['title'].'" '.$default3.'>'.$row['title'].'</option>';
						}
					}
					
					//$vehicle_model .= '</select>';
					//$vehicle_model .= '</div>';	
					$data['vehicle_model_options'] = $vehicle_model;
					//*********END SELECT VEHICLE MODEL DROPDOWN**********//
					

					//SELECT YEAR DROPDOWN
					//$year_of_manufacture = '<div class="form-group">';
					//$year_of_manufacture .= '<select name="year_of_manufacture" id="year_of_manufacture" class="form-control">';
					
					$year_of_manufacture = '<option value="0">Select Year</option>';
					for($i=date("Y")-50; $i<=date("Y"); $i++) {
						$sel = ($i == $row['year_of_manufacture']) ? 'selected' : '';
						$year_of_manufacture .= "<option value=".$i." ".$sel.">".$i."</option>";  
					}		
					
					//$year_of_manufacture .= '</select>';
					//$year_of_manufacture .= '</div>';	
					$data['year_of_manufacture_options'] = $year_of_manufacture;
					//*********END SELECT YEAR DROPDOWN**********//
										

					//SELECT COLOUR DROPDOWN
					//$colours = '<div class="form-group">';
					//$colours .= '<select name="vehicle_colour" id="vehicle_colour" class="form-control">';
					
					$colours = '<option value="0" >Select Colour</option>';
							
					$this->db->from('colours');
					$this->db->order_by('id');
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							$d = (strtolower($row['colour_name']) == strtolower($detail->vehicle_colour))?'selected':'';
							$colours .= '<option value="'.$row['colour_name'].'" '.$d.'>'.ucwords($row['colour_name']).'</option>';
						}
					}
					
					//$colours .= '</select>';
					//$colours .= '</div>';	
					$data['colour_options'] = $colours;
					//*********END SELECT COLOUR DROPDOWN**********//
					
					
					//SELECT COUNTRY DROPDOWN
					//$countries = '<div class="form-group">';
					//$countries .= '<select name="vehicle_location_country" id="vehicle_location_country" class="form-control">';
					
					$countries = '<option value="0" >Select Country</option>';
							
					$this->db->from('countries');
					$this->db->order_by('id');
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							$d = (strtolower($row['name']) == strtolower($detail->vehicle_location_country))?'selected':'';
							$countries .= '<option value="'.$row['name'].'" '.$d.'>'.ucwords($row['name']).'</option>';
						}
					}
					
					//$countries .= '</select>';
					//$countries .= '</div>';	
					$data['country_options'] = $countries;
					//*********END SELECT COUNTRY DROPDOWN**********//
					
					
					//*********SELECT SALE STATUS DROPDOWN**********//
					//$sale_status = '<div class="form-group">';
					//$sale_status .= '<select name="sale_status" id="sale_status" class="form-control">';
					
					$sale_status = '<option value="0" >Sale Status</option>';
							
					$this->db->from('status');
					$this->db->order_by('id');
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							$default = (strtolower($row['status']) == strtolower($detail->sale_status))?'selected':'';
							$status = (strtolower($row['status']) == '0')?'Available':'Sold';
							
							$sale_status .= '<option value="'.$row['status'].'" '.$default.'>'.$status.'</option>';
						}
					}
					
					//$sale_status .= '</select>';
					//$sale_status .= '</div>';	
					$data['sale_status_options'] = $sale_status;
					//*********END SELECT SALE STATUS DROPDOWN**********//
					
					
					//*********SELECT TRADER DROPDOWN**********//
					//$users = '<div class="form-group">';
					//$users .= '<select name="trader_email" id="trader_email" class="form-control">';
					
					/*$users = '<option value="0" >Select Trader</option>';
							
					$this->db->from('users');
					$this->db->order_by('id');
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							$default4 = (strtolower($row['email_address']) == strtolower($detail->trader_email))?'selected':'';
							
							$users_array = $this->Users->get_user($row['email_address']);
							$fullname = '';
							if($users_array){
								foreach($users_array as $user){
									$fullname = $user->first_name.' '.$user->last_name;
								}
							}
							$users .= '<option value="'.$row['email_address'].'" '.$default4.'>'.$fullname.' ('.$row['email_address'].')</option>';
						}
					}
					
					//$users .= '</select>';
					//$users .= '</div>';	
					$data['user_options'] = $users;*/
					//*********END SELECT TRADER DROPDOWN**********//
					
					$data['model'] = 'vehicles';
					$data['success'] = true;
					
					
			}else {
				$data['success'] = false;
			}
			
			echo json_encode($data);
			
		}	
							
	
		
		/**
		* Function to validate add vehicle
		*
		*/					
		public function add_vehicle(){

			$this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
			if (empty($_FILES['vehicle_image']['name']))
			{
				$this->form_validation->set_rules('vehicle_image', 'Image', 'required');
			}	
			$this->form_validation->set_rules('vehicle_type','Type','required|trim|xss_clean|callback_vehicle_type_check');
			$this->form_validation->set_rules('vehicle_make','Make','required|trim|xss_clean|callback_vehicle_make_check');
			$this->form_validation->set_rules('vehicle_model','Model','required|trim|xss_clean|callback_vehicle_model_check|callback_unique_vehicle');
			$this->form_validation->set_rules('year_of_manufacture','Year of Manufacture','required|trim|xss_clean|callback_year_check');
			$this->form_validation->set_rules('vehicle_odometer','Odometer','trim|xss_clean');
			$this->form_validation->set_rules('vehicle_lot_number','Lot Number','trim|xss_clean');
			$this->form_validation->set_rules('vehicle_vin','Vin','trim|xss_clean');
			
			$this->form_validation->set_rules('vehicle_colour','Colour','required|trim|xss_clean|callback_colour_check');
			$this->form_validation->set_rules('vehicle_price','Price','required|trim|xss_clean');
			$this->form_validation->set_rules('vehicle_location_city','Location City','required|trim|xss_clean');
			$this->form_validation->set_rules('vehicle_location_country','Location Country','required|trim|xss_clean|callback_country_check');
			$this->form_validation->set_rules('vehicle_description','Description','required|trim|xss_clean');
			$this->form_validation->set_rules('sale_status','Sale Status','required|trim|xss_clean');
			$this->form_validation->set_rules('trader_email','Email','required|trim|xss_clean|callback_trader_check');
			$this->form_validation->set_rules('discount','Discount','trim|xss_clean');
			$this->form_validation->set_rules('price_after_discount','Discount Price','trim|xss_clean');

			
			$this->form_validation->set_message('required', '%s cannot be blank!');
			
			if($this->form_validation->run()){
				
				//check if the type is unique and insert if it is
				//$unique_type = $this->Vehicle_types->unique_type($this->input->post('vehicle_type'));
				
				//check if the make is unique and insert if it is
				//$unique_make = $this->Vehicle_makes->unique_vehicle_make($this->input->post('vehicle_make'));
				
				//check if the model is unique and insert if it is
				//$unique_model = $this->Vehicle_models->unique_vehicle_model($this->input->post('vehicle_model'));
				
				//check if the model is unique and insert if it is
				//$unique_colour = $this->Colours->unique_colour($this->input->post('vehicle_colour'));
				
				$add = array(
					
					'vehicle_type' => $this->input->post('vehicle_type'),
					'vehicle_make' => $this->input->post('vehicle_make'),
					'vehicle_model' => $this->input->post('vehicle_model'),
					'year_of_manufacture' => $this->input->post('year_of_manufacture'),
					'vehicle_odometer' => $this->input->post('vehicle_odometer'),
					'vehicle_lot_number' => $this->input->post('vehicle_lot_number'),
					'vehicle_vin' => $this->input->post('vehicle_vin'),
					'vehicle_colour' => $this->input->post('vehicle_colour'),
					'vehicle_price' => $this->input->post('vehicle_price'),
					'vehicle_location_city' => $this->input->post('vehicle_location_city'),
					'vehicle_location_country' => $this->input->post('vehicle_location_country'),
					'vehicle_description' => $this->input->post('vehicle_description'),
					'sale_status' => $this->input->post('sale_status'),
					'trader_email' => $this->input->post('trader_email'),	
					'discount' => $this->input->post('discount'),
					'price_after_discount' => $this->input->post('price_after_discount'),
					'date_added' => date('Y-m-d H:i:s'),
						
				);
						
				$insert_id = $this->Vehicles->insert_vehicle($add);
				
				$file_clean = $this->Files->file_xss_clean($_FILES['vehicle_image']);
				
				$is_image = $this->Files->file_is_image($_FILES['vehicle_image']);
						
				if($insert_id && $file_clean && $is_image){
							
					if(!empty($_FILES['vehicle_image']['name'])){
								
						$file_name = '';
								
						$path = './uploads/vehicles/'.$insert_id.'/';
						if(!is_dir($path))
						{
							mkdir($path,0777);
						}
						$config['upload_path'] = $path;
						$config['allowed_types'] = 'gif|jpg|jpeg|png';
						$config['max_size'] = 2048000;
						$config['max_width'] = 3048;
						$config['max_height'] = 2048;
						
						//$allowed_mime_type_array = array('image/gif','image/jpg','image/jpeg','image/png');
						//$mime = get_mime_by_extension($_FILES['vehicle_image']);
						//get file extension
						//$ext = '';
						/*
						switch($mime){
						  case "image/gif":
							 $ext = '.gif';
						  break;
						  case "image/jpg":
							 $ext = '.jpg';
						  break;
						  case "image/jpeg":
							 $ext = '.jpeg';
						  break;
						  case "image/png":
							 $ext = '.png';
						  break;
						  default:
							$ext = '.jpg';
						}
						*/
						
						$file = $_FILES['vehicle_image']['name'];
						$ext = $this->Files->getFileExtension($file);
						
						//$config['file_name'] = $insert_id.'.jpg';
						$config['file_name'] = $insert_id.''.$ext;
								
						$this->load->library('upload', $config);	

						$this->upload->overwrite = true;
						if($this->upload->do_upload('vehicle_image')){
							
							$upload_data = $this->upload->data();			
							if (isset($upload_data['file_name'])){
								$file_name = $upload_data['file_name'];
							}	
							
						}else{
							$data['upload_error'] = $this->upload->display_errors();
						}
							$image_data = array(
								'vehicle_image' => $file_name,		
							);
							$this->Vehicles->update_vehicle($image_data,$insert_id);

							//store in gallery as well
							$gallery_data = array(
								'vehicle_id' => $insert_id,
								'image_name'=> $file_name,
								'created' => date('Y-m-d H:i:s'), 
							);
							$this->db->insert('vehicle_images',$gallery_data);	
							
							//check if multiple image files uploaded
							if(!empty($_FILES['vehicle_images']['name'])){
								
								//upload to folder and store
								$upload_status = $this->Files->upload_image_files($insert_id, $path, $_FILES['vehicle_images']);
							}
							
					}	
				
					
					$email = $this->session->userdata('email');
					$user_array = $this->Users->get_user($email);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->first_name.' '.$user->last_name;
						}
					}
					//update activities table
					$description = 'added <i>'.ucwords($this->input->post('vehicle_make').' '.$this->input->post('vehicle_model')).'</i> vehicle';
				
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Vehicle',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
								
					//$this->session->set_flashdata('project_added', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box alert alert-success text-center"><i class="fa fa-check-circle"></i> The vehicle has been added!</div>');
					
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> '.ucwords($this->input->post('vehicle_make').' '.$this->input->post('vehicle_model')).' has been added!</div>';

													
				}else{
					if($is_image || $file_clean){
						
						$data['success'] = false;
						$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Please only upload a valid file!</div>';
					}else{
						$data['success'] = false;
						$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Vehicle not added!</div>';
					}
					
				}				
			}
			else {
					
				$data['success'] = false;
				$data['notif'] = '<div class="text-center" role="alert">'.validation_errors().'</div>';
					
			}

			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);			
		}


		/**
		* Function to prevent double posting 
		* 
		*/			
		public function unique_vehicle(){
			
			$type = $this->input->post('vehicle_type');
			$make = $this->input->post('vehicle_make');
			$model = $this->input->post('vehicle_model');
			$email = $this->input->post('trader_email');
			
			$where = array(
				'vehicle_type' => $this->input->post('vehicle_type'),
				'vehicle_make' => $this->input->post('vehicle_make'),
				'vehicle_model' => $this->input->post('vehicle_model'),
				'trader_email' => $this->input->post('trader_email'),
			);
			
			if ($this->Vehicles->unique_vehicle($where))
			{
				$this->form_validation->set_message('unique_vehicle', 'You already have this vehicle listed!');
				return FALSE;
			}
			else
			{
				return TRUE;
			}
		}	
		
		
		/**
		* Function to ensure a vehicle type is selected 
		* 
		*/			
		public function vehicle_type_check(){
			
			$str1 = $this->input->post('vehicle_type');
			
			if ($str1 == '' || $str1 == '0')
			{
				$this->form_validation->set_message('vehicle_type_check', 'Please select a vehicle type');
				return FALSE;
			}
			else
			{
				return TRUE;
			}
		}			
		
		/**
		* Function to ensure a vehicle make is selected 
		* 
		*/			
		public function vehicle_make_check(){
			$str = $this->input->post('vehicle_make');
			if ($str == '' || $str == '0'){
				$this->form_validation->set_message('vehicle_make_check', 'Please select a vehicle make');
				return FALSE;
			}
			else{
				return TRUE;
			}
		}			
		/**
		* Function to ensure a vehicle model is selected 
		* 
		*/			
		public function vehicle_model_check(){
			$str = $this->input->post('vehicle_model');
			if ($str == '' || $str == '0'){
				$this->form_validation->set_message('vehicle_model_check', 'Please select a vehicle model');
				return FALSE;
			}
			else{
				return TRUE;
			}
		}			
		/**
		* Function to ensure a vehicle year is selected 
		* 
		*/			
		public function year_check(){
			$str = $this->input->post('year_of_manufacture');
			if ($str == '' || $str == '0'){
				$this->form_validation->set_message('year_check', 'Please select a year');
				return FALSE;
			}
			else{
				return TRUE;
			}
		}			
		/**
		* Function to ensure a vehicle colour is selected 
		* 
		*/			
		public function colour_check(){
			$str = $this->input->post('vehicle_colour');
			if ($str == '' || $str == '0'){
				$this->form_validation->set_message('colour_check', 'Please select a colour');
				return FALSE;
			}
			else{
				return TRUE;
			}
		}			
		/**
		* Function to ensure a vehicle country is selected 
		* 
		*/			
		public function country_check(){
			$str = $this->input->post('vehicle_location_country');
			if ($str == '' || $str == '0'){
				$this->form_validation->set_message('country_check', 'Please select a country');
				return FALSE;
			}
			else{
				return TRUE;
			}
		}			
		/**
		* Function to ensure a vehicle trader email is selected 
		* 
		*/			
		public function trader_check(){
			$str = $this->input->post('trader_email');
			if ($str == '' || $str == '0'){
				$this->form_validation->set_message('trader_check', 'Please select a trader');
				return FALSE;
			}
			else{
				return TRUE;
			}
		}			
																		
		
		/**
		* Function to validate update vehicle
		* form
		*/			
		public function update_vehicle(){
			
			$file_uploaded = false;
			
			//escaping the post values
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
				
			$id = html_escape($this->input->post('vehicleID'));
			
			$vehicle_id = preg_replace('#[^0-9]#i', '', $id); // filter everything but numbers
			
			//isset($_FILES["vehicle_image"])
				
			if(!empty($_FILES['vehicle_image']['name'])){

				$path = './uploads/vehicles/'.$vehicle_id.'/';
				
				if(!is_dir($path)){
					mkdir($path,0777);
				}
				
				$config['upload_path'] = $path;
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size'] = 2048000;
				$config['max_width'] = 3048;
				$config['max_height'] = 2048;
				
				$file = $_FILES['vehicle_image']['name'];
				$ext = $this->Files->getFileExtension($file);
	
				//$config['file_name'] = $vehicle_id.'.jpg';
				$config['file_name'] = $vehicle_id.''.$ext;
				
				$this->load->library('upload', $config);	

				$this->upload->overwrite = true;
				
				$file_uploaded = true;
										
			}
				
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('vehicle_type','Type','required|trim|xss_clean|callback_vehicle_type_check');
			$this->form_validation->set_rules('vehicle_make','Make','required|trim|xss_clean|callback_vehicle_make_check');
			$this->form_validation->set_rules('vehicle_model','Model','required|trim|xss_clean|callback_vehicle_model_check');
			$this->form_validation->set_rules('year_of_manufacture','Year of Manufacture','required|trim|xss_clean|callback_year_check');
			$this->form_validation->set_rules('vehicle_odometer','Odometer','trim|xss_clean');
			$this->form_validation->set_rules('vehicle_lot_number','Lot Number','trim|xss_clean');
			$this->form_validation->set_rules('vehicle_vin','Vin','trim|xss_clean');
			
			$this->form_validation->set_rules('vehicle_colour','Colour','required|trim|xss_clean|callback_colour_check');
			$this->form_validation->set_rules('vehicle_price','Price','required|trim|xss_clean');
			$this->form_validation->set_rules('vehicle_location_city','Location City','required|trim|xss_clean');
			$this->form_validation->set_rules('vehicle_location_country','Location Country','required|trim|xss_clean|callback_country_check');
			$this->form_validation->set_rules('vehicle_description','Description','required|trim|xss_clean');
			$this->form_validation->set_rules('sale_status','Sale Status','required|trim|xss_clean');
			$this->form_validation->set_rules('trader_email','Email','required|trim|xss_clean|callback_trader_check');
			$this->form_validation->set_rules('discount','Discount','trim|xss_clean');
			$this->form_validation->set_rules('price_after_discount','Discount Price','trim|xss_clean');
			
			
			$this->form_validation->set_message('required', '%s cannot be blank!');
				
			if ($this->form_validation->run()){
				
				//get vehicle from db
				$vehicle_array = $this->Vehicles->get_vehicles_by_id($vehicle_id);
				
				//initialise file name
				$new_vehicle_image = '';
				
				//check for any uploaded file
				if($file_uploaded){
					
					if($this->upload->do_upload('vehicle_image')){
							
						$upload_data = $this->upload->data();
							
						//$file_name = '';
						if (isset($upload_data['file_name'])){
							$new_vehicle_image = $upload_data['file_name'];
						}
						//$new_vehicle_image = $file_name;				
					}else{
						//failure to upload, store errors
						if($this->upload->display_errors()){
							$data['upload_error'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$this->upload->display_errors().'</div>';

						}
						
					}
				//no new uploads
				}else{
					foreach($vehicle_array as $vehicle){
						$new_vehicle_image = $vehicle->image;
					}
				}
				
				$update = array(
					'vehicle_image' => $new_vehicle_image,
					'vehicle_type' => $this->input->post('vehicle_type'),
					'vehicle_make' => $this->input->post('vehicle_make'),
					'vehicle_model' => $this->input->post('vehicle_model'),
					'year_of_manufacture' => $this->input->post('year_of_manufacture'),
					'vehicle_odometer' => $this->input->post('vehicle_odometer'),
					'vehicle_lot_number' => $this->input->post('vehicle_lot_number'),
					'vehicle_vin' => $this->input->post('vehicle_vin'),
					'vehicle_colour' => $this->input->post('vehicle_colour'),
					'vehicle_price' => $this->input->post('vehicle_price'),
					'vehicle_location_city' => $this->input->post('vehicle_location_city'),
					'vehicle_location_country' => $this->input->post('vehicle_location_country'),
					'vehicle_description' => $this->input->post('vehicle_description'),
					'sale_status' => $this->input->post('sale_status'),
					'trader_email' => $this->input->post('trader_email'),	
					'discount' => $this->input->post('discount'),
					'price_after_discount' => $this->input->post('price_after_discount'),
					'last_updated' => date('Y-m-d H:i:s'),
				);
				
				if ($this->Vehicles->update_vehicle($update, $vehicle_id)){	
					
					$email = $this->session->userdata('email');
					$user_array = $this->Users->get_user($email);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->first_name.' '.$user->last_name;
						}
					}
					
					//update activities table
					$description = 'updated <i>'.ucwords($this->input->post('vehicle_make').' '.$this->input->post('vehicle_model')).'</i> vehicle';
				
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Vehicle',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
								
					$data['success'] = true;
					
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Vehicle has been updated!</div>';
				}
				
			}else {
				$data['success'] = false;
				$data['notif'] = '<div class="text-center" role="alert">'.validation_errors().'</div>';
			}
			// Encode the data into JSON
			//$this->output->set_content_type('application/json');
			//$data = json_encode($data);

			// Send the data back to the client
			//$this->output->set_output($data);
			echo json_encode($data);			
		}

		
		/**
		* Function to handle display
		* additional image details
		* 
		*/	
		public function vehicle_image_details(){
			
			//escaping the post values
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
				
			//escaping the post values
			$image_name = html_escape($this->input->post('image_name'));
			
			$detail = $this->db->select('*')->from('vehicle_images')->where('image_name',$image_name)->get()->row();
			
			if($detail){

					$data['id'] = $detail->id;
					
					$data['headerTitle'] = $detail->image_name;			
					$data['vehicle_id'] = $detail->vehicle_id;
					
					$thumbnail = '<img src="'.base_url().'uploads/vehicles/'.$detail->vehicle_id.'/'.$detail->image_name.'" class="img-responsive img-rounded" width="240" height="280" />';
					
					$data['thumbnail'] = $thumbnail;
					
					$data['created'] = date("F j, Y", strtotime($detail->created));
					
					$data['model'] = 'vehicle_images';
					$data['success'] = true;
					
					
			}else {
				$data['success'] = false;
			}
			
			echo json_encode($data);
			
		}
		
		
		/**
		* Function to upload multiple images for vehicle 
		* 
		*/			
		public function upload_vehicle_images(){
			
			if(!empty($this->input->post('vehicle_id'))){
				
				//escaping the post values
				$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
					
				$id = html_escape($this->input->post('vehicle_id'));
				
				$vehicle_id = preg_replace('#[^0-9]#i', '', $id); // filter everything but numbers
				
				$count_vehicle_images = $this->Vehicles->count_vehicle_images($vehicle_id);	
				if($count_vehicle_images < 1){
					$count_vehicle_images = 0;
				}
				
				//check if files attached
				$upload = false;

				//Cross Site Scripting prevention filter 
				$file_clean = false;
				foreach($_FILES["vehicle_images"]["error"] as $key => $value){
					if($value == 0){
						$upload = true;
						$file_clean = $this->Files->file_xss_clean($_FILES['vehicle_images']);
						break;
					}
				}
				//!empty($_FILES['vehicle_images']['name']) && $count_vehicle_images <= 5
				if($upload && $file_clean && $count_vehicle_images <= 5){
					
					$append = 0;
					$name_array = array();
					$error_array = array();
					$upload_count = '';
					
					$count = count($_FILES['vehicle_images']['size']);	
					//$vehicle_id = $this->input->post('vehicle_id');
					
					//$existing_images_count = $this->db->where('product_id', $product_id)->get('product_images')->num_rows();
					//$existing_images_count = $this->db->where('portfolio_id', $portfolio_id)->count_all('portfolio_images');
					$allowed_uploads = 5;
					$existing_images_count = 0;
					$existing_images_count = $this->Vehicles->count_vehicle_images($vehicle_id);
					
					if($existing_images_count < 1){
						$existing_images_count = 0;
						$allowed_uploads = 5;
						$append = 1;
					}else{
						$append = $existing_images_count + 1;
						$allowed_uploads = 5 - $existing_images_count;
					}
					
					
					
					//$upload = false;
					foreach($_FILES as $key=>$value){
						
						//$s=0; $s<=$count-1; $s++
						for($s=0; $s<=$count-1; $s++) {
							
							$_FILES['vehicle_images']['name']=$value['name'][$s];
							$_FILES['vehicle_images']['type'] = $value['type'][$s];
							$_FILES['vehicle_images']['tmp_name'] = $value['tmp_name'][$s];
							$_FILES['vehicle_images']['error'] = $value['error'][$s];
							$_FILES['vehicle_images']['size'] = $value['size'][$s]; 	
							
							//ensure only files with input are processed
							if ($_FILES['vehicle_images']['size'] > 0) {
								
								$config['upload_path'] = './uploads/vehicles/'.$vehicle_id.'/';
								$config['allowed_types'] = 'gif|jpg|jpeg|png';
								$config['max_size'] = 2048000;
								$config['max_width'] = 3048;
								$config['max_height'] = 2048;
								//$ext = $append + $s;
								//count images stored
								
								//get file extension
								$file = $_FILES['vehicle_images']['name'];
								//$ext = $this->Files->getFileExtension($file);
								$ext = pathinfo($file, PATHINFO_EXTENSION);
								
								$append = $append + $s;
								
								$config['file_name'] = $vehicle_id.'_'.$append.'.'.$ext;
								
							
								$this->load->library('upload', $config);	
								
								if($this->upload->do_upload('vehicle_images')){
										
									$upload_data = $this->upload->data();
										
									$file_name = '';
									if (isset($upload_data['file_name'])){
										$file_name = $upload_data['file_name'];
									}
									
									$db_data = array(
										'vehicle_id' => $vehicle_id,
										'image_name'=> $file_name,
										'created' => date('Y-m-d H:i:s'), 
									);
									$this->db->insert('vehicle_images',$db_data);

									if($s == 0 && $count_vehicle_images == 0){
										
										$image_data = array(
											'vehicle_image' => $file_name,		
										);
										$this->Vehicles->update_vehicle($image_data,$vehicle_id);

									}
									
								}else{
									if($this->upload->display_errors()){
										
										$error_array[] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$this->upload->display_errors().'</div>';

									}
								}
								
							}
							
						}
						//$append++;
					}	
					$errors= implode(',', $error_array);
					if($errors != ''){
						
						//$this->session->set_flashdata('image_added', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> Image errors!</div>');
						$data['success'] = false;
						$data['notif'] = '<div class="alert alert-danger text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$errors.'</div>';
					
					}else{
						
						//get main image
						$main_img = '';
						$vehicles = $this->db->select('*')->from('vehicles')->where('id',$vehicle_id)->get()->row();
						if($vehicles){
							$main_img = $vehicles->vehicle_image;
						}
			
						
						$vehicle_images = $this->Vehicles->get_vehicle_images($vehicle_id);
						$count_vehicle = $this->Vehicles->count_vehicle_images($vehicle_id);
						
						//start gallery edit group
						$image_group = '<div class="">';
						
						if(!empty($vehicle_images)){
							//item count initialised
							$i = 0;
							//gallery edit row
							$image_group .= '<div class="row">';
								
								
							foreach($vehicle_images as $images){
								
								//gallery edit group
								$image_group .= '<div class="col-sm-3 nopadding">';
								
								//gallery edit group
								$image_group .= '<div class="image-group">';
								
								$image_group .= '<img src="'.base_url().'uploads/vehicles/'.$vehicle_id.'/'.$images->image_name.'" id="'.$images->image_name.'" class="img-responsive" />';
								
								//image path
								$path = 'uploads/vehicles/'.$vehicle_id.'/'.$images->image_name;
								
								if($main_img == $images->image_name){
									$image_group .= '<span class="text-primary"><strong>Main</strong></span>';
									
									$image_group .= '<span class="pull-right"><a href="#" class="remove_image" onclick="deleteVehicleImage(this,'.$vehicle_id.','.$images->id.',\''.$path.'\')"><span aria-hidden="true"><i class="fa fa-trash-o"></i> Remove</span></a></span>';
								}else{
									
									$image_group .= '<a href="#" class="remove_image" onclick="deleteVehicleImage(this,'.$vehicle_id.','.$images->id.',\''.$path.'\')"><span aria-hidden="true"><i class="fa fa-trash-o"></i> Remove</span></a>';
								
									$image_group .= '<span class="pull-right"><a href="#" class="main_image" onclick="mainVehicleImage(this,'.$vehicle_id.',\''.$images->image_name.'\')"><span aria-hidden="true"><i class="fa fa-picture-o"></i> Make Main</span></a></span>';
								}
								
								$image_group .= '</div>';
								$image_group .= '</div>';
								$i++;
								if($i % 4 == 0){
									$image_group .= '</div><br/><div class="row">';
								}
								//$image_group .= '<div style="clear:both;"></div>';
							}
						}
						
						//end gallery edit group
						$image_group .= '</div>';
						$data['image_group'] = $image_group;
						
						//count and display the number of images stored
						$images_count = $this->Vehicles->count_vehicle_images($vehicle_id);
						if($images_count == '' || $images_count == null){
							$images_count = 0;
						}
						$data['images_count'] = $images_count;
						
						
						$email = $this->session->userdata('email');
						$user_array = $this->Users->get_user($email);
						
						$fullname = '';
						if($user_array){
							foreach($user_array as $user){
								$fullname = $user->first_name.' '.$user->last_name;
							}
						}
						
						//update activities table
						$description = 'added vehicle images';
					
						$activity = array(			
							'name' => $fullname,
							'username' => $email,
							'description' => $description,
							'keyword' => 'Image',
							'activity_time' => date('Y-m-d H:i:s'),
						);
							
						$this->Site_activities->insert_activity($activity);
							
						//$this->session->set_flashdata('image_added', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> Image(s) added!</div>');
						$data['success'] = true;
						$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Image(s) added!</div>';
					}
				}else{
					$error = '';
					if(empty($_FILES['vehicle_images']['name'])){
						$error = 'Please select a valid image!';
					}else{
						$error = 'You have exceeded the number of allowed images. You must delete an existing image before you can add another!';
					}
					$data['success'] = false;
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$error.'</div>';
				}
			}/*else{
			
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Please select a valid image!</div>';
			}*/
	
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);			
		}
		
		
		
		public function delete_vehicle_images(){
			
			if($this->input->post('id') != '' && $this->input->post('vehicle_id') != '' && $this->input->post('path') != '')
			{
				
				$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
				$id = $this->input->post('id');
				$id = preg_replace('#[^0-9]#i', '', $id); // filter everything but numbers
			
				$path = $this->input->post('path');
				
				$vehicle_id = $this->input->post('vehicle_id');
				$vehicle_id = preg_replace('#[^0-9]#i', '', $vehicle_id); // filter everything but numbers
			
				
				if($this->Vehicles->delete_image($id,$path)){
					//get main image
					$main_img = '';
					$vehicles = $this->db->select('*')->from('vehicles')->where('id',$vehicle_id)->get()->row();
					if($vehicles){
						$main_img = $vehicles->vehicle_image;
					}
			
					$vehicle_images = $this->Vehicles->get_vehicle_images($vehicle_id);
					$count = $this->Vehicles->count_vehicle_images($vehicle_id);
					
					//start gallery edit group
					$image_group = '<div class="">';
					
					if(!empty($vehicle_images)){
						//item count initialised
						$i = 0;
						//gallery edit row
						$image_group .= '<div class="row">';
							
							
						foreach($vehicle_images as $images){
							
							//gallery edit group
							$image_group .= '<div class="col-sm-3 nopadding">';
							
							//gallery edit group
							$image_group .= '<div class="image-group">';
							
							$image_group .= '<img src="'.base_url().'uploads/vehicles/'.$vehicle_id.'/'.$images->image_name.'" id="'.$images->image_name.'" class="img-responsive"/>';
							//image path
							$path = 'uploads/vehicles/'.$vehicle_id.'/'.$images->image_name;
							
							if($main_img == $images->image_name){
								
								$image_group .= '<span class="text-primary"><i class="fa fa-picture-o"></i> <strong>Main</strong></span>';
								
								$image_group .= '<span class="pull-right"><a href="#" class="remove_image" onclick="deleteVehicleImage(this,'.$vehicle_id.','.$images->id.',\''.$path.'\')"><span aria-hidden="true"><i class="fa fa-trash-o"></i> Remove</span></a></span>';
								
							}else{
								$image_group .= '<a href="#" class="remove_image" onclick="deleteVehicleImage(this,'.$vehicle_id.','.$images->id.',\''.$path.'\')"><span aria-hidden="true"><i class="fa fa-trash-o"></i> Remove</span></a>';
								
								$image_group .= '<span class="pull-right"><a href="#" class="main_image" onclick="mainVehicleImage(this,'.$vehicle_id.',\''.$images->image_name.'\')"><span aria-hidden="true"><i class="fa fa-picture-o"></i> Make Main</span></a></span>';
							}
								
							$image_group .= '</div>';
							$image_group .= '</div>';
							$i++;
							if($i % 4 == 0){
								$image_group .= '</div><br/><div class="row">';
							}
							//$image_group .= '<div style="clear:both;"></div>';
						}
					}
					
					//end gallery edit group
					$image_group .= '</div>';
					$data['image_group'] = $image_group;
					
					//count and display the number of images stored
					$images_count = $this->Vehicles->count_vehicle_images($vehicle_id);
					if($images_count == '' || $images_count == null){
						$images_count = 0;
					}
					$data['images_count'] = $images_count;
					
					$email = $this->session->userdata('email');
					$user_array = $this->Users->get_user($email);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->first_name.' '.$user->last_name;
						}
					}
					//update activities table
					$description = 'deleted a vehicle image';
				
					$activity = array(			
						'name' => $fullname,
						'username' => $email,
						'description' => $description,
						'keyword' => 'Image',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
						
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Image removed!</div>';
				}else{
					$data['success'] = false;
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Image not removed!</div>';
				}
				
			}
			echo json_encode($data);
		}

		
		
		public function make_image_main(){
			
			if($this->input->post('vehicle_id') != '' && $this->input->post('image_name') != '')
			{
				
				$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
				$image_name = $this->input->post('image_name');
				
				$vehicle_id = $this->input->post('vehicle_id');
				$vehicle_id = preg_replace('#[^0-9]#i', '', $vehicle_id); // filter everything but numbers
				
				
				$image_data = array(
					'vehicle_image' => $image_name,		
				);
										;

				
				if($this->Vehicles->update_vehicle($image_data,$vehicle_id)){
					
					//get main image
					$main_img = '';
					$vehicles = $this->db->select('*')->from('vehicles')->where('id',$vehicle_id)->get()->row();
					
					if($vehicles){
						$main_img = $vehicles->vehicle_image;
					}
			
					$vehicle_images = $this->Vehicles->get_vehicle_images($vehicle_id);
					$count = $this->Vehicles->count_vehicle_images($vehicle_id);
					
					//start gallery edit group
					$image_group = '<div class="">';
					
					if(!empty($vehicle_images)){
						//item count initialised
						$i = 0;
						//gallery edit row
						$image_group .= '<div class="row">';
							
							
						foreach($vehicle_images as $images){
							
							//gallery edit group
							$image_group .= '<div class="col-sm-3 nopadding">';
							
							//gallery edit group
							$image_group .= '<div class="image-group">';
							
							$image_group .= '<img src="'.base_url().'uploads/vehicles/'.$vehicle_id.'/'.$images->image_name.'" id="'.$images->image_name.'" class="img-responsive"/>';
							//image path
							$path = 'uploads/vehicles/'.$vehicle_id.'/'.$images->image_name;
							
							if($main_img == $images->image_name){
								
								$image_group .= '<span class="text-primary"><i class="fa fa-picture-o"></i> <strong>Main</strong></span>';
								
								$image_group .= '<span class="pull-right"><a href="#" class="remove_image" onclick="deleteVehicleImage(this,'.$vehicle_id.','.$images->id.',\''.$path.'\')"><span aria-hidden="true"><i class="fa fa-trash-o"></i> Remove</span></a></span>';
								
							}else{
								$image_group .= '<a href="#" class="remove_image" onclick="deleteVehicleImage(this,'.$vehicle_id.','.$images->id.',\''.$path.'\')"><span aria-hidden="true"><i class="fa fa-trash-o"></i> Remove</span></a>';
								
								$image_group .= '<span class="pull-right"><a href="#" class="main_image" onclick="mainVehicleImage(this,'.$vehicle_id.',\''.$images->image_name.'\')"><span aria-hidden="true"><i class="fa fa-picture-o"></i> Make Main</span></a></span>';
								
							}
								
							$image_group .= '</div>';
							$image_group .= '</div>';
							$i++;
							if($i % 4 == 0){
								$image_group .= '</div><br/><div class="row">';
							}
							//$image_group .= '<div style="clear:both;"></div>';
						}
					}
					
					//end gallery edit group
					$image_group .= '</div>';
					$data['image_group'] = $image_group;
					
					//count and display the number of images stored
					$images_count = $this->Vehicles->count_vehicle_images($vehicle_id);
					if($images_count == '' || $images_count == null){
						$images_count = 0;
					}
					$data['images_count'] = $images_count;
					
					$email = $this->session->userdata('email');
					$user_array = $this->Users->get_user($email);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->first_name.' '.$user->last_name;
						}
					}
					//update activities table
					$description = 'changed vehicle main image';
				
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Image',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
						
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Main Image changed!</div>';
				}else{
					$data['success'] = false;
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Main Image not changed!</div>';
				}
				
			}
			echo json_encode($data);
		}





		
	
	
	
	
	
	
	
}
