<?php

class Vehicles_model extends MY_Model {
		
		const DB_TABLE = 'vehicles';
		const DB_TABLE_PK = 'id';

		
		var $table = 'vehicles';
		
		var $column_order = array(null, 'vehicle_image','vehicle_type','vehicle_make','vehicle_model','year_of_manufacture','vehicle_odometer','vehicle_lot_number','vehicle_vin','vehicle_colour','vehicle_price','vehicle_location_city','vehicle_location_country','vehicle_description','sale_status','trader_email','discount','price_after_discount','last_updated','date_added'); //set column field database for datatable orderable
		
		var $column_search = array('vehicle_image','vehicle_type','vehicle_make','vehicle_model','year_of_manufacture','vehicle_odometer','vehicle_lot_number','vehicle_vin','vehicle_colour','vehicle_price','vehicle_location_city','vehicle_location_country','vehicle_description','sale_status','trader_email','discount','price_after_discount','last_updated','date_added'); //set column field database for datatable searchable 
		
		var $input_search = array('vehicle_type','vehicle_make','vehicle_model','year_of_manufacture','vehicle_colour','vehicle_description'); //set column field database for datatable searchable 
		
		
		
		var $order = array('id' => 'desc'); // default order 
		
		
		/**
		 * Vehicle Image.
		 * @var string 
		 */
		public $vehicle_image;
		
		
		/**
		 * Vehicle Type.
		 * @var string 
		 */
		public $vehicle_type;

		/**
		 * Vehicle Make.
		 * @var string 
		 */
		public $vehicle_make;
		
		/**
		 * Vehicle Model.
		 * @var string 
		 */
		public $vehicle_model;

		/**
		 * Year of Manufacture.
		 * @var string 
		 */
		public $year_of_manufacture;

		/**
		 * Vehicle Odometer.
		 * @var string 
		 */
		public $vehicle_odometer;

		/**
		 * Vehicle Lot Number.
		 * @var string 
		 */
		public $vehicle_lot_number;

		/**
		 * Vehicle Vin.
		 * @var string 
		 */
		public $vehicle_vin;

		/**
		 * Vehicle Colour.
		 * @var string 
		 */
		public $vehicle_colour;

		/**
		 * Vehicle Price.
		 * @var string 
		 */
		public $vehicle_price;

		/**
		 * Vehicle Location City.
		 * @var string 
		 */
		public $vehicle_location_city;

		/**
		 * Vehicle Location Country.
		 * @var string 
		 */
		public $vehicle_location_country;

		/**
		 * Vehicle Description.
		 * @var string 
		 */
		public $vehicle_description;

		/**
		 * Sale Status.
		 * Item on sale or not
		 * @var string 
		 */
		public $sale_status;

		/**
		 * Trader Email.
		 * @var string 
		 */
		public $trader_email;

		/**
		 * Sale discount percentage.
		 * @var string 
		 */
		public $discount;

		/**
		 * Sale Price after Discount.
		 * @var string 
		 */
		public $price_after_discount;

		/**
		 * Last Time Record was updated .
		 * @var Datetime 
		 */
		public $last_updated;
		
		/**
		 * Date Added.
		 * @var string 
		 */
		public $date_added;


			
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
			
		
		
		/*
		*	DATATABLE FUNCTION FOR USER VEHICLES
		*
		*/
		private function _get_user_datatables_query()
		{
			//$email = $this->session->userdata('email');
			
			if($this->session->userdata('logged_in')){
				$email = $this->session->userdata('email');
			}
				
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
			$this->db->where('trader_email', $email);
			
		}
		
