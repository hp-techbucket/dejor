<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Location extends CI_Controller {
 
		/**
		 * Class constructor.
		 * Adding libraries for each call.
		 */
		public function __construct() {
			parent::__construct();

		}	
		
		/**
		* Function for controller
		*  index
		*/	
		public function index(){
			
			if($this->session->userdata('logged_in')){
				if(isset($_GET['type']) || !empty($_GET['type'])) {
					$type = $_GET['type'];
					if($type=='getCountries') {
						$data = $this->Countries->get_countries();
					} 
					if($type=='getStates') {
						 $countryId = $_GET['countryId'];
						 $data = $this->Countries->get_states($countryId);
					}
					if($type=='getCities') {
						 $stateId = $_GET['stateId'];
						 $data = $this->Countries->get_cities($stateId);
					}
				}
				echo json_encode($data);
				
			}else{
				redirect('main/login');	
			}
		}
	

		/**
		* Function to get states 
		* 
		*/			
		public function get_states(){
		
			if(!empty($this->input->post('id')) || $this->input->post('id') != ''){
				
				//escaping the post values
				$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
				$pid = html_escape($this->input->post('id'));
				
				$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
					
				$options = '';
				$options .= '<select name="state" id="state" class="form-control select2 states">';
				$options .= '<option value="0" selected="selected">Select State</option>';
						
				$this->db->from('states');
				$this->db->where('country_id', $id);
				$result = $this->db->get();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row){
						$options .= '<option value="'.$row['name'].'">'.$row['name'].'</option>';			
					}
				}
				$options .= '</select>';
					
				$data['options'] = $options;
						
				$data['success'] = true;
					
			}else {
					$data['success'] = false;
			}
				
			echo json_encode($data);
			
		}		
	

		/**
		* Function to get cities 
		* 
		*/			
		public function get_cities(){
		
			if(!empty($this->input->post('id')) || $this->input->post('id') != ''){
					
				$id = $this->input->post('id');
					
				$options = '';
				$options .= '<select name="card_billing_city" id="cities">';
				$options .= '<option value="0" selected="selected">Select City</option>';
						
				$this->db->from('cities');
				$this->db->where('state_id', $id);
				$result = $this->db->get();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row){
						$options .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';			
					}
				}
				$options .= '</select>';
					
				$data['options'] = $options;
						
				$data['success'] = true;
					
			}else {
					$data['success'] = false;
			}
				
			echo json_encode($data);
			
		}		

		/**
		* Function to get states 
		* 
		*/			
		public function get_shipping_states(){
		
			if(!empty($this->input->post('id')) || $this->input->post('id') != ''){
				
				//escaping the post values
				$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
				$pid = html_escape($this->input->post('id'));
				
				$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
					
				$options = '';
				
				//$options .= '<option value="0" selected="selected">Select State</option>';
						
				$this->db->from('states');
				$this->db->where('country_id', $id);
				$result = $this->db->get();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row){
						$options .= '<option value="'.$row['name'].'">'.$row['name'].'</option>';			
					}
				}
				
				$data['options'] = $options;
						
				$data['success'] = true;
					
			}else {
					$data['success'] = false;
			}
				
			echo json_encode($data);
			
		}		
	



		


	
	
	}