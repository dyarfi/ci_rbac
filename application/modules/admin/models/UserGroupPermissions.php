<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Class for User Permission
class UserGroupPermissions Extends CI_Model {
	
	protected $table = 'tbl_group_permissions';
	public $permission;
	
	function __construct(){
		// Call the Model constructor
		parent::__construct();
		
		$this->load->model('Users');
		$this->load->model('UserGroups');
		
		$this->db = $this->load->database('default', true);		

	}
	function install () {
		$insert_data	= FALSE;

		if (!$this->db->table_exists($this->table)) {
			$insert_data	= TRUE;

			$sql	= 'CREATE TABLE IF NOT EXISTS `'. $this->table .'` ('
					. '`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,'
					. '`permission_id` INT(11) NOT NULL,'
					. '`level_id` INT(11) NOT NULL,'
					. '`value` SMALLINT(1) NOT NULL,'
					. '`added` INT(11) NOT NULL,'	
					. '`modified` INT(11) NOT NULL,'	
					. 'INDEX (`id`) '
					. ') ENGINE=MYISAM';
	
			$this->db->query($sql);
			
		}
		
		// Check if table exists
		if(!$this->db->query('SELECT * FROM `'.$this->table.'` LIMIT 0 , 1;')) {
			// Set insert data to TRUE
			$insert_data	= TRUE;
		}	
		/*
		// Set insert data if TRUE
		if ($insert_data) {
			$sql	= 'INSERT INTO `'.$this->table.'` '
					. '(`id`, `permission_id`, `level_id`, `value`, `added`, `modified`) '
					. 'VALUES '
					. '(NULL, \'superadmin\', \'356a192b7913b04c54574d18c28d46e6395428ab\', \'Super Administrator\', 1, 1, '.time().', \'active\', '.time().', 0), '
					. '(NULL, \'administrator\', \'12506e739378348ec662bb015bfd2288362dcc1c\', \'Administrator\', 2, 1, '.time().', \'active\', '.time().', 0), '
					. '(NULL, \'user@testing.com\', \'12506e739378348ec662bb015bfd2288362dcc1c\', \'User\', 99, 0, '.time().', \'active\', '.time().', 0)';

			$this->db->query('INSERT',$sql);
		}
		*/
        return $this->db->table_exists($this->table);
	}
	function getModuleList($id=null){
		$data = array('id'=>$id);
		$result = '';
		$Q = $this->db->get_where('tbl_module_lists',$data);
			if ($Q->num_rows() > 0){
				//print_r($Q->result_object());
				//exit;
				foreach ($Q->result_object() as $row){
					$result[] = $row;
				}
			}
		$Q->free_result();
		return $result;
	}
	function getModulePermissions($id=null){
		$data = array('id'=>$id);
		$result = '';
		$Q = $this->db->get_where('tbl_module_permissions',$data);
			if ($Q->num_rows() > 0){
				//print_r($Q->result_object());
				//exit;
				foreach ($Q->result_object() as $row){
					$result[] = $row;
				}
			}
		$Q->free_result();
		return $result;
	}
	function getUserGroupPermissions($user_group=null){
		$data = array('group_id'=>$user_group,'value'=>1);
		$result = '';		
		$Q = $this->db->get_where('tbl_group_permissions',$data);
			if ($Q->num_rows() > 0){				
				foreach ($Q->result_object() as $row){
					$result[] = $row;
				}
			}
		$Q->free_result();
		return $result;
	}
	function getAllUserGroupPermissions($user_group=null){
		$data = array('group_id'=>$user_group);
		$result = '';
		$Q = $this->db->get_where('tbl_group_permissions',$data);
			if ($Q->num_rows() > 0){
				foreach ($Q->result_object() as $row){
					$data[] = $row;
				}
			}
		$Q->free_result();
		return $result;
	}
	function setUserGroupPermissions($object=null) {
	
		
	}
	function setUserGroupPages($pages=null,$allowed_groups=null) {
		if (is_array($allowed_groups) && is_array($pages)) {
			$user_group = $allowed_groups;
			$uri = array();
			for($i=0;$i<$this->uri->total_segments();$i++) {
				//print_r($this->uri->segment($i + 1)); //exit();
				if(empty($uri[0])) $uri[0] = 'index';
				$uri[$i] = $this->uri->segment($i + 1);
				
				//print_r($this->uri->segment($i + 1));
				//print_r($uri[$i]);

				if(in_array($uri[$i],$pages)){
					//Checking user auth
					$this->isAuthorized($user_group);
				} else {
					//Go to home if false
					//$this->session->set_flashdata('auth_message', 'You do not have that authorization.');
					//redirect($uri[0]);
					//return false;
				}
			}
		}
		return true;
	}
	function isAuthorized($user_group=null) {
		if ($this->permission && in_array($this->permission, $user_group)) {
			//Set true if exists
			return true;
		} 
	}
	