		function get_user_datatables()
		{
			$this->_get_user_datatables_query();
			if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
			$query = $this->db->get();
			return $query->result();
		}
				
	 
		function count_user_filtered(){
			$this->_get_user_datatables_query();
			$query = $this->db->get();
			return $query->num_rows();
		}
				
				
		public function count_user_all(){
			
			//$email = $this->session->userdata('email');
			
			if($this->session->userdata('logged_in')){
				$email = $this->session->userdata('email');
			}
			
			$this->db->where('trader_email', $email);
			$query = $this->db->get($this->table);
			return $query->num_rows();			

		} 
		///END DATATABLE FUNCTION FOR USER VEHICLES
				
	
	/**
		* Function to add vehicle 
		* to the database
		* @param $array
		*/		
		public function insert_vehicle($data){
			
			$this->db->insert($this->table, $data);
			$insert_id = $this->db->insert_id();
			
			if ($insert_id){
				return $insert_id;
			}else {
				return false;
			}
		}

		
		/**
		* Function to update
		* the vehicle
		* variable $id
		*/	
		public function update_vehicle($data, $id){
			
			$this->db->where('id', $id);
			$query = $this->db->update($this->table, $data);
			
			if ($query){	
				return true;
			}else {
				return false;
			}			
			
		}

		/****
		** Function to get vehicles from the database
		**	variable $limit
		****/
		public function get_vehicles($limit = 4, $start = 0){
					
			$this->db->limit($limit, $start);
			$this->db->order_by('id','DESC');
			$vehicles = $this->db->get($this->table);
					
			if($vehicles->num_rows() > 0){
				foreach ($vehicles->result() as $row){
					$data[] = $row;
				}
				return $data;
					  
			}else{
				return false;
			}
		}		

		/****
		** Function to get vehicles from the database
		**	variable $limit
		****/
		public function get_all_vehicles(){
					
			$this->db->order_by('date_added','DESC');
			$vehicles = $this->db->get($this->table);
					
			if($vehicles->num_rows() > 0){
				foreach ($vehicles->result() as $row){
					$data[] = $row;
				}
				return $data;
					  
			}else{
				return false;
			}
		}		
							
		public function count_vehicles(){
					
			$count_vehicles = $this->db->get($this->table);
					
			if($count_vehicles->num_rows() > 0)	{
				$count = $count_vehicles->num_rows();
				return $count;
			}else {	
				return false;
			}			
					
		}

		public function get_vehicles_by_id($id = ''){
			
			if($id != ''){
				$this->db->where('id',$id);
			}
			$vehicles = $this->db->get($this->table);
					
			if($vehicles->num_rows() > 0){
						
				// we will store the results in the form of class methods by using $q->result()
				// if you want to store them as an array you can use $q->result_array()
				foreach ($vehicles->result() as $row)
				{
					$data[] = $row;
				}
				return $data;
					  
			}else{
				return false;
			}
		}	

		public function get_user_vehicles($email = ''){
			
			//$this->db->limit($limit, $start);
			
			if($email != '' && $email != null){
				$this->db->where('trader_email',$email);
			}
			$this->db->order_by('date_added','DESC');
			$vehicles = $this->db->get($this->table);
					
			if($vehicles->num_rows() > 0){
						
				// we will store the results in the form of class methods by using $q->result()
				// if you want to store them as an array you can use $q->result_array()
				foreach ($vehicles->result() as $row)
				{
					$data[] = $row;
				}
				return $data;
					  
			}else{
				return false;
			}
		}		
		
		public function get_vehicles_by_type($type = '', $limit = 10, $start = 0){
					
			$this->db->limit($limit, $start);
			$this->db->where('LOWER(vehicle_type)',strtolower($type));
			$this->db->order_by('date_added','DESC');
			$vehicles = $this->db->get($this->table);
					
			if($vehicles->num_rows() > 0){
						
				// we will store the results in the form of class methods by using $q->result()
				// if you want to store them as an array you can use $q->result_array()
				foreach ($vehicles->result() as $row)
				{
					$data[] = $row;
				}
				return $data;
					  
			}else{
				return false;
			}
		}	
		
