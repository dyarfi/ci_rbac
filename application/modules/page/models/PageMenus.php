<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Model Class Object for PageMenus
class PageMenus Extends CI_Model {
	
	protected $table = 'tbl_page_menus';
	
	public function __construct(){
		// Call the Model constructor
		parent::__construct();
		
		$this->db = $this->load->database('default', true);		
				
	}
	public function install() {
		
		$insert_data	= FALSE;

		if (!$this->db->table_exists($this->table)) 
                $insert_data	= TRUE;
                
                $sql	= 'CREATE TABLE IF NOT EXISTS `'.$this->table.'` ('
				. '`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY , '
				. '`parent_id` INT(11) UNSIGNED NULL , '
				. '`name` VARCHAR(128) NULL , '
				. '`title` VARCHAR(255) NULL , '
				. '`description` TEXT NULL , '
				. '`url` VARCHAR(255) NULL , '		
				. '`media` VARCHAR(255) NULL , '				
				. '`position` VARCHAR(255) NULL , '
				. '`sub_level` TINYINT(3) NULL , '
				. '`order` TINYINT(3) NULL , '
				. '`is_system` TINYINT(3) NULL, '
				. '`has_child` TINYINT(3) NULL, '				
				. '`user_id` TINYINT(3) NULL , '
				. '`count` INT(11) NULL , '
				. '`status` ENUM( \'publish\', \'unpublish\', \'deleted\' ) NULL DEFAULT \'publish\', '
				. '`added` INT(0) NULL , '
				. '`modified` INT(0) NULL , '
				. 'INDEX (`parent_id`, `name`, `sub_level`, `order`, `status`) '
				. ') ENGINE=MYISAM ';

		$this->db->query($sql);
		
        if(!$this->db->query('SELECT * FROM `'.$this->table.'` LIMIT 0 , 1;'))
			$insert_data	= TRUE;
		
		if ($insert_data) {
			$sql	= '';

			$this->db->query($sql);
		}

		return $this->db->table_exists($this->table);
		
	}
	public function getCount($status = null){
		$data = array();
		$options = array('status' => $status);
		$this->db->where($options,1);
		$this->db->from('page_menus');
		$data = $this->db->count_all_results();
		return $data;
	}
	public function getPageMenu($id = null){
		if(!empty($id)){
			$data = array();
			$options = array('id' => $id);
			$Q = $this->db->get_where('page_menus',$options,1);
			if ($Q->num_rows() > 0){
				foreach ($Q->result_object() as $row)
				$data = $row;
			}
			$Q->free_result();
			return $data;
		}
	}
	public function getPageMenuByEmail($email = null){
		if(!empty($email)){
			$data = array();
			$options = array('email' => $email);
			$Q = $this->db->get_where('page_menus',$options,1);
			if ($Q->num_rows() > 0){
				foreach ($Q->result_object() as $row)
				$data = $row;
			}
			$Q->free_result();
			return $data;
		}
	}
	public function getPageMenuByPageMenuname($page_menuname = null){
		if(!empty($page_menuname)){
			$data = array();
			$options = array('page_menuname' => $page_menuname);
			$Q = $this->db->get_where('page_menus',$options,1);
			if ($Q->num_rows() > 0){
				foreach ($Q->result_object() as $row)
				$data = $row;
			}
			$Q->free_result();
			return $data;
		}
	}
	public function getAllPageMenu($admin=null){
		$data = array();
		$this->db->order_by('added');
		$Q = $this->db->get('page_menus');
			if ($Q->num_rows() > 0){
				//foreach ($Q->result_object() as $row){
					//$data[] = $row;
				//}
				$data = $Q->result_object();
			}
		$Q->free_result();
		return $data;
	}
	// Get page_menu's Email from posts 
	public function getPageMenuEmail($email=null){
		if(!empty($email)){
			$data = array();
			
			// Option and query result
			$options = array('email' => $email);			
			$Q = $this->db->get_where('page_menus',$options,1);
			
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
	// Get page_menu's Password from hashed password 
	public function getPageMenuPassword($password=null){
		if(!empty($password)){
			$data = array();
			
			// Option and query result
			$options = array('password' => $password);			
			$Q = $this->db->get_where('page_menus',$options,1);
			
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
							'page_menuname' => $object['page_menuname'], 
							'password' => sha1($object['page_menuname'].$object['password']),
							'status' => 1);
			
			$Q = $this->db->get_where('page_menus',$options,1);
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
		//Get page_menu id
		$this->db->where('id', $id);
		//Return result
		return $this->db->update('page_menus', array('last_login'=>time()));
	}
	public function setLoggedIn($id=null) {
		//Get page_menu id
		$this->db->where('id', $id);
		//Return result
		return $this->db->update('page_menus', array('logged_in'=>1));
	}
	public function setPassword($page_menu=null,$changed=''){
		
		$password = ($changed) ? $changed : random_string('alnum', 8);
				
		$data = array('password' => sha1($page_menu->page_menuname.$password));

		$this->db->where('id', $page_menu->id);
		$this->db->update('page_menus', $data); 
		
		return $password;
		
	}	
	public function setPageMenu($object=null){
		
		// Set PageMenu data
		$data = array(
			'page_menuname'	=> $object['page_menuname'],
			'email'		=> $object['email'],			
			'password'	=> sha1($object['page_menuname'].$object['password']),	
			'group_id'	=> @$object['group_id'],			
			'added'		=> time(),	
			'status'	=> $object['status']
		);
		
		// Insert PageMenu data
		$this->db->insert('page_menus', $data);
		
		// Return last insert id primary
		$insert_id = $this->db->insert_id();
			
		// Check if last is existed
		if ($insert_id) {
				
			// Unset previous data
			unset($data);
			
			// Set PageMenu Profile data
			$data = array(
					'page_menu_id'		=> $insert_id,
					'gender'		=> @$object['gender'],				
					'first_name'	=> @$object['first_name'],
					'last_name'		=> @$object['last_name'],				
					'birthday'		=> @$object['birthday'],
					'phone'			=> @$object['phone'],	
					'mobile_phone'	=> @$object['mobile_phone'],				
					'fax'			=> @$object['fax'],
					'website'		=> @$object['website'],
					'about'			=> @$object['about'],
					'division'		=> @$object['division'],
					'added'		=> time(),	
					'status'	=> 1);
			
			// Insert PageMenu Profile 
			$this->db->insert('page_menu_profiles', $data);
					
		}
			
		// Return last insert id primary
		return $insert_id;
		
	}	
	public function deletePageMenu($id) {
		
		// Check page_menu id
		$this->db->where('id', $id);
		
		// Delete page_menu form database
		if ($this->db->delete('page_menus')) {
			
			// Check page_menu profile id
			$this->db->where('page_menu_id', $id);
			
			// Delete page_menu profile form database		
			return $this->db->delete('page_menu_profiles');
			
		}		
	}	
}
