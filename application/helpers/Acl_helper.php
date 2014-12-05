<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class ACL extends CI_Controller {
				
	public $user = '';
	public $privileges;
	
	public $module_list;
	public $module_function_list;
	public $module_request;
	public $module_menu;
	
	public $previous_url;
	
	public function __construct () {
		parent::__construct();	
		
		$this->CI =& get_instance();
						
		$this->user	= self::user();						
		
		if (strpos($this->session->userdata('prev_url'), ADMIN) !== FALSE 
				&& $this->session->userdata('prev_url') != $this->session->userdata('curr_url')) {
			// Set Previous URL to current URL
			$this->session->set_userdata('prev_url', $this->session->userdata('curr_url'));
		}	else {
			// Set current URL from current url
			$this->session->set_userdata('curr_url', $this->uri->uri_string());
		}
		
		if ($this->session->userdata('user_session') == '') {
			// Redirect if not logged
			redirect(ADMIN);
		}
		
		// Set previous URL from previous url session		
		$this->previous_url	= $this->session->userdata('prev_url');				
							
	}
	
	public function user() {
		
		$user = $this->session->userdata('user_session');
		
		$this->user = '';
		
		if($user) {
			$this->user = (object) $user;
		} 
		
		// Return user data result from session
		return $this->user;
	}
	
	public function previous_url() {
		// Return previous url from session
		return ($this->previous_url) ? $this->previous_url : '';
	}

	/**
	* Load the current users available module list
	*
	* @access	public
	* @param	array
	* @return	array
	*/	
	public function admin_system_modules () {
				
		if ($this->user === FALSE) {
			return array();
		}	

		// ------- If User is Login set available data --- start
		if ($this->user != '') {
			//$this->userhistory		= Model_UserHistory::instance();
			$this->module_list			= json_decode($this->session->userdata('module_list'),TRUE);
			$this->module_function_list	= json_decode($this->session->userdata('module_function_list'),TRUE);
			//$this->module_request		= $this->uri->uri_string;	
			//$this->module_menu			= self::check_module_menu($this->module_request);
		}
		
		$modules				= array();

		// Check admin url
		if (strstr($this->uri->uri_string, ADMIN) !== '') {	
			// Get module listings
			$modules	= $this->module_list;			
		}
		
		return $modules;		
	}
	
	
}