		public function count_vehicles_by_type($type){
					
			$this->db->where('LOWER(vehicle_type)',strtolower($type));
			$count_vehicles = $this->db->get($this->table);
					
			if($count_vehicles->num_rows() > 0)	{
				$count = $count_vehicles->num_rows();
				return $count;
			}else {	
				return false;
			}			
					
		}
		
		/****
		** Function to get vehicle images from the database
		****/
		public function get_vehicle_images($id,$limit=10,$start=0){
			
			$this->db->limit($limit, $start);
		
			if($id != ''){
				$this->db->where('vehicle_id', $id);
			}
			
			$q = $this->db->get('vehicle_images');
			
			if($q->num_rows() > 0){
				
			  // we will store the results in the form of class methods by using $q->result()
			  // if you want to store them as an array you can use $q->result_array()
			  foreach ($q->result() as $row)
			  {
				$data[] = $row;
			  }
			  return $data;
			}
			return false;
		}

		 /**
		 * Function to count vehicle images
		 * @var int
		 */			
		public function count_vehicle_images($id=''){
			
			if($id != ''){
				$this->db->where('vehicle_id', $id);
			}
			
			$q = $this->db->get('vehicle_images');
			if($q->num_rows() > 0)	{
					
				$count = $q->num_rows();
				return $count;
			}else {
				return false;
			}				
		}

		 /**
		 * Function to delete project images
		 * @var string
		 */			
		public function delete_image($id = '',$path = ''){
			
			/*$this->db->where('id', $id);
			$this->db->where('id', $image_id);
			$path = './uploads/projects/'.$each.'/';
			unlink("uploads/projects/".$id);
			$query = $this->db->delete('portfolio_images');
			
			if ($query){	
				return true;
			}else {
				return false;
			}		*/	
			if($id != ''){
				$this->db->delete('vehicle_images', array('id' => $id));
			}
			
			if($this->db->affected_rows() >= 1){
				if(unlink($path))
				return TRUE;
			} else {
				return FALSE;
			}
			
		}
			
		
		
		/* Function to ensure the vehicle is unique 
		* 
		*/	//unique_vehicle($type = '', $make = '', $model = '', $email = '')
		public function unique_vehicle($where = array()){
			/*
			if($type != ''){
				$this->db->where('LOWER(vehicle_type)', strtolower($type));
			}

			if($make != ''){
				$this->db->where('LOWER(vehicle_make)', strtolower($make));
			}
			
			if($model != ''){
				$this->db->where('LOWER(vehicle_model)', strtolower($model));
			}
			
			if($email != ''){
				$this->db->where('LOWER(trader_email)', strtolower($email));
			}
			*/
			if(!empty($where)){
				$this->db->where($where);
			}
			
			$query = $this->db->get($this->table);
			
			if ($query->num_rows() == 0){
				return true;
			} else {
				return false;
			}
			
		}

		function get_search($data)
		{
			 
			$this->db->from($this->table);
	 
			$i = 0;
			$keywords = explode(' ', $data);
			
			$where = array();
			
			foreach($keywords as $keyword){
				
				foreach ($this->input_search as $item) // loop column 
				{
					$this->db->group_start();
					$this->db->or_like('LOWER('.$item.')',strtolower($keyword));
					if($keyword) 
					{
						 
						$where[] = "LOWER(".$item.") LIKE '%$keyword%'";
		 
					}
					$i++;
				}
			}
			$like_string = "(" . implode(' OR ', $where) . ")";
			$this->db->where($like_string);
			$query = $this->db->get();
			return $query->result();
		}
		
