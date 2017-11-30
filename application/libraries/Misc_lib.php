<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * Code Igniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		Rick Ellis
 * @copyright	Copyright (c) 2006, pMachine, Inc.
 * @license		http://www.codeignitor.com/user_guide/license.html
 * @link		http://www.codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Misc_lib Controller Class
 *
 *
 * @package     CodeIgniter
 * @subpackage  Libraries
 * @category    Other
 * @author      Syd
 * @link   2017, http://gialovela.com
 *
 */

// ------------------------------------------------------------------------


class Misc_lib{
	
	
			
	/**
	* Function to delete old records
	*  
	*/		
	public function delete_old_records($date_column, $table){
			
		$date = date("Y-m-d H:i:s",time());
		$date = strtotime($date);
		//delete records older than 90 days
		$min_date = strtotime("-90 day", $date);
			
		$this->db->where("'$date_column' < '$min_date'", NULL, FALSE);
		
		$this->db->delete($table);
	}
			
		
		
		/***
		** Function to convert timestamp to time ago
		**
		***/
		public function time_elapsed_string($ptime)
		{
			$etime = time() - $ptime;

			if ($etime < 1)
			{
				return '0 seconds';
			}

			$a = array( 365 * 24 * 60 * 60  =>  'year',
						 30 * 24 * 60 * 60  =>  'month',
							  24 * 60 * 60  =>  'day',
								   60 * 60  =>  'hour',
										60  =>  'minute',
										 1  =>  'second'
						);
			$a_plural = array( 'year'   => 'years',
							   'month'  => 'months',
							   'day'    => 'days',
							   'hour'   => 'hours',
							   'minute' => 'minutes',
							   'second' => 'seconds'
						);

			foreach ($a as $secs => $str)
			{
				$d = $etime / $secs;
				if ($d >= 1)
				{
					$r = round($d);
					return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
				}
			}
		}

		public function date_time_string($datetime, $full = false) {
			
				$today = time();    
				$createdday= strtotime($datetime); 
				$datediff = abs($createdday - $today);  
				$difftext="";  
				$years = floor($datediff / (365*60*60*24));  
				$months = floor(($datediff - $years * 365*60*60*24) / (30*60*60*24));  
				$days = floor(($datediff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));  
				$hours= floor($datediff/3600);  
				$minutes= floor($datediff/60);  
				$seconds= floor($datediff);  
				
				//year checker  
				if($difftext==""){  
					if($years>1)  
						$difftext=$years." years";  
					elseif($years==1)  
						$difftext=$years." year";  
				}  
				
				//month checker  
				if($difftext==""){  
					if($months>1)  
						$difftext=$months." months";  
					elseif($months==1)  
						$difftext=$months." month";  
				}  
				
				//day checker  
				if($difftext==""){  
					if($days>1)  
						$difftext=$days." days";  
					elseif($days==1)  
						$difftext=$days." day";  
				}  
				
				//hour checker  
				if($difftext==""){  
					if($hours>1)  
						$difftext=$hours." hours";  
					elseif($hours==1)  
						$difftext=$hours." hour";  
				}  
				
				//minutes checker  
				if($difftext==""){  
					if($minutes>1)  
						$difftext=$minutes." minutes";  
					elseif($minutes==1)  
						$difftext=$minutes." minute";  
				} 
				
				//seconds checker  
				if($difftext==""){  
					if($seconds>1)  
						$difftext=$seconds." seconds";  
					elseif($seconds==1)  
						$difftext=$seconds." second";  
				}  
				return $difftext;  
		}	
		
		/* Function to calculate difference 
		* between dates
		* variable $datetime
		*/	
		public function date_time_diff($datetime) {
				
				$today = date('Y-m-d');    
				
				
				$date1 = new DateTime($today);
				$date2 = new DateTime($datetime);
				$diff = $date1->diff($date2);
				$years = '';
				$months = '';
				$days = '';
				
				if($diff->y > 1){
					$years = $diff->y.' years,';
				}
				if($diff->y == 1){
					$years = $diff->y.' year,';
				}
				if($diff->m > 1){
					$months = $diff->m.' months and';
				}
				if($diff->m == 1){
					$months = $diff->m.' month and';
				}
				if($diff->d > 1){
					$days = $diff->d.' days';
				}
				if($diff->d == 1){
					$days = $diff->d.' day';
				}
				
				$difftext=$years. " " .$months." ".$days."";  
				
				
				return $difftext;    
		}

		/* Function to convert array 
		* to string
		* variable $array
		*/	
		public function array_to_comma_string($array) {

			switch (count($array)) {
			case 0:
				return '';

			case 1:
				return reset($array);
			
			case 2:
				return join(' and ', $array);

			default:
				$last = array_pop($array);
				return join(', ', $array) . " and $last";
			}
		}
		
	
		
