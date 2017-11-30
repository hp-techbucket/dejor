<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VehicleFinder extends CI_Controller {

		/**
		 * Index Page for this controller.
		 *
		 */
		public function index()
		{
			$this->vehicles_display_2();
		}
	
						
		/**
		 * Function for Vehicles Display Page.
		 *
		 */
		public function vehicles_display_2()
		{

			
			//number of items displayed per page				
			$items_per_page = 10;
			
			if($this->input->post('items_per_page') != ''){
				$items_per_page = $this->input->post('items_per_page');
			}
				
			$config = array();
			
			$data['display_option'] = '<strong>Showing All Vehicles</strong>';
			
			$count = $this->Vehicles->count_all();
			if($count < 1){
				$count = 0;
			}
			
			$config["base_url"] = base_url()."vehicles-2";
			$config["total_rows"] = $this->Vehicles->count_vehicles();
			$config["per_page"] = $items_per_page;
			$config["uri_segment"] = 3;
			$choice = $config["total_rows"] / $config["per_page"];
			$config["num_links"] = round($choice);
		
				
			$this->pagination->initialize($config);
						
			if($this->uri->segment(3) > 0)
				$offset = ($this->uri->segment(3) + 0)*$config['per_page'] - $config['per_page'];
			else
				$offset = $this->uri->segment(3);					
								
			//call the model function to get the vehicles data
			$data['vehicles_listing_array'] = $this->Vehicles->get_vehicles($config["per_page"], $this->uri->segment(3));		
					
			//create pagination links
			$data['pagination'] = $this->pagination->create_links();
				
			$data['count'] = $count;
			
			$currentPage = floor(($offset/$config['per_page']) + 1); 
			$total = $count;
					
			$result_start = ($currentPage - 1) * $items_per_page + 1;
			if ($result_start == 0) 
				
				$result_start= 1; // *it happens only for the first run*
						
				$result_end = $result_start + $items_per_page - 1;

			if ($result_end < $items_per_page)   // happens when records less than per page  
				$result_end = $items_per_page;  
			else if ($result_end > $total)  // happens when result end is greater than total records  
					$result_end = $total;
				if($total == 0){
						//display current page and no of pages
						$data['current'] = "";
				}else{
						//display current page and no of pages
						$data['current'] = "Displaying ".$result_start.' to '.$result_end.' of '.$total;
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
			$data['pageTitle'] = 'Vehicles 2';
				
			//assign page ID
			$data['pageID'] = 'vehicles_2';
			
			$this->load->view('pages/template-header', $data);
			
			$this->load->view('pages/vehicle_finder_page_2', $data);
				
			$this->load->view('pages/template-footer', $data);
		}




		
	
	
	
	
	
	
	
}