		public function get_s($search_values)
		{
			//$this->db->distinct();
			$this->db->select('*');
			$this->db->from($this->table);

			$this->db->where('sale_status', '0');

			if (strpos($search_values, ' ') !== false) {
				$search = explode(' ' , $search_values);
				$this->db->like('LOWER(vehicle_type)', trim($search[0]), 'both');
				$this->db->or_like('LOWER(vehicle_type)', trim($search[0]), 'both');
				$this->db->or_like('LOWER(vehicle_make)',strtolower(trim($search[0])), 'both');
				$this->db->or_like('LOWER(vehicle_model)',strtolower(trim($search[0])), 'both');
				$this->db->or_like('LOWER(year_of_manufacture)',strtolower(trim($search[0])), 'both');
				$this->db->or_like('LOWER(vehicle_colour)',strtolower(trim($search[0])), 'both');
				$this->db->or_like('LOWER(vehicle_description)',strtolower(trim($search[0])), 'both');
				unset($search[0]);
					foreach ($search as $term){
						$this->db->or_like('LOWER(vehicle_type)', trim($term), 'both');
						$this->db->or_like('LOWER(vehicle_make)',strtolower(trim($term)), 'both');
						$this->db->or_like('LOWER(vehicle_model)',strtolower(trim($term)), 'both');
						$this->db->or_like('LOWER(year_of_manufacture)',strtolower(trim($term)), 'both');
						$this->db->or_like('LOWER(vehicle_colour)',strtolower(trim($term)), 'both');
						$this->db->or_like('LOWER(vehicle_description)',strtolower(trim($term)), 'both');
					}
			}else{
				//this means you only have one value 
				//$keyword = trim($data);
				
				$this->db->like('LOWER(vehicle_type)',strtolower($search_values), 'both');
				$this->db->or_like('LOWER(vehicle_make)',strtolower($search_values), 'both');
				$this->db->or_like('LOWER(vehicle_model)',strtolower($search_values), 'both');
				$this->db->or_like('LOWER(year_of_manufacture)',strtolower($search_values), 'both');
				$this->db->or_like('LOWER(vehicle_colour)',strtolower($search_values), 'both');
				$this->db->or_like('LOWER(vehicle_description)',strtolower($search_values), 'both');
			}
			$query = $this->db->get();
			return $query->result();
		}  
		
		/**
		* Function to search vehicles
		* @var string
		*/			
		public function search($data){
			
			//$keywords = explode( ' ', $data);
			
			if(is_array($data) && count($data) > 0){
				
				$where = array();
				//$keywords = explode(' ', $data);
				
				foreach ($data as $keyword){
					
					$keyword = trim($keyword);
					
					$this->db->group_start();
					$this->db->like('LOWER(vehicle_type)',strtolower($keyword));
					$this->db->or_like('LOWER(vehicle_make)',strtolower($keyword));
					$this->db->or_like('LOWER(vehicle_model)',strtolower($keyword));
					$this->db->or_like('LOWER(year_of_manufacture)',strtolower($keyword));
					$this->db->or_like('LOWER(vehicle_colour)',strtolower($keyword));
					$this->db->or_like('LOWER(vehicle_description)',strtolower($keyword));
					$this->db->group_end();
					
				}
				
				
			}else{
				$keyword = trim($data);
				
				$this->db->like('LOWER(vehicle_type)',strtolower($keyword));
				$this->db->or_like('LOWER(vehicle_make)',strtolower($keyword));
				$this->db->or_like('LOWER(vehicle_model)',strtolower($keyword));
				$this->db->or_like('LOWER(year_of_manufacture)',strtolower($keyword));
				$this->db->or_like('LOWER(vehicle_colour)',strtolower($keyword));
				$this->db->or_like('LOWER(vehicle_description)',strtolower($keyword));
			}
				
				$this->db->order_by('id','DESC');
				$this->db->where('sale_status', '0');
				$this->db->order_by('id','DESC');
				$query = $this->db->get($this->table);
				if($query->num_rows() > 0){
					
					return $query->result();
					// we will store the results in the form of class methods by using $q->result()
					// if you want to store them as an array you can use $q->result_array()
					/*foreach ($query->result() as $row){
						$data[] = $row;
					}
					return $data;
					*/
				}
				return false;
		}			 
		