		//function to calculate 
		//how much of customer profile
		//is incomplete
		public function profile_completion($username,$column,$table){
			
			$percentage = 0;
			$empty_list = '';
			
			//$sql ="SELECT * FROM clients WHERE username=$username";
			//$query = $this->db->query($sql);
			$this->db->where($column, $username);
			$query = $this->db->get($table);

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
					$notEmpty +=  ($row->company_name != '') ? 1 : 0;
					
					if($row->company_name == ''){
						$empty_list .= 'Please provide your company name; ';
					}
					$notEmpty +=  ($row->position != '') ? 1 : 0;
					if($row->position == ''){
						$empty_list .= 'Please provide your position; ';
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
		
	
		
		//function to sort 3 ints 
		//for security answer
		public function sort_values($a,$b,$c){
			
			$min = '';
			$med = '';
			$max = '';
			
			if($a > $b){
				if($a > $c ){
					$max = $a;
					if($b > $c ){
					   $med = $b;
					   $min = $c;
					}else{
					   $med = $c;
					   $min = $b;
					}
				}else{
					$med = $a;
					$max = $c;
					$min = $b;
				}
			}else{
				if($b > $c){
					$max = $b;
					if( $a > $c ){
					   $med = $a;
					   $min = $c;
					}else{
					   $med = $c;
					   $min = $a;
					}
				}else{
					$med = $b;
					$max = $c;
					$min = $a;
				}
			}
			
			return array($min, $med, $max);
			//return $notEmpty;
		}
		
		
		/***
		** Function to mask email
		**
		***/		
		public function mask_email($email){
			/*
			Author: Fed
			Simple way of masking emails
			*/
			
			$char_shown = 3;
			
			$mail_parts = explode("@", $email);
			$username = $mail_parts[0];
			$len = strlen( $username );
			
			if( $len <= $char_shown ){
				return implode("@", $mail_parts );	
			}
			
			//Logic: show asterisk in middle, but also show the last character before @
			$mail_parts[0] = substr( $username, 0 , $char_shown )
				. str_repeat("*", $len - $char_shown - 1 )
				. substr( $username, $len - $char_shown + 2 , 1  )
				;
				
			return implode("@", $mail_parts );
		}

		function email_mask($email) 
		{ 
				$mask_char = '*';
				$percent = 50;
				list($user, $domain) = preg_split("/@/", $email); 

				$len = strlen($user); 
				$mask_count = floor( $len * $percent /100 ); 

				$offset = floor( ( $len - $mask_count ) / 2 ); 

				$masked = substr( $user, 0, $offset ) 
						.str_repeat( $mask_char, $mask_count ) 
						.substr( $user, $mask_count+$offset ); 
				
				$domain_len = strlen($domain);
				$mask_domain_count = floor($domain_len * 40 /100);
				$domain_offset = floor( ($domain_len - $mask_domain_count) / 2 ); 
				
				$masked_domain = substr($domain, 0, $domain_offset ) 
						.str_repeat( $mask_char, $mask_domain_count) 
						.substr($domain, $mask_domain_count+$domain_offset );
						
				return( $masked.'@'.$masked_domain); 
		} 
		function getLocalIp(){ 
			//return gethostbyname(trim(`hostname`));
			return getHostByName(getHostName());
		
		}
		
		function ip_details($ip) {
		  $json = file_get_contents("http://ipinfo.io/{$ip}/geo");
		  $details = json_decode($json, true);
		  return $details;
		}


		/**
		* Get Geo Location by Given/Current IP address
		*
		* @access    public
		* @param    string
		* @return    array
		*/

		public function geolocation_by_ip($ip) {
			
			$d = file_get_contents("http://www.ipinfodb.com/ip_query.php?ip=$ip&output=xml");
			//Use backup server if cannot make a connection
			if (!$d) {
				$backup = file_get_contents("http://backup.ipinfodb.com/ip_query.php?ip=$ip&output=xml");
				$result = new SimpleXMLElement($backup);
				if (!$backup){
					return false; // Failed to open connection
				} else {
					$result = new SimpleXMLElement($d);
				}
				//Return the data as an array
				return array(
				
					'ip'=>$ip, 
					'country_code'=>$result->CountryCode, 
					'country_name'=>$result->CountryName, 
					'region_name'=>$result->RegionName, 
					'city'=>$result->City, 
					'zip_postal_code'=>$result->ZipPostalCode, 
					'latitude'=>$result->Latitude, 
					'longitude'=>$result->Longitude, 
					'timezone'=>$result->Timezone, 
					'gmtoffset'=>$result->Gmtoffset, 
					'dstoffset'=>$result->Dstoffset
					
					);

			}
		}
	
			
		function generateRatingStar($no) {
			$test = '';
			for($a = 0; $a < 5; $a++){
					
				if($a < $no){
					$test .= '<i class="fa fa-star" aria-hidden="true"></i>';
				}else{
					$test .= '<i class="fa fa-star-o" aria-hidden="true"></i>';
				}
					
			}
		  return $test;
		}

	
	
	
	
	
}


