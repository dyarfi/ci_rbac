<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Model Class Object for Users
class Users Extends CI_Model {
	
	public $table = 'tbl_users';
	
	protected $_model_vars;
	
	public function __construct(){
		// Call the Model constructor
		parent::__construct();
		
		$this->_model_vars	= array('id'		 => 0,
									'email'		 => '',
									'username'	 => '',
									'group_id'	 => 0,
									'is_system'	 => 0,
									'last_login' => 0,
									'status'	 => '',
									'added'		 => 0,
									'modified'	 => 0);
				
		$this->db = $this->load->database('default', true);		
				
	}
	public function install() {
		
		$insert_data	= FALSE;

		if (!$this->db->table_exists($this->table)) 
                $insert_data	= TRUE;
                
                $sql            = 'CREATE TABLE IF NOT EXISTS `'.$this->table.'` ('
                                    . '`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,'
                                    . '`email` VARCHAR(255) NOT NULL, '
                                    . '`password` VARCHAR(100) NOT NULL, '
                                    . '`username` VARCHAR(160) NOT NULL, '
                                    . '`group_id` INT(11) UNSIGNED NOT NULL, '
                                    . '`is_system` TINYINT(3) NOT NULL DEFAULT 0, '
						            . '`last_login` INT(11) UNSIGNED NOT NULL, '
									. '`logged_in` INT(1) UNSIGNED NOT NULL,'
                                    . '`status` INT(1) UNSIGNED NOT NULL,'
									. '`session` VARCHAR(160) NOT NULL, '
                                    . '`added` INT(11) UNSIGNED NOT NULL, '
                                    . '`modified` INT(11) UNSIGNED NOT NULL, '
                                    . 'INDEX (`email`, `group_id`) '
                                    . ') ENGINE=MYISAM';

		$this->db->query($sql);
		
        if(!$this->db->query('SELECT * FROM `'.$this->table.'` LIMIT 0 , 1;'))
			$insert_data	= TRUE;
		
		if ($insert_data) {
			$sql	= 'INSERT INTO `'.$this->table.'` '
					. '(`id`, `email`, `password`, `username`, `group_id`, `is_system`, `last_login`, `status`, `added`, `modified`) '
					. 'VALUES '
					. '(NULL, \'superadmin\', \'356a192b7913b04c54574d18c28d46e6395428ab\', \'Super Administrator\', 1, 1, 1, '.time().', \'1\', '.time().', 0), '
					. '(NULL, \'administrator\', \'12506e739378348ec662bb015bfd2288362dcc1c\', \'Administrator\', 2, 1, 1, '.time().', \'1\', '.time().', 0), '
					. '(NULL, \'user@testing.com\', \'12506e739378348ec662bb015bfd2288362dcc1c\', \'User\', 99, 0, 1, '.time().', \'1\', '.time().', 0)';

			$this->db->query($sql);
		}

		return $this->db->table_exists($this->table);
		
	}
	
	public function find ($where_cond = '', $order_by = '', $limit = '', $offset = '') {
		/** Build where query **/

		if ($where_cond != '') {
			if (is_array($where_cond) && count($where_cond) != 0) {
				$buffers	= array();

				$operators	= array('LIKE',
									'IN',
									'!=',
									'>=',
									'<=',
									'>',
									'<',
									'=');
                                
				foreach ($where_cond as $field => $value) {
					$operator	= '=';

					if (strpos($field, ' ') != 0)
						list($field, $operator)	= explode(' ', $field);

					if (in_array($operator, $operators)) {
						$field		= '`'.$field.'`';

						if ($operator == 'IN' && is_array($value))
							$buffers[]	= $field.' '.$operator.' (\''.implode('\', \'', $value).'\')';
						else
							$buffers[]	= $field.' '.$operator.' \''.$value.'\'';
					} else if (is_numeric($field)) {
						$buffers[]	= $value;
					} else {
						$buffers[]	= $field.' '.$operator.' \''.$value.'\'';
					}
				}                
				$where_cond	= implode(' AND ', $buffers);                   
			}
		}

		$sql_order = ''; 
		if ($order_by != '') {
			$sql_order = ' ORDER BY '; 
			$i 	   = 1;
			foreach ($order_by as $order => $val) {
				$split = ($i > 1) ? ', ' : ''; 
				$sql_order .= ' '. $split .' `'. $order.'` '.$val.' ';
				$i++;
			}
			$order_by  = $sql_order;
		}
		
		$sql_limit = ''; 
		if ($limit != '' && $offset != '') {
			$offset    = $offset . ','; 
			$sql_limit = 'LIMIT '. $offset . $limit; 
		}
		else if ($limit != '') {
			$sql_limit = 'LIMIT '. $limit; 
		}
		$limit = $sql_limit;
		
		if ($where_cond != '') {
			$rows = $this->db->query('SELECT * FROM `'.$this->table.'` WHERE '. $where_cond . $order_by . $limit, TRUE)->result();
		}
		else {
			$rows = $this->db->query('SELECT * FROM `'.$this->table.'`' . $order_by . $limit, TRUE)->result();
		}

		$returns	= array();
                
		foreach ($rows as $row) {
			$object			= new Users;

			$object_vars	= get_object_vars($row);
			
			foreach ($object_vars as $var => $val) {
				$object->$var	= $val;
			}

			unset($object->table,$object->_model_vars,$object->db);

			$returns[]		= $object;

			unset($object, $vars);
		}
				
		return $returns;
	}
	
	public function getCount($status = null){
		$data = array();
		$options = array('status' => $status);
		$this->db->where($options,1);
		$this->db->from('users');
		$data = $this->db->count_all_results();
		return $data;
	}
	
