<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

		/**
		 * Index Page for this controller.
		 *
		 */
		public function __construct() {
			
				parent:: __construct();
		}	 
		
		
		public function index()
		{
			
			$data['testimonials_array'] = $this->Testimonials->get_testimonials(3, 0);
								
			//assign meta tags
			$page = 'home';
			$keywords = '';
			$description = '';
			$metadata_array = $this->Page_metadata->get_page_metadata($page);
			if($metadata_array){
				foreach($metadata_array as $meta){
					$keywords = $meta->keywords;
					$description = $meta->description;
				}
			}
			if($description == '' || $description == null){
				$description = 'Dejor Autos - one stop shop for new and used vehicles';
			}
			//assign meta_description
			$data['meta_description'] = $description;
			
			//assign meta_author
			$data['meta_author'] = 'Dejor Autos';
			
			//assign meta_keywords		
			$data['meta_keywords'] = $keywords;
			
			//assign page title name
			$data['pageTitle'] = 'Dejor Autos';
				
			//assign page ID
			$data['pageID'] = 'home';
			
			$this->load->view('pages/header', $data);
			
			$this->load->view('pages/home_page', $data);
				
			$this->load->view('pages/footer', $data);
		}
		
		/**
		 * Function for About Page.
		 *
		 */
		public function about()
		{
			
			$data['members_array'] = $this->Team_members->get_members(4, 0);
								
			//assign meta tags
			$page = 'about';
			$keywords = '';
			$description = '';
			
			$metadata_array = $this->Page_metadata->get_page_metadata($page);
			
			if($metadata_array){
				foreach($metadata_array as $meta){
					$keywords = $meta->keywords;
					$description = $meta->description;
				}
			}
			if($description == '' || $description == null){
				$description = 'Dejor Autos - one stop shop for new and used vehicles';
			}
			
			//assign meta_description
			$data['meta_description'] = $description;
			
			//assign meta_author
			$data['meta_author'] = 'Dejor Autos';
			
			//assign meta_keywords		
			$data['meta_keywords'] = $keywords;

			//assign page title name
			$data['pageTitle'] = 'About Us';
				
			//assign page ID
			$data['pageID'] = 'about';
			
			$this->load->view('pages/header', $data);
			
			$this->load->view('pages/about_page', $data);
				
			$this->load->view('pages/footer', $data);
		}
		
			
		/**
		 * Function for Services Page.
		 *
		 */
		public function services()
		{
			
			//escaping the post values
			$this->input->get(NULL, TRUE); // returns all GET items with XSS filter
			
			$data['active_tab_history_check'] = '';
			$data['active_tab_buyers_guide'] = '';
			$data['active_tab_car_check'] = '';
			$data['active_tab_car_insurance'] = '';
			$data['active_tab_customer_support'] = '';
			$data['active_tab_warranty'] = '';
			
			//get items from post
			$tab = html_escape($this->input->get('p'));
			$tab = trim($tab);
			
			if($tab != ''){
				
				$data['active_tab_history_check'] = ($tab == 'history-check') ? 'active' : '';
				$data['active_tab_buyers_guide'] = ($tab == 'buyers-guide') ? 'active' : '';
				$data['active_tab_car_check'] = ($tab == 'car-check') ? 'active' : '';
				$data['active_tab_car_insurance'] = ($tab == 'car-insurance') ? 'active' : '';
				$data['active_tab_customer_support'] = ($tab == 'customer-support') ? 'active' : '';
				$data['active_tab_warranty'] = ($tab == 'warranty-programs') ? 'active' : '';
			}else{
				$data['active_tab_history_check'] = 'active';
			}
			
			//assign meta tags
			$page = 'services';
			$keywords = '';
			$description = '';
			$metadata_array = $this->Page_metadata->get_page_metadata($page);
			if($metadata_array){
				foreach($metadata_array as $meta){
					$keywords = $meta->keywords;
					$description = $meta->description;
				}
			}
			if($description == '' || $description == null){
				$description = 'Dejor Autos - one stop shop for new and used vehicles';
			}
			//assign meta_description
			$data['meta_description'] = $description;
			
			//assign meta_author
			$data['meta_author'] = 'Dejor Autos';
			
			//assign meta_keywords		
			$data['meta_keywords'] = $keywords;

			//assign page title name
			$data['pageTitle'] = 'Services';
				
			//assign page ID
			$data['pageID'] = 'services';
			
			$this->load->view('pages/header', $data);
			
			$this->load->view('pages/services_page', $data);
				
			$this->load->view('pages/footer', $data);
		}
						
			
		/**
		 * Function for Gallery Page.
		 *
		 */
		public function gallery()
		{
							
			//assign meta tags
			$page = 'gallery';
			$keywords = '';
			$description = '';
			$metadata_array = $this->Page_metadata->get_page_metadata($page);
			if($metadata_array){
				foreach($metadata_array as $meta){
					$keywords = $meta->keywords;
					$description = $meta->description;
				}
			}
			if($description == '' || $description == null){
				$description = 'Dejor Autos - one stop shop for new and used vehicles';
			}
			//assign meta_description
			$data['meta_description'] = $description;
			
			//assign meta_author
			$data['meta_author'] = 'Dejor Autos';
			
			//assign meta_keywords		
			$data['meta_keywords'] = $keywords;

			//assign page title name
			$data['pageTitle'] = 'Gallery';
				
			//assign page ID
			$data['pageID'] = 'gallery';
			
			$this->load->view('pages/header', $data);
			
			$this->load->view('pages/gallery_page', $data);
				
			$this->load->view('pages/footer', $data);
		}
						
			
		/**
		 * Function for Gallery Page.
		 *
		 */
		public function team($id = -1, $name = '', $rnd = '')
		{
			//escaping the post values
			$pid = html_escape($id);
			$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
			$name = html_escape($name);
			$name = trim($name);
			
			$rnd = html_escape($rnd);
			$rnd = trim($rnd);
										
			$member_array = $this->Team_members->get_member_by_id($id);
			
			if($member_array){
				
				$member_id = '';
				$member_name = '';
				
				
				foreach($member_array as $member){
					$member_id = $member->id;
					
					$member_name = $member->first_name .' '.$member->last_name;
					
					$data['member_name'] = ucwords($member_name);
					
					$data['avatar'] = '<img title="'.ucwords($member_name).'" alt="'.ucwords($member_name).'" id="main-img" class="img-responsive" src=
						"'.base_url().'uploads/members/'.$member->id.'/'.$member->avatar.'">';
					
					$data['facebook'] = $member->facebook;
					$data['twitter'] = $member->twitter;
					$data['google'] = $member->google;
					$data['position'] = $member->position;
					$data['bio_long'] = $member->bio_long;
					//$data['position'] = $member->position;
					
				}
				
				//assign meta tags
				$page = 'team';
				$keywords = '';
				$description = '';
				$metadata_array = $this->Page_metadata->get_page_metadata($page);
				if($metadata_array){
					foreach($metadata_array as $meta){
						$keywords = $meta->keywords;
						$description = $meta->description;
					}
				}
				if($description == '' || $description == null){
					$description = 'Dejor Autos - one stop shop for new and used vehicles';
				}
				//assign meta_description
				$data['meta_description'] = ucwords($member_name);
				
				//assign meta_author
				$data['meta_author'] = 'Dejor Autos';
				
				//assign meta_keywords		
				$data['meta_keywords'] = $keywords;

				//assign page title name
				$data['pageTitle'] = ucwords($member_name).' Profile';
					
				//assign page ID
				$data['pageID'] = 'team';
				
				$this->load->view('pages/header', $data);
				
				$this->load->view('pages/team_member_page', $data);
					
				$this->load->view('pages/footer', $data);

				
			}else{
				redirect('about');
			}

		}
									
		/**
		 * Function for Contact Us Page.
		 *
		 */
		public function contact_us()
		{
							
			//assign meta tags
			$page = 'contact';
			$keywords = '';
			$description = '';
			$metadata_array = $this->Page_metadata->get_page_metadata($page);
			if($metadata_array){
				foreach($metadata_array as $meta){
					$keywords = $meta->keywords;
					$description = $meta->description;
				}
			}
			if($description == '' || $description == null){
				$description = 'Dejor Autos - one stop shop for new and used vehicles';
			}
			//assign meta_description
			$data['meta_description'] = $description;
			
			//assign meta_author
			$data['meta_author'] = 'Dejor Autos';
			
			//assign meta_keywords		
			$data['meta_keywords'] = $keywords;

			//assign page title name
			$data['pageTitle'] = 'Contacts';
				
			//assign page ID
			$data['pageID'] = 'contact_us';
			
			$this->load->view('pages/header', $data);
			
			$this->load->view('pages/contact_us_page', $data);
				
			$this->load->view('pages/footer', $data);
		}
		

		/**
		* Function to validate messages from 
		* the contact us page
		*/			
		public function contact_us_validation() {
            
            $this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
            $this->form_validation->set_rules('contact_us_name','Name','required|trim|xss_clean|min_length[4]|callback_check_double_messaging|callback_max_ip_daily_messaging|callback_max_user_daily_messaging');
            $this->form_validation->set_rules('contact_us_telephone','Telephone number','required|trim|xss_clean|regex_match[/^[0-9\+\(\)\/-]+$/]');
			$this->form_validation->set_rules('contact_us_email','Email','required|trim|valid_email');
			$this->form_validation->set_rules('contact_us_subject','Subject','required|trim|xss_clean|min_length[2]');
			$this->form_validation->set_rules('contact_us_message','Message','required|trim|xss_clean|min_length[6]');
            
			$this->form_validation->set_message('required', '%s cannot be blank!');
			$this->form_validation->set_message('min_length', '%s must be longer!');
			$this->form_validation->set_message('regex_match', 'Please enter a valid phone number!');
			$this->form_validation->set_message('valid_email', 'Please enter a valid email!');
			
			if ($this->form_validation->run()){
				
				//obtain users ip address
				$ipaddress = $this->Logins->ip();	
							
				//default function
				$ip = $this->input->ip_address();
					
				//ipinfo 
				//$details = $this->misc_lib->ip_details($ipaddress);
					
				//localhost
				$whitelist = array('127.0.0.1', '::1');	
				
				$ipdetails = '';
				
				if(!in_array($ipaddress, $whitelist)){
					//ipinfo 
					$details = $this->misc_lib->ip_details($ipaddress);
					$ipdetails .= '<p><strong> IP:</strong> '.$ipaddress.'</p>';
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
			
				//array of all post variables
				$contact_data = array(
					'contact_name' => $this->input->post('contact_us_name'),
					'contact_telephone' => $this->input->post('contact_us_telephone'),
					'contact_email' => $this->input->post('contact_us_email'),
					'contact_subject' => $this->input->post('contact_us_subject'),
					'contact_message' => $this->input->post('contact_us_message'),
					'ip_address' => $ipaddress,
					'ip_details' => $ipdetails,
					'contact_us_date' => date('Y-m-d H:i:s'),
				);
				
				if($this->Contact_us->add_contact_us($contact_data)){
						
					$to = 'getextra@gmail.com';
					$subject = 'Contact Us Message From '. $this->input->post('contact_us_name');
					$full_name = $this->input->post('contact_us_name');
					
					//COMPOSE EMAIL MESSAGE
					$message = "<h3><u>Contact Us Message From ".ucwords($this->input->post('contact_us_name'))."</u></h3>";
					$message .= "<p><strong>Name:</strong> ". $this->input->post('contact_us_name'). ",</p>";
					$message .= "<p><strong>Telephone:</strong> ". $this->input->post('contact_us_telephone').",</p>";
					$message .= "<p><strong>Email:</strong> ". $this->input->post('contact_us_email'). ",</p>";
					$message .= "<p><strong>Subject:</strong> ". $this->input->post('contact_us_subject'). ",</p>";
					$message .= "<p><strong>Message:</strong> ". $this->input->post('contact_us_message'). ",</p>";
					$message .= "<p><strong>IP:</strong> ". $ipaddress. ",</p>";
					$message .= "<p><strong>Location:</strong> ". $ipdetails. ",</p>";
						
					$this->Messages->send_email_alert($to, $subject, $full_name, $message);
						
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Message sent!</div>';

				}else{
					$data['success'] = false;
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Message not sent!</div>';
				}
					
			}else {
					//redirects to contact us page
					//$this->contact_us();	
					$data['success'] = false;
					$data['notif'] = '<div class="text-center" role="alert">'.validation_errors().'</div>';
					$data['errors'] = '<div class="text-center" role="alert">'.validation_errors().'</div>';
					
			}
                echo json_encode($data);
        }

		/**
		* Function to check_double_post 
		* 
		*/			
		public function check_double_messaging(){
			
			//obtain users ip address
			$ipaddress = $this->Logins->ip();

			$date = date("Y-m-d H:i:s",time());
			$date = strtotime($date);
			$min_date = strtotime("-20 second", $date);
			
			$max_date = date('Y-m-d H:i:s', time());
			$min_date = date('Y-m-d H:i:s', $min_date);
			
			$this->db->select('*');
			$this->db->from('contact_us');
			$this->db->where('ip_address', $ipaddress);
			
			$this->db->where("contact_us_date BETWEEN '$min_date' AND '$max_date'", NULL, FALSE);

			$query = $this->db->get();
			
			if ($query->num_rows() >= 1){	
				$this->form_validation->set_message('check_double_messaging', 'You must wait at least 20 seconds before you send another message!');
				return FALSE;
			}else {
				
				return TRUE;
			}	
		}			

		/**
		* Function to limit daily IP address 
		* max messages
		*/			
		public function max_ip_daily_messaging(){
			
			//obtain users ip address
			$ipaddress = $this->Logins->ip();

			$date = date("Y-m-d H:i:s",time());
			$date = strtotime($date);
			$min_date = strtotime("-1 day", $date);
			
			$max_date = date('Y-m-d H:i:s', time());
			$min_date = date('Y-m-d H:i:s', $min_date);
			
			$this->db->select('*');
			$this->db->from('contact_us');
			$this->db->where('ip_address', $ipaddress);
			
			$this->db->where("contact_us_date BETWEEN '$min_date' AND '$max_date'", NULL, FALSE);

			$query = $this->db->get();
			
			if ($query->num_rows() >= 20){	
				$this->form_validation->set_message('max_ip_daily_messaging', 'You have exceeded your daily messaging limit!');
				return FALSE;
			}else {
				
				return TRUE;
			}	
		}			

		/**
		* Function to limit daily user 
		* max messages
		*/			
		public function max_user_daily_messaging(){
			
			//obtain users ip address
			$email = $this->input->post('contact_us_email');

			$date = date("Y-m-d H:i:s",time());
			$date = strtotime($date);
			$min_date = strtotime("-1 day", $date);
			
			$max_date = date('Y-m-d H:i:s', time());
			$min_date = date('Y-m-d H:i:s', $min_date);
			
			$this->db->select('*');
			$this->db->from('contact_us');
			$this->db->where('LOWER(contact_email)', strtolower($email));
			
			$this->db->where("contact_us_date BETWEEN '$min_date' AND '$max_date'", NULL, FALSE);

			$query = $this->db->get();
			
			if ($query->num_rows() >= 20){	
				$this->form_validation->set_message('max_user_daily_messaging', 'You have exceeded your daily messaging limit!');
				return FALSE;
			}else {
				
				return TRUE;
			}	
		}			
										

		/**
		 * Function for Login Page.
		 *
		 */	
		public function login()
		{
		
			if($this->session->userdata('logged_in')){
					
					//assign page title name
					redirect('account/dashboard');
			}
			else {
					
				if($this->input->get('redirectURL') != ''){
						$url = $this->input->get('redirectURL');
						$this->session->set_flashdata('redirectURL', $url);	
				}
				
				//assign meta tags
				$page = 'login';
				$keywords = '';
				$description = '';
				$metadata_array = $this->Page_metadata->get_page_metadata($page);
				if($metadata_array){
					foreach($metadata_array as $meta){
						$keywords = $meta->keywords;
						$description = $meta->description;
					}
				}
				if($description == '' || $description == null){
					$description = 'Dejor Autos - one stop shop for new and used vehicles';
				}
				//assign meta_description
				$data['meta_description'] = $description;
				
				//assign meta_author
				$data['meta_author'] = 'Dejor Autos';
												
				$data['meta_keywords'] = $keywords;
						
				//assign page title name
				$data['pageTitle'] = 'Account Login';
					
				//assign page ID
				$data['pageID'] = 'login';
						
				$this->load->view('pages/header', $data);
									
				//load main body
				$this->load->view('pages/user_login_page', $data);	
				
				$this->load->view('pages/footer');
				
			}
			
		}
		
		/**
		* Function to validate user login
		* information
		*/
        public function login_validation() {
			
            $this->session->keep_flashdata('redirectURL');
			
			$this->session->keep_flashdata('checkoutURL');
			
            $this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
			$this->form_validation->set_rules('email','Email','required|trim|xss_clean|callback_max_login_attempts|callback_validate_credentials|valid_email');
            $this->form_validation->set_rules('password','Password','required|xss_clean|trim');
            
            $this->form_validation->set_message('required', '%s cannot be blank!');
			
			if ($this->form_validation->run()){
				//STORE USER SESSION DATA IN ARRAY
				$data = array(
					'email' => strtolower($this->input->post('email')),
					'logged_in' => 1,
				);
				//SAVE SESSION DATA
				$this->session->set_userdata($data);
				
				$user_array = $this->Users->get_user($this->input->post('email'));
						
					$fullname = '';
						//$email = '';
					$last_login = '';	
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->first_name .' '.$user->last_name;
							//$email = $user->email;
							$last_login = $user->last_login;
						}
					}
						
					//UPDATE ACTIVITIES TABLE
					$description = 'logged into account';
					
					$activity = array(			
						'name' => $fullname,
						'username' => $this->input->post('email'),
						'description' => $description,
						'keyword' => 'Login',
						'activity_time' => date('Y-m-d H:i:s'),
					);
							
				$this->Site_activities->insert_activity($activity);
				
				if($last_login == '0000-00-00 00:00:00' || $last_login == ''){ 
				
					$this->session->set_flashdata('welcome_alert', '<script type="text/javascript" language="javascript">$(function() { $(".custom-modal").show(); });</script>');
						
				}
							
				//CHECK IF USER ALREADY SET SECURITY INFO
				if($this->Users->check_isset_security_info()){
					
					//STORE FLASH DATA
					$set = array(
						'set_security' => 1,
					);
					
					$this->session->set_userdata($set);	
					//$data['success'] = true;
					//$data['set_security'] = false;		
					//redirects to set memorable information page
					//REDIRECT TO PAGE
					redirect('account/set-security');
					
				}else {
					//$data['success'] = true;
					//$data['set_security'] = true;
					
					//REDIRECTS TO ACCOUNT PAGE
					redirect('account/dashboard');	
				}		
            }
            else {		
				//REDIRECTS TO LOGIN PAGE
				$this->login();	
				//$data['success'] = false;
				//$data['notif'] = '<div class="text-center" role="alert">'.validation_errors().'</div>';
            }
			
			// Encode the data into JSON
			//$this->output->set_content_type('application/json');
			//$data = json_encode($data);

			// Send the data back to the client
			//$this->output->set_output($data);
			//echo json_encode($data);		
        }
		
		/**
		* Function to validate username
		* during login
		*/		
		public function validate_credentials() {
			
			$email = $this->input->post('email');
						
			//hashing the password
			$hashed_password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
				
			//obtain users ip address
			$ipaddress = $this->Users->ip();					
				
			//default function
			$ip = $this->input->ip_address();
				
			//ipinfo 
			//$details = $this->misc_lib->ip_details($ip);
				
			//localhost
			$whitelist = array('127.0.0.1', '::1');	
			
			$ipdetails = '';
			/*
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
			*/
					
			//$geo_data = $this->misc_lib->geolocation_by_ip($ip);
						
					
			if ($this->Users->can_log_in()){
				
				//check admin last login time from the logins table
				//$last_login = $this->Logins->last_login_time($username);
				
				//if there is a record then update users record
				//otherwise ignore
				/*if($last_login){
					foreach($last_login as $login){
						$this->Logins->update_login_time($username, $login->login_time);
					}
				}*/
				
				//get last login
				$last_login = $this->db->select_max('login_time')->from('logins')->where("username",$email)->get()->row();
				if(!empty($last_login)){
					$time = $last_login->login_time;
					//array of session variables
					$data = array(	
						'last_login' => $time,
					);	
					$this->Users->user_update($data, $email);
				}
				
				//array of all login posts
				$data = array(
					'ip_address' => $ipaddress,
					'ip_details' => $ipdetails,
					'username' => $this->input->post('email'),
					'password' => $hashed_password,
					'login_time' => date('Y-m-d H:i:s')
					
				);	
				
				$this->Logins->insert_login($data);
				
				return TRUE;
			}
			else {
				
				//array of all login posts
				$data = array(
					'ip_address' => $ipaddress,
					'ip_details' => $ipdetails,
					'username' => $this->input->post('email'),
					'password' => $hashed_password,
					'attempt_time' => date('Y-m-d H:i:s')
					
				);	
				$this->Failed_logins->insert_failed_login($data);
				
				$this->form_validation->set_message('validate_credentials', 'Incorrect username or password.');
				
				return FALSE;
			}
		}
		
		/**
		* Function to check if the user has logged in wrongly
		* more than 3 times in 24 hours
		*/			
		public function max_login_attempts(){
			
			$email = $this->input->post('email');
			
			$date = date("Y-m-d H:i:s",time());
			$date = strtotime($date);
			$min_date = strtotime("-1 day", $date);
			
			$max_date = date('Y-m-d H:i:s', time());
			$min_date = date('Y-m-d H:i:s', $min_date);
			
			$this->db->select('*');
			$this->db->from('failed_logins');
			$this->db->where('username', $email);
			
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
		* Function to handle user sign up
		*
		*/			
        public function signup() {
			
			if($this->session->userdata('logged_in')){
				
				//if user logged in redirect to their account page
				redirect('account/dashboard');
				
			}else{
								
				//assign meta tags
				$page = 'signup';
				$keywords = '';
				$description = '';
				$metadata_array = $this->Page_metadata->get_page_metadata($page);
				if($metadata_array){
					foreach($metadata_array as $meta){
						$keywords = $meta->keywords;
						$description = $meta->description;
					}
				}
				if($description == '' || $description == null){
					$description = 'Dejor Autos - one stop shop for new and used vehicles';
				}
				//assign meta_description
				$data['meta_description'] = $description;
				
				//assign meta_author
				$data['meta_author'] = 'Dejor Autos';
				
				$data['meta_keywords'] = $keywords;
						
				//assign page title name
				$data['pageTitle'] = 'Sign Up';
			
				//assign page ID
				$data['pageID'] = 'signup';

				//country list dropdown
				$data['list_of_countries'] =  $this->Countries->get_country_list();
		
				$country_options = '<select name="country" id="country_id">';
				$country_options .= '<option value="0" selected="selected">Select Country</option>';
					
				$this->db->from('countries');
				$this->db->order_by('id');
				$result = $this->db->get();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row){
						$country_options .= '<option value="'.$row['name'].'">'.$row['name'].'</option>';			
					}
				}
				$country_options .= '</select>';
				$data['country_options'] = $country_options;				
					
				$this->load->view('pages/header', $data);
								
				//load main body
				$this->load->view('pages/user_signup_page', $data);  
				
				$this->load->view('pages/footer');
			
			}
			
        }


		/**
		* Function to handle signup validation
		*
		*/	        
        public function signup_validation() {
            
            $this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
			$this->form_validation->set_rules('first_name','First Name','required|trim|xss_clean');
            $this->form_validation->set_rules('last_name','Last Name','required|trim|xss_clean');
            
            $this->form_validation->set_rules('email_address','Email','required|trim|valid_email|is_unique[users.email_address]|is_unique[temp_users.email_address]|xss_clean');
			$this->form_validation->set_rules('telephone','Telephone','required|trim|xss_clean|regex_match[/^[0-9\+\(\)\/-]+$/]');
			
            $this->form_validation->set_rules('password','Password','required|trim|xss_clean');
			$this->form_validation->set_rules('confirm_password','Confirm Password','required|trim|matches[password]|xss_clean');
           
			$this->form_validation->set_message('is_unique', '%s already registered, please log in!');
			
			$this->form_validation->set_message('required', '%s cannot be blank!');
			
			$this->form_validation->set_message('matches', 'The passwords do not match!');
			
			$this->form_validation->set_message('regex_match', 'Please enter a valid phone number!');
							
			
			if ($this->form_validation->run()){
				
				//obtain users ip address
				$ipaddress = $this->Logins->ip();	
							
				//default function
				$ip = $this->input->ip_address();
					
				//ipinfo 
				//$details = $this->misc_lib->ip_details($ipaddress);
					
				//localhost
				$whitelist = array('127.0.0.1', '::1');	
				
				$ipdetails = '';
				/*
				if(!in_array($ip, $whitelist)){
					//ipinfo 
					$details = $this->misc_lib->ip_details($ip);
					$ipdetails .= '<p><strong> IP:</strong> '.$ip.'</p>';
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
			*/
				//generate a random key
				$activation_key = md5(uniqid());
				
				//generate a random code
				//$code = mt_rand(100000, 999999);
				
				//hashing the password
				$hashed_password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
				//$hashed_password = md5($this->input->post('password'));
				
				//array of all post variables
				$add = array(

					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'email_address' => strtolower($this->input->post('email_address')),
					'telephone' => $this->input->post('telephone'),
					'password' => $hashed_password,	
					'ip_address' => $ip,
					'ip_details' => $ipdetails,
					'date_created' => date('Y-m-d H:i:s'),	
					'activation_key' => $activation_key,
					
				);
			
				//add new user to the temp database
				if ($this->Temp_users->add_temp_user($add)){

					$fullname = $this->input->post('first_name') .' '.$this->input->post('last_name');
						
					//update activities table
					$description = 'signed up';
					
					$activity = array(			
						'name' => $fullname,
						'username' => $this->input->post('email_address'),
						'description' => $description,
						'keyword' => 'Register',
						'activity_time' => date('Y-m-d H:i:s'),
					);
					
						
					$this->Site_activities->insert_activity($activity);
						
					$to = $this->input->post('email_address');
					$subject = 'Account Signup.';
					$full_name = $this->input->post('first_name').' '.$this->input->post('last_name');
					//compose email message
					$message = "<p>Thank you for signing up.</p>";
					$message .= "<p>Your account will be activated shortly by our staff upon complete review.</p>";

					$this->Messages->send_email_alert($to, $subject, $full_name, $message);
					
					//$data['success'] = true;
					//$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i> Thank you for signing up. Please check your email to activate your account within 24 hours.</div>';
					
							
					//$this->session->set_flashdata('signup', '<div class="alert alert-success text-center"><h5 class="text-success text-center"><i class="fa fa-check-circle"></i> Signup Success</h5><br/><p>Thank you for signing up. Your account will be activated shortly by our staff upon complete review.</p></div>');
							
					//signup successful, redirects to final page
					//redirect('signup/complete');	
					
					$data['success'] = true;
					$data['success_url'] = 'signup/complete';
					//$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <h5 class="text-success text-center"><i class="fa fa-check-circle"></i> Signup Success</h5><br/><p>Thank you for signing up. Your account will be activated shortly by our staff upon complete review.</p></div>';
				}else{
					$data['success'] = false;
					$data['notif'] = '<div class="alert alert-danger text-danger text-center" role="alert"> <i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Could not complete signup!</div>';
					
							
					//$this->session->set_flashdata('signup', '<div class="alert alert-danger text-danger text-center"><h5 class="text-danger text-center"><i class="fa fa-exclamation-triangle"></i> Signup Error</h5><br/><p>Could not complete signup</p></div>');
					
					//redirect('signup/success');			
				} 	
            }
            else {
				$data['success'] = false;
				$data['notif'] = '<div class="text-center" role="alert">'.validation_errors().'</div>';
				//registration failed and shows the signup page again
                //$this->signup();
            }
			
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);			
			
        }		
	

		/**
		* Function to handle user sign up
		* success
		*/			
        public function signup_complete() {
			
			if($this->session->userdata('logged_in')){
				
				//if user logged in redirect to their account page
				redirect('account/dashboard');
				
			}else{
				
				//assign meta tags
					$page = 'signup_complete';
					$keywords = '';
					$description = '';
					$metadata_array = $this->Page_metadata->get_page_metadata($page);
					if($metadata_array){
						foreach($metadata_array as $meta){
							$keywords = $meta->keywords;
							$description = $meta->description;
						}
					}
					if($description == '' || $description == null){
						$description = 'Dejor Autos - one stop shop for new and used vehicles';
					}
					//assign meta_description
					$data['meta_description'] = $description;
					
					//assign meta_author
					$data['meta_author'] = 'Dejor Autos';
					
					$data['meta_keywords'] = $keywords;
							
					//assign page title name
					$data['pageTitle'] = 'Sign Complete';
				
					//assign page ID
					$data['pageID'] = 'signup_complete';

					$this->load->view('pages/header', $data);
									
					//load main body
					$this->load->view('pages/signup_complete_page', $data);  
					
					$this->load->view('pages/footer');
				
			}
			
        }

		

		/**
		* Function to ensure a country is selected 
		* 
		*/			
		public function country_option_check(){
			
			$str1 = $this->input->post('country');
			
			if ($str1 == 'Select Country' )
			{
				$this->form_validation->set_message('country_option_check', 'Please select a question');
				return FALSE;
			}
			else
			{
				return TRUE;
			}
		}



		/**
		* Function to for forgot password
		*
		*/
		public function forgot_password()
		{
		
			if($this->session->userdata('logged_in')){
					
					//user already logged in, redirects to account page
					redirect('account/dashboard');
					
			}	
			else {
					
					if($this->input->get('redirectURL') != ''){
						$url = $this->input->get('redirectURL');
						$this->session->set_flashdata('redirectURL', $url);	
					}
				
				
					//assign meta tags
					$page = 'forgot_password';
					$keywords = '';
					$description = '';
					$metadata_array = $this->Page_metadata->get_page_metadata($page);
					if($metadata_array){
						foreach($metadata_array as $meta){
							$keywords = $meta->keywords;
							$description = $meta->description;
						}
					}
					if($description == '' || $description == null){
						$description = 'Dejor Autos - one stop shop for new and used vehicles';
					}
					//assign meta_description
					$data['meta_description'] = $description;
					
					//assign meta_author
					$data['meta_author'] = 'Dejor Autos';
					
					$data['meta_keywords'] = $keywords;
					
					//assign page title name
					$data['pageTitle'] = 'Forgotten Password';
					
					//assign page ID
					$data['pageID'] = 'forgot_password';
					
					//load header
					$this->load->view('pages/header', $data);
				
					//load main body
					$this->load->view('pages/forgot_password_page', $data);
					
					//load footer
					$this->load->view('pages/footer');
			}		

		}
		
		
		
		/**
		* Function to validate email
		*
		*/			
		public function validate_email(){
			
			//escaping the post values
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
				
			//escaping the post values
			$email = html_escape($this->input->post('email'));
			
			//ENSURE USER HASNT EXCEEDED
			//ALLOWED RESET ATTEMPTS IN THE LAST 24 HOURS
			if($this->not_max_reset_attempts()){
				
				//ENSURE THE EMAIL ADDRESS EXISTS
				if (!$this->Users->unique_user($email)){
					
					//ENSURE USER HAS NOT BEEN SUSPENDED
					if(!$this->Users->user_suspended($email)){
						//return TRUE;
						//get Users info
						$user_array = $this->Users->get_user($email);
						$security_question = '';
						if($user_array){
							foreach($user_array as $user){
								$security_question = $user->security_question;
							}
						}
							
						$data['security_question'] = $security_question;
						$data['success'] = TRUE;
					}else{
						//$this->form_validation->set_message('validate_email', 'This account has been suspended! Please contact Customer Service!');	
						//return FALSE;
						
						$data['notif'] = '<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle"></i> This account has been suspended! Please contact Customer Service!</div>';
						$data['success'] = false;
					}
					
				}
				//EMAIL ADDRESS DOESNT EXIST
				else {		
					
					//obtain users ip address
					$ipaddress = $this->Failed_resets->ip();

					$answer = $this->input->post('security_answer');
					if($answer == '' || $answer == null){
						$answer = '';
					}
					
					//LOCALHOST ARRAY IPV4 IPV6
					$whitelist = array('127.0.0.1', '::1');	
					
					$ipdetails = '';
					
					//ENSURE USER MACHINE IS NOT LOCALHOST
					if(!in_array($ipaddress, $whitelist)){
						//ipinfo 
						$details = $this->misc_lib->ip_details($ipaddress);
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
					
					//array of all reset posts
					$data = array(
						'ip_address' => $ipaddress,
						'ip_details' => $ipdetails,
						'email' => $email,
						'security_answer' => $answer,
						'attempt_time' => date('Y-m-d H:i:s')
					);	
					$this->Failed_resets->insert_failed_reset($data);
					
					//$this->form_validation->set_message('validate_email', 'No record of this email address.');
					//return FALSE;	
					
					$data['notif'] = '<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle"></i> This email address is not registered!</div>';
					$data['success'] = false;
				}
				
			}
			//RESET EXCEEDED IN THE LAST 24 HOURS
			else{
				//$this->form_validation->set_message('validate_email', 'You have surpassed the allowed number of reset attempts in 24 hours! Please contact Customer Service!');	
				//return FALSE;
				$data['notif'] = '<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle"></i> You have exceeded the number of reset attempts allowed in 24 hours!</div>';
				$data['success'] = false;
				
			}
			
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);		
		}

				
		/**
		* Function to validate security_answer
		*
		*/			
		public function validate_security_answer(){
			
			//escaping the post values
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
				
			//escaping the post values
			$email = html_escape($this->input->post('email'));
			$answer = html_escape($this->input->post('security_answer'));
			$question = html_escape($this->input->post('question'));
			
			if($answer != '' && $answer != null){
				
				//check the number of attempts
				if($this->not_max_reset_attempts()){
					
					if ($this->Users->valid_answer($email, $question, $answer)){
						$data['success'] = true;
					} else {
						//obtain users ip address
						$ipaddress = $this->Failed_resets->ip();

						$answer = $this->input->post('security_answer');
						if($answer == '' || $answer == null){
							$answer = '';
						}
						
						//LOCALHOST ARRAY IPV4 IPV6
						$whitelist = array('127.0.0.1', '::1');	
						
						$ipdetails = '';
						
						//ENSURE USER MACHINE IS NOT LOCALHOST
						if(!in_array($ipaddress, $whitelist)){
							//ipinfo 
							$details = $this->misc_lib->ip_details($ipaddress);
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
						
						//array of all reset posts
						$data = array(
							'ip_address' => $ipaddress,
							'ip_details' => $ipdetails,
							'email' => $email,
							'security_answer' => $answer,
							'attempt_time' => date('Y-m-d H:i:s')
						);	
						$this->Failed_resets->insert_failed_reset($data);
						
						$data['notif'] = '<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle"></i> Your answer does not match!</div>';
						$data['success'] = false;
					}
				}else{
					$data['notif'] = '<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle"></i> You have exceeded the number of reset attempts allowed in 24 hours!</div>';
					$data['success'] = false;
				}
			}else{
				$data['notif'] = '<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle"></i> Please enter an answer!</div>';
				$data['success'] = false;
			}
			
			
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);				
		}
		
		/**
		* Function to check if the user has tried to reset wrongly
		* more than 3 times in 24 hours
		*/			
		public function not_max_reset_attempts(){
			
			//$username = $this->input->post('username');
			$email = $this->input->post('email');
			
			$date = date("Y-m-d H:i:s",time());
			$date = strtotime($date);
			$min_date = strtotime("-1 day", $date);
			
			$max_date = date('Y-m-d H:i:s', time());
			$min_date = date('Y-m-d H:i:s', $min_date);
			
			$this->db->select('*');
			$this->db->from('failed_resets');
			//$this->db->where('username', $username);
			$this->db->where('email', $email);
			
			$this->db->where("attempt_time BETWEEN '$min_date' AND '$max_date'", NULL, FALSE);

			$query = $this->db->get();
			
			if ($query->num_rows() < 3){		
				return TRUE;	
			}else {	
				//$this->form_validation->set_message('max_reset_attempts', 'You have surpassed the allowed number of reset attempts in 24 hours! Please contact Customer Service!');	
				return FALSE;
			}
		}
			

		/**
		* Function to validate forgot_password
		*
		*/
        public function forgot_password_validation() {
			
            $this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
            
            $this->form_validation->set_rules('email','Email Address','required|trim|xss_clean|valid_email');
			$this->form_validation->set_rules('password','Password','required|trim|xss_clean|matches[confirm_password]');
			$this->form_validation->set_rules('confirm_password','Confirm Password','required|trim|xss_clean');
            
			$this->form_validation->set_message('required', '%s cannot be blank!');
			$this->form_validation->set_message('valid_email', 'Please enter a valid email address!');
			
            if ($this->form_validation->run()){
				//generate a random key
				//$activation_code = md5(uniqid());
				
				$email = $this->input->post('email');
				
				//hashing the password
				$hashed_password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
				
				$update = array(
					'password' => $hashed_password,
					'last_updated' => date('Y-m-d H:i:s'),
				);
				
				//UPDATE USER PASSWORD
				if ($this->Users->user_update($update, $email)){
	
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
					
					//array of all reset posts
					$reset = array(
						'ip_address' => $ip,
						'ip_details' => $ipdetails,
						'email' => $this->input->post('email'),
						//'security_answer' => $this->input->post('security_answer'),
						//'activation_code' => $activation_code,
						'request_date' => date('Y-m-d H:i:s')
					);	
					$this->Password_resets->insert_password_resets($reset);
					
					//get clients info
					$user_array = $this->Users->get_user($this->input->post('email'));
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->first_name .' '.$user->last_name;
						}
					}
					
					//send email alert
					$to = $this->input->post('email');
					$subject = 'Account Password Reset';
					$message = "<p>Your account password has been changed.</p>";
					$message .= '<p>If you did not make this request please contact Customer Service immediately at <a href="mailto:services@dejor.com">services@dejor.com</a> or (234) 7080 8887.</p>';
					
					$this->Messages->send_email_alert($to, $subject, $fullname, $message);
					
					//$this->session->set_flashdata('username', $this->input->post('username'));
					//$this->session->set_flashdata('email', $this->input->post('email'));
					
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center"><p><i class="fa fa-check-circle-o fa-lg" aria-hidden="true"></i> Your password has been successfully reset.</p><br/><p class="text-center"><a class="btn waves-effect waves-light white-text" href="'.base_url('login').'">Login <i class="material-icons right">send</i></a></p></div>';
					
				}
			
					//user already logged in, redirects to account page
					//redirect('myaccount/dashboard');
				
				
				
            }
            else {
				$data['success'] = false;
				$data['notif'] = '<div class="">'.validation_errors().'</div>';
				
				//validation errors
				//$this->forgot_password();
            }
           
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);		
				
		}			
			
						

		/**
		* Function to validate enquiries from 
		* the vehicles page
		*/			
		public function submit_enquiry() {
            
            $this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
            $this->form_validation->set_rules('customer_name','Name','required|trim|xss_clean|min_length[4]|callback_check_double_enquiry|callback_max_ip_daily_enquiry|callback_max_user_daily_enquiry');
            $this->form_validation->set_rules('customer_telephone','Telephone number','required|trim|xss_clean|regex_match[/^[0-9\+\(\)\/-]+$/]');
			$this->form_validation->set_rules('customer_email','Email','required|trim|valid_email');
			$this->form_validation->set_rules('comment','Message','required|trim|xss_clean|min_length[6]');
			$this->form_validation->set_rules('contact_method[]','Preferred Contact Method','required|trim|xss_clean');
            
			$this->form_validation->set_message('required', '%s cannot be blank!');
			$this->form_validation->set_message('min_length', '%s must be longer!');
			$this->form_validation->set_message('regex_match', 'Please enter a valid phone number!');
			$this->form_validation->set_message('valid_email', 'Please enter a valid email!');
			
			if ($this->form_validation->run()){
				
				//escaping the post values
				$vehicle_id = html_escape($this->input->post('vehicle_id'));
				$vehicle_id = preg_replace('#[^0-9]#i', '', $vehicle_id); // filter everything but numbers
				
				//GET SELLERS EMAIL
				$seller_email = '';
				$vehicle_title = '';
				$vehicles_array = $this->Vehicles->get_vehicles_by_id($vehicle_id);
				//$detail = $this->db->select('*')->from('vehicles')->where('id',$vehicle_id)->get()->row();
				if($vehicles_array){
					foreach($vehicles_array as $vehicle){
						$seller_email = $vehicle->trader_email;
						$vehicle_title = $vehicle->vehicle_make.' '.$vehicle->vehicle_model.' ('.$vehicle->year_of_manufacture.' - '.$vehicle->vehicle_colour.')';
					}
				}
				
				//obtain users ip address
				$ipaddress = $this->Logins->ip();	
							
				//default function
				$ip = $this->input->ip_address();
					
				//ipinfo 
				//$details = $this->misc_lib->ip_details($ipaddress);
					
				//localhost
				$whitelist = array('127.0.0.1', '::1');	
				
				$ipdetails = '';
				
				if(!in_array($ip, $whitelist)){
					//ipinfo 
					$details = $this->misc_lib->ip_details($ip);
					$ipdetails .= '<p><strong> IP:</strong> '.$ip.'</p>';
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
			
				//array of all post variables
				$contact_data = array(
					'customer_name' => $this->input->post('customer_name'),
					'customer_telephone' => $this->input->post('customer_telephone'),
					'customer_email' => strtolower($this->input->post('customer_email')),
					'vehicle_id' => $vehicle_id,
					'comment' => $this->input->post('comment'),
					'preferred_contact_method' => implode(', ', $this->input->post('contact_method')),
					'ip_address' => $ip,
					'ip_details' => $ipdetails,
					'seller_email' => $seller_email,
					'opened' => '0',
					'enquiry_date' => date('Y-m-d H:i:s'),
				);
				
				if($this->Sale_enquiries->add_enquiry($contact_data)){
						
					$to = $seller_email;
					$subject = 'Enquiry From '. ucwords($this->input->post('customer_name'));
					$full_name = ucwords($this->input->post('customer_name'));
					
					//compose email message
					$message = "<h3><u>Enquiry From ".ucwords($this->input->post('customer_name'))."</u></h3>";
					$message .= "<p><strong>Name:</strong> ".ucwords($this->input->post('customer_name')). ",</p>";
					$message .= "<p><strong>Telephone:</strong> ".$this->input->post('customer_telephone').",</p>";
					$message .= "<p><strong>Email:</strong> ".strtolower($this->input->post('customer_email')). ",</p>";
					$message .= "<p><strong>Subject:</strong>  ".$vehicle_title. ",</p>";
					$message .= "<p><strong>Message:</strong> ".$this->input->post('comment'). ",</p>";
					$message .= "<p><strong>Contact Method:</strong> ". implode(', ', $this->input->post('contact_method')). ";</p>";
					$message .= "<p><strong>IP: </strong> ". $ipaddress. ",</p>";
					$message .= "<p><strong>Location:</strong> ". $ipdetails. ",</p>";
						
					$this->Messages->send_email_alert($to, $subject, $full_name, $message);
					
					$data['url'] = 'vehicles';
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Enquiry sent!</div>';

				}else{
					$data['success'] = false;
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Enquiry not sent!</div>';
				}
					
			}else {
					//redirects to contact us page
					//$this->contact_us();	
					$data['success'] = false;
					$data['notif'] = '<div class="text-center" role="alert">'.validation_errors().'</div>';
					$data['errors'] = '<div class="text-center" role="alert">'.validation_errors().'</div>';
					
			}
                echo json_encode($data);
        }

		/**
		* Function to check_double_post 
		* 
		*/			
		public function check_double_enquiry(){
			
			//obtain users ip address
			$ipaddress = $this->Logins->ip();

			$date = date("Y-m-d H:i:s",time());
			$date = strtotime($date);
			$min_date = strtotime("-20 second", $date);
			
			$max_date = date('Y-m-d H:i:s', time());
			$min_date = date('Y-m-d H:i:s', $min_date);
			
			$this->db->select('*');
			$this->db->from('sale_enquiries');
			$this->db->where('ip_address', $ipaddress);
			
			$this->db->where("enquiry_date BETWEEN '$min_date' AND '$max_date'", NULL, FALSE);

			$query = $this->db->get();
			
			if ($query->num_rows() >= 1){	
				$this->form_validation->set_message('check_double_enquiry', 'You must wait at least 20 seconds before you send another enquiry!');
				return FALSE;
			}else {
				
				return TRUE;
			}	
		}			

		/**
		* Function to limit daily IP address 
		* max enquiries
		*/			
		public function max_ip_daily_enquiry(){
			
			//obtain users ip address
			$ipaddress = $this->Logins->ip();

			$date = date("Y-m-d H:i:s",time());
			$date = strtotime($date);
			$min_date = strtotime("-1 day", $date);
			
			$max_date = date('Y-m-d H:i:s', time());
			$min_date = date('Y-m-d H:i:s', $min_date);
			
			$this->db->select('*');
			$this->db->from('sale_enquiries');
			$this->db->where('ip_address', $ipaddress);
			
			$this->db->where("enquiry_date BETWEEN '$min_date' AND '$max_date'", NULL, FALSE);

			$query = $this->db->get();
			
			if ($query->num_rows() >= 20){	
				$this->form_validation->set_message('max_ip_daily_enquiry', 'You have exceeded your daily enquiry limit!');
				return FALSE;
			}else {
				
				return TRUE;
			}	
		}			

		/**
		* Function to limit daily user 
		* max enquiries
		*/			
		public function max_user_daily_enquiry(){
			
			//obtain users ip address
			$email = $this->input->post('customer_email');

			$date = date("Y-m-d H:i:s",time());
			$date = strtotime($date);
			$min_date = strtotime("-1 day", $date);
			
			$max_date = date('Y-m-d H:i:s', time());
			$min_date = date('Y-m-d H:i:s', $min_date);
			
			$this->db->select('*');
			$this->db->from('sale_enquiries');
			$this->db->where('LOWER(customer_email)', strtolower($email));
			
			$this->db->where("enquiry_date BETWEEN '$min_date' AND '$max_date'", NULL, FALSE);

			$query = $this->db->get();
			
			if ($query->num_rows() >= 20){	
				$this->form_validation->set_message('max_user_daily_enquiry', 'You have exceeded your daily enquiry limit!');
				return FALSE;
			}else {
				
				return TRUE;
			}	
		}			
			
		/**
		* Function to validate review 
		* submit
		*/			
		public function submit_review() {
            
            $this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center">', '</div>');
			
            $this->form_validation->set_rules('review_name','Name','required|trim|xss_clean|min_length[4]|callback_check_unique_review');
			$this->form_validation->set_rules('review_email','Email','required|trim|valid_email');
			$this->form_validation->set_rules('review_comment','Comment','required|trim|xss_clean|min_length[6]');
            $this->form_validation->set_rules('vID','Vehicle ID','required|trim|xss_clean');
			$this->form_validation->set_rules('rating','Rating','required|trim|xss_clean');
			
			$this->form_validation->set_message('required', 'Please enter your %s!');
			$this->form_validation->set_message('min_length', '%s must be longer!');
			
			$this->form_validation->set_message('valid_email', 'Please enter a valid email!');
			
			if ($this->form_validation->run()){
				//escaping the post values
				$vehicle_id = html_escape($this->input->post('vID'));
				$vehicle_id = preg_replace('#[^0-9]#i', '', $vehicle_id); // filter everything but numbers
				
				//GET SELLERS EMAIL
				$seller_email = '';
				$vehicles_array = $this->Vehicles->get_vehicles_by_id($vehicle_id);
				//$detail = $this->db->select('*')->from('vehicles')->where('id',$vehicle_id)->get()->row();
				if($vehicles_array){
					foreach($vehicles_array as $vehicle){
						$seller_email = $vehicle->trader_email;
					}
				}
				
				//obtain users ip address
				$ipaddress = $this->Logins->ip();	
							
				//default function
				$ip = $this->input->ip_address();
					
				//ipinfo 
				//$details = $this->misc_lib->ip_details($ipaddress);
					
				//localhost
				$whitelist = array('127.0.0.1', '::1');	
				
				$ipdetails = '';
				
				if(!in_array($ip, $whitelist)){
					//ipinfo 
					$details = $this->misc_lib->ip_details($ip);
					$ipdetails .= '<p><strong> IP:</strong> '.$ip.'</p>';
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

				//array of all post variables
				$review_data = array(
					'seller_email' => $seller_email,
					'rating' => $this->input->post('rating'),
					'reviewer_name' => $this->input->post('review_name'),
					'reviewer_email' => strtolower($this->input->post('review_email')),
					'comment' => $this->input->post('review_comment'),
					'ip_address' => $ip,
					'ip_details' => $ipdetails,
					'review_date' => date('Y-m-d H:i:s'),
				);
				
				$this->Reviews->insert_review($review_data);

				//redirect('home/contact_us', $data);	
				$data['success'] = true;
				$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Thank you for your review!</div>';
				
				
			}else {
					//redirects to contact us page
					//$this->contact_us();	
					$data['success'] = false;
					$data['notif'] = '<div class="text-center" role="alert"> <i class="fa fa-check-circle"><i class="fa fa-ban"></i>'.validation_errors().'</div>';
					
					
			}
                echo json_encode($data);
        }
		
	
		/**
		* Function to check_unique_review 
		* vID
		*/			
		public function check_unique_review(){
			
			$review_name = $this->input->post('review_name');
			$review_email = $this->input->post('review_email');
			
			//escaping the post values
			$vehicle_id = html_escape($this->input->post('vID'));
			$vehicle_id = preg_replace('#[^0-9]#i', '', $vehicle_id); // filter everything but numbers
			//GET SELLERS EMAIL
			$seller_email = '';
			$vehicles_array = $this->Vehicles->get_vehicles_by_id($vehicle_id);
			//$detail = $this->db->select('*')->from('vehicles')->where('id',$vehicle_id)->get()->row();
			if($vehicles_array){
				foreach($vehicles_array as $vehicle){
					$seller_email = $vehicle->trader_email;
				}
			}
			$user_array = $this->Users->get_user($seller_email);
			$user_id = '';
			if($user_array){
				foreach($user_array as $user){
					$user_id = $user->id;
				}
			}
				
			$this->db->select('*');
			$this->db->from('reviews');
			$this->db->where('reviewer_name', $review_name);
			$this->db->where('reviewer_email', $review_email);
			$this->db->where('user_id', $user_id);
			
			$query = $this->db->get();
			
			if ($query->num_rows() >= 1){	
				$this->form_validation->set_message('check_unique_review', 'You have already reviewed this seller!');
				return FALSE;
			}else {
				
				return TRUE;
			}	
		}			
		
		
		
			
						
		/**
		 * Function for Vehicles Display Page.
		 *
		 */
		public function vehicles_display()
		{

			$data['vehicles_array'] = $this->Vehicles->get_all_vehicles();
			$data['search'] = '';
				
			//GET COUNT OF PRODUCTS
			$data['count'] = '';
				
			//assign meta tags
			$page = 'vehicles';
			$keywords = '';
			$description = '';
			$metadata_array = $this->Page_metadata->get_page_metadata($page);
			if($metadata_array){
				foreach($metadata_array as $meta){
					$keywords = $meta->keywords;
					$description = $meta->description;
				}
			}
			if($description == '' || $description == null){
				$description = 'Dejor Autos - one stop shop for new and used vehicles';
			}
			//assign meta_description
			$data['meta_description'] = $description;
			
			//assign meta_author
			$data['meta_author'] = 'Dejor Autos';
			
			//assign meta_keywords		
			$data['meta_keywords'] = $keywords;

			//assign page title name
			$data['pageTitle'] = 'Vehicles';
				
			//assign page ID
			$data['pageID'] = 'vehicles';
			
			$this->load->view('pages/template-header', $data);
			
			$this->load->view('pages/vehicle_finder_page', $data);
				
			$this->load->view('pages/footer', $data);
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

				$url = 'account/vehicle_details';
				
				if($vehicle->vehicle_image == '' || $vehicle->vehicle_image == null || !file_exists($filename)){
					
					$result = $this->db->select('*, MIN(id) as min_id', false)->from('vehicle_images')->where('vehicle_id', $vehicle->id)->get()->row();
				
					if(!empty($result)){
						
						//THUMBNAIL
						$thumbnail = '<img src="'.base_url().'uploads/vehicles/'.$result->vehicle_id.'/'.$result->image_name.'" class="img-responsive img-rounded" width="80" height="80" />';
						
					}else{
						$thumbnail = '<img src="'.base_url().'assets/images/img/no-default-thumbnail.png" class="img-responsive img-rounded" width="80" height="80" />';
					}
					
				}
				else{
					//THUMBNAIL
					$thumbnail = '<img src="'.base_url().'uploads/vehicles/'.$vehicle->id.'/'.$vehicle->vehicle_image.'" class="img-responsive img-rounded" width="80" height="80" />';
				}	
				
				
				$row[] = $thumbnail;
				
				$row[] = $vehicle->vehicle_type;
				
				$row[] = $vehicle->year_of_manufacture;
				
				$row[] = $vehicle->vehicle_make;
				
				$row[] = $vehicle->vehicle_model;
				$row[] = $vehicle->id;
				
				$row[] = $vehicle->vehicle_location_city.', '.$vehicle->vehicle_location_country;
				$row[] = $vehicle->vehicle_odometer;
				$row[] = '$'.number_format($vehicle->vehicle_price, 0);
				
				//$row[] = $vehicle->id;
				//$row[] = $vehicle->id;
				
				
				//prepare buttons
				$row[] = '<a data-toggle="modal" data-target="#EnquireModal" class="waves-effect waves-light  btn" title="Enquire" >Enquire <i class="material-icons right">send</i></a>';
				
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
		* Function to handle display
		* additional image details
		* 
		*/	
		public function image_details(){
			
			if(!empty($this->input->post('id'))){
				
				//escaping the post values
				$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
					
				//escaping the post values
				$id = html_escape($this->input->post('id'));
				
				$vehicle_id = preg_replace('#[^0-9]#i', '', $id); // filter everything but numbers
				
				//GET NAME OF VEHICLE
				$vehicle_name = '';
				$vehicle_array = $this->Vehicles->get_vehicles_by_id($vehicle_id);
				if($vehicle_array){
					foreach($vehicle_array as $vehicle){
						$vehicle_name = ucwords($vehicle->vehicle_make.' '.$vehicle->vehicle_model);
					}
				}
				
				$vehicle_images = $this->Vehicles->get_vehicle_images($vehicle_id);
				$count_vehicle = $this->Vehicles->count_vehicle_images($vehicle_id);
						
				if(!empty($vehicle_images)){
								
					//start gallery group
					$image_gallery = '<div class="">';
					
					//item count initialised
					$i = 0;
					$count = 1;
					//gallery row
					//$image_gallery .= '<div class="row popup-gallery">';
					$image_gallery .= '<div class="row">';
								
					foreach($vehicle_images as $images){
						
						if($count_vehicle < 2){
							$image_gallery .= '<div class="col-sm-12 nopadding">';
						}else if($count_vehicle % 3 == 0){
							$image_gallery .= '<div class="col-sm-4 nopadding">';
						}else if($count_vehicle % 2 == 0){
							$image_gallery .= '<div class="col-sm-6 nopadding">';
						}else{
							if($i <= 1){
								$image_gallery .= '<div class="col-sm-6 nopadding">';
							}else{
								$image_gallery .= '<div class="col-sm-4 nopadding">';
							}	
						}
						
								
						$image_gallery .= '<div class="image-wrapper">';
									
						//$image_gallery .= '<a href="'.base_url().'uploads/vehicles/'.$vehicle_id.'/'.$images->image_name.'"><img src="'.base_url().'uploads/vehicles/'.$vehicle_id.'/'.$images->image_name.'" id="'.$images->image_name.'" data-group="1" class="galleryItem img-responsive" /></a>';
						
						$image_gallery .= '<a href="'.base_url().'uploads/vehicles/'.$vehicle_id.'/'.$images->image_name.'" data-fancybox="gallery"><img src="'.base_url().'uploads/vehicles/'.$vehicle_id.'/'.$images->image_name.'?image='.$count.'" id="'.$images->image_name.'" class="img-responsive" title="'.$vehicle_name.' Image '.$count.'" /></a>';
						
						//$image_gallery .= '<img src="'.base_url().'uploads/vehicles/'.$vehicle_id.'/'.$images->image_name.'" class="img-responsive" onclick="currentSlide('.$count.')" />';
						
						$image_gallery .= '</div>';
						
						$image_gallery .= '</div>';
						
						$i++;
						$count++;
						
					}
					
					$image_gallery .= '</div>';
						
					$image_gallery .= '</div>';
					
					$data['image_gallery'] = $image_gallery;
					
					
					$data['success'] = true;
				}else {
					$data['success'] = false;
				}
			}
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);
			
		}						

					
					
		/**
		* Function to view item
		*
		*/	
        public function view_vehicle($title='', $id='', $unique='') {
			
			//$projects = new Projects_model();
			//escaping the post values
			$pid = html_escape($id);
			$title = html_escape($title);
			$title = trim($title);
			
			$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
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
								
						//MAIN IMAGE
						$image = '<a id="single_image" href="'.base_url().'uploads/vehicles/'.$detail->id.'/'.$detail->vehicle_image.'" title=" View '.$detail->vehicle_make.' '.$detail->vehicle_model.'"><div class="wrapper-img"><img alt="" src="'.base_url().'uploads/vehicles/'.$detail->id.'/'.$result->image_name.'" class="img-responsive main-img" id="main-img" width="" height=""/><div class="img-icon"><i class="fa fa-search-plus fa-lg" aria-hidden="true"></i></div></div></a>';
								
						//THUMBNAIL
						$thumbnail = '<img src="'.base_url().'uploads/vehicles/'.$detail->id.'/'.$result->image_name.'" class="" />';
								
					}else{
						//MAIN IMAGE
						$image = '<a id="single_image" href="'.base_url().'uploads/vehicles/'.$detail->id.'/'.$detail->vehicle_image.'" title=" View '.$detail->vehicle_make.' '.$detail->vehicle_model.'"><div class="wrapper-img"><img alt="" src="'.base_url().'assets/images/img/no-default-thumbnail.png" class="img-responsive main-img" id="main-img" width="" height=""/><div class="img-icon"><i class="fa fa-search-plus fa-lg" aria-hidden="true"></i></div></div></a>';
							
						$thumbnail = '<img src="'.base_url().'assets/images/img/no-default-thumbnail.png" />';
					}
							
				}
				else{
					//MAIN IMAGE
					$image = '<a id="single_image" href="'.base_url().'uploads/vehicles/'.$detail->id.'/'.$detail->vehicle_image.'" title=" View '.$detail->vehicle_make.' '.$detail->vehicle_model.'"><div class="wrapper-img"><img alt="" src="'.base_url().'uploads/vehicles/'.$detail->id.'/'.$detail->vehicle_image.'" class="img-responsive main-img" id="main-img" width="" height=""/><div class="img-icon"><i class="fa fa-search-plus fa-lg" aria-hidden="true"></i></div></div></a>';
							
					//THUMBNAIL
					$thumbnail = '<img src="'.base_url().'uploads/vehicles/'.$detail->id.'/'.$detail->vehicle_image.'" class="" />';
							
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
					
				//start vehicle gallery view
				//$gallery = '<div class="p_gallery">';
				//$gallery = '';
				$image_gallery = '<div class="gallery-wrapper">';
					
					if(!empty($vehicle_images)){
						//item count initialised
						$i = 0;
						$a = 1;
						foreach($vehicle_images as $image){
							
							//vehicle gallery view
							//$gallery .= '<a href="'.base_url().'uploads/vehicles/'.$detail->id.'/'.$image->image_name.'" title="View" >';
							//$gallery .= '<div class="wrapper"><img src="'.base_url().'uploads/vehicles/'.$detail->id.'/'.$image->image_name.'" id="'.$image->image_name.'" class="img-responsive" onclick="changeImage(\''.base_url().'uploads/vehicles/'.$detail->id.'/'.$image->image_name.'\')"/><div class="img-icon"><i class="fa fa-search-plus" aria-hidden="true"></i></div></div>';
							//$gallery .= '</a>';
							
							$image_gallery .= '<div class="img-wrapper">';
							$image_gallery .= '<a href="'.base_url().'uploads/vehicles/'.$detail->id.'/'.$image->image_name.'" title="View" data-fancybox="gallery"><div class="wrapper"><img src="'.base_url().'uploads/vehicles/'.$detail->id.'/'.$image->image_name.'" id="'.$image->image_name.'" class="img-responsive" onclick="changeImage(\''.base_url().'uploads/vehicles/'.$detail->id.'/'.$image->image_name.'\')" /><div class="img-icon"><i class="fa fa-search-plus" aria-hidden="true"></i></div></div></a>';
							$image_gallery .= '</div>';
							
							//$gallery .= '<span href="#" class="gallery-img" title="'.$detail->vehicle_make.' '.$detail->vehicle_model.' '.$a.'" onclick="changeImage(\''.base_url().'uploads/vehicles/'.$detail->id.'/'.$image->image_name.'\')"><img src="'.base_url().'uploads/vehicles/'.$detail->id.'/'.$image->image_name.'" id="'.$image->id.'" class="img-responsive"/></span>';
							
							$a++;	
						}
					}
					
					$image_gallery .= '</div>';
					$data['image_gallery'] = $image_gallery;
					
					
					//end portfolio gallery view
					//$gallery .= '</div>';
					//$data['vehicle_gallery'] = $gallery;
					
					$data['vehicle_title'] = $detail->vehicle_make.' '.$detail->vehicle_model;
					$data['vehicle_type'] = $detail->vehicle_type;
					$data['vehicle_make'] = $detail->vehicle_make;
					$data['vehicle_model'] = $detail->vehicle_model;
					$data['year_of_manufacture'] = $detail->year_of_manufacture;
					$data['vehicle_odometer'] = $detail->vehicle_odometer;
					$data['vehicle_lot_number'] = $detail->vehicle_lot_number;
					$data['vehicle_vin'] = $detail->vehicle_vin;
					$data['vehicle_colour'] = $detail->vehicle_colour;
					
					$background_image = base_url().'assets/images/img/'.strtolower($detail->vehicle_colour).'.png?'.time();
					
					$data['colour'] = '<div class="color-box" title="'.ucwords($detail->vehicle_colour).'" id="'.strtolower($detail->vehicle_colour).'" style="background-color:'.strtolower($detail->vehicle_colour).'; background-image: url('.$background_image.'); background-position: center; background-repeat:no-repeat; background-size:cover;"></div>'; 
					
					$data['vehicle_price'] = $detail->vehicle_price;
					$data['price'] = '$'.number_format($detail->vehicle_price, 2);
					$data['vehicle_location_city'] = $detail->vehicle_location_city;
					$data['vehicle_location_country'] = $detail->vehicle_location_country;
					$data['vehicle_description'] = $detail->vehicle_description;
					$data['sale_status'] = $detail->sale_status;
					$data['trader_email'] = $detail->trader_email;
					
					$user_array = $this->Users->get_user($detail->trader_email);
					
					$fullname = '';
					$company_name = '';
					$user_id = '';
					if($user_array){
						foreach($user_array as $user){
							$user_id = $user->id;
							$fullname = $user->first_name.' '.$user->last_name;
							$company_name = $user->company_name;
						}
					}
					$data['user_id'] = $user_id;
					$data['fullname'] = $fullname;
					$data['company_name'] = $company_name;
					
					$data['discount'] = $detail->discount;
					$data['price_after_discount'] = $detail->price_after_discount;
					
					//count reviews
					$count_reviews = $this->Reviews->count_user_reviews($detail->trader_email);
					if($count_reviews == '' || $count_reviews == null || $count_reviews < 1 ){
						$count_reviews = 0 .'reviews';
					}
					else if($count_reviews == 1){
						$count_reviews = '1 review';
					}else{
						$count_reviews = $count_reviews .' reviews';
					}
					//get product ratings
					$rating = $this->db->select_avg('rating')->from('reviews')->where('seller_email', $detail->trader_email)->get()->result();
					//$res = $this->db->select_avg('rating','overall')->where('product_id', $id)->get('reviews')->result_array();
					
					$data['rating'] = $rating[0]->rating;
					
					$rating_box = '';
					$new_rating = '<div class="starrr stars"></div> <span class="stars-count">0</span> star(s)<input type="hidden" name="rating" class="rating"/>';
					if($rating[0]->rating == '' || $rating[0]->rating == null || $rating[0]->rating < 1){
						$ratings = 0;
						$rating_box = '<div class="starrr stars-existing"  data-rating="'.round($rating[0]->rating).'"></div> <span class="">No reviews yet</span>';
						
					}else{
						$rating_box = '<div class="starrr stars-existing" data-rating="'.round($rating[0]->rating).'"></div> <span class="stars-count-existing">'.round($rating[0]->rating).'</span> star(s) (<span class="review-count">'.$count_reviews.'</span>)';
					}
					$data['rating_box'] = $rating_box;
					$data['new_rating'] = $new_rating;
										
					//assign meta tags
					$page = 'vehicles';
					$keywords = '';
					$description = '';
					$metadata_array = $this->Page_metadata->get_page_metadata($page);
					if($metadata_array){
						foreach($metadata_array as $meta){
							$keywords = $meta->keywords;
							$description = $meta->description;
						}
					}
					if($description == '' || $description == null){
						$description = 'Dejor Autos - one stop shop for new and used vehicles';
					}
					//assign meta_description
					$data['meta_description'] = $description;
					
					//assign meta_author
					$data['meta_author'] = 'Dejor Autos';
					
					//assign meta_keywords		
					$data['meta_keywords'] = $keywords;
					
					//assign page title name
					$data['pageTitle'] = ucwords($detail->vehicle_make.' '.$detail->vehicle_model);
					
					//assign page ID
					$data['pageID'] = 'view-vehicle';
					
					$this->load->view('pages/header', $data);
					
					$this->load->view('pages/view_vehicle_page', $data);
					
					$this->load->view('pages/footer');
					
			}else{
				redirect('vehicles');
			}
		}

			
						
		/**
		 * Function for Store Display Page.
		 *
		 */
		public function store_display($title='', $id='', $unique='')
		{
			//escaping the post values
			$pid = html_escape($id);
			$title = html_escape($title);
			$title = trim($title);
			
			$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
			$detail = $this->db->select('*')->from('users')->where('id',$id)->get()->row();
			
			if($detail){
				
				$trader_email = $detail->email_address;
				
				$user_array = $this->Users->get_user($trader_email);
					
				$fullname = '';
				$company_name = '';
				
				if($user_array){
					foreach($user_array as $user){
						
						$fullname = $user->first_name.' '.$user->last_name;
						$company_name = $user->company_name;
					}
				}
				$data['vehicles_array'] = $this->Vehicles->get_user_vehicles($trader_email);
				
				$data['search'] = '';
				
				//GET COUNT OF PRODUCTS
				$data['count'] = '';
				
				//assign meta tags
				$page = 'vehicles';
				$keywords = '';
				$description = '';
				$metadata_array = $this->Page_metadata->get_page_metadata($page);
				if($metadata_array){
					foreach($metadata_array as $meta){
						$keywords = $meta->keywords;
						$description = $meta->description;
					}
				}
				if($description == '' || $description == null){
					$description = 'Dejor Autos - one stop shop for new and used vehicles';
				}
				//assign meta_description
				$data['meta_description'] = $description;
				
				//assign meta_author
				$data['meta_author'] = 'Dejor Autos';
				
				//assign meta_keywords		
				$data['meta_keywords'] = $keywords;

				
				//assign page title name
				$data['pageTitle'] = $company_name.' '.$fullname.' Store';
					
				//assign page ID
				$data['pageID'] = 'store_vehicles';
				
				$this->load->view('pages/template-header', $data);
				
				$this->load->view('pages/vehicle_finder_page', $data);
					
				$this->load->view('pages/footer', $data);
				
			}else{
				redirect('vehicles');
			}

		}
		
		/**
		* Function for Vehicles Search Page.
		*
		*/
		public function search()
		{
			
			if($this->input->get('vehicle_type') != '' || $this->input->get('keywords') != ''){
				
				//escaping the get values
				$this->input->get(NULL, TRUE); // returns all GET items with XSS filter
				
				if($this->input->get('vehicle_type') != '' && !empty($this->input->get('vehicle_type')) && $this->input->get('vehicle_make') != '' && !empty($this->input->get('vehicle_make')) && $this->input->get('vehicle_model') != '' && !empty($this->input->get('vehicle_model'))){
					
					$where = array();
					
					//escaping the get values
					$this->input->get(NULL, TRUE); // returns all GET items with XSS filter
						
						
					//escaping the get values
					$vehicle_type = trim($this->input->get('vehicle_type'));
					$vehicle_type = html_escape($vehicle_type);
					if(!empty($vehicle_type)){
						$where['vehicle_type'] = $vehicle_type;
					}
						
					$vehicle_make = trim($this->input->get('vehicle_make'));
					$vehicle_make = html_escape($vehicle_make); 
					if(!empty($vehicle_make)){
						$where['vehicle_make'] = $vehicle_make;
					}

					$vehicle_model = trim($this->input->get('vehicle_model'));
					$vehicle_model = html_escape($vehicle_model); 
					if(!empty($vehicle_model)){
						$where['vehicle_model'] = $vehicle_model;
					}

					$vehicle_colour = trim($this->input->get('vehicle_colour'));
					$vehicle_colour = html_escape($vehicle_colour); 
					if(!empty($vehicle_colour)){
						$where['vehicle_colour'] = $vehicle_colour;
					}

					$min_year = trim($this->input->get('vehicle_min_year'));
					$min_year = preg_replace('#[^0-9]#i', '', $min_year); // filter everything but numbers
					
					$max_year = trim($this->input->get('vehicle_max_year'));
					$max_year = preg_replace('#[^0-9]#i', '', $max_year); // filter everything but numbers
					
					$start_date = date('Y', strtotime($min_year));
					$end_date =  date('Y', strtotime($max_year));
					
					$min_price = trim($this->input->get('vehicle_min_price'));
					$min_price = preg_replace('#[^0-9]#i', '', $min_price); // filter everything but numbers
					
					$max_price = trim($this->input->get('vehicle_max_price'));
					$max_price = preg_replace('#[^0-9]#i', '', $max_price); // filter everything but numbers
					
					$count = $this->Vehicles->count_multi_search($where, $min_year, $max_year, $min_price, $max_price);
					
					if($count == '' || $count == null){
						$count = 0;
					}
					
					$data['count'] = $count;
								
					$data['display_option'] = 'Results for <strong><em>'.$vehicle_type.'</em></strong>';
					$data['vehicles_array'] = $this->Vehicles->multi_search($where, $min_year, $max_year, $min_price, $max_price);
					
				}else{
					$keywords = html_escape($this->input->get('keywords'));
					$keywords = trim($keywords);
					//$keywords = '';
					
					//$data['vehicles_array'] = $this->Vehicles->search_vehicles($keywords);
					//echo '<pre>'; print_r($data['vehicles_array']);die('</pre>');
					
					$count = '';
					if( strpos($keywords, ' ' ) !== false ) {
						$search = explode(' ', $keywords);
						$data['vehicles_array'] = $this->Vehicles->search($search);
						$count = $this->Vehicles->count_search($search);
						//echo '<pre>'; print_r($data['vehicles_array']);die('</pre>');
					}else{
						//$keywords = $search;
						$data['vehicles_array'] = $this->Vehicles->search($keywords);
						$count = $this->Vehicles->count_search($keywords);				
					}
					
					//*/
					
					$data['search'] = ucwords($keywords);
					
					//GET COUNT OF PRODUCTS
					if($count == '' || $count == null){
						$count = 0;
					}
					$data['count'] = $count;
					
					//$data['vehicles_array'] = $this->Vehicles->search_vehicles($keywords);
					
				}
				
				
				//assign meta tags
				$page = 'vehicles';
				$keywords = '';
				$description = '';
				$metadata_array = $this->Page_metadata->get_page_metadata($page);
				if($metadata_array){
					foreach($metadata_array as $meta){
						$keywords = $meta->keywords;
						$description = $meta->description;
					}
				}
				if($description == '' || $description == null){
					$description = 'Dejor Autos - one stop shop for new and used vehicles';
				}
				//assign meta_description
				$data['meta_description'] = $description;
				
				//assign meta_author
				$data['meta_author'] = 'Dejor Autos';
				
				//assign meta_keywords		
				$data['meta_keywords'] = $keywords;

				//assign page title name
				$data['pageTitle'] = 'Search';
					
				//assign page ID
				$data['pageID'] = 'vehicle_search';
				
				$this->load->view('pages/template-header', $data);
				
				$this->load->view('pages/vehicle_finder_page', $data);
					
				$this->load->view('pages/footer', $data);
			
			}else{
				redirect('main/vehicles_display');
			}
		}
			

		/**
		* Function to validate search  
		*  
		*/			
		public function search_validation() {
            
            $this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
            $this->form_validation->set_rules('vehicle_type','Vehicle Type','required|trim|xss_clean');
            $this->form_validation->set_rules('vehicle_make','Make','required|trim|xss_clean');
			$this->form_validation->set_rules('vehicle_model','Model','required|trim|xss_clean');
			$this->form_validation->set_rules('vehicle_colour','Colour','trim|xss_clean');
			$this->form_validation->set_rules('vehicle_min_year','Min Year','trim|xss_clean');
            $this->form_validation->set_rules('vehicle_max_year','Max Year','trim|xss_clean');
            $this->form_validation->set_rules('vehicle_min_price','Min Price','trim|xss_clean');
            $this->form_validation->set_rules('vehicle_max_price','Max Price','trim|xss_clean');
            
			$this->form_validation->set_message('required', '%s cannot be blank!');
			
			
			if ($this->form_validation->run()){
				

				$where = array();
					
				//escaping the post values
				$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
					
					
				//escaping the post values
				$vehicle_type = $this->input->post('vehicle_type');
				
				if(!empty($vehicle_type)){
					$where['vehicle_type'] = $vehicle_type;
				}
					
				$vehicle_make_id = $this->input->post('vehicle_make');
				//get vehicle make
				$vehicle_make = '';
				$makes = $this->db->select('*')->from('vehicle_makes')->where('id',$vehicle_make_id)->get()->row();
					
					if($makes){
						$vehicle_make = $makes->title;
					} 
				if(!empty($vehicle_make)){
					$where['vehicle_make'] = $vehicle_make;
				}

				$vehicle_model = $this->input->post('vehicle_model');
				 
				if(!empty($vehicle_model)){
					$where['vehicle_model'] = $vehicle_model;
				}
				
				
				$vehicle_colour = $this->input->post('vehicle_colour');
				 
				if(!empty($vehicle_colour)){
					$where['vehicle_colour'] = $vehicle_colour;
				}

				$min_year = $this->input->post('vehicle_min_year');
				$min_year = preg_replace('#[^0-9]#i', '', $min_year); // filter everything but numbers
				
				$max_year = $this->input->post('vehicle_max_year');
				$max_year = preg_replace('#[^0-9]#i', '', $max_year); // filter everything but numbers
				
				$start_date = date('Y', strtotime($min_year));
				$end_date =  date('Y', strtotime($max_year));
				
				$min_price = trim($this->input->get('vehicle_min_price'));
				$min_price = preg_replace('#[^0-9]#i', '', $min_price); // filter everything but numbers
					
				$max_price = trim($this->input->get('vehicle_max_price'));
				$max_price = preg_replace('#[^0-9]#i', '', $max_price); // filter everything but numbers
					
				$count = $this->Vehicles->count_multi_search($where, $min_year, $max_year, $min_price, $max_price);
					
				if($count == '' || $count == null){
					$count = 0;
				}
					
				$data['count'] = $count;
				
				$data['search'] = ucwords($vehicle_make.' - '.$vehicle_model);
									
				$data['display_option'] = 'Results for <strong><em>'.$vehicle_type.'</em></strong>';
				$data['vehicles_array'] = $this->Vehicles->multi_search($where, $min_year, $max_year, $min_price, $max_price);
				
				//assign meta tags
				$page = 'vehicles';
				$keywords = '';
				$description = '';
				$metadata_array = $this->Page_metadata->get_page_metadata($page);
				if($metadata_array){
					foreach($metadata_array as $meta){
						$keywords = $meta->keywords;
						$description = $meta->description;
					}
				}
				if($description == '' || $description == null){
					$description = 'Dejor Autos - one stop shop for new and used vehicles';
				}
				//assign meta_description
				$data['meta_description'] = $description;
				
				//assign meta_author
				$data['meta_author'] = 'Dejor Autos';
				
				//assign meta_keywords		
				$data['meta_keywords'] = $keywords;

				//assign page title name
				$data['pageTitle'] = 'Search';
					
				//assign page ID
				$data['pageID'] = 'vehicle_search';
				
				$this->load->view('pages/template-header', $data);
				
				$this->load->view('pages/vehicle_finder_page', $data);
					
				$this->load->view('pages/footer', $data);
				
				//$data['success'] = true;
				//$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Your message has been sent!</div>';
				
				
			}else {
					//redirects to contact us page
					$this->index();	
					//$data['success'] = false;
					//$data['notif'] = '<div class="text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> '.validation_errors().'</div>';
					
					
			}
                //echo json_encode($data);
        }
			

		/**
		* Function to validate search  
		*  
		*/			
		public function multi_search_validation() {
            
            $this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
            $this->form_validation->set_rules('keywords','Keywords','required|trim|xss_clean');
            
            
			$this->form_validation->set_message('required', '%s cannot be blank!');
			
			
			if ($this->form_validation->run()){
				
				$keywords = $this->input->post('keywords');
				
				//$keywords = '';
					
				//$data['vehicles_array'] = $this->Vehicles->search_vehicles($keywords);
				//echo '<pre>'; print_r($data['vehicles_array']);die('</pre>');
					
				$count = '';
				if( strpos($keywords, ' ' ) !== false ) {
					$search = explode(' ', $keywords);
					$data['vehicles_array'] = $this->Vehicles->search($search);
					$count = $this->Vehicles->count_search($search);
					//echo '<pre>'; print_r($data['vehicles_array']);die('</pre>');
				}else{
					//$keywords = $search;
					$data['vehicles_array'] = $this->Vehicles->search($keywords);
					$count = $this->Vehicles->count_search($keywords);				
				}
					
				//*/
					
				$data['search'] = ucwords($keywords);
					
				//GET COUNT OF PRODUCTS
				if($count == '' || $count == null){
					$count = 0;
				}
				$data['count'] = $count;
					
				//assign meta tags
				$page = 'vehicles';
				$keywords = '';
				$description = '';
				$metadata_array = $this->Page_metadata->get_page_metadata($page);
				if($metadata_array){
					foreach($metadata_array as $meta){
						$keywords = $meta->keywords;
						$description = $meta->description;
					}
				}
				if($description == '' || $description == null){
					$description = 'Dejor Autos - one stop shop for new and used vehicles';
				}
				//assign meta_description
				$data['meta_description'] = $description;
				
				//assign meta_author
				$data['meta_author'] = 'Dejor Autos';
				
				//assign meta_keywords		
				$data['meta_keywords'] = $keywords;

				//assign page title name
				$data['pageTitle'] = 'Search';
					
				//assign page ID
				$data['pageID'] = 'vehicle_search';
				
				$this->load->view('pages/template-header', $data);
				
				$this->load->view('pages/vehicle_finder_page', $data);
					
				$this->load->view('pages/footer', $data);
				
				//$data['success'] = true;
				//$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Your message has been sent!</div>';
				
				
			}else {
					//redirects to contact us page
					$this->index();	
					//$data['success'] = false;
					//$data['notif'] = '<div class="text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> '.validation_errors().'</div>';
					
					
			}
                //echo json_encode($data);
        }

		/**
		* Function to handle log out page
		*
		*/
		public function logged_out() {
			
					
			//assign meta tags
			$page = 'logged_out';
			$keywords = '';
			$description = '';
			
			$metadata_array = $this->Page_metadata->get_page_metadata($page);
			if($metadata_array){
				foreach($metadata_array as $meta){
					$keywords = $meta->keywords;
					$description = $meta->description;
				}
			}
			if($description == '' || $description == null){
				$description = 'Dejor Autos - one stop shop for new and used vehicles';
			}
			
			//assign meta_description
			$data['meta_description'] = $description;
					
			//assign meta_author
			$data['meta_author'] = 'Dejor Autos';
					
			$data['meta_keywords'] = $keywords;
					
			//assign page title name
			$data['pageTitle'] = 'Logged Out';
			
			//assign page ID
			$data['pageID'] = 'logged_out';
								
			//load header
			$this->load->view('pages/header', $data);
						
			//load main body
            $this->load->view('pages/logout_page', $data);
			
			//load main footer
			$this->load->view('pages/footer');				
						
			
        } 		
			
	
	
	
	
	
	
	
	
	
	
}
