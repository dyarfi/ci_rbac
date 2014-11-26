<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Admin_Controller extends My_Controller {
	public $userdata;
	public function __construct() {
		parent::__construct();				
		// Check method for users 
		//$this->user_check();		
		
		// Check if user session existed previously		
		//if($this->session->userdata('user_session') == '') {
			// Redirect if not found
			//redirect('admin/authenticate/logout');
		//} 
	}
	
	public function user_check() {
			
	}
}