		/**
		* Function to search vehicles
		* @var string
		*/			
		public function count_search($data){
			
			//$keywords = explode( ' ', $data);
			
			if(is_array($data) && count($data) > 0){
				
				$where = array();
				//$keywords = explode(' ', $data);
				
				foreach ($data as $keyword){
					
					$keyword = trim($keyword);
					
					$this->db->group_start();
					$this->db->like('LOWER(vehicle_type)',strtolower($keyword));
					$this->db->or_like('LOWER(vehicle_make)',strtolower($keyword));
					$this->db->or_like('LOWER(vehicle_model)',strtolower($keyword));
					$this->db->or_like('LOWER(year_of_manufacture)',strtolower($keyword));
					$this->db->or_like('LOWER(vehicle_colour)',strtolower($keyword));
					$this->db->or_like('LOWER(vehicle_description)',strtolower($keyword));
					$this->db->group_end();
					
				}
				
				
			}else{
				$keyword = trim($data);
				
				$this->db->like('LOWER(vehicle_type)',strtolower($keyword));
				$this->db->or_like('LOWER(vehicle_make)',strtolower($keyword));
				$this->db->or_like('LOWER(vehicle_model)',strtolower($keyword));
				$this->db->or_like('LOWER(year_of_manufacture)',strtolower($keyword));
				$this->db->or_like('LOWER(vehicle_colour)',strtolower($keyword));
				$this->db->or_like('LOWER(vehicle_description)',strtolower($keyword));
			}
				
				$this->db->order_by('id','DESC');
				$this->db->where('sale_status', '0');
				$query = $this->db->get($this->table);
				if($query->num_rows() > 0){
					return $query->num_rows();;
				}
				return false;
		}			 
		
				

		 /**
		 * Function to count search result
		 * @var string
		 */			
		public function count_multi_search($where, $min_year = '', $max_year = '', $min_price = '', $max_price = ''){
			
			$this->db->where($where);
			$this->db->where('sale_status', '0');
			
			if($min_year != '' && $max_year){
				$this->db->where("year_of_manufacture BETWEEN '$min_year' AND '$max_year'", NULL, FALSE);
			}
			
			if($min_price != '' && $max_price){
				$this->db->where("vehicle_price BETWEEN '$min_price' AND '$max_price'", NULL, FALSE);
			}

			$count_vehicles = $this->db->get($this->table);
				
			if($count_vehicles->num_rows() > 0)	{
					
				$count = $count_vehicles->num_rows();
				return $count;
			}else {
				return false;
			}			
				
		}
		
