<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

		/**
		 * Index Page for this controller.
		 *
		 *
		 */
		
		public function index()
		{
			$this->dashboard();
		}
		
		
		/**
		* Function to access client account
		*
		*/
        public function dashboard() {
			 
			if($this->session->userdata('logged_in')){
				
				//check if redirect url is set
				$redirect = '';
				if($this->session->flashdata('redirectURL')){
					$redirect = $this->session->flashdata('redirectURL');
					//redirect user to previous url
					//$url = 'account/'.$redirect;
					redirect($redirect);
				}	
				$alert = false;
				$message = '';
				$email = $this->session->userdata('email');
				
				$percentage_completion = $this->Users->profile_completion($email);
				
				$data['profile_completion'] = $percentage_completion;
				$data['profile_completion_string'] = $percentage_completion.'%';
				
				
				$data['user_array'] = $this->Users->get_user($email);
				
				$user_id = '';
				$fullname = '';
				//$email_address = '';
				$company_name = '';
				$last_login = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
						$last_login = $user->last_login;
						$user_id = $user->id;
						$fullname = $user->first_name .' '.$user->last_name;
						//$email = $user->email_address;
						$company_name = $user->company_name;
					}
					if($last_login == '0000-00-00 00:00:00' || $last_login == ''){ 
						
						$last_login = 'Never'; 
						$alert = true;
						//$alert = '<script type="text/javascript" language="javascript">$(function() { $("#popModal").modal("show"); });</script>';
						//$this->session->set_flashdata('alert', '');
						//$this->session->set_flashdata('alert', '<script type="text/javascript" language="javascript">$(function() { $(".custom-modal").show(); });</script>');
						
					}else{ 
						$last_login = date("F j, Y, g:i a", strtotime($last_login));
						$alert = false;	
					}
				}
				
				$data['last_login'] = $last_login;
				$data['fullname'] = $fullname;
				$data['user_id'] = $user_id;
				$data['email'] = $email;
				$data['company_name'] = $company_name;
				$data['alert'] = $alert;
				$data['message'] = $message;
				
				$messages_unread = $this->Messages->count_unread_messages($email);
				if($messages_unread == '' || $messages_unread == null){
					$data['messages_unread'] = 0;
				}else{
					$data['messages_unread'] = $messages_unread;
				}
				
				$data['header_messages_array'] = $this->Messages->get_header_messages($email);	
				
				
				$data['address_book_array'] = $this->Address_book->get_address_book($email);	
				
				
				$enquiries_unread = $this->Sale_enquiries->count_unread_enquiries($email);
				if($enquiries_unread == '' || $enquiries_unread == null){
					$data['enquiries_unread'] = 0;
				}else{
					$data['enquiries_unread'] = $enquiries_unread;
				}
				
				$data['transactions_array'] = $this->Transactions->get_user_transactions($email, 5, 0);
				$data['transactions_count'] = $this->Transactions->count_new_transactions($email);
				if($data['transactions_count'] == '' || $data['transactions_count'] == null){
					$data['transactions_count'] = 0;
				}	
				
				
				$data['orders_array'] = $this->Orders->get_user_orders($email,4, 0);
				$data['orders_count'] = $this->Orders->count_user_all();
				if($data['orders_count'] == '' || $data['orders_count'] == null){
					$data['orders_count'] = 0;
				}		
				
				
				$data['payments_array'] = $this->Payments->get_payments($email,4, 0);
				$data['payments_count'] = $this->Payments->count_user_all();
				if($data['payments_count'] == '' || $data['payments_count'] == null){
					$data['payments_count'] = 0;
				}		
				
				
				$data['vehicles_array'] = $this->Vehicles->get_user_vehicles($email,4, 0);
				$data['vehicles_count'] = $this->Vehicles->count_user_all();
				if($data['vehicles_count'] == '' || $data['vehicles_count'] == null){
					$data['vehicles_count'] = 0;
				}		
						
				
				$activities_array = $this->Site_activities->get_user_activities($email, 7, 0);
				
				$activity_group = '';
				$activity_class = '';
				
				if(!empty($activities_array)){
					foreach($activities_array as $activity){
						//get time ago
						$activity_time = $this->Site_activities->time_elapsed_string(strtotime($activity->activity_time));
						$icon = '<i class="fa fa-list-alt" aria-hidden="true"></i>';
						
						//obtain keyword icon from the db using sender email
						$query = $this->db->get_where('keywords', array('keyword' => $activity->keyword));
						if($query){
							foreach ($query->result() as $row){
								$icon = $row->icon;
							}							
						}
						
						$activity_group .= '<a href="javascript:void(0)" class="list-group-item">';
						$activity_group .= '<span class="badge">'.$activity_time.'</span>';
						$activity_group .= $icon .' You '.$activity->description;
						$activity_group .= '</a>';
						$activity_class = '';
					}
				}else{
					$activity_group = '<br/><br/><h2 align="center"><a href="#" class="list-group-item"><i class="fa fa-star-o" aria-hidden="true"></i> No activities yet</a></h2>';
					$activity_class = 'fixed_height_405';
				}
				
				$data['activity_group'] = $activity_group;
				$data['activity_class'] = $activity_class;		
				
				//assign page title name
				$data['pageTitle'] = 'Dashboard';
				
				//assign page ID
				$data['pageID'] = 'dashboard';
				
				//load header and page title
				$this->load->view('account_pages/header', $data);
				
				//load main body
				$this->load->view('account_pages/dashboard_page', $data);
				
				//load footer
				$this->load->view('account_pages/footer');
				
			}
			else {
				if($this->session->flashdata('redirectURL')){
					$redirect = $this->session->flashdata('redirectURL');
					$url = 'login?redirectURL='.$redirect;
					redirect($url);
				}else{	

					redirect('login');
					//user not logged in, redirects to login page
					//redirect('home/','refresh');           
				} 
			}  
        } 

		
		
		/***
		* FUNCTION TO DISPLAY USERS ORDERS
		*
		***/		
		public function orders(){
			
			if(!$this->session->userdata('logged_in')){
								
				$url = 'login?redirectURL='.urlencode(current_url());
				redirect($url);							
				
				
			}else{			

				$email = $this->session->userdata('email');
				
				$data['user_array'] = $this->Users->get_user($email);
					
				$fullname = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
						$fullname = $user->first_name .' '.$user->last_name;
					}
				}
				
				$data['fullname'] = $fullname;
				
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
				
				
				//assign page title name
				$data['pageTitle'] = 'Orders';
								
				//assign page title name
				$data['pageID'] = 'orders';
										
				//load header and page title
				$this->load->view('account_pages/header', $data);
							
				//load main body
				$this->load->view('account_pages/orders_page', $data);	
					
				//load footer
				$this->load->view('account_pages/footer');
					
			}
				
		}
		
	
		
		/***
		* Function to handle orders ajax
		* Datatable
		***/
		public function orders_datatable()
		{
			
			$list = $this->Orders->get_user_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $order) {
				$no++;
				$row = array();
				
				//$row[] = '<input type="checkbox" name="cb[]" id="cb" onclick="enableButton(this)" value="'.$order->id.'">';
				
				$url = 'account/order_details';
				
				$row[] = $order->reference;
				
				$row[] = '$'.number_format($order->total_price, 0);
				$row[] = $order->num_of_items;
				
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
					$payment_status = '<span class="badge bg-orange">Pending</span>';
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
				
				
				$row[] = '<a class="btn btn-default btn-xs" data-toggle="modal" href="#" data-target="#viewOrderModal" onclick="viewOrder('.$order->id.',\''.$url.'\');" title="View"><i class="fa fa-search" aria-hidden="true"></i> View</a>';
				
				
				//$row[] = $type->details;
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Orders->count_user_all(),
				"recordsFiltered" => $this->Orders->count_user_filtered(),
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
				
					$data['order_date'] = date("F j, Y", strtotime($detail->order_date));
					$numOfItems = '';
					if($detail->num_of_items == 1){
						$numOfItems = $detail->num_of_items.' item';
					}else{
						$numOfItems = $detail->num_of_items.' items';
					}
					
					$data['headerTitle'] = 'Order: '.$detail->reference.' <span class="badge bg-green" >'.$numOfItems.'</span>';	
					
					$data['orderDate'] = date("F j, Y", strtotime($detail->order_date));
					$data['reference'] = $detail->reference;
					$data['order_description'] = $detail->order_description;
					$data['total_price'] = number_format($detail->total_price, 2);
					$data['totalPrice'] = $detail->total_price;
					//$data['tax'] = $detail->tax;
					//$data['shipping_n_handling_fee'] = $detail->shipping_n_handling_fee;
					//$data['payment_gross'] = $detail->payment_gross;
					$data['num_of_items'] = $detail->num_of_items;
				
				
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
						$shipping_status = '<span class="badge bg-orange">Pending</span>';
						
					}
					
					$view_delivery_date = '';
					
					if($estimated_delivery_date == '0000-00-00 00:00:00'){
						$view_delivery_date = 'Not Set';
						
					}else{
						$view_delivery_date = date("F j, Y g:i A", strtotime($estimated_delivery_date));
						
					}
					
					$data['delivery_date'] = $view_delivery_date;
					
					$data['edit_shipping_status'] = $edit_shipping_status;
					$data['shipping_status'] = $shipping_status;
					$data['shipping_fee'] = $shipping_fee;
					$data['tax'] = $tax;
					
					$data['origin_city'] = $origin_city;
					$data['origin_country'] = $origin_country;
				
					$data['destination_city'] = $destination_city;
					$data['destination_country'] = $destination_country;
				
					$data['model'] = 'orders';
					$data['success'] = true;

			}else {
				$data['success'] = false;
			}
			echo json_encode($data);
		}					
		
			
		
		/***
		* Function to handle transactions
		*
		***/		
		public function transactions(){
			
			if(!$this->session->userdata('logged_in')){
								
				$url = 'login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//redirect('login/','refresh');
				
			}else{			

				$email = $this->session->userdata('email');
				
				$data['user_array'] = $this->Users->get_user($email);
					
				$fullname = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
						$fullname = $user->first_name .' '.$user->last_name;
					}
				}
				
				
				$data['fullname'] = $fullname;
				
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
				
				
				//assign page title name
				$data['pageTitle'] = 'Transactions';
								
				//assign page title name
				$data['pageID'] = 'transactions';
										
				//load header and page title
				$this->load->view('account_pages/header', $data);
							
				//load main body
				$this->load->view('account_pages/transactions_page', $data);	
					
				//load footer
				$this->load->view('account_pages/footer');
					
			}
				
		}
		
	
		
		/***
		* Function to handle transaction ajax
		* Datatable
		***/
		public function transaction_datatable()
		{
			
			$list = $this->Transactions->get_user_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $transaction) {
				$no++;
				$row = array();
				
				$url = 'account/transaction_details';
				
				$row[] = $transaction->order_reference;
				
				//$row[] = $no;
				
				$row[] = '$'.number_format($transaction->order_amount, 2);
				
				$row[] = '$'.number_format($transaction->shipping_and_handling_costs, 2);
				
				$row[] = '$'.number_format($transaction->total_amount, 2);
				
				
				$status = '';
				if($transaction->status == '0'){
					$status = '<span class="badge bg-orange">Pending</span>';
				}else{
					$status = '<span class="badge bg-green">Paid</span>';
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
				
				$row[] = '<a class="btn btn-default btn-xs" data-toggle="modal" href="#" data-target="#viewTransactionModal" onclick="viewTransaction('.$transaction->id.',\''.$url.'\');" title="View"><i class="fa fa-search" aria-hidden="true"></i> View</a>';
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Transactions->count_user_all(),
				"recordsFiltered" => $this->Transactions->count_user_filtered(),
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
		* Function to handle payments datatable
		*
		***/
		public function payments_datatable()
		{
			$list = $this->Payments->get_user_datatables();
			$data = array();
			$no = $_POST['start'];
			$last_login  = '';
			foreach ($list as $payment) {
				$no++;
				$row = array();
				$row[] = $payment->reference;
				
				$row[] = '$'.number_format($payment->total_amount, 2);
				$row[] = ucwords($payment->payment_method);
				
				$row[] = date("F j, Y g:i a", strtotime($payment->payment_date));
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Payments->count_user_all(),
				"recordsFiltered" => $this->Payments->count_user_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}
		
		
		/***
		* Function to handle shipping
		*
		***/		
		public function shipping(){
			
			if(!$this->session->userdata('logged_in')){
								
				$url = 'login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//redirect('login/','refresh');
				
			}else{			

				$email = $this->session->userdata('email');
				
				$data['user_array'] = $this->Users->get_user($email);
					
				$fullname = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
						$fullname = $user->first_name .' '.$user->last_name;
					}
				}
				
				$data['fullname'] = $fullname;
				
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
				
				//assign page title name
				$data['pageTitle'] = 'Shipping';
								
				//assign page title name
				$data['pageID'] = 'shipping';
										
				//load header and page title
				$this->load->view('account_pages/header', $data);
							
				//load main body
				$this->load->view('account_pages/shipping_page', $data);	
					
				//load footer
				$this->load->view('account_pages/footer');
					
			}
				
		}
		
	
		
		/***
		* Function to handle shipping ajax
		* Datatable
		***/
		public function shipping_datatable()
		{
			
			$list = $this->Shipping->get_user_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $shipping) {
				$no++;
				$row = array();
				
				
				$row[] = $shipping->order_reference;
				
				$row[] = $shipping->shipping_method;
				
				$row[] = '$'.number_format($shipping->shipping_fee, 2);
				
				$row[] = '$'.number_format($shipping->tax, 2);
				
				$status = '';
				if($shipping->status == '0'){
					$status = '<span class="badge bg-orange">Pending</span>';
				}else{
					$status = '<span class="badge bg-green">Shipped</span>';
				}
				$row[] = $status;
					
				
				$shipping_date = $shipping->created;
				
				if($shipping_date == '0000-00-00 00:00:00'){
					$shipping_date = 'Not Shipped';
				}else{
					$shipping_date = date('F j, Y', strtotime($shipping_date));
				}
				$row[] = $shipping_date;
				
				$url = 'account/shipping_details';
				
				$statusURL = 'account/shipping_status_details';
				
				$row[] = '<a data-toggle="modal" data-target="#viewShippingDetailsModal" class="btn btn-success btn-xs" onclick="viewShippingDetails('.$shipping->order_reference.',\''.$statusURL.'\');" id="'.$shipping->order_reference.'" title="Track Shipping"><i class="fa fa-search" aria-hidden="true"></i> Track Shipping</a>';
				
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Shipping->count_user_all(),
				"recordsFiltered" => $this->Shipping->count_user_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
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
			$customer_contact_phone = '';
			$origin = '';
			$destination = '';
			
			if($shipping_array){
				foreach($shipping_array as $shipping){
					
					$customer_contact_phone = $shipping->customer_contact_phone;
					$origin = $shipping->origin_city.', '.$shipping->origin_country;
					$destination = $shipping->destination_city.', '.$shipping->destination_country;
					
					if($shipping->estimated_delivery_date == '0000-00-00 00:00:00'){
						$estimated_delivery_date = 'N/A';
					}else{
						$estimated_delivery_date = date("F j, Y H:i a", strtotime($shipping->estimated_delivery_date));
					}
					
					
				}
			}
			
			$count_shipping = $this->Shipping_status->count_shipping_by_reference($reference);
			if($count_shipping < 0){
				$count_shipping = 0;
			}
			
			$shipping_detail_array = $this->Shipping_status->get_shipping_by_reference($reference);

			if($shipping_detail_array){
				
				$details = '<div class="" style="margin: 0 2% 2% 1%;">';
				$details .= '<p>';
				$details .= '<strong>Origin <i class="fa fa-map-pin" aria-hidden="true"></i> </strong>'.$origin.'<br/>';
				$details .= '</p>';
				
				$details .= '<p>';
				$details .= '<strong>Destination <i class="fa fa-map-marker" aria-hidden="true"></i> </strong>'.$destination.'<br/>';
				$details .= '</p>';
				
				$details .= '<p>';
				$details .= '<strong>Delivery <i class="fa fa-calendar" aria-hidden="true"></i> </strong>'.$estimated_delivery_date.'<br/>';
				$details .= '</p>';
				
				$details .= '<p>';
				$details .= '<strong>Contact <i class="fa fa-phone-square" aria-hidden="true"></i> </strong>'.$customer_contact_phone.'<br/>';
				$details .= '</p>';
				$details .= '</div>';
				
				$details .= '<table class="display table-striped bulk_action dt-responsive nowrap shipping-status" cellspacing="0" width="100%">';
				
				$details .= '<thead><tr>';
				$details .= '<th>Date</th><th>Description</th><th>Location</th><th>Time</th>';
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
		* Function to handle vehicles
		*
		***/		
		public function vehicles(){
			
			if(!$this->session->userdata('logged_in')){
								
				$url = 'login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//redirect('login/','refresh');
				
			}else{			

					$email = $this->session->userdata('email');
				
					$data['user_array'] = $this->Users->get_user($email);
						
					$fullname = '';
					$city = '';
					$country = '';
					if($data['user_array']){
						foreach($data['user_array'] as $user){
							$fullname = $user->first_name .' '.$user->last_name;
							$city = $user->city;
							$country = $user->country;
						}
					}
				
					$data['fullname'] = $fullname;
					//$data['city'] = $city;
					//$data['country'] = $country;
					   
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
				
					//SELECT VEHICLE TYPE DROPDOWN
					$vehicle_type = '<div class="form-group">';
					$vehicle_type .= '<select name="vehicle_type" id="vehicleType" class="form-control select2">';
					
					$vehicle_type .= '<option value="" selected="selected">Select Type</option>';
							
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
					$vehicle_make = '<option value="" selected="selected">Select Make</option>';
							
					$this->db->from('vehicle_makes');
					$this->db->order_by('id');
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							$vehicle_make .= '<option value="'.$row['title'].'" >'.$row['title'].'</option>';
						}
					}
					$data['vehicle_make'] = $vehicle_make;
					//*********END SELECT VEHICLE MAKE DROPDOWN**********//
					
					
					//*********SELECT VEHICLE MODEL DROPDOWN**********//
					$vehicle_model = '<option value="" selected="selected">Select Model</option>';
							
					$this->db->from('vehicle_models');
					$this->db->order_by('id');
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							$vehicle_model .= '<option value="'.$row['title'].'" >'.$row['title'].'</option>';
						}
					}
					$data['vehicle_model'] = $vehicle_model;
					//*********END SELECT VEHICLE MODEL DROPDOWN**********//
					
					
					
					//count and display the number of Vehicles
					$count = $this->Vehicles->count_user_all();
						
					if($count == '' || $count == null){
						$count = 0;
					}
					$data['vehicle_count'] = $count;
					
					//assign page title name
					$data['pageTitle'] = 'Vehicles';
								
					//assign page title name
					$data['pageID'] = 'vehicles';
										
					//load header and page title
					$this->load->view('account_pages/header', $data);
							
					//load main body
					$this->load->view('account_pages/vehicles_page', $data);	
					
					//load footer
					$this->load->view('account_pages/footer');
					
			}
				
		}

	
		
		/***
		* Function to handle vehicles ajax
		* Datatables
		***/
		public function vehicles_datatable()
		{
			$list = $this->Vehicles->get_user_datatables();
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
				"recordsTotal" => $this->Vehicles->count_user_all(),
				"recordsFiltered" => $this->Vehicles->count_user_filtered(),
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
				
				$title = $detail->vehicle_make.' '.$detail->vehicle_model;
				$image = '';
				$thumbnail = '';
					
				$filename = FCPATH.'uploads/vehicles/'.$detail->id.'/'.$detail->vehicle_image;

				if($detail->vehicle_image == '' || $detail->vehicle_image == null || !file_exists($filename)){
						
					//$result = $this->db->select_min('id')->from('vehicle_images')->where('vehicle_id', $detail->id)->get()->row();
						
					$result = $this->db->select('*, MIN(id) as min_id', false)->from('vehicle_images')->where('vehicle_id', $detail->id)->get()->row();
					
					if(!empty($result)){
							
						//MAIN IMAGE
						$image = '<div class="wrapper"><img alt="" src="'.base_url().'uploads/vehicles/'.$detail->id.'/'.$result->image_name.'" class="img-responsive main-img" id="main-img" width="" height=""/></div>';
							
						//THUMBNAIL
						$thumbnail = '<img src="'.base_url().'uploads/vehicles/'.$detail->id.'/'.$result->image_name.'" class="" />';
							
					}else{
						//MAIN IMAGE
						$image = '<div class="wrapper"><img alt="" src="'.base_url().'assets/images/img/no-default-thumbnail.png" class="img-responsive main-img" id="main-img" width="" height=""/></div>';
						
						$thumbnail = '<img src="'.base_url().'assets/images/img/no-default-thumbnail.png" />';
					}
						
				}
				else{
					//MAIN IMAGE
					$image = '<div class="wrapper"><img alt="" src="'.base_url().'uploads/vehicles/'.$detail->id.'/'.$detail->vehicle_image.'" class="img-responsive main-img" id="main-img" width="" height=""/></div>';
						
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
				$image_gallery = '<div class="gallery-wrapper">';
					
				if(!empty($vehicle_images)){
					//item count initialised
					$i = 0;
					$a = 1;
					//gallery edit row
					$image_group .= '<div class="row">';
							
							
					foreach($vehicle_images as $image){

						$image_gallery .= '<div class="img-wrapper">';
						$image_gallery .= '<a href="'.base_url().'uploads/vehicles/'.$detail->id.'/'.$image->image_name.'" title="View" data-fancybox="gallery"><div class="wrapper"><img src="'.base_url().'uploads/vehicles/'.$detail->id.'/'.$image->image_name.'" id="'.$image->image_name.'" class="img-responsive" onclick="changeImage(\''.base_url().'uploads/vehicles/'.$detail->id.'/'.$image->image_name.'\')" /><div class="img-icon"><i class="fa fa-search-plus" aria-hidden="true"></i></div></div></a>';
						$image_gallery .= '</div>';	
						
						//portfolio gallery view
						$gallery .= '<a href="javascript:void(0)" title="View '.$title.' '.$a.'">';
						$gallery .= '<img src="'.base_url().'uploads/vehicles/'.$detail->id.'/'.$image->image_name.'" id="'.$image->image_name.'" class="img-responsive" onclick="changeImage(\''.base_url().'uploads/vehicles/'.$detail->id.'/'.$image->image_name.'\')"/>';
						$gallery .= '</a>';
							
						//gallery edit group
						$image_group .= '<div class="col-sm-3 nopadding">';
							
						//gallery edit group
						$image_group .= '<div class="image-group">';
							
						$image_group .= '<img src="'.base_url().'uploads/vehicles/'.$detail->id.'/'.$image->image_name.'" id="'.$image->image_name.'" class="img-responsive" />';
						//image path
						$path = 'uploads/vehicles/'.$detail->id.'/'.$image->image_name;
						$url = 'account/delete_vehicle_images';
						$imageurl = 'account/make_image_main';
							
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
						
						$a++;
					}
				}
				
				$image_gallery .= '</div>';
				$data['image_gallery'] = $image_gallery;
					
						
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
				
				$data['date_added'] = date("F j, Y", strtotime($detail->date_added));
				$data['last_updated'] = date("F j, Y, g:i a", strtotime($detail->last_updated));	
										

				//SELECT VEHICLE TYPE DROPDOWN
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
				$data['vehicle_type_options'] = $vehicle_type;
				//*********END SELECT VEHICLE TYPE DROPDOWN**********//
					
					
				//*********SELECT VEHICLE MAKE DROPDOWN**********//
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
				$data['vehicle_model_options'] = $vehicle_model;
				//*********END SELECT VEHICLE MODEL DROPDOWN**********//
					

				//SELECT YEAR DROPDOWN
				$year_of_manufacture = '<option value="">Select Year</option>';
				for($i=date("Y")-50; $i<=date("Y"); $i++) {
					$sel = ($i == $detail->year_of_manufacture) ? 'selected' : '';
					$year_of_manufacture .= "<option value=".$i." ".$sel.">".$i."</option>";  
				}		
				$data['year_of_manufacture_options'] = $year_of_manufacture;
				//*********END SELECT YEAR DROPDOWN**********//
										

				//SELECT COLOUR DROPDOWN
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
				$data['colour_options'] = $colours;
				//*********END SELECT COLOUR DROPDOWN**********//
					
					
				//SELECT COUNTRY DROPDOWN
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
				$data['country_options'] = $countries;
				//*********END SELECT COUNTRY DROPDOWN**********//
					
					
				//*********SELECT SALE STATUS DROPDOWN**********//
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
			
				$data['sale_status_options'] = $sale_status;
					//*********END SELECT SALE STATUS DROPDOWN**********//
					
					
					
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
			
			$this->form_validation->set_rules('discount','Discount','trim|xss_clean');
			$this->form_validation->set_rules('price_after_discount','Discount Price','trim|xss_clean');

			
			$this->form_validation->set_message('required', '%s cannot be blank!');
			
			if($this->form_validation->run()){
				
				$email = $this->session->userdata('email');
				
				
				$make_array = $this->Vehicle_makes->get_make_by_id($this->input->post('vehicle_make'));
				
				$vehicle_make = '';
				if($make_array){
					foreach($make_array as $make){
						$vehicle_make = $make->title;
					}
				}
				
				//CHECK IF ITEM ALREADY EXISTS
				$where = array(
					
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
					'trader_email' => $email,	
					'discount' => $this->input->post('discount'),
					'price_after_discount' => $this->input->post('price_after_discount'),
						
				);
				
				$insert_id = false;
				
				if($this->Vehicles->unique_vehicle($where)){
					
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
						'trader_email' => $email,	
						'discount' => $this->input->post('discount'),
						'price_after_discount' => $this->input->post('price_after_discount'),
						'date_added' => date('Y-m-d H:i:s'),
							
					);
							
					$insert_id = $this->Vehicles->insert_vehicle($add);
					
				}
				
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

					$user_array = $this->Users->get_user($email);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->first_name.' '.$user->last_name;
						}
					}
					
					//CHECK IF ALERT NOTIFICATION IS ON
					if($this->Email_alerts->alert_on($email)){
						
						//SEND EMAIL NOTIFICATION
						$vehicle_title = ucwords($vehicle_make.' '.$this->input->post('vehicle_model'));
						$year = $this->input->post('year_of_manufacture');
						$colour = $this->input->post('vehicle_colour');
						
						$to = $email;
						$subject = 'New Item Listing - '.$year.' '.$vehicle_title ;
						
						$link = base_url('account/vehicles');
						
						//compose email message
						$message = "<p>You have successfully listed a new item.</p>";
						$message .= '<p>Item: '.$year.' '.$vehicle_title.' - '.$colour.' .</p>';
						$message .= '<p><a title="Vehicles" href="'.base_url('account/vehicles').'" class="link">View and manage your listings here</a></p>';

						$this->Messages->send_email_alert($to, $subject, $fullname, $message);
						
					}
					
					//update activities table
					$description = 'added <i>'.$vehicle_title.'</i> vehicle';
				
					$activity = array(			
						'name' => $fullname,
						'username' => $email,
						'description' => $description,
						'keyword' => 'Vehicle',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
								
					//$this->session->set_flashdata('project_added', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box alert alert-success text-center"><i class="fa fa-check-circle"></i> The vehicle has been added!</div>');
					
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> '.$vehicle_title.' Added!</div>';

													
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
			
			$this->form_validation->set_rules('vehicle_type','Type','required|trim|xss_clean');
			$this->form_validation->set_rules('vehicle_make','Make','required|trim|xss_clean');
			$this->form_validation->set_rules('vehicle_model','Model','required|trim|xss_clean');
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
			
			$this->form_validation->set_rules('discount','Discount','trim|xss_clean');
			$this->form_validation->set_rules('price_after_discount','Discount Price','trim|xss_clean');
			
			
			$this->form_validation->set_message('required', '%s cannot be blank!');
				
			if ($this->form_validation->run()){
				
				$email = $this->session->userdata('email');
				
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
					'trader_email' => $email,	
					'discount' => $this->input->post('discount'),
					'price_after_discount' => $this->input->post('price_after_discount'),
					'last_updated' => date('Y-m-d H:i:s'),
				);
				
				if ($this->Vehicles->update_vehicle($update, $vehicle_id)){	
					
					
					$user_array = $this->Users->get_user($email);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->first_name.' '.$user->last_name;
						}
					}
					
					
					//CHECK IF ALERT NOTIFICATION IS ON
					if($this->Email_alerts->alert_on($email)){
						
						//SEND EMAIL NOTIFICATION
						$vehicle_title = ucwords($vehicle_make.' '.$this->input->post('vehicle_model'));
						$year = $this->input->post('year_of_manufacture');
						$colour = $this->input->post('vehicle_colour');
						
						$to = $email;
						$subject = 'Updated Listing - '.$year.' '.$vehicle_title ;
						
						$link = base_url('account/vehicles');
						
						//compose email message
						$message = "<p>You have successfully updated your listing.</p>";
						$message .= '<p>Item: '.$year.' '.$vehicle_title.' - '.$colour.' .</p>';
						$message .= '<p><a title="Vehicles" href="'.base_url('account/vehicles').'" class="link">View and manage your listings here</a></p>';

						$this->Messages->send_email_alert($to, $subject, $fullname, $message);
						
					}
					
					//update activities table
					$description = 'updated <i>'.$vehicle_title.'</i>';
				
					$activity = array(			
						'name' => $fullname,
						'username' => $email,
						'description' => $description,
						'keyword' => 'Vehicle',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
								
					$data['success'] = true;
					
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> '.$vehicle_title.' updated!</div>';
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
					'last_updated' => date('Y-m-d H:i:s'),
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
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Main Image changed!</div>';
				}else{
					$data['success'] = false;
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Main Image not changed!</div>';
				}
				
			}
			echo json_encode($data);
		}

					
		
				
		/***
		* FUNCTION TO HANDLE SALE ENQUIRIES
		*
		***/		
		public function sale_enquiries(){
			
			if(!$this->session->userdata('logged_in')){
								
				$url = 'login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//redirect('login/','refresh');
				
			}else{			

				$email = $this->session->userdata('email');
				
				$data['user_array'] = $this->Users->get_user($email);
					
				$fullname = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
						$fullname = $user->first_name .' '.$user->last_name;
					}
				}
				$data['fullname'] = $fullname;
				
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
				
				$delete = $this->Sale_enquiries->delete_old_records();
					
				//assign page title name
				$data['pageTitle'] = 'Sale Enquiries';
								
				//assign page title name
				$data['pageID'] = 'sale_enquiries';
										
				//load header and page title
				$this->load->view('account_pages/header', $data);
							
				//load main body
				$this->load->view('account_pages/sale_enquiries_page', $data);	
					
				//load footer
				$this->load->view('account_pages/footer');
					
			}
				
		}
		
	
		
		/***
		* Function to handle enquiry datatable
		*
		***/
		public function sale_enquiry_datatable()
		{
			
			//$delete = $this->Sale_enquiries->delete_old_records();
			
			$list = $this->Sale_enquiries->get_user_datatables();
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
				
				$subject = 'Enquiry from '.ucwords($enquiry->customer_name);
				
				$row[] = '<span class="enquiryToggle" style="padding:3px;">
								<u><a href="javascript:void(0)" class="'.$textWeight.'" id="subj_line_'.$enquiry->id.'">'. stripslashes($subject).' <i class="fa fa-angle-double-down" aria-hidden="true"></i></a></u>
							</span>
																	
							<div class="enquiryContents"><p class="'.$textWeight.'"><i class="fa fa-phone-square" aria-hidden="true"></i> '.$enquiry->customer_telephone.'</p><p class="'.$textWeight.'"><i class="fa fa-envelope" aria-hidden="true"></i> '.strtolower($enquiry->customer_email).'</p><p class="'.$textWeight.'"><u>Re: '.strtoupper($title).'</u></p>'.$enquiry->comment.'<br/></div>';
							
				$location = '<p>'.$enquiry->ip_address.'</p>';
				$location .= $enquiry->ip_details;
				$row[] = '<span class="'.$textWeight.'">'.$location.'</span>';
				$row[] = '<span class="'.$textWeight.'">'.date("F j, Y g:i A", strtotime($enquiry->enquiry_date)).'</span>';
				
				$url = 'account/sale_enquiry_details';
				
				//prepare buttons
				$row[] = '<a data-toggle="modal" data-target="#viewModal" class="btn btn-info btn-xs" id="'.$enquiry->id.'" title="Click to View" onclick="viewEnquiry(this,'.$enquiry->id.',\''.$url.'\')"><i class="fa fa-search"></i> View</a>';
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Sale_enquiries->count_user_all(),
				"recordsFiltered" => $this->Sale_enquiries->count_user_filtered(),
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
					
					$vehicle_title = '';
					$vehicles_array = $this->Vehicles->get_vehicles_by_id($detail->vehicle_id);
					//$detail = $this->db->select('*')->from('vehicles')->where('id',$vehicle_id)->get()->row();
					if($vehicles_array){
						foreach($vehicles_array as $vehicle){
							$vehicle_title = $vehicle->vehicle_make.' '.$vehicle->vehicle_model.' ('.$vehicle->year_of_manufacture.' - '.$vehicle->vehicle_colour.')';
						}
					}
					$data['vehicle_title'] = $vehicle_title;
					
					$data['comment'] = stripslashes(wordwrap(nl2br($detail->comment), 54, "\n", true));
					$data['preferred_contact_method'] = $detail->preferred_contact_method;
					$data['ip_address'] = $detail->ip_address;
					$data['ip_details'] = $detail->ip_details;
					
					$location = '<p><strong>IP: <strong> '.$detail->ip_address.'</p>';
					$location .= $detail->ip_details;
					
					$data['location'] = $location;
					
					$opened = $detail->opened;
					if($opened == '0'){
						$opened = '<i class="fa fa-envelope-o" aria-hidden="true"></i>';
					}else{
						$opened = '<i class="fa fa-envelope-open-o" aria-hidden="true"></i>';
					}
					$data['opened'] = $opened;
					
					$enquiries_unread = $this->Sale_enquiries->count_unread_enquiries($detail->seller_email);
					if($enquiries_unread == '' || $enquiries_unread == null){
						$data['enquiries_unread'] = 0;
					}else{
						$data['enquiries_unread'] = $enquiries_unread;
					}
				
					$data['enquiry_date'] = date("F j, Y, g:i a", strtotime($detail->enquiry_date));
					
					$data['model'] = 'sale_enquiries';
					$data['success'] = true;

			}else {
				$data['success'] = false;
			}
			echo json_encode($data);
		}	
	
			
		/***
		* Function to handle reviews
		*
		***/		
		public function reviews(){
			
			if(!$this->session->userdata('logged_in')){
								
				$url = 'login?redirectURL='.urlencode(current_url());
				redirect($url);							
				
			}else{			

				$email = $this->session->userdata('email');
				
				$data['user_array'] = $this->Users->get_user($email);
					
				$fullname = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
						$fullname = $user->first_name .' '.$user->last_name;
					}
				}
				$data['fullname'] = $fullname;
				
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
				
				
				$data['count_reviews'] = $this->Reviews->count_user_all();
						
				//assign page title name
				$data['pageTitle'] = 'Reviews';
								
				//assign page title name
				$data['pageID'] = 'reviews';
										
				//load header and page title
				$this->load->view('account_pages/header', $data);
							
				//load main body
				$this->load->view('account_pages/reviews_page', $data);	
					
				//load footer
				$this->load->view('account_pages/footer');
			}
		}

	
		
		/***
		* FUNCTION TO HANDLE REVIEWS AJAX
		* DATATABLES
		***/
		public function review_datatable()
		{
			$list = $this->Reviews->get_user_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $review) {
				$no++;
				$row = array();
				
				$row[] = ucwords($review->reviewer_name).' ('.strtolower($review->reviewer_email).')';
				
				
				//GENERATE STAR RATING
				$rating = $this->misc_lib->generateRatingStar($review->rating);
				
				$row[] = ' <span class="star-rating">'.$rating.'</span>';
				
				$location = '<p>'.$review->ip_address.'</p>';
				$location .= $review->ip_details;
				
				$row[] = $location;
				$row[] = date("F j, Y, g:i a", strtotime($review->review_date));
				
				$url = 'account/review_details';
				
				//$row[] = $make->title;
				$row[] = '<a data-toggle="modal" data-target="#viewModal" href="!#" class="btn btn-primary btn-xs" onclick="viewReview('.$review->id.',\''.$url.'\')" id="'.$review->id.'" title="Click to View"><i class="fa fa-search"></i> View</a>';
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Reviews->count_user_all(),
				"recordsFiltered" => $this->Reviews->count_user_filtered(),
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
	
	
		/**
		* Function to mark messages
		* as read 
		*/	
		public function mark_as_read($id ='',$table =''){
			
			$id = preg_replace('#[^0-9]#i', '', $id); // filter everything but numbers
				
			$data = array(
				'opened' => '1',
			);
			if($id != '' && $id != null){
				$this->db->where('id', $id);
			}
			
			$query = $this->db->update($table, $data);
				
		}
								


		/***
		* Function for USER profile
		*
		***/		
		public function profile(){

			if(!$this->session->userdata('logged_in')){
								
				$url = 'login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//$this->login();
				//redirect('login/','refresh');
				
			}else{ 
			
				$email = $this->session->userdata('email');
				
				$data['user_array'] = $this->Users->get_user($email);
					
				$user_avatar = '';
				$user_id = '';
				$fullname = '';
				$facebook = '';
				$twitter = '';
				$google = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
						$fullname = $user->first_name .' '.$user->last_name;
						$user_avatar = $user->avatar;
						$user_id = $user->id;
						$facebook = $user->facebook;
						$twitter = $user->twitter;
						$google = $user->google;
					}
				}
				
				$social_icons = '';
				
				if($facebook != '' || $facebook != null || $twitter != '' || $twitter != null || $google != '' || $google != null){
					
					$social_icons .= '<ul class="list-inline">';
					if($facebook != '' || $facebook != null){
						$social_icons .= '<li><a target="_blank" href="'.$facebook.'">';
						$social_icons .= '<i class="fa fa-facebook fa-lg" aria-hidden="true"></i></a></li>';
					}
					if($twitter != '' || $twitter != null){
						$social_icons .= '<li><a target="_blank" href="'.$twitter.'">';
						$social_icons .= '<i class="fa fa-twitter fa-lg" aria-hidden="true"></i></a></li>';
					}
					if($google != '' || $google != null){
						$social_icons .= '<li><a target="_blank" href="'.$google.'">';
						$social_icons .= '<i class="fa fa-google fa-lg" aria-hidden="true"></i></a></li>';
					}
					$social_icons .= '</ul>';
				}
				$data['fullname'] = $fullname;
				$data['social_icons'] = $social_icons;
				
				//$data['facebook'] = $facebook;
				//$data['twitter'] = $twitter;
				//$data['google'] = $google;
				
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
				
				$thumbnail = '';
				$mini_thumbnail = '';
				$filename = FCPATH.'uploads/users/'.$user_id.'/'.$user_avatar;

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
					$thumbnail = '<img src="'.base_url().'uploads/users/'.$user_id.'/'.$user_avatar.'?'.time().'" class="img-responsive img-circle avatar-view" width="120" height="120" />';
					
					$mini_thumbnail = '<img src="'.base_url().'uploads/users/'.$user_id.'/'.$user_avatar.'?'.time().'" class="" width="" height="" />';
				}	
				
				$data['thumbnail'] = $thumbnail;
				$data['mini_thumbnail'] = $mini_thumbnail;
				
				$alert_array = $this->Email_alerts->get_alert($email);
				$status = '';
				if($alert_array){
					foreach($alert_array as $alert){
						$status = $alert->status;
					}
				}
				$switch = '';
				$url = 'account/change_alert_status';
				if($status == '1'){
					$switch = '<input name="alert_status" type="hidden" value="0">';
					$switch .= '<input name="alert_status" type="checkbox" onclick="alertChange(this, \''.$url.'\');" checked value="1">';
				}else{
					$switch = '<input name="alert_status" type="hidden" value="0">';
					$switch .= '<input name="alert_status" type="checkbox" onclick="alertChange(this, \''.$url.'\');" value="1">';
				}
				
				$data['switch'] = $switch;
				
				//assign page title name
				$data['pageTitle'] = 'Profile';
				
				//assign page ID
				$data['pageID'] = 'profile';
								
				//load header and page title
				$this->load->view('account_pages/header', $data);
				
				//load main body
				$this->load->view('account_pages/profile_page');
				
				//load footer
				$this->load->view('account_pages/footer');
									
			}	
		}	
			
			

		/**
		* Function to validate update profile
		* form
		*/			
		public function update_profile(){
			
			$email = $this->session->userdata('email');
				
			$user_array = $this->Users->get_user($email);
					
			$user_id = '';
			$avatar = '';
			$fullname =  '';
			if($user_array){
				foreach($user_array as $user){
					$fullname = $user->first_name .' '.$user->last_name;
					$user_id = $user->id;
					$avatar = $user->avatar;
				}
			}
			
			
			$photo_uploaded = false;		
			
			if(!empty($_FILES['update_photo']['name']) && $_FILES['update_photo']['size'] > 0){
					
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
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> ', '</div>');
			
			$this->form_validation->set_rules('company_name','Company Name','trim|xss_clean');
			$this->form_validation->set_rules('address_line_1','Address Line 1','required|trim|xss_clean');
			$this->form_validation->set_rules('address_line_2','Address Line 2','trim|xss_clean');
			$this->form_validation->set_rules('city','City','required|trim|xss_clean');
			$this->form_validation->set_rules('postcode','Postcode','required|trim|xss_clean');
			$this->form_validation->set_rules('state','State','required|trim|xss_clean');
			$this->form_validation->set_rules('country','Country','required|trim|xss_clean');
			$this->form_validation->set_rules('telephone','Telephone','required|trim|xss_clean');
			$this->form_validation->set_rules('facebook','Facebook','trim|xss_clean|callback_validate_facebook');
			$this->form_validation->set_rules('twitter','Twitter','trim|xss_clean|callback_validate_twitter');
			$this->form_validation->set_rules('google','Google','trim|xss_clean|callback_validate_google');
			
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
							
							$data['upload_errors'] = '<div class="custom-alert-box alert alert-danger text-center">'.$this->upload->display_errors().'</div>';

						}
						
					}
				}
				
				$country_id = $this->input->post('country');
				$cid = preg_replace('#[^0-9]#i', '', $country_id); // filter everything but numbers
				
				$country = '';
				
				$detail = $this->db->select('*')->from('countries')->where('id',$cid)->get()->row();
			
				if($detail){
					$country = $detail->name;
				}
				
				$user_array = $this->Users->get_user($email);
					
				$old_facebook = '';
				$old_twitter = '';
				$old_google = '';
				
				if($user_array){
					foreach($user_array as $user){
						$old_facebook = $user->facebook;
						$old_twitter = $user->twitter;
						$old_google = $user->google;
					}
				}
				
				$facebook = '';
				if($old_facebook != '' && $old_facebook != null && preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$old_facebook)){
				
					$facebook = $this->input->post('facebook');
					if($facebook !== ''){
						$facebook = preg_replace("/\s+/", "+", $facebook);
					}
					
					
				}else{
					$facebook = $this->input->post('facebook');
					if($facebook !== ''){
						$facebook = preg_replace("/\s+/", "+", $facebook);
					}
					$facebook = 'https://www.facebook.com/'.$facebook;
				}
				
				$twitter = '';
				if($old_twitter != '' && $old_twitter != null && preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$old_twitter)){
				
					$twitter = $this->input->post('twitter');
					if($twitter !== ''){
						$twitter = preg_replace("/\s+/", "+", $twitter);
					}
					
				}else{
					$twitter = $this->input->post('twitter');
					if($twitter !== ''){
						$twitter = preg_replace("/\s+/", "+", $twitter);
					}
					$twitter = 'https://www.twitter.com/'.$twitter;
				}
				
				$google = '';
				if($old_google != '' && $old_google != null && preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$old_google)){
				
					$google = $this->input->post('google');
					if($google !== ''){
						$google = preg_replace("/\s+/", "+", $google);
					}
					
				}else{
					$google = $this->input->post('google');
					if($google !== ''){
						$google = preg_replace("/\s+/", "+", $google);
					}
					$google = 'https://plus.google.com/b/'.$google;
				}
				
				
				$update = array(
					'avatar' => $avatar,
					'company_name' => ucwords($this->input->post('company_name')),
					'address_line_1' => ucwords($this->input->post('address_line_1')),
					'address_line_2' => ucwords($this->input->post('address_line_2')),
					'city' => ucwords($this->input->post('city')),
					'postcode' => strtoupper($this->input->post('postcode')),
					'state' => ucwords($this->input->post('state')),
					'country' => $country,
					'facebook' => strtolower($facebook),
					'twitter' => strtolower($twitter),
					'google' => strtolower($google),
					'telephone' => $this->input->post('telephone'),
					'last_updated' => date('Y-m-d H:i:s'),
				);

				if ($this->Users->user_update($update, $email)){	

					//update activities table
					$description = 'updated profile';
				
					$activity = array(			
						'name' => $fullname,
						'username' => $email,
						'description' => $description,
						'keyword' => 'Update',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
					
					//CHECK IF USER TURNED ON ALERT
					//IF TURNED ON THEN SEND ALERT
					if($this->Email_alerts->alert_on($email) && $this->Email_alerts->get_alert($email)){
						//send email alert
						$to = $email;
						$subject = 'Profile Updated';
						$message = "<p>Your profile has been updated!</p>";
						$message .= '<p>If you did not make this request, please contact us ASAP at <a href="mailto:info@dejor.com">info@dejor.com</a> or call <a href="callto:8455551212">(845)555-1212</a>!</p>';
						
						$this->Messages->send_email_alert($to, $subject, $fullname, $message);
						//*/	
					}
					
					
					$data['url'] = 'account/profile';
					
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


		/**
		* FUNCTION TO VALIDATE FACEBOOK 
		* 
		*/			
		public function validate_facebook(){
			
			$email = $this->session->userdata('email');
				
			$user_array = $this->Users->get_user($email);
					
			$old = '';
			if($user_array){
				foreach($user_array as $user){
					$old = $user->facebook;
				}
			}
			if($old != '' && $old != null && preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$old)){
				
				return TRUE;
				
			}else{
				$facebook = $this->input->post('facebook');
				if($facebook !== ''){
					$facebook = preg_replace("/\s+/", "+", $facebook);
				}
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
			
		}
		
		
		/**
		* FUNCTION TO VALIDATE TWITTER 
		* 
		*/			
		public function validate_twitter(){
			
			$email = $this->session->userdata('email');
				
			$user_array = $this->Users->get_user($email);
					
			$old = '';
			if($user_array){
				foreach($user_array as $user){
					$old = $user->twitter;
				}
			}
			if($old != '' && $old != null && preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$old)){
				
				return TRUE;
				
			}else{
				$twitter = $this->input->post('twitter');
				if($twitter !== ''){
					$twitter = preg_replace("/\s+/", "+", $twitter);
				}
				
				$twitter_url = 'https://www.twitter.com/'.$twitter;
				
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
		}
			
		/**
		* FUNCTION TO VALIDATE GOOGLE 
		* 
		*/			
		public function validate_google(){
			
			
			$email = $this->session->userdata('email');
				
			$user_array = $this->Users->get_user($email);
					
			$old = '';
			if($user_array){
				foreach($user_array as $user){
					$old = $user->google;
				}
			}
			if($old != '' && $old != null && preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$old)){
				
				return TRUE;
				
			}else{
				$google = ''.$this->input->post('google');
				if($google !== ''){
					$google = preg_replace("/\s+/", "+", $google);
				}

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
		}

			

		/**
		* Function to validate update profile
		* form
		*/			
		public function change_alert_status(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			//escaping the post values
			
			$alert_status = html_escape($this->input->post('alert_status'));
			
			$email = $this->session->userdata('email');
			
			$photo_uploaded = false;		
			
			if ($alert_status != '' && $alert_status != null){	
				
				$added = false;
				$description = '';
				
				//CHECK IF ALERT ALREADY SET
				if($this->Email_alerts->get_alert($email)){
					$update = array(
						'status' => $alert_status,
						'last_updated' => date('Y-m-d H:i:s'),
					);
					$added = $this->Email_alerts->update_alert($update, $email);
					$description = 'updated alert status';
				}else{
					$add = array(
						'status' => $alert_status,
						'email' => $email,
						'last_updated' => date('Y-m-d H:i:s'),
					);
					$added = $this->Email_alerts->insert_alert($add);
					$description = 'added alert status';
				}
				
				if ($added){
					
					$user_array = $this->Users->get_user($email);

					$fullname =  '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->first_name .' '.$user->last_name;
						}
					}
					//update activities table
					
				
					$activity = array(			
						'name' => $fullname,
						'username' => $email,
						'description' => $description,
						'keyword' => 'Update',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
					
					$data['success'] = true;
							
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Alert option updated!</div>';

				}
				
			}else {
				
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Alert not updated!</div>';
			}
		
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);		
		}

		
		/***
		* Function for settings
		*
		***/		
		public function settings(){

			if(!$this->session->userdata('logged_in')){
								
				$url = 'login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//redirect('login/','refresh');
				
			}else{ 
			
				$email = $this->session->userdata('email');
				
				$data['user_array'] = $this->Users->get_user($email);
				
				$fullname = '';
				$security_question = '';
				$user_id = '';
				$user_avatar = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
						$user_id = $user->id;
						$user_avatar = $user->avatar;
						$fullname = $user->first_name .' '.$user->last_name;
						$security_question = $user->security_answer;
					}
				}
				
				$data['fullname'] = $fullname;
				$data['security_question'] = $security_question;
				
				$messages_unread = $this->Messages->count_unread_messages($email);
				if($messages_unread == '' || $messages_unread == null){
					$data['messages_unread'] = 0;
				}else{
					$data['messages_unread'] = $messages_unread;
				}
					
				$data['header_messages_array'] = $this->Messages->get_header_messages($email);
				
				$mini_thumbnail = '';
				$filename = FCPATH.'uploads/users/'.$user_id.'/'.$user_avatar;

				//check if record in db is url thus facebook or google
				if(filter_var($user_avatar, FILTER_VALIDATE_URL)){
					$mini_thumbnail = '<img src="'.$user_avatar.'" class="" width="" height="" />';
				}
				elseif($user_avatar == '' || $user_avatar == null || !file_exists($filename)){
					$mini_thumbnail = '<img src="'.base_url().'assets/images/icons/avatar.jpg" class="" width="" height="" />';
				}
				else{
					$mini_thumbnail = '<img src="'.base_url().'uploads/users/'.$user_id.'/'.$user_avatar.'?'.time().'" class="" width="" height="" />';
				}	
				
				$data['mini_thumbnail'] = $mini_thumbnail;
				
				$enquiries_unread = $this->Sale_enquiries->count_unread_enquiries($email);
				if($enquiries_unread == '' || $enquiries_unread == null){
					$data['enquiries_unread'] = 0;
				}else{
					$data['enquiries_unread'] = $enquiries_unread;
				}
				$percentage_completion = $this->Users->profile_completion($email);
				
				$data['profile_completion'] = $percentage_completion;
				$data['profile_completion_string'] = $percentage_completion.'%';
				
				//assign page title name
				$data['pageTitle'] = 'Settings';
				
				//assign page ID
				$data['pageID'] = 'settings';
								
				//load header and page title
				$this->load->view('account_pages/header', $data);
				
				//load main body
				$this->load->view('account_pages/settings_page');
				
				//load footer
				$this->load->view('account_pages/footer');
									
			}	
		}	
		

		/**
		* Function to validate update password settings
		* form
		*/			
		public function password_update(){
			
			$email = $this->session->userdata('email');
			
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
				
				
				$password_data = array(
					'password' => $hashed_password,
					'last_updated' => date('Y-m-d H:i:s'),
				);

				if ($this->Users->user_update($password_data, $email)){	

					$user_array = $this->Users->get_user($email);
					
					$fullname = '';
					
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->first_name .' '.$user->last_name;
						
						}
					}
				
					//update activities table
					$description = 'updated password';
				
					$activity = array(			
						'name' => $fullname,
						'username' => $email,
						'description' => $description,
						'keyword' => 'Update',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
						
					//send email alert
					$to = $email;
					$subject = 'Password Updated';
					$message = "<p>Your password has been updated!</p>";
					$message .= '<p>If you did not make this request, please contact us ASAP at <a href="mailto:info@dejor.com">info@dejor.com</a> or call <a href="callto:8455551212">(845)555-1212</a>!</p>';
					
					$this->Messages->send_email_alert($to, $subject, $fullname, $message);
					//*/					
					
					$data['url'] = 'account/logout';
					
					$data['success'] = true;
							
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Your password has been updated!</div>';

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
							
		/**
		* FUNCTION TO VALIDATE OLD PASSWORD 
		* 
		*/			
		public function validate_old_password(){
			
			$email = $this->session->userdata('email');
			
			$old_password = $this->input->post('old_password');
			$hashed_password = '';
			
			//get users info frm db using username
			$user_array = $this->Users->get_user($email);
			if($user_array){
				//get stored password
				foreach($user_array as $user){
					$hashed_password = $user->password;
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
		* Function for security
		*
		***/		
		public function security(){

			if(!$this->session->userdata('logged_in')){
								
				$url = 'login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//redirect('login/','refresh');
				
			}else{ 
			
				$email = $this->session->userdata('email');
				
				$data['user_array'] = $this->Users->get_user($email);
				
				$fullname = '';
				$security_question = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
						$fullname = $user->first_name .' '.$user->last_name;
						$security_question = $user->security_question;
					}
				}
				
				$data['fullname'] = $fullname;
				$data['security_question'] = $security_question;
				
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
				$select_security_questions = '';
					
				$this->db->from('security_questions');
				$this->db->order_by('id');
				$result = $this->db->get();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row){
						$select_security_questions .= '<option value="'.$row['question'].'" >'.$row['question'].'</option>';
					}
				}
				$data['select_security_questions'] = $select_security_questions;
						
				//assign page title name
				$data['pageTitle'] = 'Security';
				
				//assign page ID
				$data['pageID'] = 'security';
								
				//load header and page title
				$this->load->view('account_pages/header', $data);
				
				//load main body
				$this->load->view('account_pages/security_page');
				
				//load footer
				$this->load->view('account_pages/footer');
									
			}	
		}			
					
		/***
		* Function for set security
		*
		***/		
		public function set_security(){

			if($this->session->userdata('logged_in') && !$this->session->userdata('set_security')){
								
				//$url = 'login?redirectURL='.urlencode(current_url());
				//redirect($url);							
				//$this->login();
				//redirect('login/','refresh');
				redirect('account/dashboard');
				
			}else{
				//ENSURE SET SECURITY FLASH DATA IS SET
				//ELSE GO TO LOGIN
				if($this->session->userdata('set_security')){
					
					$select_security_questions = '';
			
					$this->db->from('security_questions');
					$this->db->order_by('id');
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							$select_security_questions .= '<option value="'.$row['question'].'" >'.$row['question'].'</option>';
						}
					}
					//$select_security_questions .= '</select>';
					$data['select_security_questions'] = $select_security_questions;
						
					//assign meta tags
					$page = 'set_security';
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
					$data['pageTitle'] = 'Set Security Information';
					
					//assign page ID
					$data['pageID'] = 'set_security';
									
					//load header and page title
					$this->load->view('pages/header', $data);
					
					//load main body
					$this->load->view('pages/set_security_question_page');
					
					//load footer
					$this->load->view('pages/footer');
					
				}else {
					//$data['success'] = true;
					//$data['set_security'] = true;
					//redirects to account page
					redirect('login');	
				}
			
									
			}	
		}	

		

		/**
		* Function to validate security information
		* form
		*/			
		public function security_validate(){
			
			$this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
			$this->form_validation->set_rules('security_question','Security Question','required|trim|xss_clean|callback_validate_old_security');
			
			$this->form_validation->set_rules('security_answer','Security Answer','required|trim|xss_clean');
			
			$this->form_validation->set_message('required', 'Please enter a %s!');
			
			if ($this->form_validation->run()){	
					
				$data['success'] = true;	
				$data['notif'] = '<div class="alert alert-success text-center"><i class="fa fa-check-circle"></i> Security check successful!</div>';
			}else {
				
				//Go back to the security Page if validation fails
				$data['success'] = false;
				$data['notif'] = '<div class="text-center" role="alert"><'.validation_errors().'</div>';
				//$this->security();
			}
			
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
		
		}		
			
							
		/**
		* FUNCTION TO VALIDATE OLD SECURITY 
		* 
		*/			
		public function validate_old_security(){
			
			$email = $this->session->userdata('email');
			
			$security_question = strtolower($this->input->post('security_question'));
			$security_answer = strtolower($this->input->post('security_answer'));
			
			$question = '';
			$answer = '';
			
			//get users info frm db using username
			$user_array = $this->Users->get_user($email);
			if($user_array){
				//get stored values
				foreach($user_array as $user){
					$question = strtolower($user->security_question);
					$answer = strtolower($user->security_answer);
				}
			}
			
			
			// If the password inputs matched the hashed password in the database
			if ($question == $security_question && $answer == $security_answer){
				return TRUE;
			}
			else{
				$this->form_validation->set_message('validate_old_security', 'The Security Information is wrong');
				return FALSE;
				
			}
		}			
												

		/**
		* Function to validate update security information
		* form
		*/			
		public function security_update(){
			
			
			$this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
			$this->form_validation->set_rules('security_question','Security Question','required|trim|xss_clean');
			$this->form_validation->set_rules('security_answer','Security Answer','required|trim|xss_clean');
			
			$this->form_validation->set_message('required', 'Please enter a %s!');
			
			if ($this->form_validation->run()){	
			
				$this->session->unset_userdata('set_security');
				
				//GET USER EMAIL FROM SESSION
				$email = $this->session->userdata('email');
				
				$update = array(
					'security_question' => $this->input->post('security_question'),
					'security_answer' => $this->input->post('security_answer'),
					'last_updated' => date('Y-m-d H:i:s'),
				);
				
				if ($this->Users->user_update($update, $email)){
					
					
					//$this->session->sess_destroy();	

					$user_array = $this->Users->get_user($email);
					
					$fullname = '';
					
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->first_name .' '.$user->last_name;
						}
					}
					
					
					//update activities table
					$description = 'updated security information';
				
					$activity = array(			
						'name' => $fullname,
						'username' => $email,
						'description' => $description,
						'keyword' => 'Update',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
						
					//send email alert
					$to = $email;
					$subject = 'Security Information Updated';
					$message = "<p>Your security information has been updated!</p>";
					$message .= '<p>If you did not make this request, please contact us ASAP at <a href="mailto:info@dejor.com">info@dejor.com</a> or call <a href="callto:8455551212">(845)555-1212</a>!</p>';
					
					$this->Messages->send_email_alert($to, $subject, $fullname, $message);
					//*/					
									
					
					$data['url'] = 'account/profile';
					
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center"><i class="fa fa-check-circle"></i> Your security information has been updated!</div>';		
					//update complete redirects to success page
					//redirect('account/security/');	
				}
				
			}else {
				
				//Go back to the security Page if validation fails
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.validation_errors().'</div>';
				//$this->security();
			}
			
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
		
		}		
							
			
		
		public function multi_delete(){
			
			if($this->input->post('cb') != '' && $this->input->post('model')!= '' )
			{
				//get checked items from post
				$checked =  html_escape($this->input->post('cb'));
				
				//get model from post
				$model = html_escape($this->input->post('model'));
				
				$new_model = ucfirst($model.'_model');
				
				//load model
				$object = new $new_model();
				
				$i = 0;
				
				foreach($checked as $each){
					
					$each = preg_replace('#[^0-9]#i', '', $each); // filter everything but numbers
						
					
					if(strtolower($model) == 'vehicles'){
						$path = './uploads/vehicles/'.$each.'/';
						delete_files($path);
						
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
					$message = $i.' records deleted!';
					$description = 'deleted '.$i.' records from '.$model;
				}
					
				$email = $this->session->userdata('email');
				
				$user_array = $this->Users->get_user($email);
					
				$fullname = '';
				if($user_array){
					foreach($user_array as $user){
						$fullname = $user->first_name .' '.$user->last_name;
					}
				}
				
				//update activities table
				$activity = array(			
					'name' => $fullname,
					'username' => $email,
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
			if($this->session->userdata('logged_in')){
				$this->session->unset_userdata('logged_in');
				$this->session->unset_userdata('email');
				$this->session->unset_userdata('login_time');
				
				$this->session->sess_destroy();	
				//log out successful, redirects to log in page
				redirect('logged-out');				
				
			}else{
				
				//redirects to logged out page
				redirect('login');				
			}
		}
			
		
		
		
		
		
	
	
	
	
	
	
	
}
