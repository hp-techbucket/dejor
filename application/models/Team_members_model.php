<?php

class Team_members_model extends MY_Model {
	
	const DB_TABLE = 'team_members';
    const DB_TABLE_PK = 'id';


	var $table = 'team_members';
	
    var $column_order = array(null, 'avatar','first_name','last_name','username','password','email','facebook','twitter','google','position','bio_short','bio_long','status','access_level','last_login','date_added'); //set column field database for datatable orderable
	
    var $column_search = array('first_name','last_name','username','password','email','position','bio_short','bio_long','status','access_level','last_login','date_added'); //set column field database for datatable searchable 
	
    var $order = array('id' => 'desc'); // default order 
     
	
    /**
     * Team member avatar.
     * @var string
     */
    public $avatar;

	
    /**
     * Team member First name.
     * @var string
     */
    public $first_name;

	
    /**
     * Team member Last name.
     * @var string
     */
    public $last_name;
	
    /**
     * Team member username.
     * @var string
     */
    public $username;
	
    /**
     * Team member password.
     * @var string
     */
    public $password;


    /**
     * Team member email.
     * @var string
     */
    public $email;		


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
     * Team member position.
     * @var string
     */
    public $position;		

    /**
     * bio.
     * @var string
     */
    public $bio;		
	
    /**
     * status.
     * @var string
     */
    public $status;		
	
    /**
     * access_level.
     * @var string
     */
    public $access_level;		
		
    /**
     * status.
     * @var string
     */
    public $last_login;		
						
    /**
     * Date Created.
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
			
	
		/**
		* Function to check that the username and password 
		* exists in the database
		*/	
		public function can_log_in(){
			
			$this->db->where('LOWER(username)', strtolower($this->input->post('username')));
			$this->db->where('password', md5($this->input->post('password')));
			$this->db->where('status', '0');
			
			$query = $this->db->get($this->table);
			
			if ($query->num_rows() == 1){
				return true;
			} else {
				return false;
			}
			
		}		

		/**
		* Function to check that the user 
		* has access
		*/
		public function check_access_level(){
			
			$username = $this->session->userdata('admin_username');

			$this->db->where('username', $username);
			$this->db->where('access_level >', '2');
			
			$query = $this->db->get($this->table);
			
			if ($query->num_rows() == 1){
				return true;
			} else {
				return false;
			}
			
		}		
		
		/**
		* Function to create new team member
		*
		*/	
		public function insert_member($data){
				
			$this->db->insert($this->table, $data);
			$insert_id = $this->db->insert_id();
			if ($insert_id){
				return $insert_id;
			}else {
				return false;
			}
		}
	
		/**
		* Function to update team member
		* variable $id
		*/	
		public function update_member($data, $id){
		
			$this->db->where('id', $id);
			$query = $this->db->update($this->table, $data);
			
			if ($query){	
				return true;
			}else {
				return false;
			}			
			
		}
	
		/**
		* Function to update team member
		* variable $username
		*/	
		public function update_user($data, $username){
		
			$this->db->where('username', $username);
			$query = $this->db->update($this->table, $data);
			
			if ($query){	
				return true;
			}else {
				return false;
			}			
			
		}
				
		
		/****
		** Function to get team member from the database
		**	variable $username
		****/
		function get_member($username){
			
			$this->db->where('username', $username);
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

		
		/****
		** Function to get all usernames from the database
		****/
		function get_all_usernames(){
			
			$this->db->select('username');
			$this->db->from($this->table);
			$q = $this->db->get();
			
			return $q->result_array();

		}		
										
		/****
		** Function to get team member from the database
		**	variable $id
		****/
		function get_member_by_id($id){
			
			$this->db->where('id', $id);
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

		/****
		** Function to get team members from the database
		**	variable $limit
		****/
		public function get_members($limit = 4, $start = 0){
					
			$this->db->limit($limit, $start);
			$this->db->order_by('date_added','DESC');
			$members = $this->db->get($this->table);
					
			if($members->num_rows() > 0){
				foreach ($members->result() as $row){
					$data[] = $row;
				}
				return $data;
					  
			}else{
				return false;
			}
		}		
				
		public function count_members(){
					
			$count_members = $this->db->get($this->table);
					
			if($count_members->num_rows() > 0)	{
				$count = $count_members->num_rows();
				return $count;
			}else {	
				return false;
			}			
					
		}
	
		/* Function to ensure the ref id is unique 
		* 
		*/	
		public function unique_username($username){
			
			$this->db->where('username', $username);
			
			$query = $this->db->get($this->table);
			
			if ($query->num_rows() == 0){
				return true;
			} else {
				return false;
			}
			
		}


		/* Function to get the member name 
		* from the id
		* variable $id
		*/	
		public function member_name($id) {

			$member_name = '';
			$member_array = $this->Team_members->get_member_by_id($id);
					
			if($member_array){
						
				foreach($member_array as $member){

					$member_name = ucwords($member->first_name .' '.$member->last_name);
				}
			}
					
			return $member_name;
		}
		
		/**
		* Function to check if the user 
		* is logging in for the first time
		*  
		*/			
		public function first_time_log_in(){
			
			$username = $this->session->userdata('username');
			
			$user = $this->get_member($username);
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
	
		
		//function to calculate 
		//how much of customer profile
		//is incomplete
		public function profile_completion($username){
			
			$percentage = 0;
			$empty_list = '';
			
			//$sql ="SELECT * FROM clients WHERE username=$username";
			//$query = $this->db->query($sql);
			$this->db->where('username', $username);
			$query = $this->db->get($this->table);

			if ($query->num_rows() > 0){ 
				
				//initialise variable
				$notEmpty = 0;
				
				//numbers of columns to validate
				$totalField = 5;
				foreach ($query->result() as $row){
					
					$notEmpty +=  ($row->avatar != '') ? 1 : 0;
					
					if($row->avatar == ''){
						$empty_list .= 'Please provide your profile avatar; ';
					}
					$notEmpty +=  ($row->position != '') ? 1 : 0;
					if($row->position == ''){
						$empty_list .= 'Please provide your position; ';
					}
					$notEmpty +=  ($row->bio != '') ? 1 : 0;
					if($row->bio == ''){
						$empty_list .= 'Please complete your bio; ';
					}
					$notEmpty +=  ($row->password != '') ? 1 : 0;
					if($row->password == ''){
						$empty_list .= 'Please provide your password; ';
					}
					$notEmpty +=  ($row->email != '') ? 1 : 0;
					if($row->email == ''){
						$empty_list .= 'Please provide your email; ';
					}
					
				}
				$percentage = $notEmpty/$totalField *100;
			}
			return array(floor($percentage), $empty_list);
			//return $notEmpty;
		}


















		
}