		 /**
		 * Function to search result
		 * @var string
		 */			
		public function multi_search($where, $min_year = '', $max_year = '', $min_price = '', $max_price = ''){
			
			$this->db->where($where);
			$this->db->where('sale_status', '0');
			
			if($min_year != '' && $max_year){
				$this->db->where("year_of_manufacture BETWEEN '$min_year' AND '$max_year'", NULL, FALSE);
			}
			
			if($min_price != '' && $max_price){
				$this->db->where("vehicle_price BETWEEN '$min_price' AND '$max_price'", NULL, FALSE);
			}

			$this->db->order_by('id','DESC');
			$query = $this->db->get($this->table);
			if($query->num_rows() > 0){
					
				// we will store the results in the form of class methods by using $q->result()
				// if you want to store them as an array you can use $q->result_array()
				foreach ($query->result() as $row){
					$data[] = $row;
				}
				return $data;
			}
			return false;
		}			
					
		
		/**
		* Function to search vehicles
		* @var string
		*/			
		public function search_vehicles($keywords){
			
			
			//if(is_array($data) && count($data) > 0){
			if( strpos($keywords, ' ' ) !== false ){	
				
				//CONVERT STRING TO ARRAY
				$search_array = explode( ' ', $keywords);
			
				$where = array();
			
				foreach ($search_array as $keyword){
					
					$keyword = trim($keyword);
					
					$where[] = "(LOWER(vehicle_type) LIKE '%'".$this->db->escape($keyword)."'%' OR LOWER(vehicle_make) LIKE '%'".$this->db->escape($keyword)."'%' OR LOWER(vehicle_model) LIKE '%'".$this->db->escape($keyword)."'%' OR LOWER(year_of_manufacture) LIKE '%'".$this->db->escape($keyword)."'%' OR LOWER(vehicle_colour) LIKE '%'".$this->db->escape($keyword)."'%' OR LOWER(vehicle_description) LIKE '%'".$this->db->escape($keyword)."'%')";
				}
				
				$this->db->where(implode(' AND ', $where));
				
			}else{
				$keyword = trim($keywords);
				
				$this->db->like('LOWER(vehicle_type)',strtolower($keyword));
				$this->db->or_like('LOWER(vehicle_make)',strtolower($keyword));
				$this->db->or_like('LOWER(vehicle_model)',strtolower($keyword));
				$this->db->or_like('LOWER(year_of_manufacture)',strtolower($keyword));
				$this->db->or_like('LOWER(vehicle_colour)',strtolower($keyword));
				$this->db->or_like('LOWER(vehicle_description)',strtolower($keyword));
			}
				
				$this->db->order_by('id','DESC');
				$this->db->where('sale_status', '0');
				$query = $this->db->get($this->table);
				if($query->num_rows() > 0){
					
					return $query->result();
					// we will store the results in the form of class methods by using $q->result()
					// if you want to store them as an array you can use $q->result_array()
					/*foreach ($query->result() as $row){
						$data[] = $row;
					}
					return $data;
					*/
				}
				return false;
		}					

		 /**
		 * Function to count search result
		 * @var string
		 */			
		public function count_search_vehicles($data){
			
			//$keywords = explode( ' ', $data);
			
			if(is_array($data) && count($data) > 0){
				
				foreach ($data as $keyword){
					
					$keyword = trim($keyword);
					$this->db->where("vehicle_type LIKE '%'" . $this->db->escape($keyword) . "'%'");
					$this->db->or_where("vehicle_make LIKE '%'" . $this->db->escape($keyword) . "'%'");
					$this->db->or_where("vehicle_model LIKE '%'" . $this->db->escape($keyword) . "'%'");
					$this->db->or_where("year_of_manufacture LIKE '%'" . $this->db->escape($keyword) . "'%'");
					$this->db->or_where("vehicle_colour LIKE '%'" . $this->db->escape($keyword) . "'%'");
					$this->db->or_where("vehicle_description LIKE '%'" . $this->db->escape($keyword) . "'%'");
					
				}
			}else{
				$keyword = trim($data);
				$this->db->like('LOWER(vehicle_type)',strtolower($keyword));
				$this->db->or_like('LOWER(vehicle_make)',strtolower($keyword));
				$this->db->or_like('LOWER(vehicle_model)',strtolower($keyword));
				$this->db->or_like('LOWER(year_of_manufacture)',strtolower($keyword));
				$this->db->or_like('LOWER(vehicle_colour)',strtolower($keyword));
				$this->db->or_like('LOWER(vehicle_description)',strtolower($keyword));
			}
			
			
			$this->db->where('sale_status', '0');
			$count_vehicles = $this->db->get($this->table);
			
			if($count_vehicles->num_rows() > 0)	{
					
				$count = $count_vehicles->num_rows();
				return $count;
			}else {
				return false;
			}			
				
		}
						
