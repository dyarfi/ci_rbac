<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Model Class Object for Users
class Users Extends CI_Model {
	
	protected $table = 'tbl_users';
	
	function __construct(){
		// Call the Model constructor
		parent::__construct();
		
		$this->db = $this->load->database('default', true);		
				
	}
	function install() {
		
		$insert_data	= FALSE;

		if (!$this->db->table_exists($this->table)) 
                $insert_data	= TRUE;
                
                $sql            = 'CREATE TABLE IF NOT EXISTS `'.$this->table.'` ('
                                    . '`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,'
                                    . '`email` VARCHAR(255) NOT NULL, '
                                    . '`password` VARCHAR(100) NOT NULL, '
                                    . '`name` VARCHAR(160) NOT NULL, '
                                    . '`level_id` INT(11) UNSIGNED NOT NULL, '
                                    . '`is_system` TINYINT(3) NOT NULL DEFAULT 0, '
						            . '`last_login` INT(11) UNSIGNED NOT NULL, '
									. '`logged_in` INT(1) UNSIGNED NOT NULL,'
                                    . '`status` ENUM(\'verified\', \'active\', \'inactive\', \'blocked\') NOT NULL, '
                                    . '`added` INT(11) UNSIGNED NOT NULL, '
                                    . '`modified` INT(11) UNSIGNED NOT NULL, '
                                    . 'INDEX (`email`, `level_id`) '
                                    . ') ENGINE=MYISAM';

		$this->db->query($sql);
		
        if(!$this->db->query('SELECT * FROM `'.$this->table.'` LIMIT 0 , 1;'))
			$insert_data	= TRUE;
		
		if ($insert_data) {
			$sql	= 'INSERT INTO `'.$this->table.'` '
					. '(`id`, `email`, `password`, `name`, `level_id`, `is_system`, `last_login`, `status`, `added`, `modified`) '
					. 'VALUES '
					. '(NULL, \'superadmin\', \'356a192b7913b04c54574d18c28d46e6395428ab\', \'Super Administrator\', 1, 1, '.time().', \'active\', '.time().', 0), '
					. '(NULL, \'administrator\', \'12506e739378348ec662bb015bfd2288362dcc1c\', \'Administrator\', 2, 1, '.time().', \'active\', '.time().', 0), '
					. '(NULL, \'user@testing.com\', \'12506e739378348ec662bb015bfd2288362dcc1c\', \'User\', 99, 0, '.time().', \'active\', '.time().', 0)';

			$this->db->query($sql);
		}

		return $this->db->table_exists($this->table);
		
	}
	function getCount($status = null){
		$data = array();
		$options = array('status' => $status);
		$this->db->where($options,1);
		$this->db->from('users');
		$data = $this->db->count_all_results();
		return $data;
	}
	function getUser($id = null){
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
	function getUserByEmail($email = null){
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
	function getUserByUsername($username = null){
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
	function getAllUser($admin=null){
		$data = array();
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
	function getUserPassword($object=null){
			if(!empty($object)){
			$data = array();
			$options = array(
							'id' => $object['username'], 
							'password' => sha1($object['username'].$object['password']),
							'status' => 'active');
			
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
	function login($object=null){		
		if(!empty($object)){
			$data = array();
			$options = array(
							'username' => $object['username'], 
							'password' => sha1($object['username'].$object['password']),
							'status' => 'active');
			
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
	function setLastLogin($id=null) {
		//Get user id
		$this->db->where('id', $id);
		//Return result
		return $this->db->update('users', array('last_login'=>time()));
	}
	function setLoggedIn($id=null) {
		//Get user id
		$this->db->where('id', $id);
		//Return result
		return $this->db->update('users', array('logged_in'=>1));
	}
	function setPassword($user=null){
		
		$password = random_string('alnum', 8);
				
		$data = array('password' => sha1($user->username.$password));

		$this->db->where('id', $user->id);
		$this->db->update('users', $data); 
		
		return $password;
	}
	function set(){

	}
}
?>
