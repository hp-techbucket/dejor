<?php

class Reviews_model extends MY_Model {
		
		const DB_TABLE = 'reviews';
		const DB_TABLE_PK = 'id';


		var $table = 'reviews';
		
		var $column_order = array(null, 'seller_email','rating','reviewer_name','reviewer_email','comment','ip_address','ip_details','review_date'); //set column field database for datatable orderable
		
		var $column_search = array('seller_email','rating','reviewer_name','reviewer_email','comment','ip_address','ip_details','review_date'); //set column field database for datatable searchable 
		
		var $order = array('id' => 'desc'); // default order 
		
	
		/**
		 * user id.
		 * @var int 
		 */
		public $seller_email;

		/**
		 * rating.
		 * @var int 
		 */
		public $rating;

		/**
		 * reviewer_name.
		 * @var string 
		 */
		public $reviewer_name;

		/**
		 * reviewer email.
		 * @var string 
		 */
		public $reviewer_email;

		/**
		 * comment.
		 * @var string 
		 */
		public $comment;

		/**
		 * ip_address.
		 * @var string 
		 */
		public $ip_address;

		/**
		 * ip_details.
		 * @var string 
		 */
		public $ip_details;

		/**
		 * review date.
		 * @var date 
		 */
		public $review_date;

		
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
	
			
		private function _get_user_datatables_query()
		{
			$email = $this->session->userdata('email');
			
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
			$this->db->where('seller_email', $email);	
		}
		
		function get_user_datatables()
		{
			$this->_get_user_datatables_query();
			if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
			$query = $this->db->get();
			return $query->result();
		}
	 
		function count_user_filtered()
		{
			$this->_get_user_datatables_query();
			$query = $this->db->get();
			return $query->num_rows();
		}
	 
		public function count_user_all()
		{
			$email = $this->session->userdata('email');
			$this->db->where('seller_email', $email);	
			$query = $this->db->get($this->table);
			return $query->num_rows();
		}			

		 /**
		 * Function to count reviews
		 * @var string
		 */			
		public function count_reviews(){
			
			$count_reviews = $this->db->get($this->table);
			if($count_reviews->num_rows() > 0)	{
					
				$count = $count_reviews->num_rows();
				return $count;
			}else {
				return false;
			}				
		}
		
		
		/****
		** Function to get all records from the database
		****/
		public function get_reviews(){
			
			$this->db->order_by('id','DESC');
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
			return false;
		}

		/**
		* Function to add the item 
		* to the products table in the database
		* @param $string Activation key
		*/		
		public function insert_review($data){

			$query  = $this->db->insert($this->table, $data);
			
			if ($query ){
				return true;
			}else {
				return false;
			}
		}
		
		/**
		* Function to update
		* the review
		* variable array $data int $id
		*/	
		public function update_review($data, $id){
			
			$this->db->where('id', $id);
			$query = $this->db->update($this->table, $data);
			
			if ($query){	
				return true;
			}else {
				return false;
			}			
			
		}

		
		/****
		** Function to get user reviews from the database
		****/
		public function get_user_reviews($email = ''){
			
			if($email != '' && $email != null){
				$this->db->where('seller_email', $email);
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
			return false;
		}

		 /**
		 * Function to count user reviews
		 * @var string
		 */			
		public function count_user_reviews($email = ''){
			
			
			if($email != '' && $email != null){
				$this->db->where('seller_email', $email);
			}
			
			$count_reviews = $this->db->get($this->table);
			if($count_reviews->num_rows() > 0)	{
					
				$count = $count_reviews->num_rows();
				return $count;
			}else {
				return false;
			}				
		}

		
		/****
		** Function to get average product ratings from the database
		****/
		public function get_user_rating($email = ''){
			$this->db->select_avg('rating','overall');
			$this->db->from($this->table);
			
			if($email != '' && $email != null){
				$this->db->where('seller_email', $email);
			}
			
			$q = $this->db->get();
			
			if($q->num_rows() > 0){
				return $q->result();
			 
			}
			return false;
		}
		

						
		
		
	
}