		/**
		* Function to search products
		* @var string
		*/			
		public function search3($keyword){
			
			//if(is_array($keyword) && count($keyword) > 0){
			if( strpos($keyword, ' ' ) !== false ){	
				
				//CONVERT STRING TO ARRAY
				$search_array = explode( ' ', $keyword);
			
				$like = array();
				$like2 = array();
				$like3 = array();
				$like4 = array();
				$like5 = array();
				$like6 = array();
				
				//"(category LIKE '%".$value."%' OR colour LIKE '%".$value."%' OR brand LIKE '%".$value."%' OR name LIKE '%".$value."%' OR description LIKE '%".$value."%')"
				foreach($search_array as $value) {
					$like[] = "vehicle_type LIKE '%'" . $this->db->escape($value) . "'%'";
					$like2[] = "vehicle_make LIKE '%'" . $this->db->escape($value) . "'%'";
					$like3[] = "vehicle_model LIKE '%'" . $this->db->escape($value) . "'%'";
					$like4[] = "year_of_manufacture LIKE '%'" . $this->db->escape($value) . "'%'";
					$like5[] = "vehicle_colour LIKE '%'" . $this->db->escape($value) . "'%'";
					$like6[] = "vehicle_description LIKE '%'" . $this->db->escape($value) . "'%'";
				}
				$like_string = "(" . implode(' OR ', $like) . ")";
				$like_string2 = "(" . implode(' OR ', $like2) . ")";
				$like_string3 = "(" . implode(' OR ', $like3) . ")";
				$like_string4 = "(" . implode(' OR ', $like4) . ")";
				$like_string5 = "(" . implode(' OR ', $like5) . ")";
				$like_string6 = "(" . implode(' OR ', $like6) . ")";
				
				$this->db->where($like_string);
				$this->db->where($like_string2);
				$this->db->where($like_string3);
				$this->db->where($like_string4);
				$this->db->where($like_string5);
				$this->db->where($like_string6);
				
			}else{
				$this->db->like('LOWER(vehicle_type)',strtolower($keyword));
				$this->db->or_like('LOWER(vehicle_make)',strtolower($keyword));
				$this->db->or_like('LOWER(vehicle_model)',strtolower($keyword));
				$this->db->or_like('LOWER(year_of_manufacture)',strtolower($keyword));
				$this->db->or_like('LOWER(vehicle_colour)',strtolower($keyword));
				$this->db->or_like('LOWER(vehicle_description)',strtolower($keyword));
			}
			
			//$this->db->order_by('id','DESC');
			$query = $this->db->get($this->table);
			if($query->num_rows() > 0){
		
				foreach ($query->result() as $row){
					$data[] = $row;
				}
				return $data;
			}
			return false;
		}	
		