	function getModule ($user_group=null) {
		if($user_group == '')
			return array();
	
		$modules			= array();
	
		// Check admin group
		$user_permission	= $this->UserGroups->getUserGroup($user_group);
		// Check admin access permission
		if(!$user_permission['admin_access']) {
			// Redirect Users to login
			redirect('admin/authenticate');
		} else {
			$modules['Module']	= $this->config->item('module_link');
		}

		$modules['Users']	= $this->config->item('module_menu');
		//Controller permissions
		$modules_perm		= $this->getModuleFunction($user_group);		
		//Controller collections		
		$modules_cols		= array_keys($modules_perm);
				
		$where_cond			= array();
		if(is_array($modules_cols)) {
			$buffers = array();
			foreach ($modules_cols as $cols) {				
				$buffers[]	= strtolower($cols);
			}
			$this->db->where_in('module_name', $buffers);
		}
		
		$where_cond	  = (is_array($where_cond)) ? array_merge($where_cond, array('parent_id' => 0)) : array('parent_id' => 0);
				
		$this->db->where($where_cond);
		
		$this->db->order_by('order','ASC');
		
		$module_lists = $this->db->get('tbl_module_lists');
		
		if(count($module_lists->num_rows()) != 0) {
			foreach($module_lists->result_object() as $module) {
				
				$class_name	= $module->module_name;
				
				$this->db->where('parent_id', $module->id);
				
				$this->db->order_by('order','ASC');
				
				$menu_modules	= $this->db->get('module_lists');
				
				$buffers	= array();
				
				if(count($menu_modules->num_rows()) != 0) {
					foreach ($menu_modules->result_object() as $menu) {
						$where_cond		= array('');
						$buffers[$menu->module_link]	= $menu->module_name;
					}
				}
				
				$modules[ucwords(str_replace('_', ' ', $class_name))]	= $buffers;
				unset($buffers);
			}
		}
	
		return $modules;
	}
	
	public function getModuleFunction($user_group = '') {
		
		// Check initialize level id
		if($user_group == '') {
			// Return blank array
			return array();
		}	
		
		// Set default loaded controllers
		$modules			= array();
		
		// Set user permissions
		$user_permission	= $this->UserGroups->getUserGroup($user_group);
		
		// Check backend permission
		if(!$user_permission->admin_access) {
			// Set flash alert to session
			$this->session->set('auth_error', 'You have no access');
			// Redirect if have no access to backend / admin-panel
			redirect(ADMIN . 'authentication/noaccess');
		}
		
		// Load user admin menu controllers
		$modules['Users']		= $this->config->item('module_menu');
		
		// Check full backend permission
		if ($user_permission->admin_access) {
			// Set admin neccesary module functions
			$modules['Module']	=  $this->config->item('module_function');
		}
		
		// Set default return
		$return_object	= TRUE;

		// Check for level id
		if ($user_group == '') {
			// Set FALSE if level id not found
			$return_object	= FALSE;
		}
		
		// List all user level permissions
		$user_permissions = $this->getUserGroupPermissions($user_group);

		// Temp of array
		$buffers = array();
		
		// Loops for user_permission data 
		foreach ($user_permissions as $key) {
			// List all controller_permissions based on permission id at user_level_permission
			$module_functions = $this->getModulePermissions($key->permission_id);
			// Loops for controller_functions data 
			foreach ($module_functions as $val) {
				// List all controller_list based on controller id at controller_permission
				$class_names		= $this->getModuleList($val->module_id);
				// Loops for module_names data 
				foreach($class_names as $module) {				
					// Set temporary data in place
					$buffers[ucwords(str_replace('_', ' ', $module->module_name))][$val->module_link] = $val->module_name;
				}
				// Return all computed data of array permissions and controller lists available 
				$modules	= array_merge($modules,$buffers);
			}	
		}	
		
		unset($buffers);
		
		return $modules;
	}
}
?>
