<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user extends CI_Controller {

	public function __construct() {
		
		parent::__construct();
		// Load user related model
		$this->load->model('../modules/admin/models/Users');
		$this->load->model('../modules/admin/models/UserProfiles');		
	}
	
	public function index() {
		
		// Set main template
		$data['main'] = 'users';
				
		// Set site title page with module menu
		$data['page_title'] = 'User';
		
		// Load admin template
		$this->load->view('template/public/site_template', $this->load->vars($data));
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/user.php */