		public function search2($keyword){
			
			if(is_array($keyword) && count($keyword) > 0){
				
				$where = array();
				//LOOP THROUGH BASED ON NUMBER OF COLUMNS
				for($i = 0; $i < count($this->input_search); $i++){
					
					//$like[$i] = array();
					
					//LOOP THROUGH KEYWORDS
					foreach($keyword as $value){
						
						//GET COLUMN AND COMPARE TO KEYWORD
						foreach($this->input_search as $input){
							$where[] = $input." LIKE '%'" . $this->db->escape($value) . "'%'";
						}	
					}
				}
				$this->db->where(implode(' AND ', $where));
			}else{
				$this->db->like('LOWER(vehicle_type)',strtolower($keyword));
				$this->db->or_like('LOWER(vehicle_make)',strtolower($keyword));
				$this->db->or_like('LOWER(vehicle_model)',strtolower($keyword));
				$this->db->or_like('LOWER(year_of_manufacture)',strtolower($keyword));
				$this->db->or_like('LOWER(vehicle_colour)',strtolower($keyword));
				$this->db->or_like('LOWER(vehicle_description)',strtolower($keyword));
			}
			
			$query = $this->db->get($this->table);
			if($query->num_rows() > 0){
		
				foreach ($query->result() as $row){
					$data[] = $row;
				}
				return $data;
			}
			return false;
				
		}
		
		
		 /**
		 * Function to count search result
		 * @var string
		 */			
		public function count_search3($keyword){
			
			if(is_array($keyword) && count($keyword) > 0){
				
				$like = array();
				$like2 = array();
				$like3 = array();
				$like4 = array();
				$like5 = array();
				$like6 = array();
				
				//"(category LIKE '%".$value."%' OR colour LIKE '%".$value."%' OR brand LIKE '%".$value."%' OR name LIKE '%".$value."%' OR description LIKE '%".$value."%')"
				foreach($keyword as $value) {
					$like[] = "vehicle_type LIKE '%'" . $this->db->escape($value) . "'%'";
					$like2[] = "vehicle_make LIKE '%'" . $this->db->escape($value) . "'%'";
					$like3[] = "vehicle_model LIKE '%'" . $this->db->escape($value) . "'%'";
					$like4[] = "year_of_manufacture LIKE '%'" . $this->db->escape($value) . "'%'";
					$like5[] = "vehicle_colour LIKE '%'" . $this->db->escape($value) . "'%'";
					$like6[] = "vehicle_description LIKE '%'" . $this->db->escape($value) . "'%'";
				}
				$like_string = "(" . implode(' OR ', $like) . ")";
				$like_string2 = "(" . implode(' OR ', $like2) . ")";
				$like_string3 = "(" . implode(' OR ', $like3) . ")";
				$like_string4 = "(" . implode(' OR ', $like4) . ")";
				$like_string5 = "(" . implode(' OR ', $like5) . ")";
				$like_string6 = "(" . implode(' OR ', $like6) . ")";
				
				$this->db->where($like_string);
				$this->db->or_where($like_string2);
				$this->db->or_where($like_string3);
				$this->db->or_where($like_string4);
				$this->db->or_where($like_string5);
				$this->db->or_where($like_string6);
				
				/*$this->db->like($like_string);
				$this->db->or_like($like_string2);
				$this->db->or_like($like_string3);
				$this->db->or_like($like_string4);
				$this->db->or_like($like_string5);
				$this->db->or_like($like_string6);
				*/
			}else{
				$this->db->like('LOWER(vehicle_type)',strtolower($keyword));
				$this->db->or_like('LOWER(vehicle_make)',strtolower($keyword));
				$this->db->or_like('LOWER(vehicle_model)',strtolower($keyword));
				$this->db->or_like('LOWER(year_of_manufacture)',strtolower($keyword));
				$this->db->or_like('LOWER(vehicle_colour)',strtolower($keyword));
				$this->db->or_like('LOWER(vehicle_description)',strtolower($keyword));
			}
			
			$count_vehicles = $this->db->get($this->table);
				
			if($count_vehicles->num_rows() > 0)	{
					
				$count = $count_vehicles->num_rows();
				return $count;
			}else {
				return false;
			}			
				
		}

		public function count_search2($keyword){
			
			if(is_array($keyword) && count($keyword) > 0){
				
				//LOOP THROUGH BASED ON NUMBER OF COLUMNS
				for($i = 0; $i < count($this->input_search); $i++){
					
					$like[$i] = array();
					
					//LOOP THROUGH KEYWORDS
					foreach($keyword as $value){
						
						//GET COLUMN AND COMPARE TO KEYWORD
						foreach($this->input_search as $input){
							$like[$i] = $input." LIKE '%" . $this->db->escape($value) . "%'";
						}	
					}
					$string = array();
					$string = "(" . implode(' OR ', $like[$i]) . ")";
					$this->db->where($string);
				}
				
			}else{
				$this->db->like('LOWER(vehicle_type)',strtolower($keyword));
				$this->db->or_like('LOWER(vehicle_make)',strtolower($keyword));
				$this->db->or_like('LOWER(vehicle_model)',strtolower($keyword));
				$this->db->or_like('LOWER(year_of_manufacture)',strtolower($keyword));
				$this->db->or_like('LOWER(vehicle_colour)',strtolower($keyword));
				$this->db->or_like('LOWER(vehicle_description)',strtolower($keyword));
			}
			
			$count_vehicles = $this->db->get($this->table);
				
			if($count_vehicles->num_rows() > 0)	{
					
				$count = $count_vehicles->num_rows();
				return $count;
			}else {
				return false;
			}			
				
		}



	
	
	
}