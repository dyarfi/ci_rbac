<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

	public function __construct() {
		parent::__construct();
		
		//Load user
		$this->load->model('Users');
		
		//Load user permission
		$this->load->model('UserGroupPermissions');
		
		//Put session check in constructor
		$data['user'] = $this->session->userdata('user_session');
		//Load user session in data
		$this->load->vars($data);
		//Load into class object
		$this->userdata = $data['user'];
		//Set which controller pages that have the permission
		//Always set as an array
		$pages = array(
						'index',
						'products',
						'create',
						//'edit',
						'login',
						'logout',
						'search'
					  );
		//Set which groups that have the access permission
		//Always set as an array
		$allowed_groups = array(
									"Admin"=>"1",
									"Vendor"=>"2",
									"Publisher"=>"4"
								);

	}
	public function index() {
		$data['title']	= "Dashboard Home";
		$data['main']	= 'admin/dashboard';
		$data['tusers']	= $this->Users->getCount(1);
		
		$this->load->vars($data);
		
		// Set admin title page with module menu
		$data['page_title'] = $this->module_menu;
		
		//$this->load->view('template/dashboard');
		$this->load->view('template/admin/admin_template', $data);
		
	}
}
