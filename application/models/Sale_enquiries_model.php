<?php

class Sale_enquiries_model extends MY_Model {
    
    const DB_TABLE = 'sale_enquiries';
    const DB_TABLE_PK = 'id';
	
	var $table = 'sale_enquiries';
	
    var $column_order = array(null, 'customer_name','customer_email','customer_telephone','vehicle_id','comment','preferred_contact_method','ip_address','ip_details','seller_email','opened','enquiry_date'); //set column field database for datatable orderable
	
    var $column_search = array('customer_name','customer_email','customer_telephone','vehicle_id','comment','preferred_contact_method','ip_address','ip_details','seller_email','opened','enquiry_date'); //set column field database for datatable searchable 
	
    var $order = array('id' => 'desc'); // default order 

	
    
    /**
     * CUSTOMER NAME.
     * @var string 
     */
    public $customer_name;
 
    /**
     * CUSTOMER EMAIL.
     * @var string
     */
    public $customer_email; 

    /**
     * CUSTOMER TEL.
     * @var string
     */
    public $customer_tel; 

    /**
     * VEHICLE ID.
     * @var string
     */
    public $vehicle_id; 

    /**
     * COMMENT.
     * @var string
     */
    public $comment; 

    /**
     * PREFERRED CONTACT METHOD.
     * @var string
     */
    public $preferred_contact_method; 

    /**
     * IP ADDRESS.
     * @var string
     */
    public $ip_address; 

    /**
     * IP DETAILS.
     * @var string
     */
    public $ip_details; 

    /**
     * SELLER EMAIL.
     * @var string
     */
    public $seller_email; 

    /**
     * message read.
     * @var string
     */
    public $opened; 

    /**
     * ENQUIRY DATE.
     * @var string 
     */
    public $enquiry_date;

	
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
		*	DATATABLE FUNCTION FOR SELLERS
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
			
			$this->db->where('seller_email', $email);
			$query = $this->db->get($this->table);
			return $query->num_rows();			

		} 
		///END DATATABLE FUNCTION FOR USERS
				
	
	
	public function add_enquiry($data){
			
		$query = $this->db->insert($this->table, $data);
		//$insert_id = $this->db->insert_id();
		if ($query){
			return true;
		}else {
			return false;
		}
			
	}

	//get quote requests by id		
	public function get_enquiry($id = ''){
		
		if($id != '' && $id != null){
			$this->db->where('id', $id);
		}	
		
		$q = $this->db->get($this->table);
			
		if($q->num_rows() > 0){
			foreach ($q->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
	}	

	//get quote requests by email		
	public function get_seller_enquiries($email = ''){
		
		if($email != '' && $email != null){
			$this->db->where('seller_email', $email);
		}	

		$q = $this->db->get($this->table);
			
		if($q->num_rows() > 0){
			foreach ($q->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
	}	

	
	public function get_all(){

		$this->db->order_by('enquiry_date','DESC');
		$requests = $this->db->get($this->table);
				
		if($requests->num_rows() > 0){		
			foreach ($requests->result() as $row){
				$data[] = $row;
			}
			return $data;		  
		}else{
			return false;
		}
	}		



	public function get_enquiries($limit = 10, $start = 0){
				
		$this->db->limit($limit, $start);
		$this->db->where('opened', '0');
		$this->db->order_by('enquiry_date','DESC');
		$requests = $this->db->get($this->table);
				
		if($requests->num_rows() > 0){
					
			// we will store the results in the form of class methods by using $q->result()
			// if you want to store them as an array you can use $q->result_array()
			foreach ($requests->result() as $row)
			{
				$data[] = $row;
			}
			return $data;
				  
		}else{
			return false;
		}
	}		

			
	public function count_unread_enquiries($email = ''){
		
		if($email != '' && $email != null){
			$this->db->where('seller_email', $email);
		}	

		$this->db->where('opened', '0');
		$count_enquiries = $this->db->get($this->table);
				
		if($count_enquiries->num_rows() > 0)	{
			$count = $count_enquiries->num_rows();
			return $count;
		}else {	
			return false;
		}			
				
	}

	

			
		/**
		* Function to delete old records
		*  
		*/		
		public function delete_old_records(){
			
			$date = date("Y-m-d H:i:s",time());
			$date = strtotime($date);
			//delete records older than 90 days
			$min_date = strtotime("-90 day", $date);
			
			$this->db->where("enquiry_date < '$min_date'", NULL, FALSE);
			$this->db->delete($this->table);
		}
			
	
	



	
    
}