	public function getUser($id = null){
		if(!empty($id)){
			$data = array();
			$options = array('id' => $id);
			$Q = $this->db->get_where('users',$options,1);
			if ($Q->num_rows() > 0){
				foreach ($Q->result_object() as $row)
				$data = $row;
			}
			$Q->free_result();
			return $data;
		}
	}
	
	public function getUserByEmail($email = null){
		if(!empty($email)){
			$data = array();
			$options = array('email' => $email);
			$Q = $this->db->get_where('users',$options,1);
			if ($Q->num_rows() > 0){
				foreach ($Q->result_object() as $row)
				$data = $row;
			}
			$Q->free_result();
			return $data;
		}
	}
	
	public function getUserByUsername($username = null){
		if(!empty($username)){
			$data = array();
			$options = array('username' => $username);
			$Q = $this->db->get_where('users',$options,1);
			if ($Q->num_rows() > 0){
				foreach ($Q->result_object() as $row)
				$data = $row;
			}
			$Q->free_result();
			return $data;
		}
	}
	
	public function getAllUser($admin=null){
		$data = array();
		$this->db->order_by('added');
		$Q = $this->db->get('users');
			if ($Q->num_rows() > 0){
				//foreach ($Q->result_object() as $row){
					//$data[] = $row;
				//}
				$data = $Q->result_object();
			}
		$Q->free_result();
		return $data;
	}
	
	// Get user's Email from posts 
	public function getUserEmail($email=null){
		if(!empty($email)){
			$data = array();
			
			// Option and query result
			$options = array('email' => $email);			
			$Q = $this->db->get_where('users',$options,1);
			
			// Check result
			if($Q->num_rows() > 0) {
				// Return true if not exists
				return true;
			} else {
				// Return false if exists
				return false;
			}		 
		}
	}
	
	// Get user's Password from hashed password 
	public function getUserPassword($password=null){
		if(!empty($password)){
			$data = array();
			
			// Option and query result
			$options = array('password' => $password);			
			$Q = $this->db->get_where('users',$options,1);
			
			// Check result
			if($Q->num_rows() > 0) {
				// Return true if not exists
				return true;
			} else {
				// Return false if exists
				return false;
			}		 
		}
	}
	
	public function login($object=null){		
		if(!empty($object)){
			$data = array();
			$options = array(
							'username' => $object['username'], 
							'password' => sha1($object['username'].$object['password']),
							'status' => 1);
			
			$Q = $this->db->get_where('users',$options,1);
			if ($Q->num_rows() > 0){				
				foreach ($Q->result_object() as $row) {
					// Update login state to true
					$this->setLoggedIn($row->id);
					$data = $row;
				}
			} 			 
		
			//print_r($data);
			//exit;
			//print_r(); exit();
			//print_r($this->db->last_query()); exit();
			
			$Q->free_result();
			return $data;
		}
	}
	
	public function setLastLogin($id=null) {
		//Get user id
		$this->db->where('id', $id);
		//Return result
		return $this->db->update('users', array('last_login'=>time()));
	}
	
	public function setLoggedIn($id=null) {
		//Get user id
		$this->db->where('id', $id);
		//Return result
		return $this->db->update('users', array('logged_in'=>1));
	}
	
	public function setPassword($user=null,$changed=''){
		
		$password = ($changed) ? $changed : random_string('alnum', 8);
				
		$data = array('password' => sha1($user->username.$password));

		$this->db->where('id', $user->id);
		$this->db->update('users', $data); 
		
		return $password;
		
	}	
	
	public function setUser($object=null){
		
		// Set User data
		$data = array(
			'username'	=> $object['username'],
			'email'		=> $object['email'],			
			'password'	=> sha1($object['username'].$object['password']),	
			'group_id'	=> @$object['group_id'],			
			'added'		=> time(),	
			'status'	=> $object['status']
		);
		
		// Insert User data
		$this->db->insert('users', $data);
		
		// Return last insert id primary
		$insert_id = $this->db->insert_id();
			
		// Check if last is existed
		if ($insert_id) {
				
			// Unset previous data
			unset($data);
			
			// Set User Profile data
			$data = array(
					'user_id'		=> $insert_id,
					'gender'		=> !empty($object['gender']) ? $object['gender'] : NULL,
					'first_name'	=> !empty($object['first_name']) ? $object['first_name'] : NULL,
					'last_name'		=> !empty($object['last_name']) ? $object['last_name'] : NULL,
					'birthday'		=> !empty($object['birthday']) ? $object['birthday'] : NULL,
					'phone'			=> !empty($object['phone']) ? $object['phone'] : NULL,	
					'mobile_phone'	=> !empty($object['mobile_phone']) ? $object['mobile_phone'] : NULL,
					'fax'			=> !empty($object['fax']) ? $object['fax'] : NULL,
					'website'		=> !empty($object['website']) ? $object['website'] : NULL,
					'about'			=> !empty($object['about']) ? $object['about'] : NULL,
					'division'		=> !empty($object['division']) ? $object['division'] : NULL,
					'added'		=> time(),	
					'status'	=> 1);
			
			// Insert User Profile 
			$this->db->insert('user_profiles', $data);
					
		}
			
		// Return last insert id primary
		return $insert_id;
		
	}	
	
	public function deleteUser($id) {
		
		// Check user id
		$this->db->where('id', $id);
		
		// Delete user form database
		if ($this->db->delete('users')) {
			
			// Check user profile id
			$this->db->where('user_id', $id);
			
			// Delete user profile form database		
			return $this->db->delete('user_profiles');
			
		}		
	}	
}
