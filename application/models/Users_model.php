<?php

class Users_model extends MY_Model {
    
    const DB_TABLE = 'users';
    const DB_TABLE_PK = 'id';
	

	var $table = 'users';
	
    var $column_order = array(null, 'avatar','first_name','last_name','company_name','address_line_1','address_line_2','city','postcode','state','country','email_address','facebook','twitter','google','telephone','password','security_question','security_answer','status','last_updated','date_created','last_login'); //set column field database for datatable orderable
	
    var $column_search = array('first_name','last_name','company_name','address_line_1','address_line_2','city','postcode','state','country','email_address','facebook','twitter','google','telephone','password','security_question','security_answer','status','last_updated','date_created','last_login'); //set column field database for datatable searchable 
	
    var $order = array('id' => 'desc'); // default order 

    /**
     * User avatar.
     * @var string 
     */
    public $avatar;
    
    /**
     * User First Name.
     * @var string 
     */
    public $first_name;
    
     /**
     * User Last Name.
     * @var string
     */
    public $last_name;
    
     /**
     * User company Name.
     * @var string
     */
    public $company_name;
  
    /**
     * User address.
     * @var string
     */
    public $address_line_1;

    /**
     * User address.
     * @var string
     */
    public $address_line_2;
                
    /**
     * User city.
     * @var string
     */
    public $city;
	            
    /**
     * User postcode.
     * @var string
     */
    public $postcode;
	            
    /**
     * User state.
     * @var string
     */
    public $state;
	            
    /**
     * User country.
     * @var string
     */
    public $country;
			
    /**
     * User Email Address.
     * @var string
     */
    public $email_address;

    /**
     * Team member facebook.
     * @var string
     */
    public $facebook;		
	

    /**
     * Team member twitter.
     * @var string
     */
    public $twitter;		
		

    /**
     * Team member google.
     * @var string
     */
    public $google;		
				
    /**
     * User telephone.
     * @var string
     */
    public $telephone;

     /**
     * User password.
     * @var string
     */
    public $password;

     /**
     * User Security question.
     * @var float
     */
    public $security_question;
    
     /**
     * User Security answer.
     * @var string
     */
    public $security_answer;
    
     /**
     * status.
     * @var string
     */
    public $status;
    
     /**
     * last_updated.
     * @var string
     */
    public $last_updated;

    /**
     * Date created.
     * @var string 
     */
    public $date_created;

