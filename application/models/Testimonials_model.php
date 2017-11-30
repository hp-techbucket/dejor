<?php

class Testimonials_model extends MY_Model {
		
		const DB_TABLE = 'testimonials';
		const DB_TABLE_PK = 'id';


		var $table = 'testimonials';
		
		var $column_order = array(null, 'avatar','client_id','fullname','company','comment','testimony_date'); //set column field database for datatable orderable
		
		var $column_search = array('client_id','fullname','company','comment','testimony_date'); //set column field database for datatable searchable 
		
		var $order = array('id' => 'desc'); // default order 
			
		
		/**
		 * avatar.
		 * @var int 
		 */
		public $avatar;

		/**
		 * client_id.
		 * @var string
		 */
		public $client_id; 
	 
		/**
		 * fullname.
		 * @var string
		 */
		public $fullname; 

		/**
		 * company.
		 * @var string
		 */
		public $company; 

		/**
		 * comment.
		 * @var string
		 */
		public $comment; 

		/**
		 * Date added.
		 * @var string 
		 */
		public $testimony_date;


			
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


			
		private function _get_client_datatables_query()
		{
			$username = $this->session->userdata('username');
			$user_array = $this->Clients->get_client($username);
			$id = '';
			if($user_array){
				foreach($user_array as $user){
					$id = $user->id;
				}
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
			$this->db->where('client_id', $id);	
		}
		
		function get_client_datatables()
		{
			$this->_get_client_datatables_query();
			if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
			$query = $this->db->get();
			return $query->result();
		}
	 
		function count_client_filtered()
		{
			$this->_get_client_datatables_query();
			$query = $this->db->get();
			return $query->num_rows();
		}
	 
		public function count_client_all()
		{
			$username = $this->session->userdata('username');
			$user_array = $this->Clients->get_client($username);
			$id = '';
			if($user_array){
				foreach($user_array as $user){
					$id = $user->id;
				}
			}
			
			$this->db->where('client_id', $id);	
			$query = $this->db->get($this->table);
			return $query->num_rows();
		}

		
		
		public function add_testimonial($data){
				
			$query = $this->db->insert($this->table, $data);
			$insert_id = $this->db->insert_id();
			if ($query){
				return $insert_id;
			}else {
				return false;
			}
				
		}
			
		/**
		* Function to update testimonial
		* variable $id
		*/	
		public function update_testimonial($data, $id){

			$this->db->where('id', $id);
			$query = $this->db->update($this->table, $data);
			
			if ($query){	
				return true;
			}else {
				return false;
			}			
		}
		
	//get testimonial by id		
	public function get_testimonial($id){
			
		$this->db->where('id', $id);
		$q = $this->db->get($this->table);
			
		if($q->num_rows() > 0){
			foreach ($q->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
	}	

	
	public function get_all(){

		$this->db->order_by('testimony_date','DESC');
		$testimonials = $this->db->get($this->table);
				
		if($testimonials->num_rows() > 0){		
			foreach ($testimonials->result() as $row){
				$data[] = $row;
			}
			return $data;		  
		}else{
			return false;
		}
	}		

	

	public function get_testimonials($limit = 3, $start = 0){
				
		$this->db->limit($limit, $start);
		$this->db->order_by('testimony_date','DESC');
		$testimonials = $this->db->get($this->table);
				
		if($testimonials->num_rows() > 0){
					
			// we will store the results in the form of class methods by using $q->result()
			// if you want to store them as an array you can use $q->result_array()
			foreach ($testimonials->result() as $row)
			{
				$data[] = $row;
			}
			return $data;
				  
		}else{
			return false;
		}
	}		
			
	public function count_testimonials(){
				
		$count_testimonials = $this->db->get($this->table);
				
		if($count_testimonials->num_rows() > 0)	{
			$count = $count_testimonials->num_rows();
			return $count;
		}else {	
			return false;
		}			
				
	}
	
	
	
	



	
    
}

