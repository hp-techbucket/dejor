<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

		public function index()
		{
			$this->dashboard();
		}
		
		

		public function login()
		{
			if($this->session->userdata('admin_logged_in')){
					
					//user already logged in, redirects to account page
					redirect('admin/dashboard');
					
			}	
			else {
					
					if($this->input->get('redirectURL') != ''){
						$url = $this->input->get('redirectURL');
						$this->session->set_flashdata('redirectURL', $url);	
					}
					//assign page title name
					$data['pageTitle'] = 'Admin Login';
					
					//assign page ID
					$data['pageID'] = 'admin_login';
					
					//load main body
					$this->load->view('admin_pages/admin_login_page', $data);
			}		

		}


		/**
		* Function to validate admin login
		*
		*/
        public function login_validation() {
			
			$this->session->keep_flashdata('redirectURL');
            
            $this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
            $this->form_validation->set_rules('username','Username','required|trim|xss_clean|callback_validate_credentials|callback_max_login_attempts');
            $this->form_validation->set_rules('password','Password','required|trim|xss_clean');
            
			 $this->form_validation->set_message('required', '%s cannot be blank!');
			
            if ($this->form_validation->run()){
				
				$data = array(
					'admin_username' => strtolower($this->input->post('username')),
					'admin_logged_in' => true,
				);
				$this->session->set_userdata($data);

				//user already logged in, redirects to account page
				redirect('admin/dashboard');
				
            }
            else {
				
				//user not logged in, redirects to login page
				$this->login();
            }
                
		}		
		
		/**
		* Function to validate username
		*
		*/		
		public function validate_credentials() {
			
			//obtain users ip address
			$ipaddress = $this->Admin->ip();	
			
			$username = strtolower($this->input->post('username'));
			
			$password = $this->input->post('password');
					
			//$hashed_password = md5($this->input->post('password'));
						
			//hashing the password
			$hashed_password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
				
			//default IP function
			$ip = $this->input->ip_address();
				
			//LOCALHOST ARRAY IPV4 IPV6
			$whitelist = array('127.0.0.1', '::1');	
			$ipdetails = '';
			
			//ENSURE USER MACHINE IS NOT LOCALHOST
			if(!in_array($ip, $whitelist)){
				//ipinfo 
				$details = $this->misc_lib->ip_details($ip);
				$ipdetails .= '<p><strong> Hostname:</strong> '.$details['hostname'].'</p>';
				$ipdetails .= '<p><strong> City:</strong> '.$details['city'].'</p>';
				$ipdetails .= '<p><strong> Region:</strong> '.$details['region'].'</p>';
				
				$detail = $this->db->select('*')->from('countries')->where('LOWER(sortname)',strtolower($details['country']))->get()->row();
				$country = '';
				if($detail){
					$country = $detail->name;
				}
				
				$ipdetails .= '<p><strong> Country:</strong> '.$country.'</p>';
				$ipdetails .= '<p><strong> LOC:</strong> '.$details['loc'].'</p>';
				$ipdetails .= '<p><strong> Org:</strong> '.$details['org'].'</p>';
			}
			
				
			//$geo_data = $this->misc_lib->geolocation_by_ip($ip);
						
			if ($this->Admin->admin_can_log_in()){
				
				//check admin last login time from the logins table
				$last_login = $this->db->select_max('login_time')->from('logins')->where("username",$username)->get()->row();
				if(!empty($last_login)){
					$time = $last_login->login_time;
					//array of session variables
					$data = array(	
						'last_login' => $time,
					);	
					$this->Admin->update_user($data, $username);
				}
				
				//array of all login posts
				$login_data = array(
					'ip_address' => $ipaddress,
					'ip_details' => $ipdetails,
					'username' => $username,
					'password' => $hashed_password,
					'login_time' => date('Y-m-d H:i:s')
				);	
				
				//create new login record after updating with previous entry
				$this->Logins->insert_login($login_data);
				return TRUE;
			}
			else {
				
				//array of all login posts
				$login_data = array(
					'ip_address' => $ipaddress,
					'ip_details' => $ipdetails,
					'username' => $username,
					'password' => $hashed_password,
					'attempt_time' => date('Y-m-d H:i:s')
				);	
				
				$this->Failed_logins->insert_failed_login($login_data);
				
				$this->form_validation->set_message('validate_credentials', 'Incorrect username or password.');
				
				return FALSE;
				
			}
			
		}

		
		/**
		* Function to check if the user has logged in wrongly
		* more than 3 times in 24 hours
		*/			
		public function max_login_attempts(){
			
			$username = strtolower($this->input->post('username'));
			
			$date = date("Y-m-d H:i:s",time());
			$date = strtotime($date);
			$min_date = strtotime("-1 day", $date);
			
			$max_date = date('Y-m-d H:i:s', time());
			$min_date = date('Y-m-d H:i:s', $min_date);
			
			$this->db->select('*');
			$this->db->from('failed_logins');
			$this->db->where('username', $username);
			
			$this->db->where("attempt_time BETWEEN '$min_date' AND '$max_date'", NULL, FALSE);

			$query = $this->db->get();
			
			if ($query->num_rows() < 3){	
				return TRUE;	
			}else {	
				$this->form_validation->set_message('max_login_attempts', 'You have surpassed the allowed number of login attempts in 24 hours! Please contact Customer Service!');
				return FALSE;
			}
		}	
	
		
				
		/**
		* Function to access admin account
		*
		*/
        public function dashboard() {
			 
			if($this->session->userdata('admin_logged_in')){
				
				//check if redirect url is set
				$redirect = '';
				if($this->session->flashdata('redirectURL')){
					$redirect = $this->session->flashdata('redirectURL');
					//redirect user to previous url
					//$url = 'account/'.$redirect;
					redirect($redirect);
				}	
				$alert = '';
				$username = $this->session->userdata('admin_username');
				
				//$data['username']=$username;
				
				$data['user_array'] = $this->Admin->get_user($username);
				
				$admin_name = '';
				$last_login = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
						$last_login = $user->last_login;
						$admin_name = $user->admin_name;
					}
					if($last_login == '0000-00-00 00:00:00' || $last_login == ''){ 
						$last_login = 'Never';
						$title = 'Welcome to your Account Dashboard';
						$text = 'You can add, manage and track all your inventory and orders as well as all sale enquiries. Your account is currently imcomplete, so please <a href="'.base_url('account/profile').'"> update your account here.</a>';
						$alert = '<script type="text/javascript" language="javascript">swal({title: "'.$title.'",text: "'.$text.'",html: true});</script>';
					}else{ 
						$last_login = date("F j, Y, g:i a", strtotime($last_login)); 
					}
				}
				
				$data['last_login'] = $last_login;
				$data['admin_name'] = $admin_name;
				$data['admin_username'] = $username;
				$data['alert'] = $alert;
				
				
				$data['contact_us_count'] = $this->Contact_us->count_unread_messages();
				if($data['contact_us_count'] == '' || $data['contact_us_count'] == null){
					$data['contact_us_count'] = 0;
				}	
				
				$messages_unread = $this->Messages->count_unread_messages($username);
				if($messages_unread == '' || $messages_unread == null){
					$data['messages_unread'] = 0;
				}else{
					$data['messages_unread'] = $messages_unread;
				}
				
				$data['header_messages_array'] = $this->Messages->get_header_messages($username);	
				
				
				$data['temp_users_count'] = $this->Temp_users->count_all();
				if($data['temp_users_count'] == '' || $data['temp_users_count'] == null){
					$data['temp_users_count'] = 0;
				}	
				
				
				$enquiries_unread = $this->Sale_enquiries->count_unread_enquiries();
				if($enquiries_unread == '' || $enquiries_unread == null){
					$data['enquiries_unread'] = 0;
				}else{
					$data['enquiries_unread'] = $enquiries_unread;
				}
				
				$data['transactions_count'] = $this->Transactions->count_new_transactions();
				if($data['transactions_count'] == '' || $data['transactions_count'] == null){
					$data['transactions_count'] = 0;
				}	
				$data['transactions_array'] = $this->Transactions->get_all_transactions(5, 0);	
				//*/
				//$data['transactions_array'] = '';
				$data['logins_array'] = $this->Logins->get_logins(5, 0);
				
				$data['failed_logins_array'] = $this->Failed_logins->get_failed_logins(5, 0);
				
				$data['users_array'] = $this->Users->get_users(4, 0);
					
				
				$activities = $this->Site_activities->get_activities(7, 0);
				
				$activity_group = '';
				$activity_class = '';
				
				if(!empty($activities)){
					foreach($activities as $activity){
						//get time ago
						$activity_time = $this->Site_activities->time_elapsed_string(strtotime($activity->activity_time));
						$icon = '<i class="fa fa-list-alt" aria-hidden="true"></i>';
						
						//obtain keyword icon from the db 
						$query = $this->db->get_where('keywords', array('keyword' => $activity->keyword));
						if($query){
							foreach ($query->result() as $row){
								$icon = $row->icon;
							}							
						}
						
						$activity_group .= '<a href="javascript:void(0)" class="list-group-item">';
						$activity_group .= '<span class="badge">'.$activity_time.'</span>';
						$activity_group .= $icon .' '.ucwords($activity->name).' '.$activity->description;
						$activity_group .= '</a>';
						$activity_class = '';
					}
				}else{
					$activity_group = '<br/><br/><h2 align="center"><a href="#" class="list-group-item"><i class="fa fa-star-o" aria-hidden="true"></i> No activities yet</a></h2>';
					$activity_class = 'fixed_height_405';
				}
				
				$data['activity_group'] = $activity_group;
				$data['activity_class'] = $activity_class;	
				
				//$data['activity_group'] = $activity_group;
							
				//assign page title name
				$data['pageTitle'] = 'Admin Dashboard';
				
				//assign page ID
				$data['pageID'] = 'dashboard';
				
				//load header and page title
				$this->load->view('admin_pages/header', $data);
				
				//load main body
				$this->load->view('admin_pages/admin_dashboard_page', $data);
				
				//load footer
				$this->load->view('admin_pages/footer');
				
			}
			else {
				if($this->session->flashdata('redirectURL')){
					$redirect = $this->session->flashdata('redirectURL');
					$url = 'admin/login?redirectURL='.$redirect;
					redirect($url);
				}else{	

					redirect('admin/login');
					//user not logged in, redirects to login page
					//redirect('home/','refresh');           
				} 

			}
            
        } 



		/***
		* Function for admin profile
		*
		***/		
		public function profile(){

			if(!$this->session->userdata('admin_logged_in')){
								
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//$this->login();
				//redirect('admin/login/','refresh');
				
			}else{ 
			
				$username = $this->session->userdata('admin_username');
				
				$data['user_array'] = $this->Admin->get_user($username);
				
				$user_avatar = '';
				$user_id = '';
				$fullname = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
						$fullname = $user->admin_name;
						$user_avatar = $user->avatar;
						$user_id = $user->id;
					}
				}
				
				$data['fullname'] = $fullname;
					
				$data['unread_contact_us'] = $this->Contact_us->count_unread_messages();
					
				$messages_unread = $this->Messages->count_unread_messages($username);
				if($messages_unread == '' || $messages_unread == null){
					$data['messages_unread'] = 0;
				}else{
					$data['messages_unread'] = $messages_unread;
				}
					
				$data['header_messages_array'] = $this->Messages->get_header_messages($username);
				
				$enquiries_unread = $this->Sale_enquiries->count_unread_enquiries();
				if($enquiries_unread == '' || $enquiries_unread == null){
					$data['enquiries_unread'] = 0;
				}else{
					$data['enquiries_unread'] = $enquiries_unread;
				}
				
				$thumbnail = '';
				$mini_thumbnail = '';
				$filename = FCPATH.'uploads/admins/'.$user_id.'/'.$user_avatar;

				//check if record in db is url thus facebook or google
				if(filter_var($user_avatar, FILTER_VALIDATE_URL)){
					//diplay facebook avatar
					$thumbnail = '<img src="'.$user_avatar.'" class="social_profile img-responsive img-circle avatar-view" width="120" height="120" />';
					
					$mini_thumbnail = '<img src="'.$user_avatar.'" class="" width="" height="" />';
				}
				elseif($user_avatar == '' || $user_avatar == null || !file_exists($filename)){
					$thumbnail = '<img src="'.base_url().'assets/images/icons/avatar.jpg" class="img-responsive img-circle avatar-view" width="120" height="120" />';
					
					$mini_thumbnail = '<img src="'.base_url().'assets/images/icons/avatar.jpg" class="" width="" height="" />';
				}
				else{
					$thumbnail = '<img src="'.base_url().'uploads/admins/'.$user_id.'/'.$user_avatar.'" class="img-responsive img-circle avatar-view" width="120" height="120" />';
					
					$mini_thumbnail = '<img src="'.base_url().'uploads/admins/'.$user_id.'/'.$user_avatar.'" class="" width="" height="" />';
				}	
				
				$data['thumbnail'] = $thumbnail;
				$data['mini_thumbnail'] = $mini_thumbnail;
				
				//assign page title name
				$data['pageTitle'] = 'Profile';
				
				//assign page ID
				$data['pageID'] = 'profile';
								
				//load header and page title
				$this->load->view('admin_pages/header', $data);
				
				//load main body
				$this->load->view('admin_pages/profile_page');
				
				//load footer
				$this->load->view('admin_pages/footer');
									
			}	
		}	
			
			

		/**
		* Function to validate update profile
		* form
		*/			
		public function update_profile(){
			
			$username = $this->session->userdata('admin_username');
			
			$user_array = $this->Admin->get_user($username);
				
			$user_id = '';
			$avatar = '';
			$fullname =  '';
			if($user_array){
				foreach($user_array as $user){
					$fullname = $user->admin_name;
					$user_id = $user->id;
					$avatar = $user->avatar;
				}
			}
			$photo_uploaded = false;		
			
			if(!empty($_FILES['update_photo']['name']) && $_FILES['update_photo']['size'] > 0){
					
				//$upload = false;
						
				$path = './uploads/admins/'.$user_id.'/';
				if(!is_dir($path)){
					mkdir($path,0777);
				}
				$config['upload_path'] = $path;
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size'] = 2048000;
				$config['max_width'] = 3048;
				$config['max_height'] = 2048;
							
				$config['file_name'] = $user_id.'.jpg';
						
				$this->load->library('upload', $config);	

				$this->upload->overwrite = true;
				
				$photo_uploaded = true;
											
			}
			
			$this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> ', '</div>');
			
			$this->form_validation->set_rules('admin_name','Admin Name','required|trim|xss_clean');
			
			$this->form_validation->set_message('required', '%s cannot be blank!');
			
			if ($this->form_validation->run()){	

				if($photo_uploaded){
						
					if($this->upload->do_upload('update_photo')){
								
						$upload_data = $this->upload->data();
								
						$file_name = '';
						if (isset($upload_data['file_name'])){
							$file_name = $upload_data['file_name'];
						}
						
						$avatar = $file_name;
						
					}else{
						
						if($this->upload->display_errors()){
							//$data['upload_error'] = '<div class="text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$this->upload->display_errors().'</div>';
							
							//$this->session->set_flashdata('errors', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box alert alert-danger text-center">'.$this->upload->display_errors().'</div>');
							
							$data['upload_errors'] = '<div class="custom-alert-box alert alert-danger text-center">'.$this->upload->display_errors().'</div>';

						}
						
					}
				}
				
				$data = array(
					'avatar' => $avatar,
					'admin_name' => $this->input->post('admin_name'),
					'last_updated' => date('Y-m-d H:i:s'),
				);

				if ($this->Admin->update_user($data, $username)){	

					//update activities table
					$description = 'updated profile';
				
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Update',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
							
					//$this->session->set_flashdata('updated', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);$(".updated-message").animate({scrollTop: 0}, 300);</script><div class="custom-alert-box alert alert-success text-center"><i class="fa fa-check-circle"></i> Your profile has been updated!</div>');
							
					//update complete redirects to success page
					//redirect('admin/profile/');	
					
					$data['success'] = true;
							
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Your profile has been updated!</div>';

				}
				
			}else {
				//$url = 'edit/hand_users/'.$hand_id;
				//Go back to the Edit Details Page if validation fails
				//$this->profile();
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


		/***
		* Function for admin settings
		*
		***/		
		public function settings(){

			if(!$this->session->userdata('admin_logged_in')){
								
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//$this->login();
				//redirect('admin/login/','refresh');
				
			}else{ 
			
				$username = $this->session->userdata('admin_username');
				
				$data['user_array'] = $this->Admin->get_user($username);
					
				$fullname = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
						$fullname = $user->admin_name;
					}
				}
				
				$data['fullname'] = $fullname;
					
				$data['unread_contact_us'] = $this->Contact_us->count_unread_messages();
					
				$messages_unread = $this->Messages->count_unread_messages($username);
				if($messages_unread == '' || $messages_unread == null){
					$data['messages_unread'] = 0;
				}else{
					$data['messages_unread'] = $messages_unread;
				}
					
				$data['header_messages_array'] = $this->Messages->get_header_messages($username);

				$enquiries_unread = $this->Sale_enquiries->count_unread_enquiries();
				if($enquiries_unread == '' || $enquiries_unread == null){
					$data['enquiries_unread'] = 0;
				}else{
					$data['enquiries_unread'] = $enquiries_unread;
				}
				
				//assign page title name
				$data['pageTitle'] = 'Settings';
				
				//assign page ID
				$data['pageID'] = 'settings';
								
				//load header and page title
				$this->load->view('admin_pages/header', $data);
				
				//load main body
				$this->load->view('admin_pages/settings_page');
				
				//load footer
				$this->load->view('admin_pages/footer');
									
			}	
		}	

			

		/**
		* Function to validate update password settings
		* form
		*/			
		public function password_update(){
			
			$username = $this->session->userdata('admin_username');
			
			$this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> ', '</div>');
			
			$this->form_validation->set_rules('old_password','Old Password','required|trim|xss_clean|callback_validate_old_password');
			$this->form_validation->set_rules('new_password','New Password','required|trim|xss_clean');
			$this->form_validation->set_rules('confirm_new_password','Confirm New Password','required|matches[new_password]|trim|xss_clean');
			
			$this->form_validation->set_message('required', 'Please enter a %s!');
			$this->form_validation->set_message('matches', 'Passwords do not match!');
			
			if ($this->form_validation->run()){	
				
				//hashing the password
				$hashed_password = password_hash($this->input->post('new_password'), PASSWORD_DEFAULT);
				
				//hashing the password
				//$hashed_password = md5($this->input->post('new_password'));
				
				
				$data = array(
					'admin_password' => $hashed_password,
					'last_updated' => date('Y-m-d H:i:s'),
				);

				if ($this->Admin->update_user($data, $username)){	

					$user_array = $this->Admin->get_user($username);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update activities table
					$description = 'updated password';
				
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Update',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
							
					//$this->session->set_flashdata('admin_updated', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box alert alert-success text-center"><i class="fa fa-check-circle"></i> Your password has been updated!</div>');
							
					//update complete redirects to success page
					//redirect('admin/settings/');
					
					$data['profile_url'] = 'admin/profile';
					
					$data['success'] = true;
							
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Your password has been updated!</div>';

				}
				
			}else {
				//$url = 'edit/hand_users/'.$hand_id;
				//Go back to the Edit Details Page if validation fails
				//$this->settings();
				
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
		* FUNCTION TO VALIDATE OLD PASSWORD 
		* 
		*/			
		public function validate_old_password(){
			
			$username = $this->session->userdata('admin_username');
			$old_password = $this->input->post('old_password');
			$hashed_password = '';
			
			//get users info frm db using username
			$user_array = $this->Admin->get_user($username);
			if($user_array){
				//get stored password
				foreach($user_array as $user){
					$hashed_password = $user->admin_password;
				}
			}
			
			
			// If the password inputs matched the hashed password in the database
			if (password_verify($old_password, $hashed_password)){
				return TRUE;
			}
			else{
				$this->form_validation->set_message('validate_old_password', 'The Old Password is invalid');
				return FALSE;
				
			}
		}			
			

		/***
		* Function to handle admins
		*
		***/		
		public function admin_users(){
			
			if(!$this->session->userdata('admin_logged_in')){
								
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//redirect('admin/login/','refresh');
				
			}else{			

				if($this->Admin->check_admin_access()){
					
					$username = $this->session->userdata('admin_username');
				
					$data['user_array'] = $this->Admin->get_user($username);
					
					$fullname = '';
					if($data['user_array']){
						foreach($data['user_array'] as $user){
							$fullname = $user->admin_name;
						}
					}
				
					$data['fullname'] = $fullname;
					
					$data['unread_contact_us'] = $this->Contact_us->count_unread_messages();
					
					$messages_unread = $this->Messages->count_unread_messages($username);
					if($messages_unread == '' || $messages_unread == null){
						$data['messages_unread'] = 0;
					}else{
						$data['messages_unread'] = $messages_unread;
					}
					
					$data['header_messages_array'] = $this->Messages->get_header_messages($username);
					
					$enquiries_unread = $this->Sale_enquiries->count_unread_enquiries();
					if($enquiries_unread == '' || $enquiries_unread == null){
						$data['enquiries_unread'] = 0;
					}else{
						$data['enquiries_unread'] = $enquiries_unread;
					}
				
					$data['count_records'] = $this->Admin->count_all();
						
					//assign page title name
					$data['pageTitle'] = 'Admin Users';
								
					//assign page title name
					$data['pageID'] = 'admin_users';
										
					//load header and page title
					$this->load->view('admin_pages/header', $data);
							
					//load main body
					$this->load->view('admin_pages/admin_users_page', $data);	
					
					//load footer
					$this->load->view('admin_pages/footer');
					
					
				}else{
					//Admin access error
					redirect('admin/error');
				}
			}
		}

		
		/***
		* Function to handle admin ajax
		*
		***/
		public function admin_users_datatable()
		{
			$list = $this->Admin->get_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $user) {
				$no++;
				$row = array();
				
				$thumbnail = '';
				$filename = FCPATH.'uploads/admins/'.$user->id.'/'.$user->avatar;

				if($user->avatar == '' || $user->avatar == null || !file_exists($filename)){
					$thumbnail = '<div class="" style="margin-left:25%; margin-right:25%;"><img src="'.base_url().'assets/images/icons/avatar.jpg" class="img-responsive img-circle avatar-view" width="40" height="50"/></div>';
				}
				else{
					$thumbnail = '<div class="" style="margin-left:25%; margin-right:25%;"><img src="'.base_url().'uploads/admins/'.$user->id.'/'.$user->avatar.'" class="img-responsive img-circle" width="40" height="50"/></div>';
				}	
				
				$row[] = '<div class="checkbox checkbox-primary pull-left" style="margin:8% auto;"><input type="checkbox" name="cb[]" class="cb" onclick="enableButton(this)" value="'.$user->id.'"><label for="cb"></label></div><div class="" style="margin-left:45%; margin-right:25%;">'.$thumbnail.'</div>';
				
				//$row[] = '<input type="checkbox" name="cb[]" class="cb" onclick="enableButton(this)" value="'.$user->id.'">';
				$url = 'admin/admin_details';
				
				$row[] = '<a href="#!" data-toggle="modal" data-target="#viewModal" class="link" id="'.$user->id.'" title="View '.ucwords($user->admin_name).'" onclick="viewAdmin('.$user->id.',\''.$url.'\')">'.ucwords($user->admin_name).' ('.$user->admin_username.')</a>';
				
				$row[] = $user->access_level;
			
				//'last_updated' => date('Y-m-d H:i:s'),
				$last_updated = $user->last_updated;
				if($last_updated == '0000-00-00 00:00:00' || $last_updated == ''){ 
					$last_updated = 'Never'; 
				}else{ 
					$last_updated = date("F j, Y, g:i a", strtotime($last_updated)); 
				}
				$row[] = $last_updated;
				
				$last_login = $user->last_login;
				if($last_login == '0000-00-00 00:00:00' || $last_login == ''){ 
					$last_login = 'Never'; 
				}else{ 
					$last_login = date("F j, Y, g:i a", strtotime($last_login)); 
				}
				$row[] = $last_login;
				
				
				$row[] = date("F j, Y", strtotime($user->date_created));
				
				
				//prepare buttons
				$model = 'admin_users';
				
				
				$row[] = '<a data-toggle="modal" data-target="#messageModal" class="btn btn-success btn-xs" onclick="sendDirectMessage('.$user->id.',\''.$model.'\',\''.$url.'\')" id="'.$user->id.'" title="Send Message to '.ucwords($user->admin_name).'"><i class="fa fa-envelope"></i> Message</a>
				<a data-toggle="modal" data-target="#editModal" class="btn btn-primary btn-xs" title="Click to Edit" onclick="editAdmin('.$user->id.',\''.$url.'\')"><i class="fa fa-pencil"></i> Edit</a>';
				
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Admin->count_all(),
				"recordsFiltered" => $this->Admin->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}

	
		/**
		* Function to handle
		* user view and edit
		* display
		*/	
		public function admin_details(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$pid = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
			
			$detail = $this->db->select('*')->from('admin_users')->where('id',$id)->get()->row();
			
			if($detail){

					$data['id'] = $detail->id;
					
					$data['headerTitle'] = $detail->admin_name;			

					$thumbnail = '';
					$update_thumbnail = '';
					$filename = FCPATH.'uploads/admins/'.$detail->id.'/'.$detail->avatar;

					//check if record in db is url thus facebook or google
					if(filter_var($detail->avatar, FILTER_VALIDATE_URL)){
						//diplay facebook avatar
						$thumbnail = '<img src="'.$detail->avatar.'" class="social_profile img-circle avatar-view" width="108" height="108" />';
						$update_thumbnail = '<img src="'.$detail->avatar.'" class="social_profile img-responsive" width="108" height="108" />';
					}
					elseif($detail->avatar == '' || $detail->avatar == null || !file_exists($filename)){
						$thumbnail = '<img src="'.base_url().'assets/images/icons/avatar.jpg" class="img-circle avatar-view" width="108" height="108" />';
						$update_thumbnail = '<img src="'.base_url().'assets/images/icons/avatar.jpg" class="img-responsive" width="170" height="170" />';
					}
					
					else{
						$thumbnail = '<img src="'.base_url().'uploads/admins/'.$detail->id.'/'.$detail->avatar.'" class="img-circle avatar-view" width="108" height="108" />';
						$update_thumbnail = '<img src="'.base_url().'uploads/admins/'.$detail->id.'/'.$detail->avatar.'" class="img-responsive" width="170" height="170" />';
					}	
					$data['thumbnail'] = $thumbnail;
					
					
					$data['update_thumbnail'] = $update_thumbnail;
					$data['admin_username'] = $detail->admin_username;
					$data['admin_password'] = $detail->admin_password;
					$data['admin_name'] = $detail->admin_name;
					$data['access_level'] = $detail->access_level;
					
					//access level dropdown box
					$access_level = '<select name="access_level" class="form-control  select2" id="access_level">';
					for($i=1; $i<4; $i++){
						$default = ($i == $detail->access_level)?'selected':'';
						$access_level .= '<option value="'.$i.'" '.$default.'>'.$i.'</option>';	
					}
					$access_level .= '</select>';
					
					$data['select_access_level'] = $access_level;
					
					$data['date_created'] = date("F j, Y", strtotime($detail->date_created));
					
					//'last_updated' => date('Y-m-d H:i:s'),
					$last_updated = $detail->last_updated;
					if($last_updated == '0000-00-00 00:00:00' || $last_updated == ''){ 
						$last_updated = 'Never'; 
					}else{ 
						$last_updated = date("F j, Y, g:i a", strtotime($last_updated)); 
					}
					$data['last_updated'] = $last_updated;
					
					$last_login = '';
					if($detail->last_login == '0000-00-00 00:00:00' || $detail->last_login == ''){
						$last_login = 'Never';
					}else{
						$last_login = date("F j, Y, g:i a", strtotime($detail->last_login));
					}
					$data['last_login'] = $last_login;
					
					$data['model'] = 'admin_users';
					$data['success'] = true;
					
					
			}else {
				$data['success'] = false;
			}
			
			echo json_encode($data);
			
		}	
		
		/**
		* Function to validate add admin
		*
		*/			
		public function add_admin(){

			$this->load->library('form_validation');
					
			$this->form_validation->set_rules('admin_name','Admin Name','required|trim|xss_clean');
			$this->form_validation->set_rules('admin_username','Admin Username','required|trim|xss_clean|is_unique[admin_users.admin_username]');
			$this->form_validation->set_rules('admin_password','Admin Password','required|trim|xss_clean');
					
			$this->form_validation->set_message('required', '%s cannot be blank!');
			$this->form_validation->set_message('is_unique', 'Username already exists!');
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
				
			if($this->form_validation->run()){
				
				//hashing the password
				$hashed_password = password_hash($this->input->post('admin_password'), PASSWORD_DEFAULT);
				
				$admin_data = array(
					'admin_name' => $this->input->post('admin_name'),
					'admin_username' => $this->input->post('admin_username'),
					'admin_password' => $hashed_password,
					'access_level' => '1',
					'date_created' => date('Y-m-d H:i:s'),
				);

				$insert_id = $this->Admin->create_admin($admin_data);
							
				if($insert_id){
								
					if(isset($_FILES["newUserPhoto"])){
									
						$file_name = '';
									
						$path = './uploads/admins/'.$insert_id.'/';
						if(!is_dir($path)){
							mkdir($path,0777);
						}
						$config['upload_path'] = $path;
						$config['allowed_types'] = 'gif|jpg|jpeg|png';
						$config['max_size'] = 2048000;
						$config['max_width'] = 3048;
						$config['max_height'] = 2048;
										
						$config['file_name'] = $insert_id.'.jpg';
									
						$this->load->library('upload', $config);	

						$this->upload->overwrite = true;
								
						if($this->upload->do_upload('newUserPhoto')){
								
							$upload_data = $this->upload->data();
											
							if (isset($upload_data['file_name'])){
								$file_name = $upload_data['file_name'];
							}	
									
						}else{
							$data['upload_error'] = $this->upload->display_errors();
						}
								
						$profile_data = array(
							'avatar' => $file_name,		
						);
						$this->Admin->update_admin($profile_data, $insert_id);	
								
					}
					
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update activities table
					$description = 'added a new admin';
				
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'User',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
						

					$this->session->set_flashdata('admin_added', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box alert alert-success text-center"><i class="fa fa-check-circle"></i> A new admin user (<i>'.$this->input->post('admin_name').'</i>) has been created!</div>');
							
					$data['success'] = true;
							
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> A new admin user (<i>'.$this->input->post('admin_name').'</i>) has been created!</div>';
							
				}else{
							
					$this->session->set_flashdata('admin_added', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box alert alert-danger text-center"><i class="fa fa-check-circle"></i> The new admin user has not been created!</div>');
								
					$data['success'] = false;
							
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> The new admin user has not been created!</div>';
							
				}				
			}
			else {
						
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.validation_errors().'</div>';
				//$data['errors'] = $this->form_validation->error_array();
				//$this->addhand();	
			}

			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);			
		}


			
		/**
		* Function to validate update admin 
		* form
		*/			
		public function update_admin(){
			
			$id = html_escape($this->input->post('adminID'));
			
			$admin_id = preg_replace('#[^0-9]#i', '', $id); // filter everything but numbers
			
			$upload = false;
			
			if(!empty($_FILES['uploadPhoto']['name'])){
						
				//$upload = false;		
				$path = './uploads/admins/'.$admin_id.'/';
				if(!is_dir($path)){
					mkdir($path,0777);
				}
				$config['upload_path'] = $path;
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size'] = 2048000;
				$config['max_width'] = 3048;
				$config['max_height'] = 2048;
							
				$config['file_name'] = $admin_id.'.jpg';
						
				$this->load->library('upload', $config);	

				$this->upload->overwrite = true;
				
				$upload = true;
											
			}
					
			$this->load->library('form_validation');
				
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
			$this->form_validation->set_rules('admin_password','Password','trim|xss_clean');
			$this->form_validation->set_rules('access_level','Access Level','required|trim|xss_clean');	
						
			if ($this->form_validation->run()){
					
				$post_username = $this->input->post('admin_username');
					
				$user = $this->Admin->get_user($post_username);
				$avatar = '';
				$name = '';
				
				if($upload){
						
					if($this->upload->do_upload('uploadPhoto')){
								
						$upload_data = $this->upload->data();
								
						$file_name = '';
						if (isset($upload_data['file_name'])){
							$file_name = $upload_data['file_name'];
						}
						
						$avatar = $file_name;
						
					}else{
						
						if($this->upload->display_errors()){
							$data['upload_error'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> There are errors with the photo!<br/>'.$this->upload->display_errors().'</div>';
						}
						
					}
				}else{
					//$data['upload_error'] = $this->upload->display_errors();
					foreach($user as $u){
						$avatar = $u->avatar;
						$name = $u->admin_name;
					}
				}

				$password = '';
				if($this->input->post('new_password') == ''){
					$password = $this->input->post('old_password');
				}else{
					$password = $this->input->post('new_password');
					
					//hashing the password
					$password = password_hash($password, PASSWORD_DEFAULT);
				
				}
				

				$admin_data = array(
					'avatar' => $avatar,
					'admin_password' => $password,
					'access_level' => $this->input->post('access_level'),
					'last_updated' => date('Y-m-d H:i:s'),
				);
					
				if ($this->Admin->update_admin($admin_data, $admin_id)){	
					
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update activities table
					$description = 'updated admin - <i>'.$post_username.'</i>';
					
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'User',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
					
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Admin (<i>'.$post_username.'</i>) has been updated!</div>';
				}
					
			}else {
				
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.validation_errors().'</div>';
			}
			
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);			
		}			


				
				
		/***
		* Function to handle users
		*
		***/		
		public function users(){
			
			if(!$this->session->userdata('admin_logged_in')){
								
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//redirect('admin/login/','refresh');
				
			}else{			

				$username = $this->session->userdata('admin_username');
				
				$data['user_array'] = $this->Admin->get_user($username);
					
				$fullname = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
							$fullname = $user->admin_name;
					}
				}
				
				$data['fullname'] = $fullname;
					
				$data['unread_contact_us'] = $this->Contact_us->count_unread_messages();
					
				$messages_unread = $this->Messages->count_unread_messages($username);
				
				if($messages_unread == '' || $messages_unread == null){
					$data['messages_unread'] = 0;
				}else{
					$data['messages_unread'] = $messages_unread;
				}
					
				$data['header_messages_array'] = $this->Messages->get_header_messages($username);
					
				$enquiries_unread = $this->Sale_enquiries->count_unread_enquiries();
				
				if($enquiries_unread == '' || $enquiries_unread == null){
					$data['enquiries_unread'] = 0;
				}else{
					$data['enquiries_unread'] = $enquiries_unread;
				}
				
				$length = 10;
				$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
					
				//$rnd = md5(time()).''.$characters;
				$password_string = substr(str_shuffle($characters), 0, $length);
				$data['password_string'] = $password_string;
					
				//country list dropdown
				//$country_options = '<select name="country"  class="form-control select2" id="cntry">';
				$country_options = '<option value="" selected="selected">Select Country</option>';
						
				$this->db->from('countries');
				$this->db->order_by('id');
				$result = $this->db->get();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row){
						$country_options .= '<option value="'.$row['id'].'">'.ucwords($row['name']).'</option>';			
					}
				}
				//$country_options .= '</select>';
				$data['country_options'] = $country_options;
					
					
				//status dropdown box
				$status = '';
				$this->db->from('status');
				$this->db->order_by('id');
				$result = $this->db->get();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row){
						$status .= '<option value="'.$row['status'].'">'.$row['status'].'</option>';
					}
				}
					
				//$status .= '';
						
				$data['select_status'] = $status;
					
					
				$data['users_count'] = $this->Users->count_all();
				$data['suspended_users_count'] = $this->Users->count_all_deactivated();
				$data['temp_users_count'] = $this->Temp_users->count_all();
					
				//assign page title name
				$data['pageTitle'] = 'Users';
								
				//assign page title name
				$data['pageID'] = 'users';
										
				//load header and page title
				$this->load->view('admin_pages/header', $data);
							
				//load main body
				$this->load->view('admin_pages/users_list_page', $data);	
					
				//load footer
				$this->load->view('admin_pages/footer');
					
			}
				
		}				
	
		
		/***
		* Function to handle users ajax
		* Datatable
		***/
		public function active_users_datatable()
		{
			$list = $this->Users->get_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $user) {
				$no++;
				$row = array();
				
				$thumbnail = '';
				$filename = FCPATH.'uploads/users/'.$user->id.'/'.$user->avatar;

				if($user->avatar == '' || $user->avatar == null || !file_exists($filename)){
					$thumbnail = '<img src="'.base_url().'assets/images/icons/avatar.jpg" class="img-responsive img-circle avatar-view" width="40" height="50"/>';
				}
				else{
					$thumbnail = '<img src="'.base_url().'uploads/users/'.$user->id.'/'.$user->avatar.'" class="img-responsive img-rounded" width="40" height="50"/>';
				}
				
				$row[] = '<div class="checkbox checkbox-primary pull-left" style="margin:8% auto;"><input type="checkbox" name="cb[]" class="cb" onclick="enableButton(this)" value="'.$user->id.'"><label for="cb"></label></div><div class="" style="margin-left:45%; margin-right:25%;">'.$thumbnail.'</div>';
				
				$details_url = 'admin/user_details';
				
				$row[] = '<a href="!#" data-toggle="modal" data-target="#viewModal" class="link" onclick="viewUser('.$user->id.',\''.$details_url.'\');" title="View '.$user->first_name .' '.$user->last_name.'">'.$user->first_name .' '.$user->last_name.'</a>';
				
				$address = $user->address_line_1.', '.$user->city.' '.$user->postcode.', '.$user->state.', '.$user->country;
				if($user->address_line_2 != ''){
					$address = $user->address_line_1.', '.$user->address_line_2.', '.$user->city.' '.$user->postcode.', '.$user->state.', '.$user->country;
				}
				//USER PROFILE COMPLETION PERCENTAGE
				$profile_completion = $this->Users->profile_completion($user->email_address);
				//display progress bar
				$row[] = '<div class="project_progress"><div class="progress progress_sm">
                          <div class="progress-bar bg-green" role="progressbar"  aria-valuenow="'.$profile_completion.'"
  aria-valuemin="0" aria-valuemax="100" style="width:'.$profile_completion.'%"></div>
                        </div><br/><small>'.$profile_completion.'% Complete</small></div>';
						
				//$row[] = substr($address, 0, 25).'...';
				
				//$account_balance = number_format($user->account_balance, 2);
				//$row[] = $account_balance;
				
				//$row[] = $member->username;
				//$row[] = $user->account_number;
				//count reviews
				$count_reviews = $this->Reviews->count_user_reviews($user->id);
				if($count_reviews == '' || $count_reviews == null || $count_reviews < 1 ){
					$count_reviews = 0;
				}
				
				
				//get product ratings
				$rating = $this->db->select_avg('rating')->from('reviews')->where('	seller_email', $user->email_address)->get()->result();
					
				$rating_box = '';
				
				if($rating[0]->rating == '' || $rating[0]->rating == null || $rating[0]->rating < 1){
					$ratings = 0;
					$rating_box = '<div class="starrr stars-existing"  data-rating="'.round($rating[0]->rating).'"></div> <span class="">No reviews yet</span>';
						
				}else{
					$rating_box = '<div class="starrr stars-existing" data-rating="'.round($rating[0]->rating).'"></div> <span class="stars-count-existing">'.round($rating[0]->rating).'</span> star(s) (<span class="review-count">'.$count_reviews.'</span>)';
				}
				$row[] = $rating_box;
				
				
				$last_updated = $user->last_updated;
				if($last_updated == '0000-00-00 00:00:00' || $last_updated == ''){ 
						$last_updated = 'Never'; 
				}else{ 
					$last_updated = date("d M y", strtotime($last_updated)).' at '.date("h:i A", strtotime($last_updated)); 
					//date("d M y h:i A", strtotime($last_updated))
					
					
				}	
				$row[] = $last_updated;
				
				$last_login = $user->last_login;
				if($last_login == '0000-00-00 00:00:00' || $last_login == ''){ 
						$last_login = 'Never'; 
				}else{ 
					$last_login = date("d M y", strtotime($last_login)).' at '.date("h:i A", strtotime($last_login)); 
					//date("d M y h:i A", strtotime($last_login))
					
					
				}	
				$row[] = $last_login;
				
				
				
				
				
			//	$row[] = date("F j, Y", strtotime($user->date_created));
				
				$model = 'users';
				
				$url = 'message/new_message_detail';
				
				//prepare buttons
				
				$row[] = '<a data-toggle="modal" data-target="#messageModal" class="btn btn-primary btn-xs" onclick="sendDirectMessage('.$user->id.',\''.$model.'\',\''.$url.'\')" title="Send Message to '.$user->first_name .' '.$user->last_name.'"><i class="fa fa-envelope"></i> Send Message</a>
				
				<a data-toggle="modal" data-target="#addUserModal" class="btn btn-warning btn-xs" onclick="editUser('.$user->id.',\''.$details_url.'\');" title="Edit '.$user->first_name .' '.$user->last_name.'"><i class="fa fa-edit"></i> Edit</a>
				
				<a data-toggle="modal" class="btn btn-danger btn-xs" data-target="#suspendModal" onclick="suspendUser('.$user->id.',\''.$details_url.'\');" title="Suspend '.$user->first_name .' '.$user->last_name.'"><i class="fa fa-ban"></i> Suspend</a>
				';
				//<a data-toggle="modal" data-target="#editModal" class="btn btn-primary btn-xs" onclick="editUser('.$user->id.');" id="'.$user->id.'" title="Edit '.$user->first_name .' '.$user->last_name.'"><i class="fa fa-edit"></i></a>
				$data[] = $row;
			}
				//
				
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Users->count_all(),
				"recordsFiltered" => $this->Users->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}

		
		/***
		* Function to handle suspended users
		*  ajax Datatable
		***/
		public function suspended_users_datatable()
		{
			$list = $this->Users->get_deactivated_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $user) {
				$no++;
				$row = array();
				
				if($user->avatar == '' || $user->avatar == null || !file_exists($filename)){
					$thumbnail = '<img src="'.base_url().'assets/images/icons/avatar.jpg" class="img-responsive img-circle avatar-view" width="40" height="50"/>';
				}
				else{
					$thumbnail = '<img src="'.base_url().'uploads/users/'.$user->id.'/'.$user->avatar.'" class="img-responsive img-rounded" width="40" height="50"/>';
				}	
				$row[] = '<div class="checkbox checkbox-primary pull-left" style="margin:8% auto;"><input type="checkbox" name="cb[]" class="cb" onclick="enableButton(this)" value="'.$user->id.'"><label for="cb"></label></div> <div style="margin-left:35%; margin-right:35%;">'.$thumbnail.'</div>';
				
				$url = 'admin/user_details';
					
				//$row[] = $thumbnail;
				$row[] = '<a href="#" data-toggle="modal" data-target="#viewModal" class="link" onclick="viewUser('.$user->id.',\''.$url.'\');" title="View '.$user->first_name .' '.$user->last_name.'">'.$user->first_name .' '.$user->last_name.' ('.$user->email_address.')</a>';
				
				$address = $user->address_line_1.', '.$user->city.' '.$user->postcode.', '.$user->state.', '.$user->country;
				if($user->address_line_2 != ''){
					$address = $user->address_line_1.', '.$user->address_line_2.', '.$user->city.' '.$user->postcode.', '.$user->state.', '.$user->country;
				}
				
				//$row[] = $address;
				
				//$account_balance = number_format($user->account_balance, 2);
				//$row[] = $account_balance;
				$count_reviews = $this->Reviews->count_user_reviews($user->id);
				if($count_reviews == '' || $count_reviews == null || $count_reviews < 1 ){
					$count_reviews = 0;
				}
				
				
				//get product ratings
				$rating = $this->db->select_avg('rating')->from('reviews')->where('user_id', $user->id)->get()->result();
					
				$rating_box = '';
				
				if($rating[0]->rating == '' || $rating[0]->rating == null || $rating[0]->rating < 1){
					$ratings = 0;
					$rating_box = '<div class="starrr stars-existing"  data-rating="'.round($rating[0]->rating).'"></div> <span class="">No reviews yet</span>';
						
				}else{
					$rating_box = '<div class="starrr stars-existing" data-rating="'.round($rating[0]->rating).'"></div> <span class="stars-count-existing">'.round($rating[0]->rating).'</span> star(s) (<span class="review-count">'.$count_reviews.'</span>)';
				}
				$row[] = $rating_box;
				
				$last_updated = $user->last_updated;
				if($last_updated == '0000-00-00 00:00:00' || $last_updated == ''){ 
						$last_updated = 'Never'; 
				}else{ 
					$last_updated = date("d M y", strtotime($last_updated)).' at '.date("h:i A", strtotime($last_updated)); 
					//date("d M y h:i A", strtotime($last_updated))
					
					
				}	
				$row[] = $last_updated;
				
				$last_login = $user->last_login;
				if($last_login == '0000-00-00 00:00:00' || $last_login == ''){ 
						$last_login = 'Never'; 
				}else{ 
					$last_login = date("d M y", strtotime($last_login)).' at '.date("h:i A", strtotime($last_login)); 
					//date("d M y h:i A", strtotime($last_login))
					
					
				}	
				$row[] = $last_login;
				
				$row[] = date("F j, Y", strtotime($user->date_created));
				
				$row[] = '<a data-toggle="modal" data-target="#reactivateModal" class="btn btn-success btn-xs" onclick="reactivateUser('.$user->id.',\''.$url.'\');" id="'.$user->id.'" title="Reactivate '.$user->first_name .' '.$user->last_name.'"><i class="fa fa-undo"></i> Reactivate</a>';
				
				$data[] = $row;
			}
			
			//
			
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Users->count_all_deactivated(),
				"recordsFiltered" => $this->Users->count_filtered_deactivated(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}
		
		/***
		* Function to handle temp users ajax
		* Datatable
		***/
		public function temp_users_datatable()
		{
			$list = $this->Temp_users->get_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $user) {
				$no++;
				$row = array();
				$row[] = '<div class="checkbox checkbox-primary"><input type="checkbox" name="cb[]" class="cb" onclick="enableButton(this)" value="'.$user->id.'"><label for="cb"></label></div>';
				
				$row[] = $user->first_name .' '.$user->last_name;
				
				$row[] = $user->email_address;
				$row[] = $user->telephone;
				
				$ip_details = '<p><strong>IP: </strong>'.$user->ip_address.'</p>';
				$ip_details .= $user->ip_details;
				
				$row[] = $user->ip_address;
				
				$row[] = date("F j, Y", strtotime($user->date_created));
				
				$url = 'admin/temp_user_details';
				
				$row[] = '<a data-toggle="modal" class="btn btn-success btn-xs" data-target="#activateModal" onclick="activateUser('.$user->id.',\''.$url.'\');" id="'.$user->id.'" title="Activate '.$user->first_name .' '.$user->last_name.'"><i class="fa fa-check-circle fa-lg" aria-hidden="true"></i> Activate User</a>';
				
				$model = 'temp_users';
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Temp_users->count_all(),
				"recordsFiltered" => $this->Temp_users->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}
		
		/**
		* Function to handle
		* temp users view, edit and activation
		* 
		*/	
		public function temp_user_details(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$pid = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
			
			$detail = $this->db->select('*')->from('temp_users')->where('id',$id)->get()->row();
			
			if($detail){

					$data['id'] = $detail->id;
					
					$data['headerTitle'] = ucwords($detail->first_name) .' '.ucwords($detail->last_name);	
					
					$data['fullName'] = ucwords($detail->first_name) .' '.ucwords($detail->last_name);
					
					$data['first_name'] = ucwords($detail->first_name);
					
					$data['last_name'] = ucwords($detail->last_name);
					
					$data['email'] = $detail->email_address;
					$data['telephone'] = $detail->telephone;
					
					$data['password'] = $detail->password;
				
					$data['date_created'] = date("F j, Y", strtotime($detail->date_created));
					
					$data['model'] = 'temp_users';
					$data['success'] = true;

			}else {
				$data['success'] = false;
			}
			echo json_encode($data);
		}	
							
			
		/**
		* Function to handle
		* users view and edit
		* display
		*/	
		public function user_details(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$pid = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
			
			$detail = $this->db->select('*')->from('users')->where('id',$id)->get()->row();
			
			if($detail){

					$data['id'] = $detail->id;
					
					$data['headerTitle'] = ucwords($detail->first_name .' '.$detail->last_name);	
					
					$thumbnail = '';
					$u_thumbnail = '';
					$filename = FCPATH.'uploads/users/'.$detail->id.'/'.$detail->avatar;

					if($detail->avatar == '' || $detail->avatar == null || !file_exists($filename)){
						$thumbnail = '<img src="'.base_url().'assets/images/icons/avatar.jpg" class="img-circle" width="108" height="108"/>';
						$u_thumbnail = '<img src="'.base_url().'assets/images/icons/avatar.jpg" class="" width="" height=""/>';
					}
					else{
						$thumbnail = '<img src="'.base_url().'uploads/users/'.$detail->id.'/'.$detail->avatar.'" class="img-circle" width="108" height="108"/>';
						$u_thumbnail = '<img src="'.base_url().'uploads/users/'.$detail->id.'/'.$detail->avatar.'" class="" width="" height=""/>';
					}	
					$data['avatar_name'] = $detail->avatar;
					$data['avatar'] = $thumbnail;
					
					$data['u_thumbnail'] = $u_thumbnail;
					
					$data['first_name'] = ucwords($detail->first_name);
					
					$data['last_name'] = ucwords($detail->last_name);
					$data['fullName'] = ucwords($detail->first_name .' '.$detail->last_name);
					
					$data['company_name'] = $detail->company_name;
					//$data['position'] = $detail->position;
					//$data['profile_description'] = $detail->profile_description;
					
					$data['address_line_1'] = $detail->address_line_1;
					$data['address_line_2'] = $detail->address_line_2;
					$data['city'] = $detail->city;
					$data['postcode'] = $detail->postcode;
					
					$country_id = '';
					//get country id
					$this->db->from('countries');
					$this->db->where('name', $detail->country);
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							$country_id = $row['id'];
						}
					}
					$data['country_id'] = $country_id;
					
					//get states
					//$select_states = '<select name="state" id="state" class="form-control select2 state">';
					$state_options = '<option value="0" >Select State</option>';
					//$select_states .= '<option value="0" selected="selected">Select State</option>';
					
					$this->db->from('states');
					$this->db->where('country_id', $country_id);
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							$default = (strtolower($row['name']) == strtolower($detail->state))?'selected':'';
							$state_options .= '<option value="'.$row['name'].'" '.$default.'>'.$row['name'].'</option>';			
						}
					}
					//$select_states .= '</select>';
					$data['state_options'] = $state_options;
					
					$data['state'] = $detail->state;
					
					$address_line_2 = '';
					
					if($detail->address_line_2 != ''){
						$address_line_2 = $detail->address_line_2.', ';
					}
					
					$data['complete_address'] = $detail->address_line_1.', '.$address_line_2.''.$detail->city.' '.$detail->postcode.', '.$detail->state.', '.$detail->country;
					//country list dropdown
					//$country_options = '<select name="country" class="form-control select2" id="cntry">';
					$country_options = '<option value="0" >Select Country</option>';
						
					$this->db->from('countries');
					$this->db->order_by('id');
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							$default = ($detail->country == $row['name'])?'selected':'';
							
							$country_options .= '<option value="'.$row['id'].'" '.$default.'>'.ucwords($row['name']).'</option>';			
						}
					}
					//$country_options .= '</select>';
					
					$data['country_options'] = $country_options;
					
					$data['country'] = $detail->country;
					$data['email'] = $detail->email_address;
					$data['facebook'] = $detail->facebook;
					$data['twitter'] = $detail->twitter;
					$data['google'] = $detail->google;
					$data['telephone'] = $detail->telephone;
					
					$data['password'] = $detail->password;
				
					$data['security_question'] = $detail->security_question;
					$data['security_answer'] = $detail->security_answer;
					
					
					$status_string = '<span class="badge bg-green">Active</span>';
					if($detail->status == '1'){
						$status_string = '<span class="badge bg-red">Suspended</span>';
					}
					
					$data['status'] = $status_string;
					
					//status dropdown box
					$status = '';
					$this->db->from('status');
					$this->db->order_by('id');
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							$default = ($detail->status == $row['status'])?'selected':'';
							$status .= '<option value="'.$row['status'].'" '.$default.'>'.$row['status'].'</option>';
						}
					}
					
					//$status .= '';
						
					$data['select_status'] = $status;
					
					$last_updated = $detail->last_updated;
					if($last_updated == '0000-00-00 00:00:00' || $last_updated == ''){ 
							$last_updated = 'Never'; 
					}else{ 
						$last_updated = date("d F y, h:i A", strtotime($last_updated)); 
					}	
					$data['last_updated'] = $last_updated;
					
					$last_login = $detail->last_login;
					if($last_login == '0000-00-00 00:00:00' || $last_login == ''){ 
							$last_login = 'Never'; 
					}else{ 
						$last_login = date("d F y, h:i A", strtotime($last_login)); 
					}	
					$data['last_login'] = $last_login;
					
					
					$data['date_created'] = date("F j, Y", strtotime($detail->date_created));
					
					$data['model'] = 'users';
					$data['success'] = true;

			}else {
				$data['success'] = false;
			}
			echo json_encode($data);
		}	
							
	
		
		/**
		* Function to validate add user
		*
		*/			
		public function add_user(){

			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('first_name','First Name','required|trim|xss_clean');
			
			$this->form_validation->set_rules('last_name','Last Name','required|trim|xss_clean');
			$this->form_validation->set_rules('company_name','Company Name','trim|xss_clean');
			
			$this->form_validation->set_rules('address_line_1','Address Line 1','required|trim|xss_clean');
			$this->form_validation->set_rules('address_line_2','Address Line 2','trim|xss_clean');
			$this->form_validation->set_rules('city','City','required|trim|xss_clean');
			$this->form_validation->set_rules('postcode','Postcode','required|trim|xss_clean');
			$this->form_validation->set_rules('state','State','required|trim|xss_clean');
			$this->form_validation->set_rules('country','Country','required|trim|xss_clean');
			$this->form_validation->set_rules('email_address','Email','required|trim|valid_email|is_unique[users.email_address]|is_unique[temp_users.email_address]|xss_clean');
			$this->form_validation->set_rules('facebook','Facebook','trim|xss_clean|callback_validate_facebook');
			$this->form_validation->set_rules('twitter','Twitter','trim|xss_clean|callback_validate_twitter');
			$this->form_validation->set_rules('google','Google','trim|xss_clean|callback_validate_google');
			$this->form_validation->set_rules('telephone','Telephone','required|trim|xss_clean');
			
			//$this->form_validation->set_rules('profile_description','Profile Description','required|trim|xss_clean');
			
			$this->form_validation->set_rules('password','Password','required|trim|xss_clean');
			
			if (empty($_FILES['user_photo']['name']))
			{
				$this->form_validation->set_rules('user_photo', 'User Image', 'required');
			}
					
			$this->form_validation->set_message('required', '%s cannot be blank!');
					
			$this->form_validation->set_message('is_unique', 'This user is already registered!');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
				
				
			if($this->form_validation->run()){
				
				
				$first_name = $this->input->post('first_name');
				
				$last_name = $this->input->post('last_name');
				
				$country_id = $this->input->post('country');
				$cid = preg_replace('#[^0-9]#i', '', $country_id); // filter everything but numbers
				
				$country = '';
				
				$detail = $this->db->select('*')->from('countries')->where('id',$cid)->get()->row();
			
				if($detail){
					$country = $detail->name;
				}
				
				//hashing the password
				$hashed_password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);	
				
				$user_name = $first_name.' '.$last_name;
				
				$facebook = $this->input->post('facebook');
				$facebook = preg_replace("/\s+/", "+", $facebook);
				$facebook_url = 'https://www.facebook.com/'.$facebook;

				$twitter = $this->input->post('twitter');
				$twitter = preg_replace("/\s+/", "+", $twitter);
				$twitter_url = 'https://www.twitter.com/'.$twitter;
				

				$google = ''.$this->input->post('google');
				$google = preg_replace("/\s+/", "+", $google);
				$google_url = 'https://plus.google.com/b/'.$google;
				
				
				$user_data = array(
				
					'first_name' => ucwords($this->input->post('first_name')),
					'last_name' => ucwords($this->input->post('last_name')),
					'company_name' => ucwords($this->input->post('company_name')),
					'address_line_1' => ucwords($this->input->post('address_line_1')),
					'address_line_2' => ucwords($this->input->post('address_line_2')),
					'city' => ucwords($this->input->post('city')),
					'postcode' => strtoupper($this->input->post('postcode')),
					'state' => ucwords($this->input->post('state')),
					'country' => $country,
					'email_address' => strtolower($this->input->post('email_address')),
					'facebook' => $facebook,
					'twitter' => $twitter,
					'google' => $google,
					'telephone' => $this->input->post('telephone'),
					'password' => $hashed_password,
					'security_question' => '',
					'security_answer' => '',
					'status' => '0',
					'last_updated' => '0000-00-00 00:00:00',
					'last_login' => '0000-00-00 00:00:00',
					'date_created' => date('Y-m-d H:i:s'),
					
				);
				
				$insert_id = $this->Users->insert_user($user_data);
							
				if($insert_id){
					
					//SET DEFAULT ALERT SETTING
					$alert_data = array(
						'status' => '1',
						'email' => strtolower($this->input->post('email_address')),
						'last_updated' => '0000-00-00 00:00:00',
					);
					
					//INSERT IN DB
					$this->Email_alerts->insert_alert($alert_data);
					
					
					//CHECK IF USER PHOTO IS ATTACHED
					//THEN UPLOAD
					if(!empty($_FILES['user_photo']['name'])){
									
						$file_name = '';
									
						$path = './uploads/users/'.$insert_id.'/';
						if(!is_dir($path)){
							mkdir($path,0777);
						}
						$config['upload_path'] = $path;
						$config['allowed_types'] = 'gif|jpg|jpeg|png';
						$config['max_size'] = 2048000;
						$config['max_width'] = 3048;
						$config['max_height'] = 2048;
										
						$config['file_name'] = $insert_id.'.jpg';
									
						$this->load->library('upload', $config);	

						$this->upload->overwrite = true;
								
						if($this->upload->do_upload('user_photo')){
								
							$upload_data = $this->upload->data();
											
							if (isset($upload_data['file_name'])){
								$file_name = $upload_data['file_name'];
							}	
									
						}else{
							$data['upload_error'] = $this->upload->display_errors();
						}
								
						$profile_data = array(
							'avatar' => $file_name,		
						);
						$this->Users->update_user($profile_data, $insert_id);	
						
										
					}	
					
					
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update activities table
					$description = 'added a new user';
				
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'User',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
								
					//$this->session->set_flashdata('client_added', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box alert alert-success text-center"><i class="fa fa-check-circle"></i> A new user (<i>'.$member_name.'</i>) has been added!</div>');
							
					$data['success'] = true;
							
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> A new user (<i>'.$user_name.'</i>) has been added!</div>';
							
				}else{
							
					//$this->session->set_flashdata('client_added', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box alert alert-danger text-center"><i class="fa fa-check-circle"></i> The new user has not been added!</div>');
								
					$data['success'] = false;
							
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> The new user has not been added!</div>';
							
				}				
			}
			else {
						
				$data['success'] = false;
				$data['notif'] = '<div class="text-center" role="alert">'.validation_errors().'</div>';
				//$data['errors'] = $this->form_validation->error_array();
				//$this->addhand();	
			}

			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);			
		}



		/**
		* FUNCTION TO VALIDATE FACEBOOK 
		* 
		*/			
		public function validate_facebook(){
			
			$facebook = $this->input->post('facebook');
			$facebook = preg_replace("/\s+/", "+", $facebook);
			$facebook_url = 'https://www.facebook.com/'.$facebook;
			
			if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$facebook_url))
			{
				$this->form_validation->set_message('validate_facebook', 'Please enter a valid Facebook username!');
				return FALSE;
			}
			else
			{
				return TRUE;
			}
		}
		
		
		/**
		* FUNCTION TO VALIDATE TWITTER 
		* 
		*/			
		public function validate_twitter(){
			
			$twitter = $this->input->post('twitter');
			$twitter = preg_replace("/\s+/", "+", $twitter);
			$twitter_url = 'https://www.twitter.com/'.$twitter;
			
			$twitter = ''.$this->input->post('twitter');
			$google = ''.$this->input->post('google');
			
			if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$twitter_url))
			{
				$this->form_validation->set_message('validate_twitter', 'Please enter a valid Twitter username!');
				return FALSE;
			}
			else
			{
				return TRUE;
			}
		}
			
		/**
		* FUNCTION TO VALIDATE GOOGLE 
		* 
		*/			
		public function validate_google(){
			
			$google = ''.$this->input->post('google');
			$google = preg_replace("/\s+/", "+", $google);
			$google_url = 'https://plus.google.com/b/'.$google;
			
			
			if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$google_url))
			{
				$this->form_validation->set_message('validate_google', 'Please enter a valid Google username!');
				return FALSE;
			}
			else
			{
				return TRUE;
			}
		}
			
		
		/**
		* Function to validate update user
		* form
		*/			
		public function update_user(){
			
			$photo_uploaded = false;
			
			$id = html_escape($this->input->post('userID'));
			
			$user_id = preg_replace('#[^0-9]#i', '', $id); // filter everything but numbers
				
			
			if(!empty($_FILES['user_photo']['name'])){
					
				//$upload = false;
						
				$path = './uploads/users/'.$user_id.'/';
				if(!is_dir($path)){
					mkdir($path,0777);
				}
				$config['upload_path'] = $path;
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size'] = 2048000;
				$config['max_width'] = 3048;
				$config['max_height'] = 2048;
							
				$config['file_name'] = $user_id.'.jpg';
						
				$this->load->library('upload', $config);	

				$this->upload->overwrite = true;
				
				$photo_uploaded = true;
											
			}
					
			$this->load->library('form_validation');
				
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
			$this->form_validation->set_rules('first_name','First Name','required|trim|xss_clean');
			
			$this->form_validation->set_rules('last_name','Last Name','required|trim|xss_clean');
			$this->form_validation->set_rules('company_name','Company Name','trim|xss_clean');
			
			$this->form_validation->set_rules('address_line_1','Address Line 1','required|trim|xss_clean');
			$this->form_validation->set_rules('address_line_2','Address Line 2','trim|xss_clean');
			$this->form_validation->set_rules('city','City','required|trim|xss_clean');
			$this->form_validation->set_rules('postcode','Postcode','required|trim|xss_clean');
			$this->form_validation->set_rules('state','State','required|trim|xss_clean');
			$this->form_validation->set_rules('country','Country','required|trim|xss_clean');
			$this->form_validation->set_rules('email_address','Email','required|trim|xss_clean');
			$this->form_validation->set_rules('facebook','Facebook','trim|xss_clean');
			$this->form_validation->set_rules('twitter','Twitter','trim|xss_clean');
			$this->form_validation->set_rules('google','Google','trim|xss_clean');
			
			$this->form_validation->set_rules('telephone','Telephone','required|trim|xss_clean');
			
			//$this->form_validation->set_rules('profile_description','Profile Description','required|trim|xss_clean');
			
			$this->form_validation->set_rules('password','Password','trim|xss_clean');

			$this->form_validation->set_rules('status','Status','required|trim|xss_clean');
				
			if ($this->form_validation->run()){
				
				$first_name = $this->input->post('first_name');
				
				$last_name = $this->input->post('last_name');

				$country_id = $this->input->post('country');
				$cid = preg_replace('#[^0-9]#i', '', $country_id); // filter everything but numbers
				
				$country = '';
				
				$detail = $this->db->select('*')->from('countries')->where('id',$cid)->get()->row();
			
				if($detail){
					$country = $detail->name;
				}
				$user_name = $first_name.' '.$last_name;	
				
				$avatar = $this->input->post('avatar');
				$password = '';
				
				$users_detail = $this->db->select('*')->from('users')->where('id',$user_id)->get()->row();
				if($users_detail){
					$password = $users_detail->password;
				}
				
				if($this->input->post('password') != '' || $this->input->post('password') != null){
					//$password = md5($this->input->post('new_password'));
					//hashing the password
					$password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);	
				}

				if($photo_uploaded){
						
					if($this->upload->do_upload('user_photo')){
								
						$upload_data = $this->upload->data();
								
						$file_name = '';
						if (isset($upload_data['file_name'])){
							$file_name = $upload_data['file_name'];
						}
						
						$avatar = $file_name;
						
					}else{
						
						if($this->upload->display_errors()){
							$data['upload_error'] = '<div class="text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$this->upload->display_errors().'</div>';
						}
						
					}
				}
				
				$facebook = $this->input->post('facebook');
				if($old_facebook != '' && $old_facebook != null && preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$this->input->post('facebook'))){
				
					$facebook = preg_replace("/\s+/", "+", $facebook);
					
				}else{
					$facebook = $this->input->post('facebook');
					$facebook = preg_replace("/\s+/", "+", $facebook);
					$facebook = 'https://www.facebook.com/'.$facebook;
				}
				
				$twitter = $this->input->post('twitter');
				if(preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$this->input->post('twitter'))){
				
					$twitter = preg_replace("/\s+/", "+", $twitter);
					
				}else{
					$twitter = preg_replace("/\s+/", "+", $twitter);
					$twitter = 'https://www.twitter.com/'.$twitter;
				}
				
				$google = $this->input->post('google');
				if(preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$this->input->post('google'))){
					//$google = $this->input->post('google');
					$google = preg_replace("/\s+/", "+", $google);
					
				}else{
					$google = preg_replace("/\s+/", "+", $google);
					$google = 'https://plus.google.com/b/'.$google;
				}
				
				$user_data = array(
					'avatar' => $avatar,
					'first_name' => ucwords($this->input->post('first_name')),
					'last_name' => ucwords($this->input->post('last_name')),
					'company_name' => ucwords($this->input->post('company_name')),
					'address_line_1' => ucwords($this->input->post('address_line_1')),
					'address_line_2' => ucwords($this->input->post('address_line_2')),
					'city' => ucwords($this->input->post('city')),
					'postcode' => strtoupper($this->input->post('postcode')),
					'state' => ucwords($this->input->post('state')),
					'country' => $country,
					'email_address' => strtolower($this->input->post('email_address')),
					'facebook' => $facebook,
					'twitter' => $twitter,
					'google' => $google,
					'telephone' => $this->input->post('telephone'),
					'password' => $password,
					'security_question' => $this->input->post('security_question'),
					'security_answer' => $this->input->post('security_answer'),
					'status' => $this->input->post('status'),
					'last_updated' => date('Y-m-d H:i:s'),
					
				);

				if ($this->Users->update_user($user_data, $user_id)){
					
					
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update activities table
					$description = 'updated user <i>'.$user_name.'</i>';
				
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'User',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
								
					//$this->session->set_flashdata('client_updated', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> User updated!</div>');
						
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> User has been updated!</div>';
				}
					
			}else {
				
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> There are errors on the form!'.validation_errors().'</div>';
			}
			
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);					
		}			

		
		/**
		* Function to handle
		* suspend user
		* display
		*/	
		public function suspend_user(){
			
			//escaping the post values
			$uid = html_escape($this->input->post('userID'));
			$id = preg_replace('#[^0-9]#i', '', $uid); // filter everything but numbers

			$detail = $this->db->select('*')->from('users')->where('id',$id)->get()->row();
			
			if($detail){

					//$data['id'] = $detail->id;
					$update = array(
						'status' => '1',
					);
					
					if($this->Users->update_user($update, $id)){
						
						$data['success'] = true;
						$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> User has been suspended!</div>';
					}else{
						$data['success'] = false;
						$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Method error</div>';
					}

			}else {
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> No such user!</div>';
			}
			echo json_encode($data);
		}	
			
		
		/**
		* Function to
		* reactivate user
		* display
		*/	
		public function reactivate_user(){
			
			//escaping the post values
			$uid = html_escape($this->input->post('userID'));
			$id = preg_replace('#[^0-9]#i', '', $uid); // filter everything but numbers

			$detail = $this->db->select('*')->from('users')->where('id',$id)->get()->row();
			
			if($detail){

					//$data['id'] = $detail->id;
					$update = array(
						'status' => '0',
					);
					
					if($this->Users->update_user($update, $id)){
						
						$data['success'] = true;
						$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> User has been reactivated!</div>';
					}else{
						$data['success'] = false;
						$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Method error</div>';
					}

			}else {
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> No such user!</div>';
			}
			echo json_encode($data);
		}
			
		
		/**
		* Function to
		* reactivate user
		* display
		*/	
		public function activate_user(){
			
			//escaping the post values
			$uid = html_escape($this->input->post('userID'));
			$id = preg_replace('#[^0-9]#i', '', $uid); // filter everything but numbers

			$detail = $this->db->select('*')->from('temp_users')->where('id',$id)->get()->row();
			
			if($detail){

					$temp_user_id = $detail->id;
					
					$activate = array(
						'first_name' => $detail->first_name,
						'last_name' => $detail->last_name,
						'email_address' => $detail->email_address,
						'telephone' => $detail->telephone,
						'password' => $detail->password,						
						'date_created' => $detail->date_created,
					);
					
					if($this->db->insert('users', $activate)){
						
						$this->db->where('id', $temp_user_id);
						$this->db->delete('temp_users');
						
						//SET DEFAULT ALERT SETTING TO ON
						$alert_data = array(
							'status' => '1',
							'email' => strtolower($detail->email_address),
							'last_updated' => '0000-00-00 00:00:00',
						);
						
						//INSERT IN DB
						$this->Email_alerts->insert_alert($alert_data);
						
						$data['success'] = true;
						$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> User has been activated!</div>';
					}else{
						$data['success'] = false;
						$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Can\'t activate user. DB Error!</div>';
					}

			}else {
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> No such user!</div>';
			}
			echo json_encode($data);
		}

										
		
		/***
		* Function to handle reviews
		*
		***/		
		public function reviews(){
			
			if(!$this->session->userdata('admin_logged_in')){
								
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//redirect('admin/login/','refresh');
				
			}else{			

				
					$username = $this->session->userdata('admin_username');
				
					$data['user_array'] = $this->Admin->get_user($username);
					
					$fullname = '';
					if($data['user_array']){
						foreach($data['user_array'] as $user){
							$fullname = $user->admin_name;
						}
					}
				
					$data['fullname'] = $fullname;
					
					$data['unread_contact_us'] = $this->Contact_us->count_unread_messages();
					
					$messages_unread = $this->Messages->count_unread_messages($username);
					if($messages_unread == '' || $messages_unread == null){
						$data['messages_unread'] = 0;
					}else{
						$data['messages_unread'] = $messages_unread;
					}
					
					$data['header_messages_array'] = $this->Messages->get_header_messages($username);
					
					$enquiries_unread = $this->Sale_enquiries->count_unread_enquiries();
					if($enquiries_unread == '' || $enquiries_unread == null){
						$data['enquiries_unread'] = 0;
					}else{
						$data['enquiries_unread'] = $enquiries_unread;
					}
				
					$data['count_reviews'] = $this->Reviews->count_all();
						
					//assign page title name
					$data['pageTitle'] = 'Seller Reviews';
								
					//assign page title name
					$data['pageID'] = 'reviews';
										
					//load header and page title
					$this->load->view('admin_pages/header', $data);
							
					//load main body
					$this->load->view('admin_pages/reviews_page', $data);	
					
					//load footer
					$this->load->view('admin_pages/footer');
			}
		}

	
		
		/***
		* FUNCTION TO HANDLE REVIEWS AJAX
		* DATATABLES
		***/
		public function review_datatable()
		{
			$list = $this->Reviews->get_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $review) {
				$no++;
				$row = array();
				
				$row[] = '<div class="checkbox checkbox-primary pull-left"><input type="checkbox" name="cb[]" class="cb" onclick="enableButton(this)" value="'.$review->id.'"><label for="cb"></label></div><div class="" style="margin-left:30%; margin-right:30%;">'.ucwords($review->reviewer_name).'</div>';
				
				//GENERATE STAR RATING
				$rating = $this->misc_lib->generateRatingStar($review->rating);
				
				$row[] = ' <span class="star-rating">'.$rating.'</span>';
				
				//GET SELLERS DETAILS
				$user_array = $this->Users->get_user($review->seller_email);
				$fullname = '';
				$user_id = '';
				$profile_pic = '';
				$thumbnail = '';
				$user_avatar = '';
				if($user_array){
					foreach($user_array as $user){
						$user_id = $user->id;
						$fullname = $user->first_name .' '.$user->last_name;
						$user_avatar = $user->avatar;
					}
				}
				
				$filename = FCPATH.'uploads/users/'.$user_id.'/'.$user_avatar;
			
				if($user_avatar == '' || $user_avatar == null || !file_exists($filename)){
					$profile_pic = '<img src="'.base_url().'assets/images/icons/avatar.jpg" class="img-circle profile_img" alt="Profile Image"/>';
					
					$thumbnail = '<img src="'.base_url().'assets/images/icons/avatar.jpg" alt="Profile Image" />';
											
				}else{
					$profile_pic = '<img src="'.base_url().'uploads/users/'.$user_id.'/'.$user_avatar.'" class="img-circle profile_img" alt="Profile Image"/>';
					
					$thumbnail = '<img src="'.base_url().'uploads/users/'.$user_id.'/'.$user_avatar.'" alt="Profile Image" />';
											
				}
				$row[] = $profile_pic .'<div class="text-center">'.$fullname.'</div>';
				
				$location = '<p>'.$review->ip_address.'</p>';
				$location .= $review->ip_details;
				
				$row[] = $location;
				$row[] = date("F j, Y, g:i a", strtotime($review->review_date));
				
				$url = 'admin/review_details';
				
				//$row[] = $make->title;
				$row[] = '<a data-toggle="modal" data-target="#viewModal" href="!#" class="btn btn-primary btn-xs" onclick="viewReview('.$review->id.',\''.$url.'\')" id="'.$review->id.'" title="Click to View"><i class="fa fa-search"></i> View</a>';
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Reviews->count_all(),
				"recordsFiltered" => $this->Reviews->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}
			
	
		/**
		* FUNCTION TO HANDLE
		* REVIEW VIEW
		* DISPLAY
		*/	
		public function review_details(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$type_id = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $type_id); // filter everything but numbers
			
			$detail = $this->db->select('*')->from('reviews')->where('id',$id)->get()->row();
			
			if($detail){
					
					$data['id'] = $detail->id;
					
					$data['headerTitle'] = 'Review by '.ucwords($detail->reviewer_name);			
					$data['reviewer_name'] = ucwords($detail->reviewer_name);
					$data['reviewer_email'] = strtolower($detail->reviewer_email);
					$data['comment'] = $detail->comment;
					
					//GET SELLERS DETAILS
					$user_array = $this->Users->get_user($review->seller_email);
					$fullname = '';
					$user_id = '';
					$profile_pic = '';
					$thumbnail = '';
					$user_avatar = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->first_name .' '.$user->last_name;
							$user_avatar = $user->avatar;
							$user_id = $user->id;
						}
					}
					
					$filename = FCPATH.'uploads/users/'.$user_id.'/'.$user_avatar;
				
					if($user_avatar == '' || $user_avatar == null || !file_exists($filename)){
						$profile_pic = '<img src="'.base_url().'assets/images/icons/avatar.jpg" class="img-circle profile_img" alt="Profile Image" />';
						
						$thumbnail = '<img src="'.base_url().'assets/images/icons/avatar.jpg" alt="Profile Image" />';
												
					}else{
						$profile_pic = '<img src="'.base_url().'uploads/users/'.$user_id.'/'.$user_avatar.'" class="img-circle profile_img" alt="Profile Image" />';
						
						$thumbnail = '<img src="'.base_url().'uploads/users/'.$user_id.'/'.$user_avatar.'" alt="Profile Image" />';
												
					}
					//$data['seller'] = $profile_pic .'<div class="text-center">'.$fullname.'</div>';
					$data['seller'] = ucwords($fullname);
					
					$rating_box = $this->misc_lib->generateRatingStar($detail->rating);
					
					$data['rating_box'] = ' <span class="star-rating">'.$rating_box.'</span>';
					
					$location = '<p>'.$detail->ip_address.'</p>';
					$location .= $detail->ip_details;
					
					$data['location'] = $location;
					$data['review_date'] = date("F j, Y, g:i a", strtotime($detail->review_date));
					
					$data['model'] = 'reviews';
					$data['success'] = true;

			}else {
				$data['success'] = false;
			}
			echo json_encode($data);
		}					
	
		
		/***
		* Function to handle vehicles
		*
		***/		
		public function vehicles(){
			
			if(!$this->session->userdata('admin_logged_in')){
								
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//redirect('admin/login/','refresh');
				
			}else{			

					$username = $this->session->userdata('admin_username');
				
					$data['user_array'] = $this->Admin->get_user($username);
					
					$fullname = '';
					if($data['user_array']){
						foreach($data['user_array'] as $user){
							$fullname = $user->admin_name;
						}
					}
				
					$data['fullname'] = $fullname;
					
					$data['unread_contact_us'] = $this->Contact_us->count_unread_messages();
					
					$messages_unread = $this->Messages->count_unread_messages($username);
					if($messages_unread == '' || $messages_unread == null){
						$data['messages_unread'] = 0;
					}else{
						$data['messages_unread'] = $messages_unread;
					}
					
					$data['header_messages_array'] = $this->Messages->get_header_messages($username);
					
					$enquiries_unread = $this->Sale_enquiries->count_unread_enquiries();
					if($enquiries_unread == '' || $enquiries_unread == null){
						$data['enquiries_unread'] = 0;
					}else{
						$data['enquiries_unread'] = $enquiries_unread;
					}
				
					//SELECT VEHICLE TYPE DROPDOWN
					$vehicle_type = '<div class="form-group">';
					$vehicle_type .= '<select name="vehicle_type" id="vehicleType" class="form-control select2">';
					
					$vehicle_type .= '<option value="" selected="selected">Select</option>';
							
					$this->db->from('vehicle_types');
					$this->db->order_by('id');
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							$vehicle_type .= '<option value="'.$row['name'].'" >'.$row['name'].'</option>';
						}
					}
					
					$vehicle_type .= '</select>';
					$vehicle_type .= '</div>';	
					$data['vehicle_type'] = $vehicle_type;
					//*********END SELECT VEHICLE TYPE DROPDOWN**********//
					
					
					
					//*********SELECT VEHICLE MAKE DROPDOWN**********//
					//$vehicle_make = '<div class="form-group">';
					//$vehicle_make .= '<select name="vehicle_make" id="vehicleMake" class="form-control select2">';
					
					$vehicle_make = '<option value="" selected="selected">Select Make</option>';
							
					$this->db->from('vehicle_makes');
					$this->db->order_by('id');
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							$vehicle_make .= '<option value="'.$row['title'].'" >'.$row['title'].'</option>';
						}
					}
					
					//$vehicle_make .= '</select>';
					//$vehicle_make .= '</div>';	
					$data['vehicle_make'] = $vehicle_make;
					//*********END SELECT VEHICLE MAKE DROPDOWN**********//
					
					
					//*********SELECT VEHICLE MODEL DROPDOWN**********//
					//$vehicle_model = '<div class="form-group">';
					//$vehicle_model .= '<select name="vehicle_model" id="vehicle_model" class="form-control">';
					
					$vehicle_model = '<option value="" selected="selected">Select Model</option>';
							
					$this->db->from('vehicle_models');
					$this->db->order_by('id');
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							$vehicle_model .= '<option value="'.$row['title'].'" >'.$row['title'].'</option>';
						}
					}
					
					//$vehicle_model .= '</select>';
					//$vehicle_model .= '</div>';	
					$data['vehicle_model'] = $vehicle_model;
					//*********END SELECT VEHICLE MODEL DROPDOWN**********//
					
					
					
					//count and display the number of Vehicles
					$count = $this->Vehicles->count_all();
						
					if($count == '' || $count == null){
						$count = 0;
					}
					$data['vehicle_count'] = $count;
					
					//assign page title name
					$data['pageTitle'] = 'Vehicles';
								
					//assign page title name
					$data['pageID'] = 'vehicles';
										
					//load header and page title
					$this->load->view('admin_pages/header', $data);
							
					//load main body
					$this->load->view('admin_pages/vehicles_page', $data);	
					
					//load footer
					$this->load->view('admin_pages/footer');
					
			}
				
		}

	
		
		/***
		* Function to handle vehicles ajax
		* Datatables
		***/
		public function vehicles_datatable()
		{
			$list = $this->Vehicles->get_datatables();
			$data = array();
			$no = $_POST['start'];
			$last_login  = '';
			foreach ($list as $vehicle) {
				$no++;
				$row = array();
				
				$thumbnail = '';
				$filename = FCPATH.'uploads/vehicles/'.$vehicle->id.'/'.$vehicle->vehicle_image;

				$url = 'admin/vehicle_details';
				
				if($vehicle->vehicle_image == '' || $vehicle->vehicle_image == null || !file_exists($filename)){
					
					$result = $this->db->select('*, MIN(id) as min_id', false)->from('vehicle_images')->where('vehicle_id', $vehicle->id)->get()->row();
				
					if(!empty($result)){
						
						$thumbnail = '<img src="'.base_url().'uploads/vehicles/'.$result->vehicle_id.'/'.$result->image_name.'" class="img-responsive img-rounded" width="80" height="80" />';
						
					}else{
						$thumbnail = '<img src="'.base_url().'assets/images/img/no-default-thumbnail.png" class="img-responsive img-rounded" width="80" height="80" />';
					}
					
				}
				else{
					$thumbnail = '<img src="'.base_url().'uploads/vehicles/'.$vehicle->id.'/'.$vehicle->vehicle_image.'" class="img-responsive img-rounded" width="80" height="80" />';
				}	
				
				
				$row[] = '<div class="checkbox checkbox-primary pull-left" style="margin:5% auto;"><input type="checkbox" name="cb[]" class="cb" onclick="enableButton(this)" value="'.$vehicle->id.'"><label for="cb"></label></div><div class="" style="margin-left:35%; margin-right:35%;">'.$thumbnail.'</div>';
				
				$row[] = '<a href="!#" data-toggle="modal" data-target="#viewModal" class="link" onclick="viewVehicle('.$vehicle->id.',\''.$url.'\');" id="'.$vehicle->id.'" title="View '.$vehicle->vehicle_make .' '.$vehicle->vehicle_model.'">'.$vehicle->vehicle_make .' '.$vehicle->vehicle_model.'</a>';
				
				$row[] = $vehicle->vehicle_type;
				
				$row[] = $vehicle->vehicle_make;
				$row[] = $vehicle->vehicle_model;
				$row[] = $vehicle->year_of_manufacture;
				
				$last_updated = $vehicle->last_updated;
				if($last_updated == '0000-00-00 00:00:00' || $last_updated == ''){
					$last_updated = 'Never'; 
				}else{
					$last_updated = date("F j, Y, g:i a", strtotime($last_updated )); 
				}
				
				$row[] = $last_updated;
				
				//prepare buttons
				$row[] = '<a data-toggle="modal" data-target="#addVehicleModal" class="btn btn-primary btn-xs" onclick="editVehicle('.$vehicle->id.',\''.$url.'\')"  title="Click to Edit "><i class="fa fa-edit"></i> Edit</a>
				<a data-toggle="modal" data-target="#addImagesModal" class="btn btn-info btn-xs" title="Add / Remove Images" onclick="editVehicleImages('.$vehicle->id.',\''.$url.'\')"><i class="fa fa-upload"></i> Add / Remove Images</a>';
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Vehicles->count_all(),
				"recordsFiltered" => $this->Vehicles->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
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
						
						//$result = $this->db->select_min('id')->from('vehicle_images')->where('vehicle_id', $detail->id)->get()->row();
						
						$result = $this->db->select('*, MIN(id) as min_id', false)->from('vehicle_images')->where('vehicle_id', $detail->id)->get()->row();
					
						if(!empty($result)){
							
							//MAIN IMAGE
							$image = '<a id="single_image" href="'.base_url().'uploads/vehicles/'.$detail->id.'/'.$detail->vehicle_image.'" title=" View '.$detail->vehicle_make.' '.$detail->vehicle_model.'"><div class="wrapper"><img alt="" src="'.base_url().'uploads/vehicles/'.$detail->id.'/'.$result->image_name.'" class="img-responsive main-img" id="main-img" width="" height=""/><div class="img-icon"><i class="fa fa-search-plus fa-lg" aria-hidden="true"></i></div></div></a>';
							
							//THUMBNAIL
							$thumbnail = '<img src="'.base_url().'uploads/vehicles/'.$detail->id.'/'.$result->image_name.'" class="" />';
							
						}else{
							//MAIN IMAGE
							$image = '<a id="single_image" href="'.base_url().'uploads/vehicles/'.$detail->id.'/'.$detail->vehicle_image.'" title=" View '.$detail->vehicle_make.' '.$detail->vehicle_model.'"><div class="wrapper"><img alt="" src="'.base_url().'assets/images/img/no-default-thumbnail.png" class="img-responsive main-img" id="main-img" width="" height=""/><div class="img-icon"><i class="fa fa-search-plus fa-lg" aria-hidden="true"></i></div></div></a>';
							
							$thumbnail = '<img src="'.base_url().'assets/images/img/no-default-thumbnail.png" />';
						}
						
					}
					else{
						//MAIN IMAGE
						$image = '<a id="single_image" href="'.base_url().'uploads/vehicles/'.$detail->id.'/'.$detail->vehicle_image.'" title=" View '.$detail->vehicle_make.' '.$detail->vehicle_model.'"><div class="wrapper"><img alt="" src="'.base_url().'uploads/vehicles/'.$detail->id.'/'.$detail->vehicle_image.'" class="img-responsive main-img" id="main-img" width="" height=""/><div class="img-icon"><i class="fa fa-search-plus fa-lg" aria-hidden="true"></i></div></div></a>';
						
						//THUMBNAIL
						$thumbnail = '<img src="'.base_url().'uploads/vehicles/'.$detail->id.'/'.$detail->vehicle_image.'" class="" />';
						
					}	
				
						
					$data['image'] = $image;
					
					$data['thumbnail'] = $thumbnail;
					
					/*$result = $this->db->select_min('id')->from('vehicle_images')->where('vehicle_id', $detail->id)->get()->row();
					$image_name = '';
					if(!empty($result)){
						
						$image_name = $result->image_name;
						
						$data['image'] = '<a title="Click to View"><img alt="" src="'.base_url().'uploads/vehicles/'.$detail->id.'/'.$image_name.'" class="img-responsive main-img" id="main-img" width="" height=""/></a>';
					
						$data['mini_thumbnail'] = '<img src="'.base_url().'uploads/projects/'.$detail->id.'/'.$image_name.'" class="img-responsive img-thumbnail" />';
						
					}else{
						$data['image'] = '<a title="Click to View"><img alt="" src="'.base_url().'assets/images/img/no-default-thumbnail.png" class="img-responsive main-img" id="main-img" width="" height=""/></a>';
					
						$data['mini_thumbnail'] = '<img src="'.base_url().'assets/images/img/no-default-thumbnail.png" class="img-responsive img-thumbnail" />';
					}
					*/
					//get main image
					$main_img = $detail->vehicle_image;
					
					
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
							
							$image_group .= '<img src="'.base_url().'uploads/vehicles/'.$detail->id.'/'.$image->image_name.'" id="'.$image->image_name.'" class="img-responsive" />';
							//image path
							$path = 'uploads/vehicles/'.$detail->id.'/'.$image->image_name;
							$url = 'admin/delete_vehicle_images';
							$imageurl = 'admin/make_image_main';
							
							if($main_img == $image->image_name){
								
								$image_group .= '<span class="text-primary"><i class="fa fa-picture-o"></i> <strong>Main</strong></span>';
								
								$image_group .= '<span class="pull-right"><a href="#" class="remove_image" onclick="deleteVehicleImage(this,'.$detail->id.','.$image->id.',\''.$path.'\',\''.$url.'\')"><span aria-hidden="true"><i class="fa fa-trash-o"></i> Remove</span></a></span>';
								
							}else{
								$image_group .= '<a href="#" class="remove_image" onclick="deleteVehicleImage(this,'.$detail->id.','.$image->id.',\''.$path.'\',\''.$url.'\')"><span aria-hidden="true"><i class="fa fa-trash-o"></i> Remove</span></a>';
								
								$image_group .= '<span class="pull-right"><a href="#" class="main_image" onclick="mainVehicleImage(this,'.$detail->id.',\''.$image->image_name.'\',\''.$imageurl.'\')"><span aria-hidden="true"><i class="fa fa-picture-o"></i> Make Main</span></a></span>';
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
					
					$background_image = base_url().'assets/images/backgrounds/'.strtolower($detail->vehicle_colour).'.png?'.time();
					$data['colour'] = '<div class="colours-box" title="'.ucwords($detail->vehicle_colour).'" id="'.strtolower($detail->vehicle_colour).'" data-toggle="tooltip" data-placement="top" style="background-color:'.strtolower($detail->vehicle_colour).'; background-image: url('.$background_image.'); background-position: center; background-repeat:no-repeat; background-size:cover;"></div>';
					
					//$data['vehicle_price'] = $detail->vehicle_price;
					$vehicle_price = '$'.number_format($detail->vehicle_price, 0); 	
					
					if($detail->discount < 1){
						$data['discount'] = '';
					}else{
						$data['discount'] = $detail->discount .'%';
					}
					
					$price_after_discount = '';
					if($detail->price_after_discount < 1){
						$price_after_discount = '';
						$data['vehicle_price'] = '$'.number_format($detail->vehicle_price, 0);
						$data['price_after_discount'] = '';
					}else{
						$price_after_discount = '$'.number_format($detail->price_after_discount, 0);
						$vehicle_price = '$'.number_format($detail->price_after_discount, 0).' <span class="small"><strike>$'.number_format($detail->vehicle_price, 0).'</strike></span>';
						$data['vehicle_price'] = '$'.number_format($detail->price_after_discount, 0);
						$data['old_price'] = '<strike>$'.number_format($detail->vehicle_price, 0).'</strike>';
					}
						
					//$data['vehicle_price'] = '$'.number_format($detail->vehicle_price, 0);
					//$data['vehicle_price'] = $vehicle_price;
					
					$data['price_after_discount'] = $price_after_discount;
					$data['price'] = $detail->vehicle_price;
					
					
					/* CALCULATE INT AND DECIMAL
					$price_int = $detail->vehicle_price > 0 ? floor($detail->vehicle_price) : ceil($detail->vehicle_price);
					$data['price_int'] = $price_int;
					$data['price_decimal'] = abs($detail->vehicle_price - $price_int);
					*/
					
					$data['vehicle_location_city'] = $detail->vehicle_location_city;
					$data['vehicle_location_country'] = $detail->vehicle_location_country;
					$data['vehicle_description'] = $detail->vehicle_description;
					
					$sale_status = $detail->sale_status;
					if($sale_status == '0'){
						$sale_status = 'Available';
					}else{
						$sale_status = 'Sold';
					}
					$data['saleStatus'] = $sale_status;
					$data['sale_status'] = $detail->sale_status;
					
					$data['trader_email'] = $detail->trader_email;
					
					$users_array = $this->Users->get_user($detail->trader_email);
					$fullname = '';
					if($users_array){
						foreach($users_array as $user){
							$fullname = $user->first_name.' '.$user->last_name;
						}
					}
					$data['trader'] = $fullname.' ('.$detail->trader_email.')';
					
					$data['last_updated'] = date("F j, Y, g:i a", strtotime($detail->last_updated));
					$data['date_added'] = date("F j, Y", strtotime($detail->date_added));
					
										

					//SELECT VEHICLE TYPE DROPDOWN
					//$vehicle_type = '<div class="form-group">';
					//$vehicle_type .= '<select name="vehicle_type" id="vehicle_type" class="form-control">';
					
					$vehicle_type = '<option value="">Select Type</option>';
							
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
					
					$vehicle_make = '<option value="">Select Make</option>';
							
					$this->db->from('vehicle_makes');
					$this->db->order_by('id');
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							$default2 = (strtolower($row['title']) == strtolower($detail->vehicle_make))?'selected':'';
							$vehicle_make .= '<option value="'.$row['id'].'" '.$default2.'>'.$row['title'].'</option>';
						}
					}
					
					//$vehicle_make .= '</select>';
					//$vehicle_make .= '</div>';	
					$data['vehicle_make_options'] = $vehicle_make;
					//*********END SELECT VEHICLE MAKE DROPDOWN**********//
					
					$make_array = $this->Vehicle_makes->get_make_by_title($detail->vehicle_make);
					$made_id = '';
					if($make_array){
						foreach($make_array as $m){
							$made_id = $m->id;
						}
					}
					
					//*********SELECT VEHICLE MODEL DROPDOWN**********//
					//$vehicle_model = '<div class="form-group">';
					//$vehicle_model .= '<select name="vehicle_model" id="vehicle_model" class="form-control select2">';
					
					$vehicle_model = '<option value="">Select Model</option>';
							
					$this->db->from('vehicle_models');
					if($made_id != ''){
						$this->db->where('make_id', $made_id);
					}
					
					$this->db->order_by('id');
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							$default3 = (strtolower($row['title']) == strtolower($detail->vehicle_model))?'selected':'';
							$vehicle_model .= '<option value="'.$row['title'].'" '.$default3.'>'.$row['title'].'</option>';
						}
					}
					
					//$vehicle_model .= '</select>';
					//$vehicle_model .= '</div>';	
					$data['vehicle_model_options'] = $vehicle_model;
					//*********END SELECT VEHICLE MODEL DROPDOWN**********//
					

					//SELECT YEAR DROPDOWN
					//$year_of_manufacture = '<div class="form-group">';
					//$year_of_manufacture .= '<select name="year_of_manufacture" id="year_of_manufacture" class="form-control">';
					
					$year_of_manufacture = '<option value="">Select Year</option>';
					for($i=date("Y")-50; $i<=date("Y"); $i++) {
						$sel = ($i == $detail->year_of_manufacture) ? 'selected' : '';
						$year_of_manufacture .= "<option value=".$i." ".$sel.">".$i."</option>";  
					}		
					
					//$year_of_manufacture .= '</select>';
					//$year_of_manufacture .= '</div>';	
					$data['year_of_manufacture_options'] = $year_of_manufacture;
					//*********END SELECT YEAR DROPDOWN**********//
										

					//SELECT COLOUR DROPDOWN
					//$colours = '<div class="form-group">';
					//$colours .= '<select name="vehicle_colour" id="vehicle_colour" class="form-control">';
					
					$colours = '<option value="" >Select Colour</option>';
							
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
					
					$countries = '<option value="" >Select Country</option>';
							
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
					
					$sale_status = '<option value="" >Sale Status</option>';
							
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
					
					$users = '<option value="" >Select Trader</option>';
							
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
					$data['user_options'] = $users;
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
			$this->form_validation->set_rules('vehicle_type','Type','required|trim|xss_clean');
			$this->form_validation->set_rules('vehicle_make','Make','required|trim|xss_clean');
			$this->form_validation->set_rules('vehicle_model','Model','required|trim|xss_clean|callback_unique_vehicle');
			$this->form_validation->set_rules('year_of_manufacture','Year of Manufacture','required|trim|xss_clean');
			$this->form_validation->set_rules('vehicle_odometer','Odometer','trim|xss_clean');
			$this->form_validation->set_rules('vehicle_lot_number','Lot Number','trim|xss_clean');
			$this->form_validation->set_rules('vehicle_vin','Vin','trim|xss_clean');
			
			$this->form_validation->set_rules('vehicle_colour','Colour','required|trim|xss_clean');
			$this->form_validation->set_rules('vehicle_price','Price','required|trim|xss_clean');
			$this->form_validation->set_rules('vehicle_location_city','Location City','required|trim|xss_clean');
			$this->form_validation->set_rules('vehicle_location_country','Location Country','required|trim|xss_clean');
			$this->form_validation->set_rules('vehicle_description','Description','required|trim|xss_clean');
			$this->form_validation->set_rules('sale_status','Sale Status','required|trim|xss_clean');
			$this->form_validation->set_rules('trader_email','Email','required|trim|xss_clean|valid_email');
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
				
				$make_array = $this->Vehicle_makes->get_make_by_id($this->input->post('vehicle_make'));
				
				$vehicle_make = '';
				if($make_array){
					foreach($make_array as $make){
						$vehicle_make = $make->title;
					}
				}
				
				$add = array(
					
					'vehicle_type' => $this->input->post('vehicle_type'),
					'vehicle_make' => ucwords($vehicle_make),
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
					
				if($insert_id){
							
					if(!empty($_FILES['vehicle_image']['name'])){
						
						$file_clean = $this->Files->file_xss_clean($_FILES['vehicle_image']);
						
						$is_image = $this->Files->file_is_image($_FILES['vehicle_image']);
							
						if($file_clean && $is_image){
							
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
							//$ext = $this->Files->getFileExtension($file);
							$ext = pathinfo($file, PATHINFO_EXTENSION);
							//$config['file_name'] = $insert_id.'.jpg';
							$config['file_name'] = $insert_id.'.'.$ext;
									
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
						
					}	
				
					
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update activities table
					$description = 'added <i>'.ucwords($vehicle_make.' '.$this->input->post('vehicle_model')).'</i> vehicle';
				
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
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> '.ucwords($vehicle_make.' '.$this->input->post('vehicle_model')).' has been added!</div>';

													
				}else{
					$data['success'] = false;
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Vehicle not added!</div>';
					
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
			
			if (!$this->Vehicles->unique_vehicle($where))
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
			$colour = $this->input->post('vehicle_colour');
			if ($colour == '' || $colour == '0'){
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
				//$ext = $this->Files->getFileExtension($file);
				$ext = pathinfo($file, PATHINFO_EXTENSION);
							
				//$config['file_name'] = $vehicle_id.'.jpg';
				$config['file_name'] = $vehicle_id.'.'.$ext;
				
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
			$this->form_validation->set_rules('trader_email','Email','required|trim|xss_clean|valid_email|callback_trader_check');
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
						$new_vehicle_image = $vehicle->vehicle_image;
					}
				}
				
				
				
				$make_array = $this->Vehicle_makes->get_make_by_id($this->input->post('vehicle_make'));
				
				$vehicle_make = '';
				if($make_array){
					foreach($make_array as $make){
						$vehicle_make = $make->title;
					}
				}
				
				
				$update = array(
					'vehicle_image' => $new_vehicle_image,
					'vehicle_type' => $this->input->post('vehicle_type'),
					'vehicle_make' => ucwords($vehicle_make),
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
					
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update activities table
					$description = 'updated <i>'.ucwords($vehicle_make.' '.$this->input->post('vehicle_model')).'</i> vehicle';
				
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
			
			if($this->input->post('vehicle_id') != '' && $this->input->post('vehicle_id') != null){
				
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
						
						
						$username = $this->session->userdata('admin_username');
						$user_array = $this->Admin->get_user($username);
						
						$fullname = '';
						if($user_array){
							foreach($user_array as $user){
								$fullname = $user->admin_name;
							}
						}
						
						
						//update activities table
						$description = 'added vehicle images';
					
						$activity = array(			
							'name' => $fullname,
							'username' => $username,
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
					
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update activities table
					$description = 'deleted a vehicle image';
				
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
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
					
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
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

								
		
		/***
		* Function to handle vehicle makes
		*
		***/		
		public function vehicle_makes(){
			
			if(!$this->session->userdata('admin_logged_in')){
								
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//redirect('admin/login/','refresh');
				
			}else{			

				
					$username = $this->session->userdata('admin_username');
				
					$data['user_array'] = $this->Admin->get_user($username);
					
					$fullname = '';
					if($data['user_array']){
						foreach($data['user_array'] as $user){
							$fullname = $user->admin_name;
						}
					}
				
					$data['fullname'] = $fullname;
					
					$data['unread_contact_us'] = $this->Contact_us->count_unread_messages();
					
					$messages_unread = $this->Messages->count_unread_messages($username);
					if($messages_unread == '' || $messages_unread == null){
						$data['messages_unread'] = 0;
					}else{
						$data['messages_unread'] = $messages_unread;
					}
					
					$data['header_messages_array'] = $this->Messages->get_header_messages($username);
					
					$enquiries_unread = $this->Sale_enquiries->count_unread_enquiries();
					if($enquiries_unread == '' || $enquiries_unread == null){
						$data['enquiries_unread'] = 0;
					}else{
						$data['enquiries_unread'] = $enquiries_unread;
					}
				
					$data['count_vehicle_makes'] = $this->Vehicle_makes->count_all();
						
					//assign page title name
					$data['pageTitle'] = 'Vehicle Makes';
								
					//assign page title name
					$data['pageID'] = 'vehicle_makes';
										
					//load header and page title
					$this->load->view('admin_pages/header', $data);
							
					//load main body
					$this->load->view('admin_pages/vehicle_makes_page', $data);	
					
					//load footer
					$this->load->view('admin_pages/footer');
			}
		}

	
		
		/***
		* Function to handle Vehicle makes ajax
		* datatables
		***/
		public function vehicle_make_datatable()
		{
			$list = $this->Vehicle_makes->get_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $make) {
				$no++;
				$row = array();
				
				$row[] = '<div class="checkbox checkbox-primary pull-left"><input type="checkbox" name="cb[]" class="cb" onclick="enableButton(this)" value="'.$make->id.'"><label for="cb"></label></div><div class="" style="margin-left:30%; margin-right:30%;">'.$make->title.'</div>';

				//$row[] = '<h4><a data-toggle="modal" data-target="#editVehicleMakeModal"  class="link" onclick="editVehicleMake('.$make->id.')" id="'.$make->id.'" title="Click to Edit">'.$make->title.'</a></h4>';
				
				$row[] = $make->code;
				
				$url = 'admin/vehicle_make_details';
				
				//$row[] = $make->title;
				$row[] = '<a data-toggle="modal" data-target="#editModal" href="!#" class="btn btn-primary btn-xs" onclick="editVehicleMake('.$make->id.',\''.$url.'\')" id="'.$make->id.'" title="Click to Edit"><i class="fa fa-edit"></i> Edit</a>';
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Vehicle_makes->count_all(),
				"recordsFiltered" => $this->Vehicle_makes->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}
			
	
		/**
		* Function to handle
		* Vehicle make view and edit
		* display
		*/	
		public function vehicle_make_details(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$type_id = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $type_id); // filter everything but numbers
			
			$detail = $this->db->select('*')->from('vehicle_makes')->where('id',$id)->get()->row();
			
			if($detail){
					
					$data['id'] = $detail->id;
					
					$data['headerTitle'] = ucwords($detail->code.' - '.$detail->title);			
					$data['code'] = $detail->code;
					$data['title'] = $detail->title;
					
					$data['model'] = 'vehicle_makes';
					$data['success'] = true;

			}else {
				$data['success'] = false;
			}
			echo json_encode($data);
		}					
	
		
		/**
		* Function to validate add vehicle make
		*
		*/			
		public function add_vehicle_make(){

			$this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
				
			$this->form_validation->set_rules('code','Code','required|trim|xss_clean|is_unique[vehicle_makes.code]');
			$this->form_validation->set_rules('title','Title','required|trim|xss_clean|is_unique[vehicle_makes.title]');
							
			$this->form_validation->set_message('required', '%s cannot be blank!');
			$this->form_validation->set_message('is_unique', 'This %s already exists!');
			
			if($this->form_validation->run()){
							
				$add = array(
					'code' => strtoupper($this->input->post('code')),
					'title' => ucwords($this->input->post('title')),
				);

				$insert_id = $this->Vehicle_makes->insert_vehicle_make($add);
							
				if($insert_id){
					
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update activities table
					$description = 'added a new vehicle make (<i>'.$this->input->post('title').'</i>)';
				
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Vehicle',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
					
					$data['success'] = true;
							
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> A new vehicle make (<i>'.$this->input->post('title').'</i>) has been added!</div>';
							
				}else{
					
					$data['success'] = false;
							
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> The new vehicle make (<i>'.$this->input->post('title').'</i>) has not been added!</div>';
							
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
		* Function to validate update vehicle make
		* form
		*/			
		public function update_vehicle_make(){
			
			$this->load->library('form_validation');
				
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
			$this->form_validation->set_rules('code','Code','required|trim|xss_clean');
			$this->form_validation->set_rules('title','Title','required|trim|xss_clean');
			
			if ($this->form_validation->run()){
				
				//escaping the post values
				$type_id = html_escape($this->input->post('type_id'));
				$id = preg_replace('#[^0-9]#i', '', $type_id); // filter everything but numbers
				
				$code = strtoupper($this->input->post('code'));
				$title = ucwords($this->input->post('title'));
				
				//check if name already exists
				if($this->Vehicle_makes->unique_make($code,$title)){
								
					$update = array(
						'code' => $code,
						'title' => $title,
					);

						
					if ($this->Vehicle_makes->update_vehicle_make($update, $id)){	
						
						$username = $this->session->userdata('admin_username');
						$user_array = $this->Admin->get_user($username);
						
						$fullname = '';
						if($user_array){
							foreach($user_array as $user){
								$fullname = $user->admin_name;
							}
						}
						//update activities table
						$description = 'updated vehicle make';
					
						$activity = array(			
							'name' => $fullname,
							'username' => $username,
							'description' => $description,
							'keyword' => 'Vehicle',
							'activity_time' => date('Y-m-d H:i:s'),
						);
							
						$this->Site_activities->insert_activity($activity);
						
						$data['success'] = true;
						$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Vehicle make has been updated!</div>';
					}
				}
					
			}else {
				
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
	
		
		
		/***
		* Function to handle vehicle models
		*
		***/		
		public function vehicle_models(){
			
			if(!$this->session->userdata('admin_logged_in')){
								
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//redirect('admin/login/','refresh');
				
			}else{			

				
					$username = $this->session->userdata('admin_username');
				
					$data['user_array'] = $this->Admin->get_user($username);
					
					$fullname = '';
					if($data['user_array']){
						foreach($data['user_array'] as $user){
							$fullname = $user->admin_name;
						}
					}
				
					$data['fullname'] = $fullname;
					
					$data['unread_contact_us'] = $this->Contact_us->count_unread_messages();
					
					$messages_unread = $this->Messages->count_unread_messages($username);
					if($messages_unread == '' || $messages_unread == null){
						$data['messages_unread'] = 0;
					}else{
						$data['messages_unread'] = $messages_unread;
					}
					
					$data['header_messages_array'] = $this->Messages->get_header_messages($username);
					
					$enquiries_unread = $this->Sale_enquiries->count_unread_enquiries();
					if($enquiries_unread == '' || $enquiries_unread == null){
						$data['enquiries_unread'] = 0;
					}else{
						$data['enquiries_unread'] = $enquiries_unread;
					}
				
					$data['count_vehicle_models'] = $this->Vehicle_models->count_all();
					
					//SELECT MAKE DROPDOWN
					//$select_make = '<div class="form-group">';
					//$select_make .= '<select name="make_id" id="make_id" class="form-control">';
					
					$select_make = '<option value="0" >Select Make</option>';
							
					$this->db->from('vehicle_makes');
					$this->db->order_by('id');
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							
							$select_make .= '<option value="'.$row['id'].'" >'.ucwords($row['title']).' ('.$row['id'].')</option>';
						}
					}
					
					//$select_make .= '</select>';
					//$select_make .= '</div>';	
					$data['select_make'] = $select_make;
					//*********END SELECT COUNTRY DROPDOWN**********//
						
					//assign page title name
					$data['pageTitle'] = 'Vehicle Models';
								
					//assign page title name
					$data['pageID'] = 'vehicle_models';
										
					//load header and page title
					$this->load->view('admin_pages/header', $data);
							
					//load main body
					$this->load->view('admin_pages/vehicle_models_page', $data);	
					
					//load footer
					$this->load->view('admin_pages/footer');
			}
		}

	
		
		/***
		* Function to handle Vehicle models ajax
		* datatables
		***/
		public function vehicle_model_datatable()
		{
			$list = $this->Vehicle_models->get_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $model) {
				$no++;
				$row = array();
				
				$make_name = '';
				$make_array = $this->Vehicle_makes->get_make_by_id($model->make_id);
				if($make_array){
					foreach($make_array as $make){
						$make_name = $make->title;
					}
				}
				$row[] = '<div class="checkbox checkbox-primary pull-left"><input type="checkbox" name="cb[]" class="cb" onclick="enableButton(this)" value="'.$model->id.'"><label for="cb"></label></div><div class="" style="margin-left:30%; margin-right:30%;"><strong>'.$make_name.'</strong> ('.$model->make_id.')</div>';
				
				//$row[] = '<div class="checkbox checkbox-primary"><input type="checkbox" name="cb[]" class="cb" onclick="enableButton(this)" value="'.$model->id.'"></div>';
				
				//$row[] = '<h4><a data-toggle="modal" data-target="#editVehicleModelModal" href="!#" class="link" onclick="editVehicleModel('.$model->id.')" id="'.$model->id.'" title="Click to Edit"><strong>'.$make_name .'</strong> ('.$model->make_id.')</a></h4>';
				
				//$row[] = '<strong>'.$make_name .'</strong> ('.$model->make_id.')';
				
				$row[] = $model->code;
				$row[] = $model->title;
				//$row[] = 'ok';
				
				$url = 'admin/vehicle_model_details';
				
				$row[] = '<a data-toggle="modal" data-target="#editModal"  class="btn btn-primary btn-xs" onclick="editVehicleModel('.$model->id.',\''.$url.'\')" id="'.$model->id.'" title="Click to Edit"><i class="fa fa-edit"></i> Edit</a>';
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Vehicle_models->count_all(),
				"recordsFiltered" => $this->Vehicle_models->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}
			
	
		/**
		* Function to handle
		* Vehicle model view and edit
		* display
		*/	
		public function vehicle_model_details(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$type_id = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $type_id); // filter everything but numbers
			
			$detail = $this->db->select('*')->from('vehicle_models')->where('id',$id)->get()->row();
			
			if($detail){
					
					$data['id'] = $detail->id;
					
					$make_name = '';
					$make_array = $this->Vehicle_makes->get_make_by_id($detail->make_id);
					if($make_array){
						foreach($make_array as $make){
							$make_name = $make->title;
						}
					}
					
					$data['headerTitle'] = ucwords($make_name.' - '.$detail->code);
					
					$data['make_id'] = $detail->make_id;
					$data['make_name'] = $make_name;
					$data['code'] = $detail->code;
					$data['title'] = $detail->title;
					
						
					//SELECT MAKE DROPDOWN
					//$select_make = '<div class="form-group">';
					//$select_make .= '<select name="make_id" id="make_id" class="form-control">';
					
					$select_make = '<option value="0" >Select Make</option>';
							
					$this->db->from('vehicle_makes');
					$this->db->order_by('id');
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							$default = (strtolower($row['id']) == strtolower($detail->make_id))?'selected':'';
							$select_make .= '<option value="'.$row['id'].'" '.$default.'>'.ucwords($row['title']).' ('.$row['id'].')</option>';
						}
					}
					
					//$select_make .= '</select>';
					//$select_make .= '</div>';	
					$data['select_make'] = $select_make;
					//*********END SELECT COUNTRY DROPDOWN**********//
						
					
					$data['model'] = 'vehicle_models';
					$data['success'] = true;

			}else {
				$data['success'] = false;
			}
			echo json_encode($data);
		}					
	
		
		/**
		* Function to validate add vehicle model
		*
		*/			
		public function add_vehicle_model(){

			$this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
			$this->form_validation->set_rules('make_id','Make ID','required|trim|xss_clean');			
			$this->form_validation->set_rules('code','Code','required|trim|xss_clean|is_unique[vehicle_models.code]');
			$this->form_validation->set_rules('title','Title','required|trim|xss_clean|is_unique[vehicle_models.title]');
							
			$this->form_validation->set_message('required', '%s cannot be blank!');
			$this->form_validation->set_message('is_unique', 'This %s already exists!');
			
			if($this->form_validation->run()){
							
				$add = array(
					'make_id' => $this->input->post('make_id'),
					'code' => strtoupper($this->input->post('code')),
					'title' => ucwords($this->input->post('title')),
				);

				$insert_id = $this->Vehicle_models->insert_vehicle_model($add);
							
				if($insert_id){
					
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update activities table
					$description = 'added a new vehicle model (<i>'.$this->input->post('code').'</i>)';
				
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Vehicle',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
					
					$data['success'] = true;
							
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> A new vehicle model (<i>'.$this->input->post('code').'</i>) has been added!</div>';
							
				}else{
					
					$data['success'] = false;
							
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> The new vehicle model (<i>'.$this->input->post('code').'</i>) has not been added!</div>';
							
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
		* Function to validate update vehicle model
		* form
		*/			
		public function update_vehicle_model(){
			
			$this->load->library('form_validation');
				
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
			$this->form_validation->set_rules('model_id','Model ID','required|trim|xss_clean|numeric');
			$this->form_validation->set_rules('code','Code','required|trim|xss_clean');
			$this->form_validation->set_rules('title','Title','required|trim|xss_clean');
			
			if ($this->form_validation->run()){
				
				//escaping the post model_id values
				$model_id = html_escape($this->input->post('model_id'));
				$id = preg_replace('#[^0-9]#i', '', $model_id); // filter everything but numbers
				
				$make_id = $this->input->post('make_id');
				$code = strtoupper($this->input->post('code'));
				$title = ucwords($this->input->post('title'));
				
				//check if name already exists
				if($this->Vehicle_models->unique_model($make_id,$code,$title)){
								
					$update = array(
						'make_id' => $make_id,
						'code' => $code,
						'title' => $title,
					);

						
					if ($this->Vehicle_models->update_vehicle_model($update, $id)){	
						
						$username = $this->session->userdata('admin_username');
						$user_array = $this->Admin->get_user($username);
						
						$fullname = '';
						if($user_array){
							foreach($user_array as $user){
								$fullname = $user->admin_name;
							}
						}
						//update activities table
						$description = 'updated vehicle model';
					
						$activity = array(			
							'name' => $fullname,
							'username' => $username,
							'description' => $description,
							'keyword' => 'Vehicle',
							'activity_time' => date('Y-m-d H:i:s'),
						);
							
						$this->Site_activities->insert_activity($activity);
						
						$data['success'] = true;
						$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Vehicle model has been updated!</div>';
					}
				}
					
			}else {
				
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
	
								
		
		/***
		* Function to handle vehicle types
		*
		***/		
		public function vehicle_types(){
			
			if(!$this->session->userdata('admin_logged_in')){
								
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//redirect('admin/login/','refresh');
				
			}else{			

					$username = $this->session->userdata('admin_username');
				
					$data['user_array'] = $this->Admin->get_user($username);
					
					$fullname = '';
					if($data['user_array']){
						foreach($data['user_array'] as $user){
							$fullname = $user->admin_name;
						}
					}
				
					$data['fullname'] = $fullname;
					
					$data['unread_contact_us'] = $this->Contact_us->count_unread_messages();
					
					$messages_unread = $this->Messages->count_unread_messages($username);
					if($messages_unread == '' || $messages_unread == null){
						$data['messages_unread'] = 0;
					}else{
						$data['messages_unread'] = $messages_unread;
					}
					
					$data['header_messages_array'] = $this->Messages->get_header_messages($username);
					
					$enquiries_unread = $this->Sale_enquiries->count_unread_enquiries();
					if($enquiries_unread == '' || $enquiries_unread == null){
						$data['enquiries_unread'] = 0;
					}else{
						$data['enquiries_unread'] = $enquiries_unread;
					}
				
					$data['count_vehicle_types'] = $this->Vehicle_types->count_all();
					$data['count_vehicle_models'] = $this->Vehicle_models->count_all();
					
					$data['count_vehicle_makes'] = $this->Vehicle_makes->count_all();
						
					//assign page title name
					$data['pageTitle'] = 'Vehicle Types';
								
					//assign page title name
					$data['pageID'] = 'vehicle_types';
										
					//load header and page title
					$this->load->view('admin_pages/header', $data);
							
					//load main body
					$this->load->view('admin_pages/vehicle_types_page', $data);	
					
					//load footer
					$this->load->view('admin_pages/footer');
			}
		}

	
		
		/***
		* Function to handle Vehicle Types ajax
		* datatables
		***/
		public function vehicle_type_datatable()
		{
			$list = $this->Vehicle_types->get_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $type) {
				$no++;
				$row = array();
				
				$row[] = '<div class="checkbox checkbox-primary pull-left"><input type="checkbox" name="cb[]" class="cb" onclick="enableButton(this)" value="'.$type->id.'"><label for="cb"></label></div><div class="" style="margin-left:30%; margin-right:30%;"><strong>'.$type->name.'</strong> </div>';
				
				//$row[] = '<div class="checkbox checkbox-primary"><input type="checkbox" name="cb[]" class="cb" onclick="enableButton(this)" value="'.$type->id.'"></div>';

				//$row[] = $type->name;
				
				//$row[] = $type->name;
				
				$url = 'admin/vehicle_type_details';
				
				$row[] = '<a data-toggle="modal" data-target="#editModal"  class="btn btn-primary btn-xs" onclick="editVehicleType('.$type->id.',\''.$url.'\')" id="'.$type->id.'" title="Click to Edit"><i class="fa fa-edit"></i> Edit</a>';
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Vehicle_types->count_all(),
				"recordsFiltered" => $this->Vehicle_types->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}
			
	
		/**
		* Function to handle
		* Vehicle Type view and edit
		* display
		*/	
		public function vehicle_type_details(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$type_id = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $type_id); // filter everything but numbers
			
			$detail = $this->db->select('*')->from('vehicle_types')->where('id',$id)->get()->row();
			
			if($detail){
					
					$data['id'] = $detail->id;
					
					$data['headerTitle'] = ucwords($detail->name);			

					$data['name'] = $detail->name;
					
					$data['model'] = 'vehicle_types';
					$data['success'] = true;

			}else {
				$data['success'] = false;
			}
			echo json_encode($data);
		}					
	
		
		/**
		* Function to validate add vehicle type
		*
		*/			
		public function add_vehicle_type(){

			$this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
				
			$this->form_validation->set_rules('name','Name','required|trim|xss_clean|is_unique[vehicle_types.name]');
							
			$this->form_validation->set_message('required', '%s cannot be blank!');
			$this->form_validation->set_message('is_unique', 'This vehicle type already exists!');
			
			if($this->form_validation->run()){
							
				$add = array(
					'name' => ucwords($this->input->post('name')),
				);

				$insert_id = $this->Vehicle_types->insert_vehicle_type($add);
							
				if($insert_id){
					
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update activities table
					$description = 'added a new vehicle type (<i>'.$this->input->post('name').'</i>)';
				
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Vehicle',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
					
					$data['success'] = true;
							
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> A new vehicle type (<i>'.$this->input->post('name').'</i>) has been added!</div>';
							
				}else{
					
					$data['success'] = false;
							
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> The new vehicle type (<i>'.$this->input->post('name').'</i>) has not been added!</div>';
							
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
		* Function to validate update vehicle type
		* form
		*/			
		public function update_vehicle_type(){
			
			$this->load->library('form_validation');
				
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			$this->form_validation->set_rules('name','Name','required|trim|xss_clean');
			
			if ($this->form_validation->run()){
				
				//escaping the post values
				$type_id = html_escape($this->input->post('type_id'));
				$id = preg_replace('#[^0-9]#i', '', $type_id); // filter everything but numbers
				
				//check if name already exists
				if($this->Vehicle_types->unique_name($this->input->post('name'))){
								
					$update = array(
						'name' => ucwords($this->input->post('name')),
					);

						
					if ($this->Vehicle_types->update_vehicle_type($update, $id)){	
						
						$username = $this->session->userdata('admin_username');
						$user_array = $this->Admin->get_user($username);
						
						$fullname = '';
						if($user_array){
							foreach($user_array as $user){
								$fullname = $user->admin_name;
							}
						}
						//update activities table
						$description = 'updated vehicle type';
					
						$activity = array(			
							'name' => $fullname,
							'username' => $username,
							'description' => $description,
							'keyword' => 'Vehicle',
							'activity_time' => date('Y-m-d H:i:s'),
						);
							
						$this->Site_activities->insert_activity($activity);
						
						$data['success'] = true;
						$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Vehicle type has been updated!</div>';
					}
				}
					
			}else {
				
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
	
			

		
		/***
		* Function to handle orders
		*
		***/		
		public function orders(){
			
			if(!$this->session->userdata('admin_logged_in')){
								
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//redirect('admin/login/','refresh');
				
			}else{			

				$username = $this->session->userdata('admin_username');
				
				$data['user_array'] = $this->Admin->get_user($username);
					
				$fullname = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
						$fullname = $user->admin_name;
					}
				}
				
				$data['fullname'] = $fullname;
					
				$data['unread_contact_us'] = $this->Contact_us->count_unread_messages();
					
				$messages_unread = $this->Messages->count_unread_messages($username);
				if($messages_unread == '' || $messages_unread == null){
					$data['messages_unread'] = 0;
				}else{
					$data['messages_unread'] = $messages_unread;
				}
					
				$data['header_messages_array'] = $this->Messages->get_header_messages($username);
				
				$enquiries_unread = $this->Sale_enquiries->count_unread_enquiries();
				if($enquiries_unread == '' || $enquiries_unread == null){
					$data['enquiries_unread'] = 0;
				}else{
					$data['enquiries_unread'] = $enquiries_unread;
				}
				
				//generate a random 8 digit string of numbers
				//ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789
				$reference = substr(str_shuffle("0123456789"), 0, 8);
					
				//ensure the username is unique
				while(!$this->Orders->is_unique_reference($reference)){
					$reference = substr(str_shuffle("0123456789"), 0, 8);
				}
				
				$data['reference'] = $reference;
				
				//assign page title name
				$data['pageTitle'] = 'Orders';
								
				//assign page title name
				$data['pageID'] = 'orders';
										
				//load header and page title
				$this->load->view('admin_pages/header', $data);
							
				//load main body
				$this->load->view('admin_pages/orders_page', $data);	
					
				//load footer
				$this->load->view('admin_pages/footer');
					
			}
				
		}
		
	
		
		/***
		* Function to handle orders ajax
		* Datatable
		***/
		public function orders_datatable()
		{
			
			$list = $this->Orders->get_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $order) {
				$no++;
				$row = array();
				
				//$row[] = '<input type="checkbox" name="cb[]" id="cb" onclick="enableButton(this)" value="'.$order->id.'">';
				
				$url = 'admin/order_details';
				
				$row[] = '<div class="checkbox checkbox-primary pull-left"><input type="checkbox" name="cb[]" class="cb" onclick="enableButton(this)" value="'.$order->id.'"><label for="cb"></label></div><div class="" style="margin-left:40%; margin-right:40%;"><a data-toggle="modal" href="#" data-target="#viewOrderModal" class="link" onclick="viewOrder('.$order->id.',\''.$url.'\');" title="View">'.$order->reference.'</a></div>';
				
				$row[] = '$'.number_format($order->total_price, 0);
				$row[] = $order->num_of_items;
				
				$user_array = $this->Users->get_user($order->customer_email);
					
				$fullname = '';
				if($user_array){
					foreach($user_array as $user){
						$fullname = $user->first_name.' '.$user->last_name;
					}
				}
				$row[] = $fullname .' ('.$order->customer_email.')';
				
				//GET PAYMENT STATUS FROM TRANSACTION DB
				$transaction_array = $this->Transactions->get_transaction($order->reference);
				$payment_status = '';
				if($transaction_array){
					foreach($transaction_array as $transaction){
						$payment_status = $transaction->status;
					}
				}
				
				if($payment_status == '1'){
					$payment_status = '<span class="badge bg-green">Paid</span>';
				}else{
					$payment_status = '<span class="badge bg-yellow">Pending</span>';
				}
				$row[] = $payment_status;
				
				//GET SHIPPING STATUS FROM DB
				$shipping_array = $this->Shipping->get_shipping($order->reference);
				$shipping_status = '';
				if($shipping_array){
					foreach($shipping_array as $shipping){
						$shipping_status = $shipping->status;
					}
				}
				
				if($shipping_status == '1'){
					$shipping_status = '<span class="badge bg-green">Shipped</span>';
				}else{
					$shipping_status = '<span class="badge bg-yellow">Pending</span>';
				}
				$row[] = $shipping_status;
				
				$row[] = date("F j, Y", strtotime($order->order_date));
				
				$row[] = date("F j, Y, g:i a", strtotime($order->last_updated));
				
				$row[] = '<a data-toggle="modal" data-target="#editModal" class="btn btn-info btn-xs" onclick="editOrder('.$order->id.',\''.$url.'\');" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
				
				
				//$row[] = $type->details;
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Orders->count_all(),
				"recordsFiltered" => $this->Orders->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}

	
		/**
		* Function to handle
		* orders view and edit
		* display
		*/	
		public function order_details(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$pid = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
			$detail = $this->db->select('*')->from('orders')->where('id',$id)->get()->row();
			
			if($detail){
				
					$data['id'] = $detail->id;
					
					$data['last_updated'] = date("F j, Y, g:i a", strtotime($detail->last_updated));
					
					$data['order_date'] = date("F j, Y", strtotime($detail->order_date));
					$numOfItems = '';
					if($detail->num_of_items == 1){
						$numOfItems = $detail->num_of_items.' item';
					}else{
						$numOfItems = $detail->num_of_items.' items';
					}
					
					$data['headerTitle'] = 'Order: '.$detail->reference.' <span class="badge bg-green" >'.$numOfItems.'</span>';	
					
					$data['orderDate'] = '<i class="fa fa-calendar-o" aria-hidden="true"></i> '.date("F j, Y", strtotime($detail->order_date));
					$data['reference'] = $detail->reference;
					$data['order_description'] = $detail->order_description;
					$data['total_price'] = number_format($detail->total_price, 2);
					$data['totalPrice'] = $detail->total_price;
					//$data['tax'] = $detail->tax;
					//$data['shipping_n_handling_fee'] = $detail->shipping_n_handling_fee;
					//$data['payment_gross'] = $detail->payment_gross;
					$data['num_of_items'] = $detail->num_of_items;
					$data['customer_email'] = $detail->customer_email;
					
					$user_array = $this->Users->get_user($detail->customer_email);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->first_name.' '.$user->last_name;
						}
					}
					$data['customer'] = $fullname .' ('.$detail->customer_email.')';
					
					//SELECT CUSTOMER DROPDOWN
					
					$customer_options = '<option value="" >Select User</option>';
							
					$this->db->from('users');
					$this->db->order_by('id');
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							//AUTO SELECT DEFAULT
							$d = (strtolower($row['email_address']) == strtolower($detail->customer_email))?'selected':'';
							$customer_options .= '<option value="'.$row['email_address'].'" '.$d.'>'.ucwords($row['first_name'].' '.$row['last_name']).' ('.$row['email_address'].')</option>';
						}
					}
					
					$data['customer_options'] = $customer_options;
					//*********END SELECT DESTINATION COUNTRY DROPDOWN**********//
					
				
					//GET PAYMENT STATUS FROM TRANSACTION DB
					$transaction_array = $this->Transactions->get_transaction($detail->reference);
					$payment_status = '';
					$edit_payment_status = '';
					$order_amount = '';
					$shipping_and_handling_costs = '';
					$total_amount = '';
					$transaction_id = '';
					
					if($transaction_array){
						foreach($transaction_array as $transaction){
							$transaction_id = $transaction->id;
							$payment_status = $transaction->status;
							$edit_payment_status = $transaction->status;
							$order_amount = $transaction->order_amount;
							$shipping_and_handling_costs = $transaction->shipping_and_handling_costs;
							$total_amount = $transaction->total_amount;
						}
					}
					
					if($payment_status == '1'){
						$payment_status = '<span class="badge bg-green">Paid</span>';
					}else{
						$payment_status = '<span class="badge bg-yellow">Pending</span>';
					}
					$data['payment_status'] = $payment_status;
					$data['edit_payment_status'] = $edit_payment_status;
					
					$data['transaction_id'] = $transaction_id;
					
					//SELECT PAYMENT STATUS DROPDOWN
					$payment_status_options = '<option value="" >Select Payment Status</option>';
							
					for($i=0; $i<=1; $i++){
						//AUTO SELECT DEFAULT
						$sel = ($i == $edit_payment_status) ? 'selected' : '';
						
						//READABLE DISPLAY
						$string = ($i == '0') ? 'Pending' : 'Paid';
						
						$payment_status_options .= '<option value="'.$i.'" '.$sel.'>'.$string.'</option>';
					}
					$data['payment_status_options'] = $payment_status_options;
					//*********END SELECT PAYMENT STATUS DROPDOWN**********//
					
					//GET PAYMENT STATUS FROM TRANSACTION DB
					$payment_array = $this->Payments->get_payment($detail->reference);
					$payment_method = '';
					$payment_id = '';
					if($payment_array){
						foreach($payment_array as $payment){
							$payment_method = $payment->payment_method;
							$payment_id = $payment->id;
						}
					}
					
					$data['payment_id'] = $payment_id;
					
					//VIEW
					$data['view_payment_method'] = 'Payment Method: '.$payment_method;
					
					//SELECT PAYMENT METHOD DROPDOWN
					$payment_method_options = '<option value="" >Select Payment Method</option>';
							
					$this->db->from('payment_methods');
					$this->db->order_by('id');
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							
							//AUTO SELECT DEFAULT
							$default = (strtolower($row['method_name']) == strtolower($payment_method))?'selected':'';
							
							$payment_method_options .= '<option value="'.$row['method_name'].'" '.$default.'>'.$row['method_name'].'</option>';
						}
					}
					$data['payment_method_options'] = $payment_method_options;
					//*********END SELECT PAYMENT METHOD DROPDOWN**********//
					
					
					$data['order_amount'] = $order_amount;
					$data['shipping_and_handling_costs'] = $shipping_and_handling_costs;
					$data['total_amount'] = $total_amount;
					
					//GET SHIPPING STATUS FROM DB
					$shipping_array = $this->Shipping->get_shipping($detail->reference);
					$shipping_status = '';
					$edit_shipping_status = '';
					$shipping_id = '';
					$method = '';
					$shipping_fee = '';
					$tax = '';
					$origin_city = '';
					$origin_country = '';
					$destination_city = '';
					$destination_country = '';
					$customer_contact_phone = '';
					$estimated_delivery_date = '';
					
					
					if($shipping_array){
						foreach($shipping_array as $shipping){
							$shipping_id = $shipping->id;
							$shipping_status = $shipping->status;
							$edit_shipping_status = $shipping->status;
							$method = $shipping->shipping_method;
							$shipping_fee = $shipping->shipping_fee;
							$tax = $shipping->tax;
							$origin_city = $shipping->origin_city;
							$origin_country = $shipping->origin_country;
							$destination_city = $shipping->destination_city;
							$destination_country = $shipping->destination_country;
							$customer_contact_phone = $shipping->customer_contact_phone;
							$estimated_delivery_date = $shipping->estimated_delivery_date;
						}
					}
					
					if($shipping_status == '1'){
						$shipping_status = '<span class="badge bg-green">Shipped</span>';
						
					}else{
						$shipping_status = '<span class="badge bg-yellow">Pending</span>';
						
					}
					
					$view_delivery_date = '';
					$edit_delivery_date = '';
					if($estimated_delivery_date == '0000-00-00 00:00:00'){
						$view_delivery_date = 'Not Set';
						$edit_delivery_date = '';
						
					}else{
						$view_delivery_date = date("F j, Y g:i A", strtotime($estimated_delivery_date));
						$edit_delivery_date = date("Y-m-d g:i A", strtotime($estimated_delivery_date));
					}
					
					$data['delivery_date'] = $view_delivery_date;
					$data['edit_delivery_date'] = $edit_delivery_date;
					
					$data['edit_shipping_status'] = $edit_shipping_status;
					$data['shipping_status'] = $shipping_status;
					$data['shipping_fee'] = $shipping_fee;
					$data['tax'] = $tax;
					$data['shipping_id'] = $shipping_id; 
						
					//SELECT SHIPPING METHODS DROPDOWN
					//$shipping_methods = '<div class="form-group">';
					//$shipping_methods .= '<select name="shipping_method" id="shipping_method" class="form-control">';
						
					$shipping_methods = '<option value="" >Select Shipping Method</option>';
								
					$this->db->from('shipping_methods');
					$this->db->order_by('id');
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							
							$d = (strtolower($row['shipping_company']) == strtolower($method))?'selected':'';
					
							$shipping_methods .= '<option value="'.ucwords($row['id']).'" '.$d.'>'.ucwords($row['shipping_company']).'</option>';
						}
					}
						
					//$shipping_methods .= '</select>';
					//$shipping_methods .= '</div>';	
					$data['shipping_method_options'] = $shipping_methods;
					//*********END SELECT SHIPPING METHODS DROPDOWN**********//
					
					
					$data['origin_city'] = $origin_city;
					$data['origin_country'] = $origin_country;
						
					//SELECT ORIGIN COUNTRY DROPDOWN
					
					$origin_country_options = '<option value="" >Select Origin Country</option>';
							
					$this->db->from('countries');
					$this->db->order_by('id');
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							//AUTO SELECT DEFAULT
							$d = (strtolower($row['name']) == strtolower($origin_country))?'selected':'';
							$origin_country_options .= '<option value="'.$row['name'].'" '.$d.'>'.ucwords($row['name']).'</option>';
						}
					}
					
					$data['origin_country_options'] = $origin_country_options;
					//*********END SELECT DESTINATION COUNTRY DROPDOWN**********//
					
					$data['destination_city'] = $destination_city;
					$data['destination_country'] = $destination_country;
						
					//SELECT DESTINATION COUNTRY DROPDOWN
					
					$destination_country_options = '<option value="" >Select Destination Country</option>';
							
					$this->db->from('countries');
					$this->db->order_by('id');
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							//AUTO SELECT DEFAULT
							$d = (strtolower($row['name']) == strtolower($destination_country))?'selected':'';
							$destination_country_options .= '<option value="'.$row['name'].'" '.$d.'>'.ucwords($row['name']).'</option>';
						}
					}
					
					$data['destination_country_options'] = $destination_country_options;
					//*********END SELECT DESTINATION COUNTRY DROPDOWN**********//
					
					
					$data['customer_contact_phone'] = $customer_contact_phone;
					
					//SELECT SHIPPING STATUS DROPDOWN
					$shipping_status_options = '<option value="" >Select Shipping Status</option>';
							
					for($i=0; $i<=1; $i++){
						//AUTO SELECT DEFAULT
						$sel = ($i == $edit_shipping_status) ? 'selected' : '';
						
						//READABLE DISPLAY
						$status_string = ($i == '0') ? 'Pending' : 'Shipped';
						
						$shipping_status_options .= '<option value="'.$i.'" '.$sel.'>'.$status_string.'</option>';
					}
					$data['shipping_status_options'] = $shipping_status_options;
					//*********END SELECT SHIPPING STATUS DROPDOWN**********//
					
					$data['model'] = 'orders';
					$data['success'] = true;

			}else {
				$data['success'] = false;
			}
			echo json_encode($data);
		}					
	
	
				
		/**
		* Function to validate add shipping
		*
		*/			
		public function add_order(){

			$this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
			$this->form_validation->set_rules('reference','Reference','required|trim|xss_clean|callback_unique_order');
			$this->form_validation->set_rules('order_description','Order Description','required|trim|xss_clean');
			$this->form_validation->set_rules('total_price','Total Price','required|trim|xss_clean');
			$this->form_validation->set_rules('num_of_items','Number Of Items','required|trim|xss_clean');
			$this->form_validation->set_rules('customer_email','Customer Email','required|trim|xss_clean|valid_email');
			$this->form_validation->set_rules('shipping_method','Shipping Method','required|trim|xss_clean');
			$this->form_validation->set_rules('shipping_fee','Shipping Fee','required|trim|xss_clean');
			$this->form_validation->set_rules('tax','Tax','required|trim|xss_clean');
			$this->form_validation->set_rules('origin_city','Origin City','required|trim|xss_clean');
			$this->form_validation->set_rules('origin_country','Origin Country','required|trim|xss_clean');
			$this->form_validation->set_rules('destination_city','Destination City','required|trim|xss_clean');
			$this->form_validation->set_rules('destination_country','Destination Country','required|trim|xss_clean');
			$this->form_validation->set_rules('customer_contact_phone','Customer Contact Phone','required|trim|xss_clean');
			$this->form_validation->set_rules('shipping_status','Shipping Status','required|trim|xss_clean');
			$this->form_validation->set_rules('estimated_delivery_date','Estimated Delivery Date','required|trim|xss_clean');
			$this->form_validation->set_rules('payment_status','Payment Status','required|trim|xss_clean');
			$this->form_validation->set_rules('payment_method','Payment Method','trim|xss_clean');
			
						
			$this->form_validation->set_message('required', '%s cannot be blank!');
			
			
			if($this->form_validation->run()){
				
				//COMMON VARIABLES
				$ref = $this->input->post('reference');
				$email = $this->input->post('customer_email');
				
				//CONVERT DATE FORMAT
				$estimated_delivery_date = '';
				$delivery_date = $this->input->post('estimated_delivery_date');
				if($delivery_date != ''){
					// to disregard that PM escape it in the format
					
					$estimated_delivery_date = date("Y-m-d H:i:s",strtotime($delivery_date));
				}
				
				
				//GET CURRENT DATE FOR ALL ENTRIES
				$order_date = date('Y-m-d H:i:s');
				
				////ARRAY OF ORDER DATA
				$order_data = array(
					'reference' => $ref,
					'order_description' => $this->input->post('order_description'),
					'total_price' => $this->input->post('total_price'),
					'num_of_items' => $this->input->post('num_of_items'),
					'customer_email' => $email,
					'order_date' => date('Y-m-d H:i:s'),
				);

				//INSERT NEW ORDER
				if($this->Orders->insert_order($order_data)){
					
					//GET STRING NAME FOR METHOD
					$shipping_method_id = $this->input->post('shipping_method');
					
					$shipping_method_detail = $this->db->select('*')->from('shipping_methods')->where('id',$shipping_method_id)->get()->row();
					
					$shipping_company = '';
					if($shipping_method_detail){
						foreach($shipping_method_detail as $method){
							$shipping_company = $method->shipping_company;
						}
					}
					
					//ARRAY OF SHIPPING DATA
					$shipping_data = array(
						'order_reference' => $ref,
						'shipping_fee' => $this->input->post('shipping_fee'),
						'tax' => $this->input->post('tax'),
						'shipping_method' => $shipping_company,
						'origin_city' => $this->input->post('origin_city'),
						'origin_country' => $this->input->post('origin_country'),
						'destination_city' => $this->input->post('destination_city'),
						'destination_country' => $this->input->post('destination_country'),
						'customer_contact_phone' => $this->input->post('customer_contact_phone'),
						'customer_email' => $email,
						'status' => $this->input->post('shipping_status'),
						'estimated_delivery_date' => $estimated_delivery_date,
						'created' => date('Y-m-d H:i:s'),
					);
					
					//INSERT DATA INTO SHIPPING
					if($this->Shipping->insert_shipping($shipping_data)){
						
						//CREATE STATUS DETAILS
						$status_description = 'Shipping label created.';
						$location = $this->input->post('origin_city').', '.$this->input->post('origin_country');
						
						
						//CREATE FIRST SHIPPING LABEL
						//STORE IN DB
						$status_data = array(
							'order_reference' => $ref,
							'status_description' => $status_description,
							'location' => $location,
							'customer_email' => $email,
							'status_date' => date('Y-m-d H:i:s'),
						);
						//INSERT SHIPPING STATUS
						$this->Shipping_status->insert_shipping_status($status_data);
						
					}
					
					//CALCULATE TRANSACTION COSTS
					$order_amt = $this->input->post('total_price');
					$shipping_fee = $this->input->post('shipping_fee');
					$tax = $this->input->post('tax');
					
					$shipping_and_handling_costs = $shipping_fee + $tax;
					$total_amt = $order_amt + $shipping_fee + $tax;
					
					//GET TRANSACTION DATA
					$transaction_data = array(
						'order_reference' => $ref,
						'order_amount' => $order_amt,
						'shipping_and_handling_costs' => $shipping_and_handling_costs,
						'total_amount' => $total_amt,
						'email' => $email,
						'status' => $this->input->post('payment_status'),
						'created' => date('Y-m-d H:i:s'),
					);
					
					//STORE IN DB
					$this->Transactions->insert_transaction($transaction_data);
					
					$payment_status = $this->input->post('payment_status');
					
					//IF PAYMENT STATUS IS PAID, THEN STORE PAYMENT DATA
					if($payment_status == '1'){
						
						//GET PAYMENT DATA
						$payment = array(
							'reference' => $ref,
							'total_amount' => $total_amt,
							'payment_method' => $this->input->post('payment_method'),
							'customer_email' => $email,
							'payment_date' => date('Y-m-d H:i:s'),
						);
						
						//STORE IN DB
						$this->Payments->insert_payment($payment);
						
					}
					
					/**********SEND AN EMAIL NOTIFICATION TO THE USER**************/
					
					//GET CLIENTS DETAILS FROM DB
					$client_array = $this->Users->get_user($email);
					$name = '';
					if($client_array){
						foreach($client_array as $client){
							$name = $client->first_name.' '.$client->last_name;
						}
					}
					
					//GET ADMINS DETAILS
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					
					$message_subject = 'New Order ('.$ref.')';
					$message_details = 'Your new order has been placed.';
					
					//MESSAGE NOTIFICATION
					//DATA ARRAY
					$message_data = array(
						'sender_name' => $fullname,
						'sender_email' => $username,
						'receiver_name' => $name,
						'receiver_email' => $email,
						'message_subject' => $message_subject,
						'message_details' => $message_details,
						'attachment' => '0',
						'opened' => '0',
						'recipient_archive' => '0',
						'recipient_delete' => '0',
						'sender_archive' => '0',
						'sender_delete' => '0',
						'replied' => '0',
						'date_sent' => date('Y-m-d H:i:s'),
					);
					
					
					//SEND MESSAGE ON SYSTEM
					if($this->Messages->send_new_message($message_data)){
						
						//RECIEVERS FIRST AND LAST NAME
						$to_name = $name;
						
						//RECIEVERS EMAIL
						$to_email = $email;
						
						//EMAIL SUBJECT
						$subject = $message_subject;
						
						//COMPOSE EMAIL MESSAGE
						$message = "<h3><u>New Order (".$ref.")</u></h3>";
						
						$order_link = base_url('account/orders');
						
						$message .= '<p>New order placed. <a title="Orders" href="'.base_url('account/orders').'" class="link">View, manage and track your orders here</a></p>';
						
						$this->Messages->send_email_alert($to_email, $subject, $to_name, $message);
					
					}
					
					/**********END EMAIL NOTIFICATION**************/
					
					//INSERT INTO SITE ACTIVITIES TABLE
					$description = 'added a new order';
				
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Orders',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
					
					$data['success'] = true;
							
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> A new order has been added!</div>';
							
				}else{
							
					//$this->session->set_flashdata('added', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> The new order has not been added!</div>');
								
					$data['success'] = false;
							
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> The new order has not been added!</div>';
							
				}				
			}
			else {
						
				$data['success'] = false;
				$data['notif'] = '<div class="text-center" role="alert">'.validation_errors().'</div>';
				//$data['errors'] = $this->form_validation->error_array();
				//$this->addhand();	
			}

			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);			
		}



		/**
		* Function to ensure order data  
		* is unique
		*/			
		public function unique_order(){
			
			$where = array(
				'reference' => $this->input->post('reference'),
				'order_description' => $this->input->post('order_description'),
				'total_price' => $this->input->post('total_price'),
				'num_of_items' => $this->input->post('num_of_items'),
				'customer_email' => $this->input->post('customer_email'),
			);
			
			if (!$this->Orders->is_unique($where))
			{
				$this->form_validation->set_message('unique_order', 'You already have this order on record!');
				return FALSE;
			}
			else
			{
				return TRUE;
			}
		}	
		
			
		/**
		* Function to validate update order
		* form
		*/			
		public function update_order(){
			
			$this->load->library('form_validation');
				
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
			$this->form_validation->set_rules('reference','Reference','required|trim|xss_clean');
			$this->form_validation->set_rules('order_description','Order Description','required|trim|xss_clean');
			$this->form_validation->set_rules('total_price','Total Price','required|trim|xss_clean');
			$this->form_validation->set_rules('num_of_items','Number Of Items','required|trim|xss_clean');
			$this->form_validation->set_rules('customer_email','Customer Email','required|trim|xss_clean|valid_email');
			$this->form_validation->set_rules('shipping_method','Shipping Method','required|trim|xss_clean');
			$this->form_validation->set_rules('shipping_fee','Shipping Fee','required|trim|xss_clean');
			$this->form_validation->set_rules('tax','Tax','required|trim|xss_clean');
			$this->form_validation->set_rules('origin_city','Origin City','required|trim|xss_clean');
			$this->form_validation->set_rules('origin_country','Origin Country','required|trim|xss_clean');
			$this->form_validation->set_rules('destination_city','Destination City','required|trim|xss_clean');
			$this->form_validation->set_rules('destination_country','Destination Country','required|trim|xss_clean');
			$this->form_validation->set_rules('customer_contact_phone','Customer Contact Phone','required|trim|xss_clean');
			$this->form_validation->set_rules('shipping_status','Shipping Status','required|trim|xss_clean');
			$this->form_validation->set_rules('payment_status','Payment Status','required|trim|xss_clean');
			$this->form_validation->set_rules('payment_method','Payment Method','trim|xss_clean');
			$this->form_validation->set_rules('estimated_delivery_date','Estimated Delivery Date','trim|xss_clean');
			
			
			$this->form_validation->set_message('required', '%s cannot be blank!');
			
				
			if ($this->form_validation->run()){
				
				//COMMON VARIABLES
				$ref = $this->input->post('reference');
				$ref = preg_replace('#[^0-9]#i', '', $ref); // filter everything but numbers
				
				$email = $this->input->post('customer_email');
				
				//CONVERT DATE FORMAT
				$estimated_delivery_date = '';
				$delivery_date = $this->input->post('estimated_delivery_date');
				if($delivery_date != ''){
					$estimated_delivery_date = date("Y-m-d H:i:s",strtotime($delivery_date));
				}
					
				//escaping the post values
				$order_id = html_escape($this->input->post('order_id'));
				$id = preg_replace('#[^0-9]#i', '', $order_id); // filter everything but numbers
				
				$shipping_array = $this->Shipping->get_shipping($ref);
				$shipping_id = '';
				if($shipping_array){
					foreach($shipping_array as $shipping){
						$shipping_id = $shipping->id;
					}
				}
				
				//$shipping_id = html_escape($this->input->post('shipping_id'));
				//$shipping_id = preg_replace('#[^0-9]#i', '', $shipping_id); // filter everything but numbers
				

				$transaction_array = $this->Transactions->get_transaction($ref);
				$transaction_id = '';
				if($transaction_array){
					foreach($transaction_array as $transaction){
						$transaction_id = $transaction->id;
							
					}
				}
				
				//$transaction_id = html_escape($this->input->post('transaction_id'));
				//$transaction_id = preg_replace('#[^0-9]#i', '', $transaction_id); // filter everything but numbers
				

				$payment_array = $this->Payments->get_payment($ref);
				$payment_id = '';
					
				if($payment_array){
					foreach($payment_array as $payment){
						$payment_id = $payment->id;
					}
				}

				//$payment_id = html_escape($this->input->post('payment_id'));
				//$payment_id = preg_replace('#[^0-9]#i', '', $payment_id); // filter everything but numbers
				
				
				//GET COMPANY NAME FOR SHIPPING METHOD
				$method_id = $this->input->post('shipping_method');
				$method_id = preg_replace('#[^0-9]#i', '', $method_id); // filter everything but numbers
					
				$method_detail = $this->Shipping_methods->get_shipping_method($method_id);					
				//$shipping_method_detail = $this->db->select('*')->from('shipping_methods')->where('id',$shipping_method_id)->get()->row();
						
				$shipping_company = '';
				if($method_detail){
					foreach($method_detail as $method){
						$shipping_company = $method->shipping_company;
					}
				}
					
				
				//GET CURRENT DATE FOR ALL ENTRIES
				//$order_date = date('Y-m-d H:i:s');
				
				////ARRAY OF ORDER DATA
				$update_data = array(
					'order_description' => $this->input->post('order_description'),
					'total_price' => $this->input->post('total_price'),
					'num_of_items' => $this->input->post('num_of_items'),
					'customer_email' => $email,
					'last_updated' => date('Y-m-d H:i:s'),
					//'order_date' => $order_date,
				);
		
				//UPDATE ORDER
				if ($this->Orders->update_order($update_data, $id)){

					
					//GET SHIPPING ID
					/*$shipping_detail = $this->Shipping->get_shipping($ref);
					
					//$shipping_detail = $this->db->select('*')->from('shipping')->where('order_reference',$ref)->get()->row();
					
					$shipping_id = '';
					if($shipping_detail){
						foreach($shipping_detail as $shipping){
							$shipping_id = $shipping->id;
						}
					}
					*/
					
					//ARRAY OF SHIPPING DATA
					$shipping_data = array(
						'shipping_fee' => $this->input->post('shipping_fee'),
						'tax' => $this->input->post('tax'),
						'shipping_method' => $shipping_company,
						'origin_city' => $this->input->post('origin_city'),
						'origin_country' => $this->input->post('origin_country'),
						'destination_city' => $this->input->post('destination_city'),
						'destination_country' => $this->input->post('destination_country'),
						'customer_contact_phone' => $this->input->post('customer_contact_phone'),
						'customer_email' => $email,
						'status' => $this->input->post('shipping_status'),
						'estimated_delivery_date' => $estimated_delivery_date,
					);
					
					//UPDATE DATA INTO SHIPPING
					if($this->Shipping->update_shipping($shipping_data, $shipping_id)){
						
						//UPDATE STATUS DETAILS
						$location = $this->input->post('origin_city').', '.$this->input->post('origin_country');
						
						//STATUS DATA
						$status_data = array(
							'location' => $location,
							'customer_email' => $email,
						);
						//UPDATE SHIPPING STATUS
						$this->Shipping_status->update_status_by_ref($status_data, $ref);
						
					}
					
					//CALCULATE TRANSACTION COSTS
					$order_amt = $this->input->post('total_price');
					$shipping_fee = $this->input->post('shipping_fee');
					$tax = $this->input->post('tax');
					
					$shipping_and_handling_costs = $shipping_fee + $tax;
					$total_amt = $order_amt + $shipping_fee + $tax;
					
					//GET TRANSACTION ID
					/*$transaction_detail = $this->Transactions->get_transaction($ref);
					
					//$transaction_detail = $this->db->select('*')->from('transactions')->where('order_reference',$ref)->get()->row();
					
					$transaction_id = '';
					if($transaction_detail){
						foreach($transaction_detail as $transaction){
							$transaction_id = $transaction->id;
						}
					}
					*/
					
					//GET TRANSACTION DATA
					$transaction_data = array(
						'order_amount' => $order_amt,
						'shipping_and_handling_costs' => $shipping_and_handling_costs,
						'total_amount' => $total_amt,
						'email' => $email,
						'status' => $this->input->post('payment_status'),
					);
					
					//UPDATE TRANSACTION IN DB
					$this->Transactions->update_transaction($transaction_data, $transaction_id);
					
					
					//IF PAYMENT STATUS IS PAID, THEN STORE PAYMENT DATA
					if($this->input->post('payment_status') == '1'){
						
						//IF REFERENCE DOES NOT EXISTS, THEN DO AN INSERT
						if($this->Payments->unique_payment($ref)){
							
							//GET PAYMENT DATA
							$add_payment = array(
								'reference' => $ref,
								'total_amount' => $total_amt,
								'payment_method' => $this->input->post('payment_method'),
								'customer_email' => $email,
								'payment_date' => date('Y-m-d H:i:s'),
							);
							
							//INSERT IN DB
							$this->Payments->insert_payment($add_payment);
							
						}else{//ELSE DO AN UPDATE
						
							//GET PAYMENT DATA
							$update_payment = array(
								'total_amount' => $total_amt,
								'payment_method' => $this->input->post('payment_method'),
								'customer_email' => $email,
							);
							
							//UPDATE IN DB
							$this->Payments->update_payment($update_payment);
							
						}
						
					}
					
					/**********SEND AN EMAIL NOTIFICATION TO THE USER**************/
					
					//GET CLIENTS DETAILS FROM DB
					$client_array = $this->Users->get_user($email);
					$name = '';
					if($client_array){
						foreach($client_array as $client){
							$name = $client->first_name.' '.$client->last_name;
						}
					}
					
					//GET ADMINS DETAILS
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					
					
					$message_subject = 'Order ('.$ref.')';
					$message_details = 'Your order ('.$ref.') has been updated.';
					
					
					//MESSAGE NOTIFICATION
					//DATA ARRAY
					$message_data = array(
						'sender_name' => $fullname,
						'sender_email' => $username,
						'receiver_name' => $name,
						'receiver_email' => $email,
						'message_subject' => $message_subject,
						'message_details' => $message_details,
						'attachment' => '0',
						'opened' => '0',
						'recipient_archive' => '0',
						'recipient_delete' => '0',
						'sender_archive' => '0',
						'sender_delete' => '0',
						'replied' => '0',
						'date_sent' => date('Y-m-d H:i:s'),
					);
					
					//SEND MESSAGE ON SYSTEM
					if($this->Messages->send_new_message($message_data)){
						
						//CHECK IF ALERT NOTIFICATION IS ON
						if($this->Email_alerts->alert_on($email)){
							
							//RECIEVERS FIRST AND LAST NAME
							$to_name = $name;
							
							//RECIEVERS EMAIL
							$to_email = $email;
							
							//EMAIL SUBJECT
							$subject = $message_subject;
							
							//COMPOSE EMAIL MESSAGE
							$message = "<h3><u>Order (".$ref.")</u></h3>";
							
							$order_link = base_url('account/orders/');
							
							$message .= '<p>Your order ('.$ref.') has been updated. <a title="Orders" href="'.base_url('account/orders').'" class="">View, manage and track your orders here</a></p>';
							
							
							$this->Messages->send_email_alert($to_email, $subject, $to_name, $message);
						}	
						
						
					}
					
					/**********END EMAIL NOTIFICATION**************/
					
					//GET ADMIN INFO FRM DB
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
						
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update page metadata table
					$description = 'updated order';
					
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Orders',
						'activity_time' => date('Y-m-d H:i:s'),
					);
							
					$this->Site_activities->insert_activity($activity);
									
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Order has been updated!</div>';
				}
				
					
			}else {
				
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> There are errors on the form!'.validation_errors().'</div>';
			}
			
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);			
		}			
	
			
			
		
		/***
		* Function to handle shipping
		*
		***/		
		public function shipping(){
			
			if(!$this->session->userdata('admin_logged_in')){
								
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//redirect('admin/login/','refresh');
				
			}else{			

				$username = $this->session->userdata('admin_username');
				
				$data['user_array'] = $this->Admin->get_user($username);
					
				$fullname = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
						$fullname = $user->admin_name;
					}
				}
				
				$data['fullname'] = $fullname;
					
				$data['unread_contact_us'] = $this->Contact_us->count_unread_messages();
					
				$messages_unread = $this->Messages->count_unread_messages($username);
				if($messages_unread == '' || $messages_unread == null){
					$data['messages_unread'] = 0;
				}else{
					$data['messages_unread'] = $messages_unread;
				}
					
				$data['header_messages_array'] = $this->Messages->get_header_messages($username);
				
				
				$enquiries_unread = $this->Sale_enquiries->count_unread_enquiries();
				if($enquiries_unread == '' || $enquiries_unread == null){
					$data['enquiries_unread'] = 0;
				}else{
					$data['enquiries_unread'] = $enquiries_unread;
				}
				
				//*********SELECT ORDER DROPDOWN**********//
				//$existing_orders = '<div class="form-group">';
				//$existing_orders .= '<select name="existing_orders" id="existing_orders" class="form-control">';
					
				$existing_orders = '<option value="0" >Select Existing Order</option>';
							
				$this->db->from('orders');
				$this->db->order_by('id');
				$result = $this->db->get();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row){
							
						$users_array = $this->Users->get_user($row['customer_email']);
						$fullname = '';
						if($users_array){
							foreach($users_array as $user){
								$fullname = $user->first_name.' '.$user->last_name;
							}
						}
						$existing_orders .= '<option value="'.$row['reference'].'-'.$row['customer_email'].'" >'.$row['reference'].' - '.$fullname.' ('.$row['customer_email'].')</option>';
					}
				}
					
				//$existing_orders .= '</select>';
				//$existing_orders .= '</div>';	
				$data['existing_orders'] = $existing_orders;
				//*********END SELECT ORDER DROPDOWN**********//
					
					
				//SELECT SHIPPING METHODS DROPDOWN
				//$shipping_methods = '<div class="form-group">';
				//$shipping_methods .= '<select name="shipping_method" id="shipping_method" class="form-control">';
					
				$shipping_methods = '<option value="" >Select Shipping Method</option>';
							
				$this->db->from('shipping_methods');
				$this->db->order_by('id');
				$result = $this->db->get();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row){
						
						$shipping_methods .= '<option value="'.ucwords($row['id']).'" >'.ucwords($row['shipping_company']).'</option>';
					}
				}
					
				//$shipping_methods .= '</select>';
				//$shipping_methods .= '</div>';	
				$data['shipping_method_options'] = $shipping_methods;
				//*********END SELECT SHIPPING METHODS DROPDOWN**********//
						
				
				//assign page title name
				$data['pageTitle'] = 'Shipping';
								
				//assign page title name
				$data['pageID'] = 'shipping';
										
				//load header and page title
				$this->load->view('admin_pages/header', $data);
							
				//load main body
				$this->load->view('admin_pages/shipping_page', $data);	
					
				//load footer
				$this->load->view('admin_pages/footer');
					
			}
				
		}
		
	
		
		/***
		* Function to handle shipping ajax
		* Datatable
		***/
		public function shipping_datatable()
		{
			
			$list = $this->Shipping->get_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $shipping) {
				$no++;
				$row = array();
				
				$url = 'admin/shipping_details';
				
				$row[] = '<div class="checkbox checkbox-primary pull-left"><input type="checkbox" name="cb[]" class="cb" onclick="enableButton(this)" value="'.$shipping->id.'"><label for="cb"></label></div><div class="" style="margin-left:40%; margin-right:40%;"><a data-toggle="modal" href="#" data-target="#viewShippingModal" class="link" onclick="viewShipping('.$shipping->id.',\''.$url.'\');" title="View">'.$shipping->order_reference.'</a></div>';
				
				//$row[] = $no;
				
				//$row[] = '';
				$row[] = $shipping->shipping_method;
				
				$row[] = '$'.number_format($shipping->shipping_fee, 2);
				
				$row[] = '$'.number_format($shipping->tax, 2);
				
				$status = '';
				if($shipping->status == '0'){
					$status = 'Pending';
				}else{
					$status = 'Shipped';
				}
				$row[] = $status;
					
				$user_array = $this->Users->get_user($shipping->customer_email);
					
				$fullname = '';
				if($user_array){
					foreach($user_array as $user){
						$fullname = $user->first_name.' '.$user->last_name;
					}
				}
				$row[] = $fullname;
				$shipping_date = $shipping->created;
				
				if($shipping_date == '0000-00-00 00:00:00'){
					$shipping_date = 'Not Shipped';
				}else{
					$shipping_date = date('F j, Y', strtotime($shipping_date));
				}
				$row[] = $shipping_date;
				
				$statusURL = 'admin/shipping_status_details';
				
				$row[] = '<a data-toggle="modal" data-target="#viewShippingDetailsModal" class="btn btn-success btn-xs" onclick="viewShippingDetails('.$shipping->order_reference.',\''.$statusURL.'\');" id="'.$shipping->order_reference.'" title="Track Shipping"><i class="fa fa-search" aria-hidden="true"></i> Track Shipping</a><a data-toggle="modal" data-target="#addShippingStatusModal" class="btn btn-default btn-xs" onclick="getShippingStatus('.$shipping->id.',\''.$url.'\');" title="Add Shipping Status"><i class="fa fa-plus" aria-hidden="true"></i> Add Shipping Status</a>';
				
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Shipping->count_all(),
				"recordsFiltered" => $this->Shipping->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}


		
		/**
		* Function to handle
		* shipping view and edit
		* display
		*/	
		public function shipping_details(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$pid = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
			$detail = $this->db->select('*')->from('shipping')->where('id',$id)->get()->row();
			
			if($detail){
				
					
					$data['id'] = $detail->id;
					
					$data['headerTitle'] = 'Shipping - '.$detail->order_reference;			
					$data['reference'] = $detail->order_reference;
					$data['shipping_fee'] = $detail->shipping_fee;
					$data['shippingFee'] = number_format($detail->shipping_fee, 2);
					$data['tax'] = $detail->tax;
					$data['tx'] = number_format($detail->tax, 2);
					$data['shipping_method'] = $detail->shipping_method;
						
					//SELECT SHIPPING METHODS DROPDOWN
					//$shipping_methods = '<div class="form-group">';
					//$shipping_methods .= '<select name="shipping_method" id="shipping_method" class="form-control">';
					
					$shipping_methods = '<option value="" >Select Shipping Method</option>';
							
					$this->db->from('shipping_methods');
					$this->db->order_by('id');
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							$d = (strtolower($row['shipping_company']) == strtolower($detail->shipping_method))?'selected':'';
							$shipping_methods .= '<option value="'.ucwords($row['id']).'" '.$d.'>'.ucwords($row['shipping_company']).'</option>';
						}
					}
					
					//$shipping_methods .= '</select>';
					//$shipping_methods .= '</div>';	
					$data['shipping_method_options'] = $shipping_methods;
					//*********END SELECT SHIPPING METHODS DROPDOWN**********//
					
					$data['origin_city'] = $detail->origin_city;
					$data['origin_country'] = $detail->origin_country;
					$data['location'] = $detail->origin_city.', '.$detail->origin_country;
						
					//SELECT DESTINATION COUNTRY DROPDOWN
					//$origin_country = '<div class="form-group">';
					//$origin_country .= '<select name="origin_country" id="origin_country" class="form-control">';
					
					$origin_country = '<option value="0" >Select Origin Country</option>';
							
					$this->db->from('countries');
					$this->db->order_by('id');
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							$d = (strtolower($row['name']) == strtolower($detail->origin_country))?'selected':'';
							$origin_country .= '<option value="'.$row['name'].'" '.$d.'>'.ucwords($row['name']).'</option>';
						}
					}
					
					//$origin_country .= '</select>';
					//$origin_country .= '</div>';	
					$data['origin_country_options'] = $origin_country;
					//*********END SELECT DESTINATION COUNTRY DROPDOWN**********//
					
					$data['destination_city'] = $detail->destination_city;
					$data['destination_country'] = $detail->destination_country;
						
					//SELECT DESTINATION COUNTRY DROPDOWN
					//$destination_country = '<div class="form-group">';
					//$destination_country .= '<select name="destination_country" id="destination_country" class="form-control">';
					
					$destination_country = '<option value="0" >Select Destination Country</option>';
							
					$this->db->from('countries');
					$this->db->order_by('id');
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							$d = (strtolower($row['name']) == strtolower($detail->destination_country))?'selected':'';
							$destination_country .= '<option value="'.$row['name'].'" '.$d.'>'.ucwords($row['name']).'</option>';
						}
					}
					
					//$destination_country .= '</select>';
					//$destination_country .= '</div>';	
					$data['destination_country_options'] = $destination_country;
					//*********END SELECT DESTINATION COUNTRY DROPDOWN**********//
					
					
					$data['customer_contact_phone'] = $detail->customer_contact_phone;
					
					$user_array = $this->Users->get_user($detail->customer_email);
						
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->first_name.' '.$user->last_name;
						}
					}
				
					$data['customer'] = $fullname;
					$data['customer_email'] = $detail->customer_email;
					
					
					//*********SELECT CUSTOMER DROPDOWN**********//
					//$users = '<div class="form-group">';
					//$users .= '<select name="customer_email" id="customer_email" class="form-control">';
					
					$users = '<option value="0" >Select Customer</option>';
							
					$this->db->from('users');
					$this->db->order_by('id');
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							$default = (strtolower($row['email_address']) == strtolower($detail->customer_email))?'selected':'';
							
							$users_array = $this->Users->get_user($row['email_address']);
							$fullname = '';
							if($users_array){
								foreach($users_array as $user){
									$fullname = $user->first_name.' '.$user->last_name;
								}
							}
							$users .= '<option value="'.$row['email_address'].'" '.$default.'>'.$fullname.' ('.$row['email_address'].')</option>';
						}
					}
					
					//$users .= '</select>';
					//$users .= '</div>';	
					$data['user_options'] = $users;
					//*********END SELECT CUSTOMER DROPDOWN**********//
					
					
					$status = '';
					if($detail->status == '0'){
						$status = 'Pending';
					}else{
						$status = 'Shipped';
					}
					$data['status'] = $status;
					$data['shipping_status'] = $detail->status;
					//$data['note'] = $detail->note;
					
					
					$data['shipping_date'] = date("F j, Y", strtotime($detail->created));
					
					$shipping_date = $detail->created;
					$u_shipping_date = '';
					
					if($shipping_date == '0000-00-00 00:00:00'){
						$shipping_date = 'Not Assigned';
						$u_shipping_date = '';
					}else{
						$shipping_date = date('F j, Y', strtotime($shipping_date));
						$u_shipping_date = date('d/m/Y', strtotime($shipping_date));
					}
					$data['update_shipping_date'] = $u_shipping_date;
					
					$estimated_delivery_date = '';
					$delivery_date = '';
					
					if($detail->estimated_delivery_date == '0000-00-00 00:00:00'){
						$estimated_delivery_date = 'Not set';
						$delivery_date = '';
					}else{
						$estimated_delivery_date = date("F j, Y H:i a", strtotime($detail->estimated_delivery_date));
						$delivery_date = date('d/m/Y', strtotime($detail->estimated_delivery_date));
					}
					
					$data['delivery_date'] = $delivery_date;
					$data['estimated_delivery_date'] = $estimated_delivery_date;
					
					$details = '<table class="display table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">';
					$details .= '<tr>';
					$details .= '<th class="text-right"><h5><strong>Reference</strong></h5></th>';
					$details .= '<td><h5>'.$detail->order_reference.'</h5></td>';
					$details .= '</tr>';
					
					$details .= '<tr>';
					$details .= '<th class="text-right"><h5><strong>Entry Date</strong></h5></th>';
					$details .= '<td><h5>'.date("F j, Y", strtotime($detail->created)).'</h5></td>';
					$details .= '</tr>';
					
					$details .= '<tr>';
					$details .= '<th class="text-right"><h5><strong>Estimated Delivery Date</strong></h5></th>';
					$details .= '<td><h5>'.$estimated_delivery_date.'</h5></td>';
					$details .= '</tr>';
					
					$details .= '<tr>';
					$details .= '<th class="text-right"><h5><strong>Status</strong></h5></th>';
					$details .= '<td><span class="badge badge-success"><h5>'.$status.'</h5></span></td>';
					$details .= '</tr>';
					
					$details .= '<tr>';
					$details .= '<th class="text-right"><h5><strong>Method</strong></h5></th>';
					$details .= '<td><h5>'.$detail->shipping_method.'</h5></td>';
					$details .= '</tr>';
					
					$details .= '<tr>';
					$details .= '<th class="text-right"><h5><strong>Shipping Fee</strong></h5></th>';
					$details .= '<td> <h5>$'.number_format($detail->shipping_fee, 2).'</h5></td>';
					$details .= '</tr>';
					
					$details .= '<tr>';
					$details .= '<th class="text-right"><h5><strong>Shipping Tax</strong></h5></th>';
					$details .= '<td> <h5>$'.number_format($detail->tax, 2).'</h5></td>';
					$details .= '</tr>';
					
					$details .= '<tr>';
					$details .= '<th class="text-right"><h5><strong>Origin Location</strong></h5></th>';
					$details .= '<td><h5>'.$detail->origin_city.', '.$detail->origin_country.'</h5></td>';
					$details .= '</tr>';
					
					$details .= '<tr>';
					$details .= '<th class="text-right"><h5><strong>Destination Location</strong></h5></th>';
					$details .= '<td><h5>'.$detail->destination_city.', '.$detail->destination_country.'</h5></td>';
					$details .= '</tr>';
					
					$details .= '<tr>';
					$details .= '<th class="text-right"><h5><strong>Customer</strong></h5></th>';
					$details .= '<td><h5>'.$fullname.'</h5></td>';
					$details .= '</tr>';
					
					$details .= '<tr>';
					$details .= '<th class="text-right"><h5><strong>Contact Tel:</strong></h5></th>';
					$details .= '<td><h5>'.$detail->customer_contact_phone.'</h5></td>';
					$details .= '</tr>';
					
					$details .= '</table>';	
					
					$data['details'] = $details;
					
					$data['model'] = 'shipping';
					$data['success'] = true;

			}else {
				$data['success'] = false;
			}
			echo json_encode($data);
		}					
	
			
	
		/**
		* Function to handle
		* shipping view and edit
		* display
		*/	
		public function existing_order_details(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$reference = html_escape($this->input->post('reference'));
			//$reference = preg_replace('#[^0-9]#i', '', $reference); // filter everything but numbers
			$email = html_escape($this->input->post('email'));
			
			$detail = $this->db->select('*')->from('orders')->where('reference',$reference)->where('customer_email',$email)->get()->row();
			
			if($detail){
				
					$data['id'] = $detail->id;
					$data['headerTitle'] = $detail->reference;			
					$data['reference'] = $detail->reference;
					$data['customer_email'] = $detail->customer_email;
					//$data['payment_status'] = $detail->payment_status;
					//$data['shipping_status'] = $detail->shipping_status;
					
					$users_array = $this->Users->get_user($detail->customer_email);
					$destination_city = '';
					$destination_country = '';
					if($users_array){
						foreach($users_array as $user){

							$destination_city = $user->city;
							$destination_country = $user->country;
						}
					}
					$data['destination_city'] = $destination_city;
					$data['destination_country'] = $destination_country;
					//$data['order_date'] = date("F j, Y", strtotime($detail->order_date));
					
					//GET TRANSACTION DETAILS
					$transaction_array = $this->Transactions->get_transaction($detail->reference);
					
					$total_amount = '';
					if($transaction_array){
						foreach($transaction_array as $transaction){
							$total_amount = $transaction->total_amount;
						}
					}
					$data['total_amount'] = $total_amount;
					
					//$shipping_array = $this->Shipping->get_shipping($detail->reference);
					
					
					$data['success'] = true;

			}else {
				$data['success'] = false;
			}
			echo json_encode($data);
		}					

		/**
		* Function to handle
		* shipping view and edit
		* display
		*/	
		public function customer_details(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$reference = html_escape($this->input->post('reference'));
			//$reference = preg_replace('#[^0-9]#i', '', $reference); // filter everything but numbers
			
			$detail = $this->db->select('*')->from('orders')->where('reference',$reference)->get()->row();
			
			if($detail){
				
					$data['customer_email'] = $detail->customer_email;
					
					$data['success'] = true;

			}else {
				$data['success'] = false;
			}
			echo json_encode($data);
		}					

		/**
		* Function to handle
		* shipping view and edit
		* display
		*/	
		public function get_customer_details(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$email = html_escape($this->input->post('email'));
			//$reference = preg_replace('#[^0-9]#i', '', $reference); // filter everything but numbers
			
			$detail = $this->db->select('*')->from('users')->where('email_address',$email)->get()->row();
			
			if($detail){
				
					$data['customer_email'] = $detail->email_address;
					$data['telephone'] = $detail->telephone;
					$data['success'] = true;

			}else {
				$data['success'] = false;
			}
			echo json_encode($data);
		}			


		/**
		* Function to ensure shipping data  
		* is unique
		*/			
		public function unique_shipping(){
			
			$shipping_method_id = $this->input->post('shipping_method');
			$id = preg_replace('#[^0-9]#i', '', $shipping_method_id); // filter everything but numbers
				
			$detail = $this->db->select('*')->from('shipping_methods')->where('id',$id)->get()->row();
				
			$shipping_method = '';
			if($detail){
				$shipping_method = $detail->shipping_company;
			}
				
			$where = array(
				'reference' => $this->input->post('reference'),
				'shipping_fee' => $this->input->post('shipping_fee'),
				'tax' => $this->input->post('tax'),
				'shipping_method' => $shipping_method,
				'origin_city' => $this->input->post('origin_city'),
				'origin_country' => $this->input->post('origin_country'),
				'destination_city' => $this->input->post('destination_city'),
				'destination_country' => $this->input->post('destination_country'),
				'customer_contact_phone' => $this->input->post('customer_contact_phone'),
				'customer_email' => $this->input->post('customer_email'),
				'shipping_date' => $this->input->post('shipping_date'),
			);
			
			if (!$this->Shipping->unique_shipping($where))
			{
				$this->form_validation->set_message('unique_shipping', 'You already have this shipping on record!');
				return FALSE;
			}
			else
			{
				return TRUE;
			}
		}	
		
			
	
		/**
		* Function to handle
		* shipping_status details view
		* display
		*/	
		public function shipping_status_details(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$reference = html_escape($this->input->post('reference'));
			//$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
			//get delivery date
			$shipping_array = $this->Shipping->get_shipping($reference);
			//	
			$estimated_delivery_date = '';
			$customer_email = '';
			if($shipping_array){
				foreach($shipping_array as $shipping){
					
					$customer_email = $shipping->customer_email;
					if($shipping->estimated_delivery_date == '0000-00-00 00:00:00'){
						$estimated_delivery_date = 'Not set';
					}else{
						$estimated_delivery_date = date("F j, Y H:i a", strtotime($shipping->estimated_delivery_date));
					}
					
					
				}
			}
			//Get customers name from email
			$user_array = $this->Users->get_user($customer_email);
			$customer_name = '';
			if($user_array){
				foreach($user_array as $user){
					$customer_name = $user->first_name.' '.$user->last_name;
				}
			}
				
			$count_shipping = $this->Shipping_status->count_shipping_by_reference($reference);
			if($count_shipping < 0){
				$count_shipping = 0;
			}
			
			$shipping_detail_array = $this->Shipping_status->get_shipping_by_reference($reference);

			if($shipping_detail_array){
				
				
				$details = '<table class="display table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">';
				$details .= '<thead><tr>';
				$details .= '<th colspan="2"><h5><strong>Customer - </strong>'.$customer_name.'</h5></th>';
				$details .= '<th colspan="2"><h5><strong>Estimated Delivery - </strong>'.$estimated_delivery_date.'</h5></th>';
				$details .= '</tr></thead>';
				$details .= '<thead><tr>';
				$details .= '<th>Date</th><th>Description</th><th>Location</th>';
				$details .= '</tr></thead><tbody>';
				
				$no = $count_shipping;
				$lastDate = null;
				
				foreach($shipping_detail_array as $detail){
					
					$date = date('l, F j, Y', strtotime($detail->status_date));
					$time = date('H:i a', strtotime($detail->status_date));
					
					
					if (is_null($lastDate) || $lastDate !== $date) {
						$details .= '<tr>';
						
						$details .= '<th colspan="4"><h5><strong>'.$date.'</strong></h5></th>';
						$details .= '</tr>';
					}
					
					
					$details .= '<tr>';
					$details .= '<td>'.$no.'</td>';
					$details .= '<td>'.$detail->status_description.'</td>';
					$details .= '<td>'.$detail->location.'</td>';
					$details .= '<td>'.$time.'</td>';
					$details .= '</tr>';
					$lastDate = $date;
					$no--;
				}
				$details .= '<tr>';
				
				$details .= '</tbody>';	
				$details .= '</table>';	
				
				$data['headerTitle'] = 'Order Reference - '.$reference;			
				$data['shipping_status_details'] = $details;
				
				$data['model'] = 'shipping_status';
				$data['success'] = true;

			}else {
				$data['success'] = false;
			}
			echo json_encode($data);
		}					

		
		/***
		* Function to handle shipping status ajax
		* Datatable
		***/
		public function shipping_status_datatable()
		{
			
			$list = $this->Shipping_status->get_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $status) {
				$no++;
				$row = array();
				
				$row[] = '<div class="checkbox checkbox-primary pull-left"><input type="checkbox" name="cb[]" class="cb" onclick="enableButton(this)" value="'.$status->id.'"><label for="cb"></label></div><div style="margin-left: 40%; margin-right: 40%;">'.$status->order_reference.'</div>';
				
				//$row[] = $no;
				
				//$row[] = $status->order_reference;
				
				$row[] = $status->status_description;
				
				$row[] = $status->location;
					
				$user_array = $this->Users->get_user($status->customer_email);
					
				$fullname = '';
				if($user_array){
					foreach($user_array as $user){
						$fullname = $user->first_name.' '.$user->last_name;
					}
				}
				$row[] = $fullname.' ('.$status->customer_email.')';
				$row[] = date('l, F j, Y g:i a', strtotime($status->status_date));
				
				$row[] = '<a data-toggle="modal" data-target="#viewShippingStatusModal" class="btn btn-default btn-xs" onclick="viewShippingStatus('.$status->id.');" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a><a data-toggle="modal" data-target="#editShippingStatusModal" class="btn btn-primary btn-xs" onclick="editShippingStatus('.$status->id.');" id="'.$status->id.'" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
				
				$data[] = $row;
				
				
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Shipping_status->count_all(),
				"recordsFiltered" => $this->Shipping_status->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}


		/**
		* Function to handle
		* shipping status view and edit
		* display
		*/	
		public function shipping_status_main(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$id = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $id); // filter everything but numbers
			
			$detail = $this->db->select('*')->from('shipping_status')->where('id',$id)->get()->row();
			
			if($detail){
				
					$data['id'] = $detail->id;
					$data['headerTitle'] = 'Order Reference - '.ucwords($detail->order_reference);			
					$data['order_reference'] = $detail->order_reference;
					$data['status_description'] = $detail->status_description;
					$data['location'] = $detail->location;
					$data['customer_email'] = $detail->customer_email;
					$data['status_date'] = date("l, F j, Y g:i a", strtotime($detail->status_date));
					
					$users_array = $this->Users->get_user($detail->customer_email);
					$fullname = '';
					if($users_array){
						foreach($users_array as $user){
							$fullname = $user->first_name.' '.$user->last_name;
						}
					}
					//$data['shipping_status'] = $detail->shipping_status;
					
					$details = '<table class="display table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">';
					
					
					$details .= '<tr>';
					$details .= '<th class="text-right"><h5><strong>Date</strong></h5></th>';
					$details .= '<td><h5>'.date("l, F j, Y g:i a", strtotime($detail->status_date)).'</h5></td>';
					$details .= '</tr>';
					
					$details .= '<tr>';
					$details .= '<th class="text-right"><h5><strong>Description</strong></h5></th>';
					$details .= '<td><h5>'.$detail->status_description.'</h5></td>';
					$details .= '</tr>';
					
					$details .= '<tr>';
					$details .= '<th class="text-right"><h5><strong>Location</strong></h5></th>';
					$details .= '<td><h5>'.$detail->location.'</h5></td>';
					$details .= '</tr>';
					
					
					$details .= '<tr>';
					$details .= '<th class="text-right"><h5><strong>Customer</strong></h5></th>';
					$details .= '<td><h5>'.$fullname.'</h5></td>';
					$details .= '</tr>';
					
					$details .= '</table>';	
					
					$data['details'] = $details;
					
					//$data['order_date'] = date("F j, Y", strtotime($detail->order_date));
					
					$data['success'] = true;

			}else {
				$data['success'] = false;
			}
			echo json_encode($data);
		}					

				
		/**
		* Function to validate add shipping
		* status
		*/			
		public function add_shipping_status(){

			$this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
			$this->form_validation->set_rules('reference','Reference','required|trim|xss_clean');	
			$this->form_validation->set_rules('status_description','Status Description','required|trim|xss_clean|callback_unique_shipping_status');
			$this->form_validation->set_rules('location','Location','required|trim|xss_clean');
			$this->form_validation->set_rules('customer_email','Customer Email','required|trim|xss_clean|valid_email');
						
			$this->form_validation->set_message('required', '%s cannot be blank!');
			$this->form_validation->set_message('is_unique', 'This shipping already exists!');
			
			
			if($this->form_validation->run()){
				
				$customer_email = $this->input->post('customer_email');
				$reference = $this->input->post('reference');
				$reference = preg_replace('#[^0-9]#i', '', $reference); // filter everything but numbers
			
				
				//SHIPPING DATA FROM POST
				$add = array(
					'order_reference' => $reference,
					'status_description' => $this->input->post('status_description'),
					'location' => $this->input->post('location'),
					'customer_email' => $customer_email,
					'status_date' => date('Y-m-d H:i:s'),
				);
				
				//INSERT SHIPPING IN DB
				$insert_id = $this->Shipping_status->insert_shipping_status($add);
							
				if($insert_id){
					
					$where = array(
						'order_reference' => $reference,
					);
					
					//CHECK IF REFERENCE ALREADY EXISTS IN STATUS TABLE
					//IF NOT UNIQUE, UPDATE SHIPPING AS SHIPPED
					if(!$this->Shipping_status->unique_status($where)){
						
						//GET SHIPPING ID
						$shipping_id = '';
						$shipping_array = $this->Shipping->get_shipping($reference);
						if($shipping_array){
							foreach($shipping_array as $shipping){
								$shipping_id = $shipping->id;
							}
						}
						$shipping_data = array(
							'status' => '1',
						);
						//UPDATE SHIPPING AS SHIPPED
						$this->Shipping->update_shipping($shipping_data, $shipping_id);
					}
					
			
					//GET CUSTOMERS DETAILS
					$user_array = $this->Users->get_user($customer_email);
					
					$customer_name = '';
					if($user_array){
						foreach($user_array as $user){
							$customer_name = $user->first_name.' '.$user->last_name;
						}
					}
					
					
				
					//GET ADMINS DETAILS
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					
					
					$message_subject = 'Shipping Updated (Ref:'.$reference.')';
					$message_details = 'Your shipping has been updated.';
					
					//MESSAGE NOTIFICATION
					//DATA ARRAY
					$message_data = array(
						'sender_name' => $fullname,
						'sender_email' => $username,
						'receiver_name' => $customer_name,
						'receiver_email' => $customer_email,
						'message_subject' => $message_subject,
						'message_details' => $message_details,
						'attachment' => '0',
						'opened' => '0',
						'recipient_archive' => '0',
						'recipient_delete' => '0',
						'sender_archive' => '0',
						'sender_delete' => '0',
						'replied' => '0',
						'date_sent' => date('Y-m-d H:i:s'),
					);
					
					//SEND MESSAGE ON SYSTEM
					if($this->Messages->send_new_message($message_data)){
						
						//CHECK IF ALERT NOTIFICATION IS ON
						if($this->Email_alerts->alert_on($email)){
							
							//SEND EMAIL NOTIFICATION TO CUSTOMER
						
							//RECIEVERS FIRST AND LAST NAME
							$to_name = $customer_name;
							
							//RECIEVERS EMAIL
							$to_email = $customer_email;
							
							//EMAIL SUBJECT
							$subject = $message_subject;
							
							//COMPOSE EMAIL MESSAGE
							$message = "<h3><u>(".$message_subject.")</u></h3>";
							
							$link = base_url('account/shipping');
							
							$message .= '<p>Your shipping has been updated. <a title="Check Status" href="'.base_url('account/shipping').'">Track your shipping here</a></p>';
							
							$this->Messages->send_email_alert($to_email, $subject, $to_name, $message);
							
						}
						
					
					}
					
					//update page metadata table
					$description = 'added a new shipping status';
				
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Shipping',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$data['success'] = true;
							
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> New Shipping status added!</div>';
							
				}else{
					
					$data['success'] = false;
							
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> New Shipping status not added!</div>';
							
				}				
			}
			else {
						
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.validation_errors().'</div>';
				//$data['errors'] = $this->form_validation->error_array();
				//$this->addhand();	
			}

			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);			
		}


		/**
		* Function to ensure shipping data  
		* is unique
		*/			
		public function unique_shipping_status(){
			
			$where = array(
				'order_reference' => $this->input->post('reference'),
				'status_description' => $this->input->post('status_description'),
				'location' => $this->input->post('location'),
				'customer_email' => $this->input->post('customer_email'),
			);
			
			if (!$this->Shipping_status->unique_status($where))
			{
				$this->form_validation->set_message('unique_shipping_status', 'This record already exist!');
				return FALSE;
			}
			else
			{
				return TRUE;
			}
		}	
		
			
		/**
		* Function to validate update shipping status
		* form
		*/			
		public function update_shipping_status(){
			
			$this->load->library('form_validation');
				
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
			$this->form_validation->set_rules('status_description','Status Description','required|trim|xss_clean');
			
			$this->form_validation->set_rules('location','Location','required|trim|xss_clean');
			$this->form_validation->set_rules('customer_email','Customer Email','required|trim|xss_clean|valid_email');
			//$this->form_validation->set_rules('status_date','Status Date','required|trim|xss_clean');
			
						
			$this->form_validation->set_message('required', '%s cannot be blank!');
			
				
			if ($this->form_validation->run()){
				
				//escaping the post values
				$status_id = html_escape($this->input->post('status_id'));
				$id = preg_replace('#[^0-9]#i', '', $status_id); // filter everything but numbers
				
				//SHIPPING DATA FROM POST
				$update = array(
					'status_description' => $this->input->post('status_description'),
					'location' => $this->input->post('location'),
					'customer_email' => $this->input->post('customer_email'),
				);
				
				//IF TRUE, UPDATE DB
				if ($this->Shipping_status->update_status($update, $id)){
						
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
						
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					
					//update page metadata table
					$description = 'updated shipping status';
					
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Shipping',
						'activity_time' => date('Y-m-d H:i:s'),
					);
							
					$this->Site_activities->insert_activity($activity);
								
							
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Shipping status has been updated!</div>';
				}
					
			}else {
				
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> There are errors on the form!'.validation_errors().'</div>';
			}
			
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);			
		}			
	
		
		/***
		* Function to handle shipping methods ajax
		* Datatable
		***/
		public function shipping_methods_datatable()
		{
			
			$list = $this->Shipping_methods->get_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $method) {
				$no++;
				$row = array();
				
				$row[] = '<div class="checkbox checkbox-primary pull-left"><input type="checkbox" name="cb[]" class="cb" onclick="enableButton(this)" value="'.$method->id.'"><label for="cb"></label></div><div class="" style="margin-left:40%; margin-right:40%;">'.$method->shipping_company.'</div>';
				
				//$row[] = $no;
				
				//$row[] = $method->shipping_company;
				
				$row[] = '$'.number_format($method->shipping_costs, 2);
				
				$row[] = $method->shipping_duration;
				
				$url = 'admin/shipping_method_details';
				
				$row[] = '<a data-toggle="modal" data-target="#editShippingMethodModal" class="btn btn-primary btn-xs" onclick="editShippingMethod('.$method->id.',\''.$url.'\');" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
				
				$data[] = $row;
				
				
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Shipping_methods->count_all(),
				"recordsFiltered" => $this->Shipping_methods->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}

	
		/**
		* Function to handle
		* shipping method view and edit
		* display
		*/	
		public function shipping_method_details(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$id = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $id); // filter everything but numbers
			
			$detail = $this->db->select('*')->from('shipping_methods')->where('id',$id)->get()->row();
			
			if($detail){
				
					$data['id'] = $detail->id;
					$data['headerTitle'] = ucwords($detail->shipping_company);			
					$data['shipping_company'] = $detail->shipping_company;
					$data['shipping_costs'] = $detail->shipping_costs;
					$data['shipping_duration'] = $detail->shipping_duration;
					//$data['shipping_status'] = $detail->shipping_status;
					
					//$data['order_date'] = date("F j, Y", strtotime($detail->order_date));
					
					$data['success'] = true;

			}else {
				$data['success'] = false;
			}
			echo json_encode($data);
		}					

				
		/**
		* Function to validate add shipping
		* method
		*/			
		public function add_shipping_method(){

			$this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
				
			$this->form_validation->set_rules('shipping_company','Shipping Company','required|trim|xss_clean|is_unique[shipping_methods.shipping_company]');
			
			$this->form_validation->set_rules('shipping_costs','Shipping Costs','required|trim|xss_clean');
			
			$this->form_validation->set_rules('shipping_duration','Shipping Duration','required|trim|xss_clean');
									
			$this->form_validation->set_message('required', '%s cannot be blank!');
			$this->form_validation->set_message('is_unique', 'This record already exists!');
			
			if($this->form_validation->run()){
				
				
				//DATA FROM POST
				$add = array(
					'shipping_company' => ucwords($this->input->post('shipping_company')),
					'shipping_costs' => $this->input->post('shipping_costs'),
					'shipping_duration' => $this->input->post('shipping_duration'),
				);
				
				//INSERT TO DB
				if($this->Shipping_methods->insert_shipping_method($add)){
					
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update page metadata table
					$description = 'added a new shipping method';
				
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Shipping',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$data['success'] = true;
							
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> New shipping method has been added!</div>';
							
				}else{
					
					$data['success'] = false;
							
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> New shipping method has not been added!</div>';
							
				}				
			}
			else {
						
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.validation_errors().'</div>';
				//$data['errors'] = $this->form_validation->error_array();
				//$this->addhand();	
			}

			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);			
		}

			
		/**
		* Function to validate update shipping method
		* form
		*/			
		public function update_shipping_method(){
			
			$this->load->library('form_validation');
				
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
			$this->form_validation->set_rules('shipping_company','Shipping Company','required|trim|xss_clean');
			
			$this->form_validation->set_rules('shipping_costs','Shipping Costs','required|trim|xss_clean');
			
			$this->form_validation->set_rules('shipping_duration','Shipping Duration','required|trim|xss_clean');
			
						
			$this->form_validation->set_message('required', '%s cannot be blank!');
			
				
			if ($this->form_validation->run()){
				
				//escaping the post values
				$method_id = html_escape($this->input->post('method_id'));
				$id = preg_replace('#[^0-9]#i', '', $method_id); // filter everything but numbers
				
				//SHIPPING DATA FROM POST
				$update = array(
					'shipping_company' => ucwords($this->input->post('shipping_company')),
					'shipping_costs' => $this->input->post('shipping_costs'),
					'shipping_duration' => $this->input->post('shipping_duration'),
				);
				
				//VERIFY IF DETAILS DIFFERENT
				if($this->Shipping_methods->unique_method($update)){	
					
					//IF TRUE, UPDATE DB
					if ($this->Shipping_methods->update_shipping_method($update, $id)){
						
						$username = $this->session->userdata('admin_username');
						$user_array = $this->Admin->get_user($username);
						
						$fullname = '';
						if($user_array){
							foreach($user_array as $user){
								$fullname = $user->admin_name;
							}
						}
						//update page metadata table
						$description = 'updated shipping method';
					
						$activity = array(			
							'name' => $fullname,
							'username' => $username,
							'description' => $description,
							'keyword' => 'Shipping',
							'activity_time' => date('Y-m-d H:i:s'),
						);
							
						$this->Site_activities->insert_activity($activity);
								
							
						$data['success'] = true;
						$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Shipping method has been updated!</div>';
					}
				}
					
			}else {
				
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> There are errors on the form!'.validation_errors().'</div>';
			}
			
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);			
		}			
	
		
			
			
		
		/***
		* Function to handle transactions
		*
		***/		
		public function transactions(){
			
			if(!$this->session->userdata('admin_logged_in')){
								
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//redirect('admin/login/','refresh');
				
			}else{			

				$username = $this->session->userdata('admin_username');
				
				$data['user_array'] = $this->Admin->get_user($username);
					
				$fullname = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
						$fullname = $user->admin_name;
					}
				}
				
				$data['fullname'] = $fullname;
					
				$data['unread_contact_us'] = $this->Contact_us->count_unread_messages();
					
				$messages_unread = $this->Messages->count_unread_messages($username);
				if($messages_unread == '' || $messages_unread == null){
					$data['messages_unread'] = 0;
				}else{
					$data['messages_unread'] = $messages_unread;
				}
					
				$data['header_messages_array'] = $this->Messages->get_header_messages($username);
				
				
				$enquiries_unread = $this->Sale_enquiries->count_unread_enquiries();
				if($enquiries_unread == '' || $enquiries_unread == null){
					$data['enquiries_unread'] = 0;
				}else{
					$data['enquiries_unread'] = $enquiries_unread;
				}
				
				//*********SELECT ORDER DROPDOWN**********//
				//$existing_orders = '<div class="form-group">';
				//$existing_orders .= '<select name="existing_orders" id="existing_orders" class="form-control">';
					
				$existing_orders = '<option value="0" >Select Existing Order</option>';
							
				$this->db->from('orders');
				$this->db->order_by('id');
				$result = $this->db->get();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row){
							
						$users_array = $this->Users->get_user($row['customer_email']);
						$fullname = '';
						if($users_array){
							foreach($users_array as $user){
								$fullname = $user->first_name.' '.$user->last_name;
							}
						}
						$existing_orders .= '<option value="'.$row['reference'].'-'.$row['customer_email'].'" >'.$row['reference'].' - '.$fullname.' ('.$row['customer_email'].')</option>';
					}
				}
					
				//$existing_orders .= '</select>';
				//$existing_orders .= '</div>';	
				$data['existing_orders'] = $existing_orders;
				//*********END SELECT ORDER DROPDOWN**********//
				
				
				//assign page title name
				$data['pageTitle'] = 'Transactions';
								
				//assign page title name
				$data['pageID'] = 'transactions';
										
				//load header and page title
				$this->load->view('admin_pages/header', $data);
							
				//load main body
				$this->load->view('admin_pages/transactions_page', $data);	
					
				//load footer
				$this->load->view('admin_pages/footer');
					
			}
				
		}
		
	
		
		/***
		* Function to handle transaction ajax
		* Datatable
		***/
		public function transaction_datatable()
		{
			
			$list = $this->Transactions->get_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $transaction) {
				$no++;
				$row = array();
				
				$url = 'admin/transaction_details';
				
				$row[] = '<div class="checkbox checkbox-primary pull-left"><input type="checkbox" name="cb[]" class="cb" onclick="enableButton(this)" value="'.$transaction->id.'"><label for="cb"></label></div><div class="" style="margin-left:40%; margin-right:40%;"><a data-toggle="modal" href="#" data-target="#viewTransactionModal" class="link" onclick="viewTransaction('.$transaction->id.',\''.$url.'\');" title="View">'.$transaction->order_reference.'</a></div>';
				
				//$row[] = $no;
				
				$row[] = '$'.number_format($transaction->order_amount, 2);
				
				$row[] = '$'.number_format($transaction->shipping_and_handling_costs, 2);
				
				$row[] = '$'.number_format($transaction->total_amount, 2);
				
				$user_array = $this->Users->get_user($transaction->email);
					
				$fullname = '';
				if($user_array){
					foreach($user_array as $user){
						$fullname = $user->first_name.' '.$user->last_name;
					}
				}
				//CUSTOMER
				$row[] = $fullname;
				
				$status = '';
				if($transaction->status == '0'){
					$status = 'Pending';
				}else{
					$status = 'Paid';
				}
				//STATUS
				$row[] = $status;
					
				$transaction_date = $transaction->created;
				
				if($transaction_date == '0000-00-00 00:00:00'){
					$transaction_date = 'Not Paid';
				}else{
					$transaction_date = date('l, F j, Y g:i a', strtotime($transaction_date));
				}
				$row[] = $transaction_date;
				
				//$row[] = '<a data-toggle="modal" data-target="#editModal" class="btn btn-info btn-xs" onclick="editTransaction('.$transaction->id.');" id="'.$transaction->id.'" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
				
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Transactions->count_all(),
				"recordsFiltered" => $this->Transactions->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}


		
		/**
		* Function to handle
		* transaction view and edit
		* display
		*/	
		public function transaction_details(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$pid = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
			$detail = $this->db->select('*')->from('transactions')->where('id',$id)->get()->row();
			
			if($detail){
				
					
					$data['id'] = $detail->id;
					
					$data['headerTitle'] = 'Transaction - '.$detail->order_reference;
					$status = '';
					
					$badge = '';
					
					if($detail->status == '0'){
						$status = 'Pending';
						$badge = 'badge-danger';
					}else{
						$status = 'Paid';
						$badge = 'badge-success';
					}
					$data['status'] = $status;
					$data['payment_status'] = $detail->status;
					
					
					$data['transaction_date'] = date("l, F j, Y g:i a", strtotime($detail->created));
					
					$transaction_date = $detail->created;
					$u_transaction_date = '';
					
					$details = '<table class="display table-striped table-bordered"  width="100%">';
					
					$details .= '<tr>';
					$details .= '<th class="text-right" style="padding-right: 2%;"><h5><strong>Date</strong></h5></th>';
					$details .= '<td><h5>'.date("l, F j, Y g:i a", strtotime($detail->created)).'</h5></td>';
					$details .= '</tr>';
					
					$details .= '<tr>';
					$details .= '<th class="text-right" style="padding-right: 2%;"><h5><strong>Status</strong></h5></th>';
					$details .= '<td><span class="badge '.$badge.'">'.$status.'</span></td>';
					$details .= '</tr>';
					
					$details .= '<tr>';
					$details .= '<th class="text-right" style="padding-right: 2%;"><h5><strong>Order Amount</strong></h5></th>';
					$details .= '<td> <h5>$'.number_format($detail->order_amount, 2).'</h5></td>';
					$details .= '</tr>';
					
					$details .= '<tr>';
					$details .= '<th class="text-right" style="padding-right: 2%;"><h5><strong>Shipping & Handling</strong></h5></th>';
					$details .= '<td> <h5>$'.number_format($detail->shipping_and_handling_costs, 2).'</h5></td>';
					$details .= '</tr>';
					
					$details .= '<tr>';
					$details .= '<th class="text-right" style="padding-right: 2%;"><h5><strong>Total</strong></h5></th>';
					$details .= '<td> <h5>$'.number_format($detail->total_amount, 2).'</h5></td>';
					$details .= '</tr>';
					
					$user_array = $this->Users->get_user($detail->email);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->first_name.' '.$user->last_name;
						}
					}
					$details .= '<tr>';
					$details .= '<th class="text-right" style="padding-right: 2%;"><h5><strong>Customer</strong></h5></th>';
					$details .= '<td><h5>'.$fullname.'</h5></td>';
					$details .= '</tr>';
					
					
					$details .= '</table>';	
					
					$data['details'] = $details;
					
					$data['model'] = 'transactions';
					$data['success'] = true;

			}else {
				$data['success'] = false;
			}
			echo json_encode($data);
		}					
		
		
		/***
		* Function to handle payments
		*
		***/		
		public function payments(){
			
			if(!$this->session->userdata('admin_logged_in')){
				
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);				
				//redirect('admin/login/','refresh');
				
			}else{  
			
				$username = $this->session->userdata('admin_username');
				
				$data['user_array'] = $this->Admin->get_user($username);
					
				$fullname = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
						$fullname = $user->admin_name;
					}
				}
				
				$data['fullname'] = $fullname;
					
				$data['unread_contact_us'] = $this->Contact_us->count_unread_messages();
					
				$messages_unread = $this->Messages->count_unread_messages($username);
				if($messages_unread == '' || $messages_unread == null){
					$data['messages_unread'] = 0;
				}else{
					$data['messages_unread'] = $messages_unread;
				}
					
				$data['header_messages_array'] = $this->Messages->get_header_messages($username);
				
				
				$enquiries_unread = $this->Sale_enquiries->count_unread_enquiries();
				if($enquiries_unread == '' || $enquiries_unread == null){
					$data['enquiries_unread'] = 0;
				}else{
					$data['enquiries_unread'] = $enquiries_unread;
				}
					
				//assign page title name
				$data['pageTitle'] = 'Payments';
						
				//assign page title name
				$data['pageID'] = 'payments';
								
				//load header and page title
				$this->load->view('admin_pages/header', $data);
					
				//load main body
				$this->load->view('admin_pages/payments_page', $data);	
				
				//load footer
				$this->load->view('admin_pages/footer');
								
			}
		}
		
		
		/***
		* Function to handle payments datatable
		*
		***/
		public function payments_datatable()
		{
			$list = $this->Payments->get_datatables();
			$data = array();
			$no = $_POST['start'];
			$last_login  = '';
			foreach ($list as $payment) {
				$no++;
				$row = array();
				$row[] = '<div class="checkbox checkbox-primary pull-left"><input type="checkbox" name="cb[]" class="cb" onclick="enableButton(this)" value="'.$payment->id.'"><label for="cb"></label></div><div style="margin-left: 40%; margin-right: 40%;">'.$payment->reference.'</div>';
				
				$row[] = '$'.number_format($payment->total_amount, 2);
				$row[] = ucwords($payment->payment_method);
				
				$user_array = $this->Users->get_user($payment->customer_email);
					
				$fullname = '';
				if($user_array){
					foreach($user_array as $user){
						$fullname = $user->first_name.' '.$user->last_name;
					}
				}
				$row[] = ucwords($fullname);
				//$row[] = date("F j, Y", strtotime($portfolio->date_added));
				
				$model = 'payments';
				
				//prepare buttons
				$row[] = '<a data-toggle="modal" data-target="#editPaymentModal" class="btn btn-primary btn-xs" id="'.$payment->id.'" title="Edit '.ucwords($payment->payment_method).'" onclick="editPayment('.$payment->id.')"><i class="fa fa-edit"></i> Edit</a>
				';
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Payments->count_all(),
				"recordsFiltered" => $this->Payments->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}
		
		

		/**
		* Function to handle AJAX display and edit
		* payment
		* 
		*/	
		public function payment_details(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$pid = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
			$detail = $this->db->select('*')->from('payments')->where('id',$id)->get()->row();
			
			if($detail){

					$data['id'] = $detail->id;
					
					$data['headerTitle'] = $detail->reference;			

					$data['total_amount'] = $detail->total_amount;
					$data['payment_method'] = $detail->payment_method;
					$data['customer_email'] = $detail->customer_email;
					
					$user_array = $this->Users->get_user($detail->customer_email);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->first_name.' '.$user->last_name;
						}
					}
					$data['customer'] = $fullname;
					$data['payment_date'] = date("l, F j, Y g:i a", strtotime($detail->payment_date));
					
					
					$data['model'] = 'payments';
					$data['success'] = true;
					
			}else {
				$data['success'] = false;
			}
			
			echo json_encode($data);
			
		}
					

		/**
		* Function to handle AJAX display and edit
		* payment methods
		* 
		*/	
		public function payment_method_details(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$pid = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
			$detail = $this->db->select('*')->from('payment_methods')->where('id',$id)->get()->row();
			
			if($detail){

					$data['id'] = $detail->id;
					
					$data['headerTitle'] = $detail->method_name;			

					$data['method_name'] = $detail->method_name;
					
					$select_payment_methods = '<select name="payment_methods" id="payment_methods" class="form-control">';
					
					$this->db->from('payment_methods');
					$this->db->order_by('id');
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							$default = ($row['method_name'] == $detail->method_name)?'selected':'';
							$select_payment_methods .= '<option value="'.$row['method_name'].'" '.$default.'>'.$row['method_name'].'</option>';			
						}
					}
					
					$select_payment_methods .= '</select>';
					
					$data['select_payment_methods'] = $select_payment_methods;
					
					$data['model'] = 'payment_methods';
					$data['success'] = true;
					
			}else {
				$data['success'] = false;
			}
			
			echo json_encode($data);
			
		}
		
		/***
		* FUNCTION TO HANDLE PAYMENT METHODS DATATABLE
		*
		***/
		public function payment_methods_datatable()
		{
			$list = $this->Payment_methods->get_datatables();
			$data = array();
			$no = $_POST['start'];
			$last_login  = '';
			foreach ($list as $method) {
				
				$no++;
				
				$row = array();
				
				$row[] = '<div class="checkbox checkbox-primary pull-left"><input type="checkbox" name="cb[]" class="cb" onclick="enableButton(this)" value="'.$method->id.'"><label for="cb"></label></div><div style="margin-left: 20%; margin-right: 20%;">'.ucwords($method->method_name).'</div>';
				
				//$row[] = $method->id;
				
				//$row[] = ucwords($method->method_name);
				
				//$row[] = date("F j, Y", strtotime($portfolio->date_added));
				
				$model = 'payment_methods';
				
				$url = 'admin/payment_method_details';
				
				//prepare buttons
				$row[] = '<a data-toggle="modal" data-target="#editPaymentMethodModal" class="btn btn-primary btn-xs" title="Edit '.ucwords($method->method_name).'" onclick="editPaymentMethod('.$method->id.',\''.$url.'\')"><i class="fa fa-edit"></i> Edit</a>
				';
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Payment_methods->count_all(),
				"recordsFiltered" => $this->Payment_methods->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}
		

								
		/**
		* Function to validate add payment method
		*
		*/			
		public function add_payment_method(){

			$this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
				
			$this->form_validation->set_rules('method_name','Payment Method','required|trim|xss_clean|is_unique[payment_methods.method_name]');
			
					
			$this->form_validation->set_message('required', '%s cannot be blank!');
			$this->form_validation->set_message('is_unique', 'Payment Method already exists! Please enter a new name!');
			
			
			if($this->form_validation->run()){
		
				$add = array(
					'method_name' => ucwords($this->input->post('method_name')),
				);
				
				if($this->Payment_methods->insert_payment_method($add)){
					
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
							
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update activities table
					$description = 'added a new payment method - <i>'.ucwords($this->input->post('method_name')).'</i>';
						
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Payment Method',
						'activity_time' => date('Y-m-d H:i:s'),
					);
								
					$this->Site_activities->insert_activity($activity);
					
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> '.ucwords($this->input->post('method_name')).' added!</div>';
						
				}else{
					
					$data['success'] = false;
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> '.ucwords($this->input->post('method_name')).' not added!</div>';
						
				}				
			}
			else {
					
				$data['success'] = false;
				$data['notif'] = '<div class="text-center" role="alert">'.validation_errors().'</div>';
				//$data['errors'] = $this->form_validation->error_array();
				//$this->addhand();	
			}

			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);	
			
		}

		
		/**
		* FUNCTION TO VALIDATE UPDATE PAYMENT METHOD 
		*  
		*/			
		public function update_payment_method(){
			
			$this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			   	
			$this->form_validation->set_rules('method_name','Payment Method','required|trim|xss_clean');
			 	
			$this->form_validation->set_message('required', '%s cannot be blank!');
			
			if ($this->form_validation->run()){
				
				$id = $this->input->post('methodID');
				$id = preg_replace('#[^0-9]#i', '', $id); // filter everything but numbers
					
				$edit = array(
					'method_name' => ucwords($this->input->post('method_name')),
				);
				
				if ($this->Payment_methods->update_payment_method($edit, $id)){	
				
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
							
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update activities table
					$description = 'updated a payment method - <i>'.ucwords($this->input->post('method_name')).'</i>';
						
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Payment Method',
						'activity_time' => date('Y-m-d H:i:s'),
					);
								
					$this->Site_activities->insert_activity($activity);
					
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Payment Method has been updated!</div>';	
				}
				
			}else {
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
		

					
		
				
		/***
		* Function to handle contact us
		*
		***/		
		public function contact_us(){
			
			if(!$this->session->userdata('admin_logged_in')){
								
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//redirect('admin/login/','refresh');
				
			}else{			

				$username = $this->session->userdata('admin_username');
				
				$data['user_array'] = $this->Admin->get_user($username);
					
				$fullname = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
							$fullname = $user->admin_name;
					}
				}
				
				$data['fullname'] = $fullname;
					
				$data['unread_contact_us'] = $this->Contact_us->count_unread_messages();
					
				$messages_unread = $this->Messages->count_unread_messages($username);
				if($messages_unread == '' || $messages_unread == null){
					$data['messages_unread'] = 0;
				}else{
					$data['messages_unread'] = $messages_unread;
				}
					
				$data['header_messages_array'] = $this->Messages->get_header_messages($username);
				
				$enquiries_unread = $this->Sale_enquiries->count_unread_enquiries();
				if($enquiries_unread == '' || $enquiries_unread == null){
					$data['enquiries_unread'] = 0;
				}else{
					$data['enquiries_unread'] = $enquiries_unread;
				}
				
				$data['count_records'] = $this->Contact_us->count_all();
				
				$delete = $this->Contact_us->delete_old_records();
					
				//assign page title name
				$data['pageTitle'] = 'Contact Us';
								
				//assign page title name
				$data['pageID'] = 'contact_us';
										
				//load header and page title
				$this->load->view('admin_pages/header', $data);
							
				//load main body
				$this->load->view('admin_pages/contact_us_page', $data);	
					
				//load footer
				$this->load->view('admin_pages/footer');
					
			}
				
		}
		
	
		
		/***
		* Function to handle contact us datatable
		*
		***/
		public function contact_us_datatable()
		{
			
			$delete = $this->Contact_us->delete_old_records();
			
			$list = $this->Contact_us->get_datatables();
			$data = array();
			$no = $_POST['start'];
			$last_login  = '';
			foreach ($list as $contact_us) {
				$no++;
				$row = array();
				
				//$row[] = '<div class="checkbox checkbox-primary"><input type="checkbox" name="cb[]" class="cb" onclick="enableButton(this)" value="'.$contact_us->id.'"></div>';
				
				$row[] = '<div class="checkbox checkbox-primary pull-left"><input type="checkbox" name="cb[]" class="cb" onclick="enableButton(this)" value="'.$contact_us->id.'"><label for="cb"></label></div><div style="margin-left: 40%; margin-right: 40%;">'.$no.'</div>';
				
				$textWeight = '';
				$opened = $contact_us->opened;
				
				//check if message has been read
				if($opened == '0'){ 
					$textWeight = 'msgDefault';
					$opened = '<strong>Not Read</strong>'; 
					
				}else{ 
					$textWeight = 'msgRead';
					$opened = 'Read'; 
				}
				
				$row[] = '<span class="'.$textWeight.'">'.$contact_us->contact_name.'</span>';
				$row[] = '<span class="'.$textWeight.'">'.$contact_us->contact_company.'</span>';
				$row[] = '<span class="'.$textWeight.'">'.$contact_us->contact_telephone.'</span>';
				$row[] = '<span class="'.$textWeight.'">'.$contact_us->contact_email.'</span>';
				$row[] = '<span class="'.$textWeight.'">'.$contact_us->ip_details.'</span>';
				$row[] = '<span class="'.$textWeight.'">'.date("F j, Y", strtotime($contact_us->contact_us_date)).'</span>';
				
				$url = 'admin/contact_us_details';
				
				//prepare buttons
				$row[] = '<a data-toggle="modal" data-target="#viewModal" class="btn btn-info btn-xs" id="'.$contact_us->id.'" title="Click to View" onclick="viewContactMessage('.$contact_us->id.', \''.$url.'\')"><i class="fa fa-search"></i> View</a>';
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Contact_us->count_all(),
				"recordsFiltered" => $this->Contact_us->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}
	
		/**
		* Function to handle
		* contact us view and edit
		* display
		*/	
		public function contact_us_details(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$pid = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
			$detail = $this->db->select('*')->from('contact_us')->where('id',$id)->get()->row();
			
			if($detail){
					
					$this->mark_as_read($id,'contact_us');
					
					$data['id'] = $detail->id;
					
					$data['headerTitle'] = 'Contact Us Message';			

					$data['contact_name'] = $detail->contact_name;
					$data['contact_telephone'] = $detail->contact_telephone;
					$data['contact_email'] = $detail->contact_email;
					$data['contact_company'] = $detail->contact_company;
					$data['contact_message'] = stripslashes(wordwrap(nl2br($detail->contact_message), 54, "\n", true));
					
					$data['ip_address'] = $detail->ip_address;
					$data['ip_details'] = $detail->ip_details;
					
					$opened = $detail->opened;
					if($opened == '0'){
						$opened = 'Not Read';
					}else{
						$opened = 'Read';
					}
					$data['opened'] = $opened;
					
					$data['contact_us_date'] = date("F j, Y", strtotime($detail->contact_us_date));
					
					$data['model'] = 'contact_us';
					$data['success'] = true;

			}else {
				$data['success'] = false;
			}
			echo json_encode($data);
		}	
	
		/**
		* Function to mark messages
		* as read 
		*/	
		public function mark_as_read($id,$table){
				
			$data = array(
				'opened' => '1',
			);
			$this->db->where('id', $id);
			$query = $this->db->update($table, $data);
				
		}

	
				
		/***
		* FUNCTION TO HANDLE SALE ENQUIRIES
		*
		***/		
		public function sale_enquiries(){
			
			if(!$this->session->userdata('admin_logged_in')){
								
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//redirect('admin/login/','refresh');
				
			}else{			

				$username = $this->session->userdata('admin_username');
				
				$data['user_array'] = $this->Admin->get_user($username);
					
				$fullname = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
							$fullname = $user->admin_name;
					}
				}
				
				$data['fullname'] = $fullname;
				
				$messages_unread = $this->Messages->count_unread_messages($username);
				if($messages_unread == '' || $messages_unread == null){
					$data['messages_unread'] = 0;
				}else{
					$data['messages_unread'] = $messages_unread;
				}
					
				$data['header_messages_array'] = $this->Messages->get_header_messages($username);
				
				$enquiries_unread = $this->Sale_enquiries->count_unread_enquiries();
				if($enquiries_unread == '' || $enquiries_unread == null){
					$data['enquiries_unread'] = 0;
				}else{
					$data['enquiries_unread'] = $enquiries_unread;
				}
				
				
				$delete = $this->Sale_enquiries->delete_old_records();
					
				//assign page title name
				$data['pageTitle'] = 'Sale Enquiries';
								
				//assign page title name
				$data['pageID'] = 'sale_enquiries';
										
				//load header and page title
				$this->load->view('admin_pages/header', $data);
							
				//load main body
				$this->load->view('admin_pages/sale_enquiries_page', $data);	
					
				//load footer
				$this->load->view('admin_pages/footer');
					
			}
				
		}
		
	
		
		/***
		* Function to handle enquiry datatable
		*
		***/
		public function sale_enquiry_datatable()
		{
			
			$delete = $this->Sale_enquiries->delete_old_records();
			
			$list = $this->Sale_enquiries->get_datatables();
			$data = array();
			$no = $_POST['start'];
			$last_login  = '';
			foreach ($list as $enquiry) {
				$no++;
				$row = array();
				
				
				$textWeight = '';
				$opened = $enquiry->opened;
				
				//check if message has been read
				if($opened == '0'){ 
					$textWeight = 'msgDefault';
					$opened = '<strong><i class="fa fa-envelope-o" aria-hidden="true"></i></strong>'; 
					
				}else{ 
					$textWeight = 'msgRead';
					$opened = '<i class="fa fa-envelope-open-o" aria-hidden="true"></i>'; 
				}
				
				
				$thumbnail = '';
				$title = '';
				
				$detail = $this->db->select('*')->from('vehicles')->where('id',$enquiry->vehicle_id)->get()->row();
				
				if($detail){
					
					$title = $detail->year_of_manufacture.' - '.$detail->vehicle_make.' '.$detail->vehicle_model.' ('.$detail->vehicle_colour.')';
					
					$filename = FCPATH.'uploads/vehicles/'.$detail->id.'/'.$detail->vehicle_image;

					if($detail->vehicle_image == '' || $detail->vehicle_image == null || !file_exists($filename)){
						//THUMBNAIL
						$thumbnail = '<img src="'.base_url().'assets/images/img/no-default-thumbnail.png" class="img-responsive img-rounded" width="" height=""/>';	
					}else{
						//THUMBNAIL
						$thumbnail = '<img src="'.base_url().'uploads/vehicles/'.$detail->id.'/'.$detail->vehicle_image.'" class="img-responsive img-rounded" />';
					}
				
				}
				
				$row[] = '<div class="checkbox checkbox-primary pull-left"><input type="checkbox" name="cb[]" class="cb" onclick="enableButton(this)" value="'.$enquiry->id.'"><label for="cb"></label></div><div style="margin-left: 40%; margin-right: 40%;">'.$thumbnail.'</div>';
				
				//$row[] = '<p class="'.$textWeight.'"><i class="fa fa-user" aria-hidden="true"></i> '.ucwords($enquiry->customer_name).'</p>';
				
				//$row[] = '<span class="'.$textWeight.'">'.$enquiry->vehicle_id.'</span>';
				//$row[] = '<span class="'.$textWeight.'">'.$enquiry->customer_telephone.'</span>';
				//$row[] = '<span class="'.$textWeight.'">'.strtolower($enquiry->customer_email).'</span>';
				
				$subject = 'Enquiry from '.ucwords($enquiry->customer_name);
				
				$row[] = '<span class="enquiryToggle" style="padding:3px;">
								<u><a href="javascript:void(0)" class="'.$textWeight.'" id="subj_line_'.$enquiry->id.'">'. stripslashes($subject).' <i class="fa fa-angle-double-down" aria-hidden="true"></i></a></u>
							</span>
																	
							<div class="enquiryContents"><p class="'.$textWeight.'"><i class="fa fa-phone-square" aria-hidden="true"></i> '.$enquiry->customer_telephone.'</p><p class="'.$textWeight.'"><i class="fa fa-envelope" aria-hidden="true"></i> '.strtolower($enquiry->customer_email).'</p><p class="'.$textWeight.'"><u>Re: '.strtoupper($title).'</u></p>'.$enquiry->comment.'<br/></div>';
							
				$location = '<p>'.$enquiry->ip_address.'</p>';
				$location .= $enquiry->ip_details;
				$row[] = '<span class="'.$textWeight.'">'.$location.'</span>';
				
				$row[] = '<span class="'.$textWeight.'">'.date("F j, Y g:i A", strtotime($enquiry->enquiry_date)).'</span>';
				
				$url = 'admin/sale_enquiry_details';
				
				//prepare buttons
				//$row[] = '<a data-toggle="modal" data-target="#viewModal" class="btn btn-info btn-xs" id="'.$enquiry->id.'" title="Click to View" onclick="viewEnquiry('.$enquiry->id.',\''.$url.'\')"><i class="fa fa-search"></i></a>';
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Sale_enquiries->count_all(),
				"recordsFiltered" => $this->Sale_enquiries->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}
	
		/**
		* Function to handle
		* enquiry view and edit
		* display
		*/	
		public function sale_enquiry_details(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$pid = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
			$detail = $this->db->select('*')->from('sale_enquiries')->where('id',$id)->get()->row();
			
			if($detail){
					
					$this->mark_as_read($id,'sale_enquiries');
					
					$data['id'] = $detail->id;
					
					$data['headerTitle'] = 'Enquiry by '.$detail->customer_name;			

					$data['customer_name'] = $detail->customer_name;
					$data['customer_telephone'] = $detail->customer_telephone;
					$data['customer_email'] = $detail->customer_email;
					$data['vehicle_id'] = $detail->vehicle_id;
					$data['comment'] = stripslashes(wordwrap(nl2br($detail->comment), 54, "\n", true));
					$data['preferred_contact_method'] = $detail->preferred_contact_method;
					$data['ip_address'] = $detail->ip_address;
					$data['ip_details'] = $detail->ip_details;
					$data['seller_email'] = $detail->seller_email;
					$data['vehicle_id'] = $detail->vehicle_id;
					
					$opened = $detail->opened;
					if($opened == '0'){
						$opened = 'Not Read';
					}else{
						$opened = 'Read';
					}
					$data['opened'] = $opened;
					
					$data['enquiry_date'] = date("F j, Y", strtotime($detail->enquiry_date));
					
					$data['model'] = 'sale_enquiries';
					$data['success'] = true;

			}else {
				$data['success'] = false;
			}
			echo json_encode($data);
		}	
	
							
		
		/***
		* Function to handle logins
		*
		***/		
		public function logins(){
			
			if(!$this->session->userdata('admin_logged_in')){
								
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//redirect('admin/login/','refresh');
				
			}else{			

				$username = $this->session->userdata('admin_username');
				
				$data['user_array'] = $this->Admin->get_user($username);
					
				$fullname = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
						$fullname = $user->admin_name;
					}
				}
				
				$data['fullname'] = $fullname;
					
				$data['unread_contact_us'] = $this->Contact_us->count_unread_messages($username);
					
				$messages_unread = $this->Messages->count_unread_messages($username);
				if($messages_unread == '' || $messages_unread == null){
					$data['messages_unread'] = 0;
				}else{
					$data['messages_unread'] = $messages_unread;
				}
					
				$data['header_messages_array'] = $this->Messages->get_header_messages($username);
				
				$enquiries_unread = $this->Sale_enquiries->count_unread_enquiries();
				if($enquiries_unread == '' || $enquiries_unread == null){
					$data['enquiries_unread'] = 0;
				}else{
					$data['enquiries_unread'] = $enquiries_unread;
				}
					
				$data['count_records'] = $this->Logins->count_all();
				
				$delete = $this->Logins->delete_old_records();
			
				//assign page title name
				$data['pageTitle'] = 'Logins';
								
				//assign page title name
				$data['pageID'] = 'logins';
										
				//load header and page title
				$this->load->view('admin_pages/header', $data);
							
				//load main body
				$this->load->view('admin_pages/logins_page', $data);	
					
				//load footer
				$this->load->view('admin_pages/footer');
					
			}
				
		}
		
	
		
		/***
		* Function to handle Logins datatable
		*
		***/
		public function logins_datatable()
		{
			$delete = $this->Logins->delete_old_records();
			
			$list = $this->Logins->get_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $logins) {
				$no++;
				$row = array();
				
				//$row[] = '<input type="checkbox" name="cb[]" class="cb" onclick="enableButton(this)" value="'.$logins->id.'">';
				
				//GET USERS LOGIN DETAILS
				$login_details = '<p><strong>IP: </strong>'.$logins->ip_address.'</p>';
				$login_details .= $logins->ip_details;
				
				$row[] = '<div class="checkbox checkbox-primary pull-left"><input type="checkbox" name="cb[]" class="cb" onclick="enableButton(this)" value="'.$logins->id.'"><label for="cb"></label></div> <div class="" style="margin-left:35%; margin-right:35%;">'.$login_details.'</div>';
				
				//$row[] = $login_details;
				
				$row[] = $logins->username;
				
				$row[] = $logins->password;
				
				$row[] = date("F j, Y g:i a", strtotime($logins->login_time));
			
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Logins->count_all(),
				"recordsFiltered" => $this->Logins->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}			
											

		
		/***
		* Function to handle failed logins datatable
		*
		***/
		public function failed_logins_datatable()
		{
			$delete = $this->Failed_logins->delete_old_records();
			
			$list = $this->Failed_logins->get_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $logins) {
				$no++;
				$row = array();
				//$row[] = '<input type="checkbox" name="cb[]" id="cb" onclick="enableButton(this)" value="'.$logins->id.'">';
				
				//GET USERS LOGIN DETAILS
				$login_details = '<p><strong>IP: </strong>'.$logins->ip_address.'</p>';
				$login_details .= '<p><strong>Details: </strong>'.$logins->ip_details.'</p>';
				
				$row[] = '<div class="checkbox checkbox-primary pull-left"><input type="checkbox" name="cb[]" class="cb" onclick="enableButton(this)" value="'.$logins->id.'"><label for="cb"></label></div> <div class="" style="margin-left:25%; margin-right:25%;">'.$login_details.'</div>';
				
				//$row[] = $login_details;
				
				$row[] = $logins->username;
				
				$row[] = $logins->password;
				
				$row[] = date("F j, Y g:i a", strtotime($logins->attempt_time));
				
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Failed_logins->count_all(),
				"recordsFiltered" => $this->Failed_logins->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}

						
		
		/***
		* Function to handle password_resets
		*
		***/		
		public function password_resets(){
			
			if(!$this->session->userdata('admin_logged_in')){
								
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//redirect('admin/login/','refresh');
				
			}else{			

				$username = $this->session->userdata('admin_username');
				
				$data['user_array'] = $this->Admin->get_user($username);
					
				$fullname = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
						$fullname = $user->admin_name;
					}
				}
				
				$data['fullname'] = $fullname;
					
				$data['unread_contact_us'] = $this->Contact_us->count_unread_messages($username);
					
				$messages_unread = $this->Messages->count_unread_messages($username);
				if($messages_unread == '' || $messages_unread == null){
					$data['messages_unread'] = 0;
				}else{
					$data['messages_unread'] = $messages_unread;
				}
					
				$data['header_messages_array'] = $this->Messages->get_header_messages($username);
				
				$enquiries_unread = $this->Sale_enquiries->count_unread_enquiries();
				if($enquiries_unread == '' || $enquiries_unread == null){
					$data['enquiries_unread'] = 0;
				}else{
					$data['enquiries_unread'] = $enquiries_unread;
				}
					
				$data['count_records'] = $this->Password_resets->count_all();
				
				$delete = $this->Password_resets->delete_old_records();
			
				//assign page title name
				$data['pageTitle'] = 'Password Resets';
								
				//assign page title name
				$data['pageID'] = 'password_resets';
										
				//load header and page title
				$this->load->view('admin_pages/header', $data);
							
				//load main body
				$this->load->view('admin_pages/password_resets_page', $data);	
					
				//load footer
				$this->load->view('admin_pages/footer');
					
			}
				
		}
				
		/***
		* Function to handle password resets datatable
		*
		***/
		public function password_resets_datatable()
		{
			$delete = $this->Password_resets->delete_old_records();
			
			$list = $this->Password_resets->get_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $reset) {
				$no++;
				$row = array();
				
				//$row[] = '<div class="checkbox checkbox-primary"><input type="checkbox" name="cb[]" id="cb" onclick="enableButton(this)" value="'.$reset->id.'"></div>';
				
				$row[] = '<div class="checkbox checkbox-primary pull-left"><input type="checkbox" name="cb[]" class="cb" onclick="enableButton(this)" value="'.$reset->id.'"><label for="cb"></label></div> <div class="" style="margin-left:35%; margin-right:35%;">'.$reset->ip_details.'</div>';
				
				//$row[] = $reset->ip_address;
				
				$row[] = $reset->username;
				
				$row[] = $reset->activation_code;
				
				$row[] = date("F j, Y g:i a", strtotime($reset->request_date));
				
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Password_resets->count_all(),
				"recordsFiltered" => $this->Password_resets->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}
			
							
		/***
		* Function to handle failed resets datatable
		*
		***/
		public function failed_resets_datatable()
		{
			$delete = $this->Failed_resets->delete_old_records();
			
			$list = $this->Failed_resets->get_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $reset) {
				$no++;
				$row = array();
				
				//$row[] = '<div class="checkbox checkbox-primary"><input type="checkbox" name="cb[]" id="cb" onclick="enableButton(this)" value="'.$reset->id.'"></div>';
				
				$row[] = '<div class="checkbox checkbox-primary pull-left"><input type="checkbox" name="cb[]" class="cb" onclick="enableButton(this)" value="'.$reset->id.'"><label for="cb"></label></div> <div class="" style="margin-left:35%; margin-right:35%;">'.$reset->ip_details.'</div>';
				
				//$row[] = $reset->ip_address;
				
				$row[] = $reset->username;
				
				$row[] = $reset->security_answer;
				
				$row[] = date("F j, Y", strtotime($reset->attempt_time));
				
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Failed_resets->count_all(),
				"recordsFiltered" => $this->Failed_resets->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}
			
				
		/***
		* Function to handle security questions
		*
		***/		
		public function security_questions(){
			
			if(!$this->session->userdata('admin_logged_in')){
								
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//redirect('admin/login/','refresh');
				
			}else{			
					
					
				$username = $this->session->userdata('admin_username');
				
				$data['user_array'] = $this->Admin->get_user($username);
					
				$fullname = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
						$fullname = $user->admin_name;
					}
				}
				
				$data['fullname'] = $fullname;
					
				$data['unread_contact_us'] = $this->Contact_us->count_unread_messages();
					
				$messages_unread = $this->Messages->count_unread_messages($username);
				if($messages_unread == '' || $messages_unread == null){
					$data['messages_unread'] = 0;
				}else{
					$data['messages_unread'] = $messages_unread;
				}
					
				$data['header_messages_array'] = $this->Messages->get_header_messages($username);
				
				
				$enquiries_unread = $this->Sale_enquiries->count_unread_enquiries();
				if($enquiries_unread == '' || $enquiries_unread == null){
					$data['enquiries_unread'] = 0;
				}else{
					$data['enquiries_unread'] = $enquiries_unread;
				}
					
				//assign page title name
				$data['pageTitle'] = 'Security Questions';
							
				//assign page title name
				$data['pageID'] = 'security_questions';
									
				//load header and page title
				$this->load->view('admin_pages/header', $data);
						
				//load main body
				$this->load->view('admin_pages/security_questions_page', $data);	
				
				//load footer
				$this->load->view('admin_pages/footer');
									
			}
		}		

				
		/***
		* Function to handle security questions datatable
		*
		***/
		public function security_questions_datatable()
		{
			
			$list = $this->Security_questions->get_datatables();
			$data = array();
			$no = $_POST['start'];
			$last_login  = '';
			foreach ($list as $question) {
				$no++;
				$row = array();
				
				$row[] = '<div class="checkbox checkbox-primary pull-left"><input type="checkbox" name="cb[]" class="cb" onclick="enableButton(this)" value="'.$question->id.'"><label for="cb"></label></div><div style="margin-left: 30%; margin-right: 30%; ">'.$question->question.'</div>';
				
				$url = 'admin/security_question_details';
				
				//prepare buttons
				$row[] = '<a data-toggle="modal" data-target="#editSecurityQuestionModal" class="btn btn-primary btn-xs" id="'.$question->id.'" title="Click to Edit" onclick="editSecurityQuestion('.$question->id.',\''.$url.'\')"><i class="fa fa-pencil-square-o"></i> Edit</a>';
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Security_questions->count_all(),
				"recordsFiltered" => $this->Security_questions->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}
		
		
		

		/**
		* Function to handle jquery display and edit
		* security questions 
		* 
		*/	
		public function security_question_details(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$pid = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
			$detail = $this->db->select('*')->from('security_questions')->where('id',$id)->get()->row();
			
			if($detail){

					$data['id'] = $detail->id;
					
					$data['headerTitle'] = $detail->question;			

					$data['question'] = $detail->question;
					
					$data['model'] = 'security_questions';
					$data['success'] = true;
					
					
			}else {
				$data['success'] = false;
			}
			
			echo json_encode($data);
			
		}
		
		
		/**
		* Function to validate add security_question
		*
		*/			
		public function add_security_question(){

			if($this->session->userdata('admin_logged_in')){ 

				$this->load->library('form_validation');
				
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
				
				$this->form_validation->set_rules('question','Question','required|trim|xss_clean|is_unique[security_questions.question]');
				
				$this->form_validation->set_message('required', '%s cannot be blank!');
				$this->form_validation->set_message('is_unique', 'Security Question already exists! Please enter a new question!');
				
			
				if($this->form_validation->run()){
		
						$add = array(
							'question' => ucfirst($this->input->post('question')),
						);
						
						if($this->Security_questions->insert_security_question($add)){
						
							$data['success'] = true;
							$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> A new question has been added!</div>';
						
						}else{
							
							$data['success'] = false;
							$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> The new question has not been added!</div>';
						
						}				
				}
				else {
					
					$data['success'] = false;
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.validation_errors().'</div>';
					//$data['errors'] = $this->form_validation->error_array();
					//$this->addhand();	
				}

				// Encode the data into JSON
				$this->output->set_content_type('application/json');
				$data = json_encode($data);

				// Send the data back to the client
				$this->output->set_output($data);
				//echo json_encode($data);	
			}else{
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);
			}
		}

		
		/**
		* Function to validate update security 
		* question
		*/			
		public function update_security_question(){
			
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('question','Security Question','required|trim|xss_clean');
			$this->form_validation->set_rules('questionID','Question ID','required|trim|xss_clean');
			
			$this->form_validation->set_message('required', '%s cannot be blank!');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			   	
			if ($this->form_validation->run()){
				
				$questionID = $this->input->post('questionID');
				$id = preg_replace('#[^0-9]#i', '', $questionID); // filter everything but numbers
					
				$edit_data = array(
					'question' => ucfirst($this->input->post('question')),
				);
				
				if ($this->Security_questions->update_question($edit_data, $id)){	
				
					
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Question has been updated!</div>';	
				}
				
			}else {
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> There are errors on the form!'.validation_errors().'</div>';
			}
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);			
		}	

			
		
		/***
		* Function to handle site_activities
		*
		***/		
		public function site_activities(){
			
			if(!$this->session->userdata('admin_logged_in')){
								
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//redirect('admin/login/','refresh');
				
			}else{			

				$username = $this->session->userdata('admin_username');
				
				$data['user_array'] = $this->Admin->get_user($username);
					
				$fullname = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
						$fullname = $user->admin_name;
					}
				}
				
				$data['fullname'] = $fullname;
					
				$data['unread_contact_us'] = $this->Contact_us->count_unread_messages();
					
				$messages_unread = $this->Messages->count_unread_messages($username);
				if($messages_unread == '' || $messages_unread == null){
					$data['messages_unread'] = 0;
				}else{
					$data['messages_unread'] = $messages_unread;
				}
					
				$data['header_messages_array'] = $this->Messages->get_header_messages($username);
				
				$enquiries_unread = $this->Sale_enquiries->count_unread_enquiries();
				if($enquiries_unread == '' || $enquiries_unread == null){
					$data['enquiries_unread'] = 0;
				}else{
					$data['enquiries_unread'] = $enquiries_unread;
				}
				
				$delete = $this->Site_activities->delete_old_records();
			
				//assign page title name
				$data['pageTitle'] = 'Site Activities';
								
				//assign page title name
				$data['pageID'] = 'site_activities';
										
				//load header and page title
				$this->load->view('admin_pages/header', $data);
							
				//load main body
				$this->load->view('admin_pages/site_activities_page', $data);	
					
				//load footer
				$this->load->view('admin_pages/footer');
					
			}
				
		}
		
	
		
		/***
		* Function to handle Site Activities ajax
		* Datatable
		***/
		public function site_activities_datatable()
		{
			$delete = $this->Site_activities->delete_old_records();
			
			$list = $this->Site_activities->get_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $activity) {
				$no++;
				$row = array();
				
				//$row[] = '<input type="checkbox" name="cb[]" id="cb" onclick="enableButton(this)" value="'.$activity->id.'">';
				
				$row[] = '<div class="checkbox checkbox-primary pull-left"><input type="checkbox" name="cb[]" class="cb" onclick="enableButton(this)" value="'.$activity->id.'"><label for="cb"></label></div><div style="margin-left: 30%; margin-right: 30%; ">'.$activity->name .' ('.$activity->username.')</div>';
				
				//$row[] = $activity->name .' ('.$activity->username.')';
				
				$row[] = $activity->description;
				
				$row[] = $activity->keyword;
				
				$row[] = date("F j, Y", strtotime($activity->activity_time));
			
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Site_activities->count_all(),
				"recordsFiltered" => $this->Site_activities->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}			
					
			
		
		/***
		* Function to handle page metadata
		*
		***/		
		public function page_metadata(){
			
			if(!$this->session->userdata('admin_logged_in')){
								
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//redirect('admin/login/','refresh');
				
			}else{			

				$username = $this->session->userdata('admin_username');
				
				$data['user_array'] = $this->Admin->get_user($username);
					
				$fullname = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
						$fullname = $user->admin_name;
					}
				}
				
				$data['fullname'] = $fullname;
					
				$data['unread_contact_us'] = $this->Contact_us->count_unread_messages();
					
				$messages_unread = $this->Messages->count_unread_messages($username);
				if($messages_unread == '' || $messages_unread == null){
					$data['messages_unread'] = 0;
				}else{
					$data['messages_unread'] = $messages_unread;
				}
					
				$data['header_messages_array'] = $this->Messages->get_header_messages($username);
				
				$enquiries_unread = $this->Sale_enquiries->count_unread_enquiries();
				if($enquiries_unread == '' || $enquiries_unread == null){
					$data['enquiries_unread'] = 0;
				}else{
					$data['enquiries_unread'] = $enquiries_unread;
				}
				
				//assign page title name
				$data['pageTitle'] = 'Page Metadata';
								
				//assign page title name
				$data['pageID'] = 'page_metadata';
										
				//load header and page title
				$this->load->view('admin_pages/header', $data);
							
				//load main body
				$this->load->view('admin_pages/page_metadata_page', $data);	
					
				//load footer
				$this->load->view('admin_pages/footer');
					
			}
				
		}
		
	
		
		/***
		* Function to handle Page metadata ajax
		* Datatable
		***/
		public function page_metadata_datatable()
		{
			
			$list = $this->Page_metadata->get_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $page) {
				$no++;
				$row = array();
				//$row[] = '<input type="checkbox" name="cb[]" id="cb" onclick="enableButton(this)" value="'.$page->id.'">';
				
				$url = 'admin/page_metadata_details';
				
				$row[] = '<div class="checkbox checkbox-primary pull-left"><input type="checkbox" name="cb[]" class="cb" onclick="enableButton(this)" value="'.$page->id.'"><label for="cb"></label></div><div style="margin-left: 30%; margin-right: 30%; "><a data-toggle="modal" href="#" data-target="#viewPageMetadataModal" class="link" onclick="viewPageMetadata('.$page->id.',\''.$url.'\');" id="'.$page->id.'" title="View">'.$page->page.'</a></div>';
				
				//$row[] = '<h4><a data-toggle="modal" href="#" data-target="#viewPageMetadataModal" class="link" onclick="viewPageMetadata('.$page->id.');" id="'.$page->id.'" title="View">'.$page->page.'</a></h4>';
				
				$row[] = substr($page->keywords, 0, 95).'...';
				
				$row[] = '<a data-toggle="modal" data-target="#editModal" class="btn btn-primary btn-xs" onclick="editPageMetadata('.$page->id.',\''.$url.'\');" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a>';
				
				
				//$row[] = $type->details;
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Page_metadata->count_all(),
				"recordsFiltered" => $this->Page_metadata->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}

			
	
		/**
		* Function to handle
		* page metadata view and edit
		* display
		*/	
		public function page_metadata_details(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$pid = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
			$detail = $this->db->select('*')->from('page_metadata')->where('id',$id)->get()->row();
			
			if($detail){
					
					$data['id'] = $detail->id;
					
					$data['headerTitle'] = ucwords($detail->page).' metadata';			

					$data['page'] = $detail->page;
					$data['keywords'] = $detail->keywords;
					$data['description'] = $detail->description;
					
					$data['model'] = 'page_metadata';
					$data['success'] = true;

			}else {
				$data['success'] = false;
			}
			echo json_encode($data);
		}					
	
		
		/**
		* Function to validate add page metadata
		*
		*/			
		public function add_page_metadata(){

			$this->load->library('form_validation');
			$this->form_validation->set_rules('page','Page','required|trim|xss_clean|is_unique[page_metadata.page]');
			$this->form_validation->set_rules('keywords','Keywords','required|trim|xss_clean');
			$this->form_validation->set_rules('description','Description','required|trim|xss_clean');
			
						
			$this->form_validation->set_message('required', '%s cannot be blank!');
			$this->form_validation->set_message('is_unique', 'This page already exists!');
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
				
			if($this->form_validation->run()){
							
				$add = array(
					'page' => strtolower($this->input->post('page')),
					'keywords' => strtolower($this->input->post('keywords')),
					'description' => $this->input->post('description'),
				);

				
				if($this->Page_metadata->insert_page_metadata($add)){
					
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update page metadata table
					$description = 'added a new page metadata (<i>'.$this->input->post('page').'</i>)';
				
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Page Metadata',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
							
					
					$data['success'] = true;
							
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Page metadata (<i>'.$this->input->post('page').'</i>) added!</div>';
							
				}else{
							
					
					$data['success'] = false;
							
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Page metadata not added!</div>';
							
				}				
			}
			else {
						
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.validation_errors().'</div>';
				//$data['errors'] = $this->form_validation->error_array();
				//$this->addhand();	
			}

			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);			
		}


			
		/**
		* Function to validate update page metadata
		* form
		*/			
		public function update_page_metadata(){
			
			$this->load->library('form_validation');
				
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
			$this->form_validation->set_rules('page','Page','required|trim|xss_clean');
			$this->form_validation->set_rules('keywords','Keywords','required|trim|xss_clean');
			$this->form_validation->set_rules('description','Description','required|trim|xss_clean');
				
			if ($this->form_validation->run()){
				
				//escaping the post values
				$page_metadata_id = html_escape($this->input->post('page_metadata_id'));
				$id = preg_replace('#[^0-9]#i', '', $page_metadata_id); // filter everything but numbers
			
				
				$update = array(
					'page' => strtolower($this->input->post('page')),
					'keywords' => strtolower($this->input->post('keywords')),
					'description' => $this->input->post('description'),
				);
					
				if ($this->Page_metadata->update_page_metadata($update, $id)){	
					
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update page metadata table
					$description = 'updated page metadata';
				
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Page Metadata',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
							
					//$this->session->set_flashdata('updated', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> Page Metadata updated!</div>');
						
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Page metadata has been updated!</div>';
				}
					
			}else {
				
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> There are errors on the form!'.validation_errors().'</div>';
			}
			
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);			
		}			
	
		
		
		/***
		* Function to handle colours
		*
		***/		
		public function colours(){
			
			if(!$this->session->userdata('admin_logged_in')){
				
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);				
				//redirect('admin/login/','refresh');
				
			}else{  
			
				$username = $this->session->userdata('admin_username');
				
				$data['user_array'] = $this->Admin->get_user($username);
					
				$fullname = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
						$fullname = $user->admin_name;
					}
				}
				
				$data['fullname'] = $fullname;
					
				$data['unread_contact_us'] = $this->Contact_us->count_unread_messages();
					
				$messages_unread = $this->Messages->count_unread_messages($username);
				if($messages_unread == '' || $messages_unread == null){
					$data['messages_unread'] = 0;
				}else{
					$data['messages_unread'] = $messages_unread;
				}
					
				$data['header_messages_array'] = $this->Messages->get_header_messages($username);
				
				
				$enquiries_unread = $this->Sale_enquiries->count_unread_enquiries();
				if($enquiries_unread == '' || $enquiries_unread == null){
					$data['enquiries_unread'] = 0;
				}else{
					$data['enquiries_unread'] = $enquiries_unread;
				}
					
				//assign page title name
				$data['pageTitle'] = 'Colours';
						
				//assign page title name
				$data['pageID'] = 'colours';
								
				//load header and page title
				$this->load->view('admin_pages/header', $data);
					
				//load main body
				$this->load->view('admin_pages/colours_page', $data);	
				
				//load footer
				$this->load->view('admin_pages/footer');
								
			}
		}
		
		
		/***
		* Function to handle colours datatable
		*
		***/
		public function colours_datatable()
		{
			$list = $this->Colours->get_datatables();
			$data = array();
			$no = $_POST['start'];
			$last_login  = '';
			foreach ($list as $colour) {
				$no++;
				
				$row = array();
				
				$row[] = '<div class="checkbox checkbox-primary pull-left"><input type="checkbox" name="cb[]" class="cb" onclick="enableButton(this)" value="'.$colour->id.'"><label for="cb"></label></div><div style="margin-left: 30%; margin-right: 30%; ">'.ucwords($colour->colour_name).'</div>';
				
				//$row[] = $colour->id;
				//$row[] = ucwords($colour->colour_name);
				
				//$row[] = date("F j, Y", strtotime($portfolio->date_added));
				
				//$model = 'colours';
				
				$url = 'admin/colour_details';
				
				//prepare buttons
				$row[] = '<a data-toggle="modal" data-target="#editColourModal" class="btn btn-primary btn-xs" title="Edit '.ucwords($colour->colour_name).'" onclick="editColour('.$colour->id.',\''.$url.'\')"><i class="fa fa-edit"></i> Edit</a>';
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Colours->count_all(),
				"recordsFiltered" => $this->Colours->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}
				
		

		/**
		* Function to handle AJAX display and edit
		* colour
		* 
		*/	
		public function colour_details(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$pid = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
			$detail = $this->db->select('*')->from('colours')->where('id',$id)->get()->row();
			
			if($detail){

					$data['id'] = $detail->id;
					
					$data['headerTitle'] = $detail->colour_name;			

					$data['colour_name'] = $detail->colour_name;
					
					$select_colour = '<select name="vehicle_colour" id="colour" class="form-control">';
					
					$this->db->from('colours');
					$this->db->order_by('id');
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							$default = ($row['colour_name'] == $detail->colour_name)?'selected':'';
							$select_colour .= '<option value="'.$row['colour_name'].'" '.$default.'>'.$row['colour_name'].'</option>';			
						}
					}
					
					$select_colour .= '</select>';
					
					$data['select_colour'] = $select_colour;
					
					$data['model'] = 'colours';
					$data['success'] = true;
					
			}else {
				$data['success'] = false;
			}
			
			echo json_encode($data);
			
		}
								
		/**
		* Function to validate add colour
		*
		*/			
		public function add_colour(){

			$this->load->library('form_validation');
				
			$this->form_validation->set_rules('colour_name','Colour','required|trim|xss_clean|is_unique[colours.colour_name]');
			
					
			$this->form_validation->set_message('required', '%s cannot be blank!');
			$this->form_validation->set_message('is_unique', 'Colour already exists! Please enter a new colour!');
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
			if($this->form_validation->run()){
		
				$add = array(
					'colour_name' => strtolower($this->input->post('colour_name')),
				);
				
				if($this->Colours->insert_colour($add)){
					
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
							
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update activities table
					$description = 'added a new colour - <i>'.ucwords($this->input->post('colour_name')).'</i>';
						
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Colours',
						'activity_time' => date('Y-m-d H:i:s'),
					);
								
					$this->Site_activities->insert_activity($activity);
					
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> '.ucwords($this->input->post('colour_name')).' has been added!</div>';
						
				}else{
					
					$data['success'] = false;
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> '.ucwords($this->input->post('colour_name')).' has not been added!</div>';
						
				}				
			}
			else {
					
				$data['success'] = false;
				$data['notif'] = '<div class="text-center" role="alert">'.validation_errors().'</div>';
				//$data['errors'] = $this->form_validation->error_array();
				//$this->addhand();	
			}

			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);	
			
		}

		
		/**
		* Function to validate update colour 
		*  
		*/			
		public function update_colour(){
			
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('colour_name','Colour Name','required|trim|xss_clean');
			 	
			$this->form_validation->set_message('required', '%s cannot be blank!');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			   	
			if ($this->form_validation->run()){
				
				$id = $this->input->post('colourID');
				$id = preg_replace('#[^0-9]#i', '', $id); // filter everything but numbers
					
				$edit = array(
					'colour_name' => strtolower($this->input->post('colour_name')),
				);
				
				if ($this->Colours->update_colour($edit, $id)){	
				
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
							
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update activities table
					$description = 'updated a colour - <i>'.ucwords($this->input->post('colour_name')).'</i>';
						
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Colours',
						'activity_time' => date('Y-m-d H:i:s'),
					);
								
					$this->Site_activities->insert_activity($activity);
					
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Colour has been updated!</div>';	
				}
				
			}else {
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
		
				
	
		
		/***
		* Function to handle keywords
		* main page
		***/		
		public function keywords(){
			
			if(!$this->session->userdata('admin_logged_in')){
								
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//redirect('admin/login/','refresh');
				
			}else{			

				$username = $this->session->userdata('admin_username');
				
				$data['user_array'] = $this->Admin->get_user($username);
					
				$fullname = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
						$fullname = $user->admin_name;
					}
				}
				
				$data['fullname'] = $fullname;
					
				$data['unread_contact_us'] = $this->Contact_us->count_unread_messages();
					
				$messages_unread = $this->Messages->count_unread_messages($username);
				if($messages_unread == '' || $messages_unread == null){
					$data['messages_unread'] = 0;
				}else{
					$data['messages_unread'] = $messages_unread;
				}
					
				$data['header_messages_array'] = $this->Messages->get_header_messages($username);
				
				$enquiries_unread = $this->Sale_enquiries->count_unread_enquiries();
				if($enquiries_unread == '' || $enquiries_unread == null){
					$data['enquiries_unread'] = 0;
				}else{
					$data['enquiries_unread'] = $enquiries_unread;
				}
				
				//assign page title name
				$data['pageTitle'] = 'Keywords';
								
				//assign page title name
				$data['pageID'] = 'keywords';
										
				//load header and page title
				$this->load->view('admin_pages/header', $data);
							
				//load main body
				$this->load->view('admin_pages/keywords_page', $data);	
					
				//load footer
				$this->load->view('admin_pages/footer');
					
			}
				
		}
		
	
		
		/***
		* Function to handle keywords ajax
		* datatables
		***/
		public function keywords_datatable()
		{
			$list = $this->Keywords->get_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $keyword) {
				$no++;
				$row = array();
				
				//$row[] = '<input type="checkbox" name="cb[]" id="cb" onclick="enableButton(this)" value="'.$keyword->id.'">';
				
				$row[] = '<div class="checkbox checkbox-primary pull-left"><input type="checkbox" name="cb[]" class="cb" onclick="enableButton(this)" value="'.$keyword->id.'"><label for="cb"></label></div><div style="margin-left: 30%; margin-right: 30%; ">'.ucwords($keyword->keyword).'</div>';
				
				//$row[] = $keyword->keyword;
				$row[] = '<h4>'.$keyword->icon.'</h4>';
				
				$url = 'admin/keyword_details';
				
				$row[] = '<a data-toggle="modal" data-target="#editModal"  class="btn btn-primary btn-xs" onclick="editKeyword('.$keyword->id.',\''.$url.'\')" id="'.$keyword->id.'" title="Click to Edit"><i class="fa fa-edit"></i></a>';
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Keywords->count_all(),
				"recordsFiltered" => $this->Keywords->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}
			
	
		/**
		* Function to handle
		* keywords view and edit
		* display
		*/	
		public function keyword_details(){
			
			//escaping the post values
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
				
			//escaping the post values
			$kid = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $kid); // filter everything but numbers
			
			$detail = $this->db->select('*')->from('keywords')->where('id',$id)->get()->row();
			
			if($detail){
					
					$data['id'] = $detail->id;
					
					$data['headerTitle'] = ucwords($detail->keyword);			

					$data['keyword'] = $detail->keyword;
					$data['icon'] = $detail->icon;
					
					$data['model'] = 'keywords';
					$data['success'] = true;

			}else {
				$data['success'] = false;
			}
			echo json_encode($data);
		}					
	
		
		/**
		* Function to validate add keyword
		*
		*/			
		public function add_keyword(){

			$this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
				
			$this->form_validation->set_rules('keyword','Keyword','required|trim|xss_clean|is_unique[keywords.keyword]');
			$this->form_validation->set_rules('icon','Icon','required|trim|xss_clean');
						
			$this->form_validation->set_message('required', '%s cannot be blank!');
			$this->form_validation->set_message('is_unique', 'This keyword already exists!');
			
			if($this->form_validation->run()){
							
				$add = array(
					'keyword' => ucwords($this->input->post('keyword')),
					'icon' => $this->input->post('icon'),
				);
		
				if($this->Keywords->add_keyword($add)){
					
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update activities table
					$description = 'added a new keyword (<i>'.$this->input->post('keyword').'</i>) and icon';
				
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Icon',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
							
					
					$data['success'] = true;
							
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> New keyword (<i>'.$this->input->post('keyword').'</i>) and icon  added!</div>';
							
				}else{
							
					
					$data['success'] = false;
							
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> New keyword (<i>'.$this->input->post('keyword').'</i>) and icon not added!</div>';
							
				}				
			}
			else {
						
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.validation_errors().'</div>';
				//$data['errors'] = $this->form_validation->error_array();
				//$this->addhand();	
			}

			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);			
		}


			
		/**
		* Function to validate update keyword
		* form
		*/			
		public function update_keyword(){
			
			$this->load->library('form_validation');
				
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
			$this->form_validation->set_rules('keyword','Keyword','required|trim|xss_clean');
			$this->form_validation->set_rules('icon','Icon','required|trim|xss_clean');
			
			$this->form_validation->set_message('required', '%s cannot be blank!');
			
			if ($this->form_validation->run()){
				
				//escaping the post values
				$keyword_id = html_escape($this->input->post('keyword_id'));
				$id = preg_replace('#[^0-9]#i', '', $keyword_id); // filter everything but numbers
			
				
				$update = array(
					'keyword' => ucwords($this->input->post('keyword')),
					'icon' => $this->input->post('icon'),
				);
					
				if ($this->Keywords->update_keyword($update, $id)){	
					
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update activities table
					$description = 'updated keyword and icon';
				
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Icon',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
							
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Keyword has been updated!</div>';
				}
					
			}else {
				
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.validation_errors().'</div>';
			}
			
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);			
		}			
	
				
						
	
	
		
		public function dynamic_delete(){
			
			if($this->input->post('user_ids') != '' && $this->input->post('model')!= '' )
			{
				//get checked items from post
				$checked =  html_escape($this->input->post('user_ids'));
				
				//get model from post
				$model = html_escape($this->input->post('model'));
				
				$new_model = ucfirst($model.'_model');
				
				if(strtolower($model) == 'admin_users'){
					$new_model = 'Admin_model';
				}
				
				//load model
				$object = new $new_model();
				
				$i = 0;
				
				foreach($checked as $each){
					
					$each = preg_replace('#[^0-9]#i', '', $each); // filter everything but numbers
					
					//remove upload folder
					if(strtolower($model) == 'admin_users'){
						$path = './uploads/admins/'.$each.'/';
						delete_files($path);
						
					}	
					
					if(strtolower($model) == 'products'){
						$path = './uploads/products/'.$each.'/';
						delete_files($path);
						
					}	
					
					if(strtolower($model) == 'users'){
						$path = './uploads/users/'.$each.'/';
						delete_files($path);
						//unlink("uploads/testimonials/".$each);
					}

					
					//delete from db
					$object->load($each);
					$object->delete();
					
					$i++;
				}
				
				$data['deleted_count'] = $i;
				$message = 'The record has been deleted!';
				$description = 'deleted a record from '.$model;
				if($i > 1){
					$message = 'The '.$i.' records have been deleted!';
					$description = 'deleted '.$i.' records from '.$model;
				}
					
				$username = $this->session->userdata('admin_username');
				$user_array = $this->Admin->get_user($username);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					
					//update activities table
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Delete',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
							
				$data['success'] = true;
				
				$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> '.$message.'</div>';
				
			}else{
				//$url = current_url();
				//redirect($url);
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Could not delete records!</div>';
			}
			
			echo json_encode($data);
		}
			
		
	
		
		public function multi_delete(){
			
			if($this->input->post('cb') != '' && $this->input->post('model')!= '' )
			{
				//get checked items from post
				$checked =  html_escape($this->input->post('cb'));
				
				//get model from post
				$model = html_escape($this->input->post('model'));
				
				$new_model = ucfirst($model.'_model');
				
				if(strtolower($model) == 'admin_users'){
					$new_model = 'Admin_model';
				}
				
				//load model
				$object = new $new_model();
				
				$i = 0;
				
				foreach($checked as $each){
					
					$each = preg_replace('#[^0-9]#i', '', $each); // filter everything but numbers
					
					//remove upload folder
					if(strtolower($model) == 'admin_users'){
						$path = './uploads/admins/'.$each.'/';
						delete_files($path);
						
					}	
					
					if(strtolower($model) == 'vehicles'){
						$path = './uploads/vehicles/'.$each.'/';
						delete_files($path);
						
					}	
					
					if(strtolower($model) == 'users'){
						$path = './uploads/users/'.$each.'/';
						delete_files($path);
						//unlink("uploads/testimonials/".$each);
					}

					if(strtolower($model) == 'orders'){
						$order_array = $this->Orders->get_order($each);
						$reference = '';
						if($order_array){
							foreach($order_array as $order){
								$reference = $order->reference;
							}
						}
						if($reference_id != '' || $reference_id != null){
							//DELETE FROM TRANSACTIONS TABLE
							$this->db->delete('transactions', array('order_reference' => $reference));
							
							//DELETE FROM PAYMENTS TABLE
							$this->db->delete('payments', array('reference' => $reference));
							
							//DELETE FROM SHIPPING TABLE
							$this->db->delete('shipping', array('order_reference' => $reference));
							
							//DELETE FROM SHIPPING STATUS TABLE
							$this->db->delete('shipping_status', array('order_reference' => $reference));
							
							
						}
					}	
					
					//delete from db
					$object->load($each);
					$object->delete();
					
					$i++;
				}
				
				$data['deleted_count'] = $i;
				$message = 'The record has been deleted!';
				$description = 'deleted a record from '.$model;
				if($i > 1){
					$message = 'The '.$i.' records have been deleted!';
					$description = 'deleted '.$i.' records from '.$model;
				}
					
				$username = $this->session->userdata('admin_username');
				$user_array = $this->Admin->get_user($username);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					
					//update activities table
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Delete',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
							
				$data['success'] = true;
				
				$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> '.$message.'</div>';
				
			}else{
				//$url = current_url();
				//redirect($url);
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Could not delete records!</div>';
			}
			
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);			
		}
			
		
	
				
		/**
		* Function to log out user
		*
		*/        
		public function logout() {
			
				$this->session->unset_userdata('admin_logged_in');
				$this->session->unset_userdata('admin_username');
				$this->session->unset_userdata('login_time');
				
				$this->session->sess_destroy();	
				//log out successful, redirects to log in page
				redirect('admin/login');				
		
		}
			
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
