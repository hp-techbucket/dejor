<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends CI_Controller {
		
		/**
		* Function for controller
		*  index
		*/	
		public function index(){
			
			if($this->session->userdata('admin_logged_in') || $this->session->userdata('logged_in')){
			
				redirect('message/inbox');

			}else{
				
				redirect('main');	
			}
		}

				
		/**
		* Function to display
		* all messages
		*/		
		public function all_messages(){
			
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
					
					//assign page title name
					$data['pageTitle'] = 'All Messages';
					
					//assign page ID
					$data['pageID'] = 'all_messages';
					
					//load header
					$this->load->view('admin_pages/header', $data);
					
					//load main body
					$this->load->view('admin_pages/all_messages_page', $data);
					
					//load main footer
					$this->load->view('admin_pages/footer');	
						
					
				}else{
					//Admin access error
					redirect('admin/error');
				}
			}
		}
		
		
				
		/***
		* Function to handle all messages
		* Datatable
		***/
		public function all_messages_datatable()
		{
			$list = $this->Messages->get_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $message) {
				$no++;
				
				
				$textWeight = '';	
				$icon = '';
				$replied = '';
				
				//check if there is an attachment
				$attachment = '';
				if($message->attachment == '1'){
					$attachment = '<i class="fa fa-paperclip" aria-hidden="true"></i>';
				}
				
				//generate download link
				$thisRandNum = md5(uniqid());
				
				$files_link = '<ul class="files-list">';
				$files_array = $this->Files->get_message_files($message->id);
				if($files_array){
					foreach($files_array as $file){
						$file_size = ($file->file_size != '') ? ' ('.$file->file_size.')':'';
						$files_link .= '<li><a title="Download '.$file->file_name.'" href="javascript:void(0)" onclick="location.href=\''.base_url().'file/download/'.$message->id.'/'.$file->id.'/'.$thisRandNum.'\'" class="">'.$attachment.' '.$file->file_name.' '.$file_size.'</a></li>';
					}
				}
				$files_link .= '</ul>';
				
				$row = array();
			
				//$row[] = '<input type="checkbox" name="cb[]" id="cb" onclick="enableButton(this)" value="'.$message->id.'">';
				//<div style="margin-left: 40%; margin-right: 40%;">'.$status->order_reference.'</div>
				
				
				//$row[] = $replied;
				
				if($message->opened == "0"){		
					$textWeight = 'msgDefault';	
					//$icon = '<i class="fa fa-circle"></i>';
					$row[] = '<div class="checkbox checkbox-primary pull-left"><input type="checkbox" name="cb[]" class="cb" onclick="enableButton(this)" value="'.$message->id.'"><label for="cb"></label></div><div style="margin-left: 40%; margin-right: 40%;"><strong>'.$message->sender_name.'</strong></div>';
				
					//$row[] = '<strong>'.$message->sender_name.'</strong>';
					$row[] = '<strong>'.$message->receiver_name.'</strong>';
					$row[] = '<span class="messageToggle" style="padding:3px;">
								<a href="javascript:void(0)" class="'.$textWeight.'" id="subj_line_'.$message->id.'">'.$attachment.' '. stripslashes($message->message_subject).'</a>
							</span>
																	
							<div class="messageContents">'.stripslashes(wordwrap(nl2br($message->message_details), 54, "\n", true)).'<br/><br/>'.$files_link.'<br/></div>';
							
					
					$row[] = '<strong><small>'.date("d M Y", strtotime($message->date_sent)).'</small></strong>';
					$row[] = '<i class="fa fa-circle"></i>';
					
				}else{	
					$textWeight = 'msgRead';
					//$icon = '<i class="fa fa-circle-o"></i>';
					$row[] = '<div class="checkbox checkbox-primary pull-left"><input type="checkbox" name="cb[]" class="cb" onclick="enableButton(this)" value="'.$message->id.'"><label for="cb"></label></div><div style="margin-left: 40%; margin-right: 40%;"><strong>'.$message->sender_name.'</strong></div>';
				
					//$row[] = $message->sender_name;
					$row[] = $message->receiver_name;
					$row[] = '<span class="messageToggle" style="padding:3px;">
								<a href="javascript:void(0)" class="'.$textWeight.'" id="subj_line_'.$message->id.'">'.$attachment.' '. stripslashes($message->message_subject).'</a>
							</span>
																	
							<div class="messageContents">'.stripslashes(wordwrap(nl2br($message->message_details), 54, "\n", true)).'<br/><br/>'.$files_link.'<br/></div>';
					
					$row[] = '<small>'.date("d M Y", strtotime($message->date_sent)).'</small>';
					$row[] = '<i class="fa fa-circle-o"></i>';
				}

				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Messages->count_all(),
				"recordsFiltered" => $this->Messages->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}
			
		
		/***
		* Function to handle messages archive
		* Datatable
		***/
		public function archive_datatable()
		{
			$list = $this->Messages->get_archive_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $message) {
				$no++;
				
				$textWeight = '';	
				$icon = '';
				$replied = '';
				
				if($message->opened == "0"){		
					$textWeight = 'msgDefault';	
					$icon = '<i class="fa fa-circle"></i>';
				}else{	
					$textWeight = 'msgRead';
					$icon = '<i class="fa fa-circle-o"></i>';
				}
				if($message->replied == "1"){
					$replied = '<i class="fa fa-reply" ></i>';		
				}else{		
					$replied = '';
				}	
				
				$row = array();
				$row[] = '<input type="checkbox" name="cb[]" id="cb" onclick="enableButton(this)" value="'.$message->id.'">';
				
				$row[] = $message->sender_name;
				
				$row[] = '<span class="messageToggle" style="padding:3px;">
							<a href="javascript:void(0)" class="'.$textWeight.'" id="subj_line_'.$message->id.'">'. stripslashes($message->message_subject).'</a>
						</span>
																
						<div class="messageDiv"><br/>'.stripslashes(wordwrap(nl2br($message->message_details), 54, "\n", true)).'
																	<br/><br/><br/>
																</div>';
				
				$row[] = '<small>'.date("d M Y", strtotime($message->date_sent)).'</small>';
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Messages->count_archive_all(),
				"recordsFiltered" => $this->Messages->count_filtered_archive(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}
				
		
		/***
		* Function to handle messages inbox
		* Datatable
		***/
		public function inbox_datatable()
		{
			$list = $this->Messages->get_inbox_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $message) {
				$no++;
				
				
				$textWeight = '';	
				$icon = '';
				$replied = '';
				
				if($message->opened == "0"){		
					$textWeight = 'msgDefault';	
					$icon = '<i class="fa fa-circle"></i>';
				}else{	
					$textWeight = 'msgRead';
					$icon = '<i class="fa fa-circle-o"></i>';
				}
				if($message->replied == "1"){
					$replied = '<i class="fa fa-reply" ></i>';		
				}else{		
					$replied = '';
				}	
				$row = array();
			
				//$row[] = '<input type="checkbox" name="cb[]" id="cb" onclick="enableButton(this)" value="'.$message->id.'">'.nbs(5).''.$icon.''.nbs(10).''.$replied;
				
				$row[] = '<div class="checkbox checkbox-primary pull-left"><input type="checkbox" name="cb[]" class="cb" onclick="enableButton(this)" value="'.$message->id.'"><label for="cb"></label></div>'.nbs(5).''.$icon.''.nbs(10).''.$replied;
				
				//$row[] = $replied;
				
				//check if there is an attachment
				$attachment = '';
				if($message->attachment == '1'){
					$attachment = '<i class="fa fa-paperclip" aria-hidden="true"></i>';
				}
				
				//generate download link
				$thisRandNum = md5(uniqid());
				
				$files_link = '<ul class="files-list">';
				$files_array = $this->Files->get_message_files($message->id);
				if($files_array){
					foreach($files_array as $file){
						$file_size = ($file->file_size != '') ? $file->file_size:'';
						$files_link .= '<li><a title="Download '.$file->file_name.'" href="javascript:void(0)" onclick="location.href=\''.base_url().'file/download/'.$message->id.'/'.$file->id.'/'.$thisRandNum.'\'" class="">'.$attachment.' '.$file->file_name.' ('.$file_size.')</a></li>';
					}
				}
				$files_link .= '</ul>';
				
				$row[] = $message->sender_name;
				
				$reply_url = 'message/detail';
				
				$read_url = 'message/mark_as_read';
				
				$row[] = '<span class="messageToggle" style="padding:3px;">
							<a href="javascript:void(0)" class="'.$textWeight.'" id="subj_line_'.$message->id.'" onclick="markAsRead('.$message->id.', \''.$read_url.'\'); ">'.$attachment.' '. stripslashes($message->message_subject).'</a>
						</span>
																
						<div class="messageContents">'.stripslashes(wordwrap(nl2br($message->message_details), 54, "\n", true)).'<br/><br/>'.$files_link.'<br/><strong><a data-toggle="modal" data-target="#replyModal" class="btn btn-primary btn-xs" onclick="replyMessage('.$message->id.', \''.$reply_url.'\');" id="'.$message->id.'"><i class="fa fa-reply"></i> Reply</a></strong></div>';
				
				$row[] = '<small>'.date("d M Y", strtotime($message->date_sent)).'</small>';
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Messages->count_inbox_all(),
				"recordsFiltered" => $this->Messages->count_filtered_inbox(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}
			
		/**
		* Function to display
		* inbox messages
		*/	
		public function inbox(){
										
			if($this->session->userdata('admin_logged_in') || $this->session->userdata('logged_in')){	
			
				//check if redirect url is set
				$redirect = '';
				if($this->session->flashdata('redirectURL')){
					$redirect = $this->session->flashdata('redirectURL');
					//redirect user to previous url
					//$url = 'account/'.$redirect;
					redirect($redirect);
				}	
				
				if($this->session->userdata('admin_logged_in')){
					$email = $this->session->userdata('admin_username');
					
					$data['user_array'] = $this->Admin->get_user($email);
					
					$fullname = '';
					if($data['user_array']){
						foreach($data['user_array'] as $user){
							$fullname = $user->admin_name;
						}
					}
			
				}
				
				if($this->session->userdata('logged_in')){
					$email = $this->session->userdata('email');
					
					$data['user_array'] = $this->Users->get_user($email);
					
					$fullname = '';
					if($data['user_array']){
						foreach($data['user_array'] as $user){
							$fullname = $user->first_name.' '.$user->last_name;
						}
					}
			
				}
				
				$data['fullname'] = $fullname;
				$data['email'] = $email;
				
				$data['unread_contact_us'] = $this->Contact_us->count_unread_messages();
				
				$messages_unread = $this->Messages->count_unread_messages($email);
				if($messages_unread == '' || $messages_unread == null){
					$data['messages_unread'] = 0;
				}else{
					$data['messages_unread'] = $messages_unread;
				}
				
				$data['header_messages_array'] = $this->Messages->get_header_messages($email);
				
				$enquiries_unread = $this->Sale_enquiries->count_unread_enquiries($email);
				if($enquiries_unread == '' || $enquiries_unread == null){
					$data['enquiries_unread'] = 0;
				}else{
					$data['enquiries_unread'] = $enquiries_unread;
				}
				
				$count_inbox_messages = $this->Messages->count_inbox_all();
				if($count_inbox_messages == '' || $count_inbox_messages == null){
					$count_inbox_messages = 0;
				}
				$data['count_inbox_messages'] = $count_inbox_messages;
				
				$count_archive_messages = $this->Messages->count_archive_all();
				if($count_archive_messages == '' || $count_archive_messages == null){
					$count_archive_messages = 0;
				}
				$data['count_archive_messages'] = $count_archive_messages;
				
				
				
				$count_sent_messages = $this->Messages->count_sent_all();
				if($count_sent_messages == '' || $count_sent_messages == null){
					$count_sent_messages = 0;
				}
				$data['count_sent_messages'] = $count_sent_messages;
				//$data['count'] = $this->Messages->count_received_messages($email);
				$data['count'] = $count_sent_messages;
				$data['display_option'] = '<strong>Showing All</strong>';
				$result = '';
				
				$result = $this->db->limit(1)->select('*')->from('messages')->where('receiver_email', $email)->order_by('id','DESC')->get()->row();	
				
				$data['result'] = $result;
				
				if(!empty($result)){
					
					$this->mark_as_read($result->id);
				
					$data['message_id'] = $result->id;
					$data['sender_name'] = $result->sender_name;
					$data['sender_email'] = $result->sender_email;
					$data['message_subject'] = $result->message_subject;
					$data['message_details'] = $result->message_details;
					$data['message_date'] = date("F j, Y", strtotime($result->date_sent)); 
				}
				
				//assign page title name
				$data['pageTitle'] = 'Inbox';
				
				//assign page ID
				$data['pageID'] = 'inbox';
				
				
				
				if($this->session->userdata('admin_logged_in')){
					
					//load header
					$this->load->view('admin_pages/header', $data);
				
					//load main body
					$this->load->view('admin_pages/inbox_page', $data);
				
					//load main footer
					$this->load->view('admin_pages/footer');
				
				}
				
				if($this->session->userdata('logged_in')){
					$email = $this->session->userdata('email');
					$data['address_book_array'] = $this->Address_book->get_address_book($email);	
				
					//load header
					$this->load->view('account_pages/header', $data);
				
					//load main body
					$this->load->view('account_pages/inbox_page', $data);
				
					//load main footer
					$this->load->view('account_pages/footer');
				
				}
												
								
			}else{
				redirect('message/index');
			}	
		}		
		
			
		/***
		* Function to handle messages sent
		* Datatables
		***/
		public function sent_datatable()
		{
			$list = $this->Messages->get_sent_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $message) {
				$no++;
				$row = array();
				
				//$row[] = '<div class="checkbox checkbox-primary pull-left"><input type="checkbox" name="cb[]" class="cb" onclick="enableButton(this)" value="'.$message->id.'"><label for="cb"></label></div>'.nbs(15).'<i class="fa fa-reply" aria-hidden="true"></i>';
				
				$row[] = '<div class="checkbox checkbox-primary pull-left"><input type="checkbox" name="cb[]" class="cb" onclick="enableButton(this)" value="'.$message->id.'"><label for="cb"></label></div>'.nbs(15).'<i class="fa fa-reply" aria-hidden="true"></i>';
				//check if there is an attachment
				$attachment = '';
				if($message->attachment == '1'){
					$attachment = '<i class="fa fa-paperclip" aria-hidden="true"></i>';
				}
				
				//generate download link
				$thisRandNum = md5(uniqid());
				
				$files_link = '<ul class="files-list">';
				$files_array = $this->Files->get_message_files($message->id);
				if($files_array){
					foreach($files_array as $file){
						$file_size = ($file->file_size != '') ? $file->file_size:'';
						$files_link .= '<li><a title="Download '.$file->file_name.'" href="javascript:void(0)" onclick="location.href=\''.base_url().'file/download/'.$message->id.'/'.$file->id.'/'.$thisRandNum.'\'" class="">'.$attachment.' '.$file->file_name.' ('.$file_size.')</a></li>';
					}
				}
				$files_link .= '</ul>';
				
				$row[] = $message->receiver_name;
				
				$row[] = '<span class="messageToggle" style="padding:3px;">
							<a href="!#" class="msgRead" id="subj_line_'.$message->id.'">'. stripslashes($message->message_subject).'</a>
							<span class="pull-right">'.$attachment.'</span></span>
																
							<div class="messageContents"><br/>'.stripslashes(wordwrap(nl2br($message->message_details), 54, "\n", true)).'
																	<br/><br/>'.$files_link.'<br/>
																</div>';
				
				$row[] = '<small>'.date("F j, Y", strtotime($message->date_sent)).'</small>';
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Messages->count_sent_all(),
				"recordsFiltered" => $this->Messages->count_filtered_sent(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}
					
		/**
		* Function to display
		* sent messages
		*/				
		public function sent(){
			
			if($this->session->userdata('admin_logged_in') || $this->session->userdata('logged_in')){
				
				//check if redirect url is set
				$redirect = '';
				if($this->session->flashdata('redirectURL')){
					$redirect = $this->session->flashdata('redirectURL');
					//redirect user to previous url
					//$url = 'account/'.$redirect;
					redirect($redirect);
				}	
				
				$email = '';
				if($this->session->userdata('admin_logged_in')){
					$email = $this->session->userdata('admin_username');
					
					$data['user_array'] = $this->Admin->get_user($email);
					
					$fullname = '';
					if($data['user_array']){
						foreach($data['user_array'] as $user){
							$fullname = $user->admin_name;
						}
					}
			
				}
				
				if($this->session->userdata('logged_in')){
					$email = $this->session->userdata('email');
					
					$data['user_array'] = $this->Users->get_user($email);
					
					$fullname = '';
					if($data['user_array']){
						foreach($data['user_array'] as $user){
							$fullname = $user->first_name.' '.$user->last_name;
						}
					}
			
				}
				
				$data['fullname'] = $fullname;
				
				$data['unread_contact_us'] = $this->Contact_us->count_unread_messages();
				
				$messages_unread = $this->Messages->count_unread_messages($email);
				if($messages_unread == '' || $messages_unread == null){
					$data['messages_unread'] = 0;
				}else{
					$data['messages_unread'] = $messages_unread;
				}
				
				$data['header_messages_array'] = $this->Messages->get_header_messages($email);
				
				$enquiries_unread = $this->Sale_enquiries->count_unread_enquiries($email);
				if($enquiries_unread == '' || $enquiries_unread == null){
					$data['enquiries_unread'] = 0;
				}else{
					$data['enquiries_unread'] = $enquiries_unread;
				}
				
				
				$count_inbox_messages = $this->Messages->count_inbox_all();
				if($count_inbox_messages == '' || $count_inbox_messages == null){
					$count_inbox_messages = 0;
				}
				$data['count_inbox_messages'] = $count_inbox_messages;
				
				
				$count_sent_messages = $this->Messages->count_sent_all();
				if($count_sent_messages == '' || $count_sent_messages == null){
					$count_sent_messages = 0;
				}
				$data['count_sent_messages'] = $count_sent_messages;
				
				
				//load header and page title
				//assign page title name
				$data['pageTitle'] = 'Sent';
				
				//assign page ID
				$data['pageID'] = 'sent';
				
				
				if($this->session->userdata('admin_logged_in')){
					
					//load header
					$this->load->view('admin_pages/header', $data);
				
					//load main body
					$this->load->view('admin_pages/sent_page', $data);
				
					//load main footer
					$this->load->view('admin_pages/footer');
				
				}
				
				if($this->session->userdata('logged_in')){
					
					//load header
					$this->load->view('account_pages/header', $data);
				
					//load main body
					$this->load->view('account_pages/sent_page', $data);
				
					//load main footer
					$this->load->view('account_pages/footer');
				
				}
				
			}else{
				
				redirect('message/index');
			}	
		}	

			
			
		/**
		* Function to handle display
		* message preview and
		* reply message
		*/	
		public function detail(){
			
			$email = $this->session->userdata('email');
			if($this->session->userdata('admin_logged_in')){
				$email = $this->session->userdata('admin_username');
			}
			//escaping the post values
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
				
			//escaping the post values
			$pid = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
			$detail = $this->db->select('*')->from('messages')->where('id',$id)->get()->row();
			
			if($detail){

				//$this->db->where('message_id',$this->input->post('id'))->update('messages',array('opened'=>'0'));
				
				//$this->mark_as_read($id);
				$update = array(
					'opened' => '1',
				);
				$this->db->where('id', $id);
				$query = $this->db->update('messages', $update);
					
				$data['id'] = $detail->id;
				$data['name'] = $detail->sender_name;
				$data['email'] = $detail->sender_email;
				$data['subject'] = $detail->message_subject;
				$data['message'] = $detail->message_details;
				
				$data['date_sent'] = date("F j, Y", strtotime($detail->date_sent)); 
				
				$attachment = '';
				if($detail->attachment == '1'){
					$attachment = '<i class="fa fa-paperclip" aria-hidden="true"></i>';
				}
				$data['attachment'] = '<span class="" >'.$attachment.'</span>';
				
				//generate download link
				$thisRandNum = md5(uniqid());
								
				$files_link = '<ul class="files-list">';
				$files_array = $this->Files->get_message_files($detail->id);
				if($files_array){
					foreach($files_array as $file){
						$file_size = ($file->file_size != '') ? $file->file_size:'';
						$files_link .= '<li><a title="Download '.$file->file_name.'" href="javascript:void(0)" onclick="location.href=\''.base_url().'file/download/'.$message->id.'/'.$file->id.'/'.$thisRandNum.'\'" class="">'.$attachment.' '.$file->file_name.' ('.$file_size.')</a></li>';
					}
				}
				$files_link .= '</ul>';
				$data['files_link'] = $files_link;
				
				//$data['update_count_message'] = $this->db->where('opened','0')->count_all_results('message');
				$count = $this->Messages->count_unread_messages($detail->receiver_email);
				//$data['count_unread'] = "'".$count."'";
				if($count == '' || $count == null){
					$count = 0;
				}
				$data['count_unread'] = $count;
				
				$header_messages = '';
				$header_messages_array = $this->Messages->get_header_messages($detail->receiver_email);
				//check messages array for messages to display			
				if(!empty($header_messages_array)){			
					//obtain each row of message
					foreach ($header_messages_array as $message){			
						$sender_image = '';
						$avatar = '';
						$sender_id = '';
						$u_array = $this->Users->get_user($message->sender_email);
						if($u_array){
							foreach($u_array as $u){
								$avatar = $u->avatar;
								$sender_id = $u->id;
							}
							$filename = FCPATH.'uploads/users/'.$sender_id.'/'.$avatar;
							if($avatar == '' || $avatar == null || !file_exists($filename)){
								$sender_image = '<img src="'.base_url().'assets/images/icons/avatar.jpg" class="" alt="Profile Image" />';
										
							}else{
								$sender_image = '<img src="'.base_url().'uploads/users/'.$sender_id.'/'.$avatar.'" class="" alt="Profile Image" />';
										
							}
						}
						$url = 'message/detail';
						$elip = strlen($message->message_details) > 35 ? '...' : '';
						
						$header_messages .= '<li>';
						$header_messages .= '<a data-toggle="modal" data-target="#previewModal" onclick="javascript:previewMessage('.$message->id.', \''.$url.'\');" id="'.$message->id.'">';
						$header_messages .= '<span class="image">'.$sender_image.'</span>';
						$header_messages .= '<span> <span>'.$message->sender_name.'</span>';
						$header_messages .= '<span class="time">'.$this->misc_lib->time_elapsed_string(strtotime($message->date_sent)).'</span></span>';
						$header_messages .= '<span class="message">'.substr($message->message_details, 0, 35).''.$elip .'</span>';
						$header_messages .= '</a>';
						$header_messages .= ' </li>';
					}		
				}
				$data['header_messages'] = $header_messages;
				
				$data['success'] = true;
				
				//handle reply requests
				$data['receiver_name'] = $detail->sender_name;
				$data['receiver_email'] = $detail->sender_email;
				$data['sender_name'] = $detail->receiver_name;
				$data['sender_email'] = $detail->receiver_email;
				$data['message_subject'] = 'Re: '.$detail->message_subject;
					
				//handle default reply box content
				$Sname = $detail->receiver_name;
				$Rname = $detail->sender_name;
					
				//message content default display
				$message_content = '';
					
				$message_content .= '<br/><br/>';
				$message_content .= '<br/><br/>';
				$message_content .= ' ';
				$message_content .= '  <br/><br/>';
				$message_content .= '-------------------------------------------------------------------------------------';
				$message_content .= '<br/>'.$detail->message_details;
				$message_content .= '<br/><br/>';
				$message_content .= '<br/><br/>';
				$breaks = array("<br />","<br>","<br/>");  
				$message_content = str_ireplace($breaks, "\r\n", $message_content); 
				/*$message_content .= '<br/>';
				$message_content .= '<br/>';
				$message_content .= '-----------------------------------------------------------------------------------------------<br/>';
				$message_content .= 'From: '.$Rname.' <'.$detail->sender_username.'><br/>';
				$message_content .= 'To: '.$Sname.' <'.$detail->receiver_username.'><br/>';
				$message_content .= 'Sent: '.date("F j, Y, g:i a", strtotime($detail->date_sent)) .'<br/>';
				$message_content .= 'Subject: '.$detail->message_subject.'<br/>';
				$message_content .= '<br/><br/>';
				$message_content .= $detail->message_details;
				$message_content .= '<br/><br/>';
				$message_content .= '-----------------------------------------------------------------------------------------------';
					
					
				$breaks = array("<br />","<br>","<br/>");  
				$message_content = str_ireplace($breaks, "\r\n", $message_content); 
				*/				
					
				$data['message_details'] = $message_content;
				$data['replying_to'] = '<strong>Replying to:</strong> '.$Rname;
				$data['email_to'] = '<strong>Email To:</strong> '.$Rname.' ('.$detail->sender_email.')';
				$data['message_id'] = $detail->id;
				$data['headerTitle'] = 'Re: '.$detail->message_subject;			

			} else {
				$data['success'] = false;
			}
			echo json_encode($data);
					
		}
	
	
		/**
		* Function to mark messages
		* as read 
		*/	
		public function mark_as_read(){
			
			//escaping the post values
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
				
			//escaping the post values
			$message_id = html_escape($this->input->post('message_id'));
			$id = preg_replace('#[^0-9]#i', '', $message_id); // filter everything but numbers
			
			$update = array(
				'opened' => '1',
			);
			$this->db->where('id', $id);
			$query = $this->db->update('messages', $update);
			if($query){
				$email = $this->session->userdata('email');
				if($this->session->userdata('admin_logged_in')){
					$email = $this->session->userdata('admin_username');
				}
			
				$data['count_unread_messages'] = $this->Messages->count_unread_messages($email);
				$data['success'] = true;
			}
			
			//echo json_encode($data);
			
		}



		/**
		* Function to handle new compose
		* 
		* 
		*/	
		public function new_message_detail(){
			
			
			$message_id = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $message_id); // filter everything but numbers
			
			$model = html_escape($this->input->post('model'));
			
			
			//initialise variables
			$email = ''; 
			$user_array = '';
			$sender_name = '';
			$sender_email = '';
			$receiver_name = '';
			$receiver_email = ''; 
			
			//check if admin loggedin
			if($this->session->userdata('admin_logged_in')){
				
				$email = $this->session->userdata('admin_username');
				$user_array = $this->Admin->get_user($email);
				
				if($user_array){
					foreach($user_array as $user){
						$sender_name = $user->admin_name;
						$sender_email = $user->admin_username;
					}
				}
			}
			
			//check if user logged in
			if($this->session->userdata('logged_in')){
				
				$email = $this->session->userdata('email');
				$user_array = $this->Users->get_user($email);
				if($user_array){
					foreach($user_array as $user){
						$sender_name = $user->first_name .' '.$user->last_name;
						$sender_email = $email;
					}
				}
			}
			
			$detail = $this->db->select('*')->from($model)->where('id',$id)->get()->row();
			
			if($detail){
				
				if($model == 'admin_users'){
					$receiver_name = $detail->admin_name;
					$receiver_email = $detail->admin_username; 
				}
				if($model == 'users'){
					$receiver_name = $detail->first_name .' '.$detail->last_name;
					$receiver_email = $detail->email_address; 
				}
			}
			if($receiver_email != $email){
				
				$data['email_to'] = $receiver_name.' ('.$receiver_email.')';
					
				$data['messageTitle'] = 'Send Message To '.$receiver_name;
				$data['sender_name'] = $sender_name;
				$data['sender_email'] = $sender_email;
				$data['receiver_name'] = $receiver_name;
				$data['receiver_email'] = $receiver_email;
				$data['model'] = $model;

				$data['success'] = true;
			
			} else {
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> You can\'t email that user!</div>';
				$data['success'] = false;
			}
			echo json_encode($data);
					
		}


		/**
		* Function to validate replied
		* message
		*/	
		public function reply_message(){
			
			$this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
            $this->form_validation->set_rules('sender_name','Sender Name','required|trim|xss_clean');
			$this->form_validation->set_rules('sender_email','Sender Email','required|trim|xss_clean');
			$this->form_validation->set_rules('receiver_name','Receiver Name','required|trim|xss_clean');
			$this->form_validation->set_rules('receiver_email','Receiver Email','required|trim|xss_clean');
			$this->form_validation->set_rules('message_subject','Subject','required|trim|xss_clean');
			$this->form_validation->set_rules('message_details','Message','required|trim|xss_clean');
		
			$this->form_validation->set_message('required', 'Please enter a %s!');
			
			//$id = $this->input->post('message_id');
			
			if ($this->form_validation->run()){
				
				//escaping the post values
				$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
					
				//escaping the post values
				$message_id = html_escape($this->input->post('message_id'));
				$id = preg_replace('#[^0-9]#i', '', $message_id); // filter everything but numbers
				
				//check if files attached
				$upload = false;
				$attachment = '0';
				
				//validate file type before upload
				$file_type_error = false;
				
				//Cross Site Scripting prevention filter 
				$file_clean = true;
				$count = count($_FILES['documents']['size']);
				
				foreach($_FILES["documents"]["error"] as $key => $value){
					if($value == 0){
						$upload = true;
						$attachment = '1';
						$file_clean = $this->Files->file_xss_clean($_FILES['documents']);
						break;
					}
				}
				
				
				//array of all post variables
				$message_data = array(
					'sender_name' => $this->input->post('sender_name'),
					'sender_email' => $this->input->post('sender_email'),
					'receiver_name' => $this->input->post('receiver_name'),
					'receiver_email' => $this->input->post('receiver_email'),
					'message_subject' => $this->input->post('message_subject'),
					'message_details' => $this->input->post('message_details'),
					'opened' => '0',
					'recipient_archive' => '0',
					'sender_archive' => '0',
					'replied' => '0',
					'date_sent' => date('Y-m-d H:i:s'),
				);
				
				$message_id = $this->Messages->reply_message($message_data, $id);
				
				if($message_id && $file_clean){
					
					if($upload){
						
						//FILE PATH
						$path = './uploads/files/'.$message_id.'/';
						$files = $_FILES;
						
						//STORE FILE DATA
						$file_data = array(
							'message_id' => $message_id,
							'user_email' => $this->input->post('receiver_email'),
							'created' => date('Y-m-d H:i:s'), 
							'status' => '1',
						);
						//UPLOAD FILE
						$upload_status = $this->Files->upload_files($path, $_FILES['documents'], $file_data);
						
						if($upload_status != true){
							$data['upload_error'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> '.$upload_status.'</div>';
						}
						
					}//*/


					//STORE INFO IN ADDRESS BOOK
					$sender_email = $this->input->post('sender_email');
					$receiver_name = $this->input->post('receiver_name');
					$receiver_email = $this->input->post('receiver_email');
					
					//CHECK IF INFO ALREADY EXISTS
					if($this->Address_book->unique_address($sender_email, $receiver_name,$receiver_email)){
						
						$address_book_data = array(
							'sender_email' => $this->input->post('sender_email'),
							'receiver_name' => $this->input->post('receiver_name'),
							'receiver_email' => $this->input->post('receiver_email'),
							'date_added' => date('Y-m-d H:i:s'),
						);
						$this->Address_book->add_address($address_book_data);
					}
					
					//count users sent messages
					$data['count_sent_messages'] = $this->Messages->count_sent_messages($sender_email);
				
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Your reply has been sent!</div>';
				
				}else {
					if($file_type_error || $file_clean){
						$data['success'] = false;
						
						$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Please only upload a valid file!</div>';
					}else{
						$data['success'] = false;
						
						$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Reply not sent! </div>';
					}
					
						
				}
					
			}else {
				$data['success'] = false;
				$data['notif'] = '<div class="text-center" role="alert">'.validation_errors().'</div>';
				$data['errors'] = '<div class="text-center" role="alert">'.validation_errors().'</div>';
			}
			echo json_encode($data);
		}

		
		/**
		* Function to prevent user from posting
		* same message within a few seconds
		*/			
		public function prevent_double_post($username){

			$date = date("Y-m-d H:i:s",time());
			$date = strtotime($date);
			$min_date = strtotime("-20 second", $date);
			
			$max_date = date('Y-m-d H:i:s', time());
			$min_date = date('Y-m-d H:i:s', $min_date);
			
			$this->db->select('*');
			$this->db->from('messages');
			$this->db->where('sender_username', $username);
			
			$this->db->where("date_sent BETWEEN '$min_date' AND '$max_date'", NULL, FALSE);

			$query = $this->db->get();
			
			if ($query->num_rows() >= 1){	
				return true;
			}else {
				return false;
			}	
								
		}		
		
		
		/**
		* Function to validate
		* new message sent
		*/	
		public function new_message_validation(){
			
			$this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');
			
            $this->form_validation->set_rules('sender_name','Sender Name','required|trim|xss_clean');
			$this->form_validation->set_rules('sender_email','Sender Email','required|trim|xss_clean');
			$this->form_validation->set_rules('receiver_name','Receiver Name','required|trim|xss_clean');
			$this->form_validation->set_rules('receiver_email','Receiver Email','required|trim|xss_clean');
			$this->form_validation->set_rules('message_subject','Subject','required|trim|xss_clean');
			$this->form_validation->set_rules('message_details','Message','required|trim|xss_clean|callback_check_double_messaging');
		
			$this->form_validation->set_message('required', 'Please enter a %s!');
			$this->form_validation->set_message('min_length', '%s is too short!');
			
			if ($this->form_validation->run()){
				
				//store info in address book
				$email = $this->input->post('sender_email');
				$receiver_name = $this->input->post('receiver_name');
				$receiver_email = $this->input->post('receiver_email');
				
				//check if files attached
				$upload = false;
				$attachment = '0';
				
				//validate file type before upload
				$file_type_error = false;
				
				//Cross Site Scripting prevention filter 
				$file_clean = true;
				$count = count($_FILES['documents']['size']);
				//!empty($_FILES['documents']['name'])
				//file_exists($_FILES['documents']['tmp_name']) || is_uploaded_file($_FILES['documents']['tmp_name'])
				/*if(isset($_FILES['documents']) && count($_FILES['documents']['error']) == 1 && $_FILES['documents']['error'][0] > 0){
					$upload = true;
					//$attachment = '1';
					//$file_type_error = $this->Files->file_check($_FILES['documents']);
					$file_clean = $this->Files->file_xss_clean($_FILES['documents']);
				}
				*/
				foreach($_FILES["documents"]["error"] as $key => $value){
					if($value == 0){
						$upload = true;
						$attachment = '1';
						$file_clean = $this->Files->file_xss_clean($_FILES['documents']);
						break;
					}
				}
				//array of all post variables
				$message_data = array(
					'sender_name' => $this->input->post('sender_name'),
					'sender_email' => $this->input->post('sender_email'),
					'receiver_name' => $this->input->post('receiver_name'),
					'receiver_email' => $this->input->post('receiver_email'),
					'message_subject' => $this->input->post('message_subject'),
					'message_details' => $this->input->post('message_details'),
					'attachment' => $attachment,
					'opened' => '0',
					'recipient_archive' => '0',
					'recipient_delete' => '0',
					'sender_archive' => '0',
					'sender_delete' => '0',
					'replied' => '0',
					'date_sent' => date('Y-m-d H:i:s'),
				);
				
				$message_id = $this->Messages->send_new_message($message_data);
				
				if($message_id && $file_clean){
					// && $file_type_error && $file_clean
					if($upload){
						
						//FILE PATH
						$path = './uploads/files/'.$message_id.'/';
						$files = $_FILES;
						
						//STORE FILE DATA
						$file_data = array(
							'message_id' => $message_id,
							'user_email' => $receiver_email,
							'created' => date('Y-m-d H:i:s'), 
							'status' => '1',
						);
						//UPLOAD FILE
						$upload_status = $this->Files->upload_files($path, $_FILES['documents'], $file_data);
						
						if($upload_status != true){
							$data['upload_error'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> '.$upload_status.'</div>';
						}
						
					}//*/
					
					//check if files attached
					/*if(!empty($_FILES['documents']['name'])){
						
						//COUNT NUMBER OF FILES ATTACHED
						$count = count($_FILES['documents']['size']);
						//GET ATTACHED FILES
						foreach($_FILES as $key=>$value){
							
							for($s=0; $s<=$count-1; $s++) {
								
								$_FILES['documents']['name']=$value['name'][$s];
								$_FILES['documents']['type'] = $value['type'][$s];
								$_FILES['documents']['tmp_name'] = $value['tmp_name'][$s];
								$_FILES['documents']['error'] = $value['error'][$s];
								$_FILES['documents']['size'] = $value['size'][$s]; 	
								
								//ensure only files with input are processed
								if ($_FILES['documents']['size'] > 0) {
												
									$path = './uploads/files/'.$message_id.'/';
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
									
									if($this->upload->do_upload('documents')){
											
										$upload_data = $this->upload->data();
											
										$file_name = '';
										if (isset($upload_data['file_name'])){
											$file_name = $upload_data['file_name'];
										}
										
										//STORE FILE DATA
										$file_data = array(
											'message_id' => $message_id,
											'user_email' => $receiver_email,
											'file_name'=> $file_name,
											'created' => date('Y-m-d H:i:s'), 
											'status' => '1',
										);
										$this->db->insert('files',$file_data);		
										
									}else{
										if($this->upload->display_errors()){
											$data['upload_error'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> '.$this->upload->display_errors().'</div>';

										}
									}
									
									
								}
							}
						}
					}*/
					
					//count users sent messages
					$data['count_sent_messages'] = $this->Messages->count_sent_messages($email);
				
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Message Sent!</div>';
					$data['toast'] = 'Your message has been sent!</div>';
				
				}else{
					if($file_type_error || $file_clean){
						$data['success'] = false;
						$data['notif'] = '<div class="alert alert-danger text-center" role="alert"> Please only upload a valid file!</div>';
					}else{
						$data['success'] = false;
						$data['notif'] = '<div class="alert alert-danger text-center" role="alert"> Message not sent!</div>';
					}
					
				}
			}else {
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert">'.validation_errors().'</div>';
			}
			echo json_encode($data);
		}

		  		
		/**
		* Function to validate
		* new message sent
		*/	
		public function bulk_message_validation(){
			
			$this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
            $this->form_validation->set_rules('sender_name','Sender Name','required|trim|xss_clean');
			$this->form_validation->set_rules('sender_username','Sender Username','required|trim|xss_clean');
			
			$this->form_validation->set_rules('message_subject','Subject','required|trim|xss_clean');
			$this->form_validation->set_rules('message_details','Message','required|trim|xss_clean|callback_check_double_messaging');
			$this->form_validation->set_rules('model','Model','required|trim|xss_clean');
		
			$this->form_validation->set_message('required', 'Please enter a %s!');
			$this->form_validation->set_message('min_length', '%s is too short!');
			
			if ($this->form_validation->run()){
				
				//initialise variables
				$success = false;
				$recipients_array = '';
				
				//get model name
				$model = $this->input->post('model');
				if($model == 'users'){
					//get all from db
					$recipients_array = $this->Users->get_all_users();
				}
				
				//check if array not empty
				if($recipients_array){
					
					//loop through array and send mail to each
					foreach($recipients_array as $recipient){
						
						//get receivers details for message db
						$receiver_name = $recipient->first_name .' '.$recipient->last_name;
						$receiver_username = $recipient->username;
						
						//array of all post variables
						$message_data = array(
							'sender_name' => $this->input->post('sender_name'),
							'sender_username' => $this->input->post('sender_username'),
							'receiver_name' => $receiver_name,
							'receiver_username' => $receiver_username,
							'message_subject' => $this->input->post('message_subject'),
							'message_details' => $this->input->post('message_details'),
							'opened' => '0',
							'recipient_archive' => '0',
							'sender_archive' => '0',
							'replied' => '0',
							'date_sent' => date('Y-m-d H:i:s'),
						);
						
						//save to messages table
						if($this->Messages->send_new_message($message_data)){
							
									
							//store info in address book
							$username = $this->input->post('sender_username');
							$receiver_name = $this->input->post('receiver_name');
							$receiver_username = $this->input->post('receiver_username');

							if($this->Address_book->unique_address($username,$receiver_name,$receiver_username)){
								
								$address_data = array(
									'sender_username' => $username,
									'receiver_name' => $receiver_name,
									'receiver_username' => $receiver_username,
									'date_added' => date('Y-m-d H:i:s'),
								);
								
								$this->Address_book->add_address($address_data);
							}	
							
							$success = true;
							
						}
						
						
					}
					
					if($success){
						$data['success'] = $success;
						$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Your messages have been sent!</div>';
					}else{
						$data['success'] = $success;
						$data['notif'] = '<div class="alert alert-danger text-center" role="alert"> <i class="fa fa-exclamation-triangle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Error sending messages!</div>';
					}
				
				}
				
			}else {
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert">'.validation_errors().'</div>';
			}
			echo json_encode($data);
		}
				
		
		/**
		* Function to check_double_post 
		* 
		*/			
		public function check_double_messaging(){
			
			$email = $this->input->post('sender_email');
			$date = date("Y-m-d H:i:s",time());
			$date = strtotime($date);
			$min_date = strtotime("-20 second", $date);
			
			$max_date = date('Y-m-d H:i:s', time());
			$min_date = date('Y-m-d H:i:s', $min_date);
			
			$this->db->select('*');
			$this->db->from('messages');
			$this->db->where('sender_email', $email);
			
			$this->db->where("date_sent BETWEEN '$min_date' AND '$max_date'", NULL, FALSE);

			$query = $this->db->get();
			
			if ($query->num_rows() >= 1){	
				$this->form_validation->set_message('check_double_messaging', 'You must wait at least 20 seconds before you send another message!');
				return FALSE;
			}else {
				
				return TRUE;
			}	
		}	
		
		
		/**
		* Function to check if the user has sent
		*  too many messages in 24 hours
		*/			
		public function max_sent_messages(){
			
			//obtain users username
			$email = '';
			if($this->session->userdata('admin_logged_in')){
				$email = $this->session->userdata('admin_username');
			}
			//check if user logged in
			if($this->session->userdata('logged_in')){
				$email = $this->session->userdata('email');
			}
			
			$date = date("Y-m-d H:i:s",time());
			$date = strtotime($date);
			$min_date = strtotime("-1 day", $date);
			
			$max_date = date('Y-m-d H:i:s', time());
			$min_date = date('Y-m-d H:i:s', $min_date);
			
			$this->db->select('*');
			$this->db->from('messages');
			$this->db->where('sender_email', $email);
			
			$this->db->where("date_sent BETWEEN '$min_date' AND '$max_date'", NULL, FALSE);

			$query = $this->db->get();
			
			//get admin username array
			//$admin_usernames = $this->Admin->get_all_usernames();
			
			//get team members username array
			//$member_usernames = $this->Users->get_all_usernames();
			
			if ($query->num_rows() < 20){	
				return TRUE;	
			}
			//else if(in_array(strtolower($username), $admin_usernames) || in_array(strtolower($username), $member_usernames)){
				//return TRUE;
			else {	
				$this->form_validation->set_message('max_sent_messages', 'You can\'t send any more messages. Your have surpassed the allowed quota in 24 hours! Please contact Customer Service!');
				return FALSE;
			}
		}	
	
				
			
		
		/**
		* Function to delete
		* multiple messages
		*/			
		public function multi_delete() {
			
			//escaping the post values
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
				
			if($this->input->post('table') == 'inbox_messages'){
						
				$data = array(
					'recipient_archive' => '1',
				);
				
				//get checked items from post
				$checked_messages =  html_escape($this->input->post('cb'));
				//$checked_messages = $this->input->post('cb');		
				
				$this->db->where_in('id', $checked_messages);
				$query = $this->db->update('messages', $data);	
						
				if($query){
							
					$count = count($checked_messages);
					
					if($count == 1){
						//$this->session->set_flashdata('message_deleted', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".commentDiv").fadeOut("slow"); }, 5000);</script><div class="commentDiv alert alert-success text-center"><i class="fa fa-check-circle"></i>'.$count.' message has been archived!</div>');
								
						$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fa fa-check-circle"></i>'.$count.' message has been archived!</div>';
					}else{
						//$this->session->set_flashdata('archived', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".commentDiv").fadeOut("slow"); }, 5000);</script><div class="commentDiv alert alert-success text-center"><i class="fa fa-check-circle"></i>'.$count.' messages have been archived!</div>');
						$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fa fa-check-circle"></i>'.$count.' messages have been archived!</div>';

					}
							
					$data['success'] = true;
					
				}else{
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Delete Error!</div>';
					$data['success'] = false;
				}
												
				//redirect('account/messages/','refresh');
			}
			
			if($this->input->post('table') == 'sent_messages'){
						
				$data = array(
					'sender_archive' => '1',
				);
				
				//get checked items from post
				$checked_messages =  html_escape($this->input->post('cb'));
				//$checked_messages = $this->input->post('cb');
				$this->db->where_in('id', $checked_messages);
				$query = $this->db->update('messages', $data);	
						
				if($query){
					$count = count($checked_messages);
					if($count == 1){
						//$this->session->set_flashdata('archived', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".commentDiv").fadeOut("slow"); }, 5000);</script><div class="commentDiv alert alert-success text-center"><i class="fa fa-check-circle"></i>'.$count.' message has been archived!</div>');
								
						$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fa fa-check-circle"></i>'.$count.' message has been archived!</div>';
								
					}else{
						//$this->session->set_flashdata('message_deleted', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".commentDiv").fadeOut("slow"); }, 5000);</script><div class="commentDiv alert alert-success text-center"><i class="fa fa-check-circle"></i>'.$count.' messages have been archived!</div>');
								
						$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fa fa-check-circle"></i>'.$count.' messages have been archived!</div>';
					}
				}else{
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Delete Error!</div>';
					$data['success'] = false;
				}
						//redirect('message/sent_messages/','refresh');
			}				
				
			echo json_encode($data);
        }		
					
		
		/**
		* Function to archive
		* multiple messages
		*/			
		public function multi_archive(){
			
			
			if($this->input->post('cb') != '' && $this->input->post('table')== 'inbox' )
			{
				$username = $this->session->userdata('username');
				
				//get checked items from post
				$checked =  html_escape($this->input->post('cb'));
				
				//check if message has been read
				$unread = $this->Messages->check_for_unread('0',$checked);
				//$this->db->where_in('id', $checked);
				//$this->db->where('opened', '0');
				//$q = $this->db->get('messages');
				
				if(!$unread){
					
					$update = array(
						'recipient_archive' => '1',
					);
					
					$this->db->where_in('id', $checked);
					$query = $this->db->update('messages', $update);	
							
					if($query){
						$count = count($checked);
						$message = '';
						if($count == 1){
							$message = $count.' message has been archived!';
							
						}else{
							$message = $count.' messages have been archived!';
						}
						
						//get current inbox count
						$count_inbox_messages = $this->Messages->count_unread_messages($username);
						if($count_inbox_messages == '' || $count_inbox_messages == null){
							$data['count_inbox_messages'] = 0;
						}else{
							$data['count_inbox_messages'] = $count_inbox_messages;
						}
						
						//get current archive count
						$count_archive_messages = $this->Messages->count_archive_messages($username);
						if($count_archive_messages == '' || $count_archive_messages == null){
							$data['count_archive_messages'] = 0;
						}else{
							$data['count_archive_messages'] = $count_archive_messages;
						}	
						$data['table'] = 'inbox';
						
						$data['success'] = true;
						$data['notif'] = '<div class="alert alert-success text-success text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fa fa-check-circle"></i> '.$message.'</div>';
					}
					
				}else{
					$data['success'] = false;
					$data['notif'] = '<div class="alert alert-danger text-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-ban"></i> You can\'t archive unread message(s)!</div>';
				}
				
				
				
			}
			
			echo json_encode($data);
		}
			
		
		/**
		* Function to archive
		* multiple messages
		*/			
		public function sent_archive(){
			
			if($this->input->post('cb') != '' && $this->input->post('table')== 'sent' )
			{
				$username = $this->session->userdata('username');
				
				//get checked items from post
				$checked =  html_escape($this->input->post('cb'));
				
				$update = array(
					'sender_archive' => '1',
				);
				
				$this->db->where_in('id', $checked);
				$query = $this->db->update('messages', $update);	
						
				if($query){
					$count = count($checked);
					$message = '';
					if($count == 1){
						$message = $count.' message has been deleted!';
						
					}else{
						$message = $count.' messages have been deleted!';
					}
					
					//get current sent count
					$count_sent_messages = $this->Messages->count_sent_messages($username);
					if($count_sent_messages == '' || $count_sent_messages == null){
						$data['count_sent_messages'] = 0;
					}else{
						$data['count_sent_messages'] = $count_sent_messages;
					}
					
					$data['table'] = 'sent';
					
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-success text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fa fa-check-circle"></i> '.$message.'</div>';
				}
				
				
			}
			else{
				//$url = current_url();
				//redirect($url);
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-ban"></i> Can\'t delete message(s)!</div>';
			}
			
			echo json_encode($data);
		}
											
		
		/**
		* Function to move multiple archive 
		* messages back to inbox
		*/			
		public function move_to_inbox() {
			
			
			if($this->input->post('cb') != '' && $this->input->post('table') == 'archives'){
						
				$username = $this->session->userdata('username');
				
				//escaping the post values
				$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
				
			
				//get checked items from post
				$checked_messages =  html_escape($this->input->post('cb'));
				//$checked_messages = $this->input->post('cb');		
				
				$update = array(
					'recipient_archive' => '0',
				);
				
				$this->db->where_in('id', $checked_messages);
				$query = $this->db->update('messages', $update);	
						
				if($query){
							
					$count = count($checked_messages);
					
					if($count == 1){
						
						$data['notif'] = '<div class="alert alert-success text-success text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fa fa-check-circle"></i>'.$count.' message has been moved to your inbox!</div>';
					}else{
						$data['notif'] = '<div class="alert alert-success text-success text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fa fa-check-circle"></i>'.$count.' messages  has been moved to your inbox!</div>';

					}
							
					$data['success'] = true;
					
					//get current inbox count
					$count_inbox_messages = $this->Messages->count_unread_messages($username);
					if($count_inbox_messages == '' || $count_inbox_messages == null){
						$data['count_inbox_messages'] = 0;
					}else{
						$data['count_inbox_messages'] = $count_inbox_messages;
					}
					
					//get current archive count
					$count_archive_messages = $this->Messages->count_archive_messages($username);
					if($count_archive_messages == '' || $count_archive_messages == null){
						$data['count_archive_messages'] = 0;
					}else{
						$data['count_archive_messages'] = $count_archive_messages;
					}	
					
					
				}else{
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Delete Error!</div>';
					$data['success'] = false;
				}
												
				//redirect('account/messages/','refresh');
			}				
				
			echo json_encode($data);
        }		
	  
			
		
		
		
		
		
		



}