    /**
     * User last login.
     * @var string 
     */
    public $last_login;


			
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
			$this->db->where('status', '0');
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
			$this->db->where('status', '0');
			$query = $this->db->get($this->table);
			return $query->num_rows();
			//$this->db->from($this->table);
			//return $this->db->count_all_results();
		}	
		

			
		private function _get_deactivated_datatables_query()
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
			$this->db->where('status', '1');
		}
		
		function get_deactivated_datatables()
		{
			$this->_get_deactivated_datatables_query();
			if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
			$query = $this->db->get();
			return $query->result();
		}
	 
		function count_filtered_deactivated()
		{
			$this->_get_deactivated_datatables_query();
			$query = $this->db->get();
			return $query->num_rows();
		}
	 
		public function count_all_deactivated()
		{
			$this->db->where('status', '1');
			$query = $this->db->get($this->table);
			return $query->num_rows();
			//$this->db->from($this->table);
			//return $this->db->count_all_results();
		}	
				
				
		/**
		* Function to check that the email and password 
		* exists in the database
		*/	
		
		public function can_log_in(){
			
			$email = strtolower($this->input->post('email'));
			$password = $this->input->post('password');
			$db_password = '';
			
			//get users info frm db using email
			$user_array = $this->get_user($email);
			
			//check if email exists
			if($user_array){
				//get stored password
				foreach($user_array as $user){
					$db_password = $user->password;
				}
				// If the password inputs matched the hashed password in the database
				if(password_verify($password, $db_password) && $this->account_status($email)) {
					return true;
				}else{
					return false;
				} 
			}else {
				return false;
			}
			
		}
		public function account_status($email){
			
			$this->db->where('LOWER(email_address)', $email);
			$this->db->where('status', '0');
			
			$query = $this->db->get($this->table);
			
			if ($query->num_rows() == 1){
				return true;
			} else {
				return false;
			}
			
		}
		/*
		public function can_log_in(){
			
			$email = strtolower($this->input->post('email'));
			$password = md5($this->input->post('password'));
			
			
			$this->db->where('LOWER(email_address)', $email);
			$this->db->where('password',$password);
			$this->db->where('status', '0');
			
			$query = $this->db->get($this->table);
			
			if ($query->num_rows() == 1){
				return true;
			} else {
				return false;
			}
			
		}*/


					
		/**
		* Function to add the user 
		* to the users table in the database
		* @param $string Activation key
		*/		
		public function insert_user($data){

			$this->db->insert($this->table, $data);
			$insert_id = $this->db->insert_id();
			if ($insert_id){
				return $insert_id;
			}else {
				return false;
			}
		}
		
		function get_user($email = ''){
			
			if($email != '' && $email != null){
				$this->db->where('email_address', $email);
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
		}

				
		function get_user_by_id($id = ''){
			
			if($id != '' && $id != null){
				$this->db->where('id', $id);
			}
			
			$q = $this->db->get($this->table);
			
			if($q->num_rows() > 0){
			  foreach ($q->result() as $row)
			  {
				$data[] = $row;
			  }
			  return $data;
			}
		}
		
		/****
		** Function to get users from the database
		****/
		function get_users($limit, $offset){
			
			$this->db->limit($limit, $offset);
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

		}		
			

		public function user_update($data='', $email=''){
			
			if( $email != ''){
				$this->db->where('email_address', $email);
			}

			$query = $this->db->update($this->table, $data);
			
			if ($query){	
				return true;	
			}else {		
				return false;			
			}			
		}			
		
		public function update_user($data, $id=''){
			
			if( $id != ''){
				$this->db->where('id', $id);
			}

			$query = $this->db->update($this->table, $data);
			
			if ($query){	
				return true;	
			}else {		
				return false;			
			}			
		}		
		

		/**
		* Function to check if the user 
		* is logging in for the first time
		*  
		*/			
		public function first_time_log_in(){
			
			$email = $this->session->userdata('email');
			
			$user = $this->get_user($email);
			$last_login = '';
			
			foreach($user as $u){	
				$last_login = $u->last_login;
			}
			if ($last_login === '0000-00-00 00:00:00'){		
				return TRUE;		
			}else {
				return FALSE;
			}
		}
	
		//function to check if user has set 
		//their security question and answer
		//after log in
		public function check_isset_security_info(){
			
				$email = $this->session->userdata('email');
				
				$security_question = '';
				
				$user = $this->get_user($email);
				
				foreach($user as $u){	
					$security_question = $u->security_question;
				}					
				if($security_question == '' || $security_question == null){
					return true;
				}else{
					return false;
				}	
		} 
		

		/* Function to check that the memorable answer 
		* exists in the database
		*/	
		public function answer_exists(){
			
			$security_answer = $this->input->post('security_answer');

			$this->db->like('LOWER(security_answer)', strtolower($security_answer));
			
			$query = $this->db->get($this->table);
			
			if ($query->num_rows() == 1){
				return true;
			} else {
				return false;
			}
			
		}		
	
		/* Function to check that the email address 
		* exists in the database
		*/	
		public function email_exists(){
			
			$this->db->where('LOWER(email_address)', strtolower($this->input->post('email_address')));
			
			$query = $this->db->get($this->table);
			
			if ($query->num_rows() == 1){
				return true;
			} else {
				return false;
			}
			
		}

		/* Function to check that the email address 
		* exists in the database
		*/	
		public function check_email_exists($email = ''){
			
			if($email != '' && $email != null){
				$this->db->where('LOWER(email_address)', strtolower($email));
			}
			$query = $this->db->get($this->table);
			
			if ($query->num_rows() == 1){
				return true;
			} else {
				return false;
			}
			
		}
	

		/* Function to ensure the username is unique 
		* 
		*/	
		public function unique_user($email = ''){
			
			if($email != '' && $email != null){
				$this->db->where('LOWER(email_address)', strtolower($email));
			}
			$query = $this->db->get($this->table);
			
			if ($query->num_rows() == 0){
				return true;
			} else {
				return false;
			}
		}

		
		/**
		* Function to check that the user is not 
		* suspended
		*/	
		public function user_suspended($email = ''){
			
			if($email != '' && $email != null){
				$this->db->where('LOWER(email_address)', strtolower($email));
			}
			$this->db->where('status', '1');
			
			$query = $this->db->get($this->table);
			
			if ($query->num_rows() == 1){
				return true;
			} else {
				return false;
			}
			
		}

		
		/**
		* Function to validate users 
		* security answer
		*/	
		public function valid_answer($email = '', $question = '', $answer = ''){
			
			
			if($email != '' && $email != null){
				$this->db->where('LOWER(email_address)', strtolower($email));
			}
			if($question != '' && $question != null){
				$this->db->where('LOWER(security_question)', strtolower($question));
			}
			if($answer != '' && $answer != null){
				$this->db->where('LOWER(security_answer)', strtolower($answer));
			}
			
			$query = $this->db->get($this->table);
			
			if ($query->num_rows() == 1){
				return true;
			} else {
				return false;
			}
			
		}

		
		//function to calculate 
		//how much of customer profile
		//is incomplete
		public function profile_completion($email = ''){
			
			$percentage = 0;
			$empty_list = '';
			
			//$sql ="SELECT * FROM users WHERE email_address=$email";
			//$query = $this->db->query($sql);
			if($email != '' && $email != null){
				$this->db->where('email_address', $email);
			}
			
			$query = $this->db->get($this->table);

			if ($query->num_rows() > 0){ 
				
				//initialise variable
				$notEmpty = 0;
				
				//numbers of columns to validate
				$totalField = 10;
				
				foreach ($query->result() as $row){
					
					$notEmpty +=  ($row->avatar != '') ? 1 : 0;
					
					//$notEmpty +=  ($row->company_name != '') ? 1 : 0;
					
					$notEmpty +=  ($row->address_line_1 != '') ? 1 : 0;
					
					$notEmpty +=  ($row->city != '') ? 1 : 0;
					
					$notEmpty +=  ($row->postcode != '') ? 1 : 0;
					
					$notEmpty +=  ($row->state != '') ? 1 : 0;
					
					$notEmpty +=  ($row->country != '') ? 1 : 0;
				
					$notEmpty +=  ($row->telephone != '') ? 1 : 0;
				
					$notEmpty +=  ($row->password != '') ? 1 : 0;
				
					$notEmpty +=  ($row->security_question != '') ? 1 : 0;
				
					$notEmpty +=  ($row->security_answer != '') ? 1 : 0;
					
				}
				$percentage = $notEmpty/$totalField *100;
			}
			return floor($percentage);
			//return $notEmpty;
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
			
			
}