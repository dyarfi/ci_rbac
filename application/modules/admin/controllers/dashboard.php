<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	var $userdata = '';
	var $auth_message = '';
	function __construct() {
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
		//Get user's group permission
		//$permission = new UserGroupPermission();
		//$permission->getUserGroupPermissions($this->userdata['group_id']);
		//$permission->setUserGroupPages($pages,$allowed_groups);

		//Debugging user session variable
		//print_r($this->session->userdata('user_session')); exit();
		//$this->session->sess_destroy('user_session');
		
		//Debugging cart session variable
		//print_r($this->cart->contents()); exit();
		//$this->cart->destroy();
		
		//Set authentication message if exists
		$this->auth_message = ($this->session->flashdata('auth_message')) ? $this->session->flashdata('auth_message') : '';
		$data['auth_message'] = $this->auth_message;

		// Load product configuration
		//$this->config->load('products');
	}
	function index() {
		$data['title']	= "Dashboard Home";
		$data['main']	= 'admin/dashboard';
		$data['tusers']	= $this->Users->getCount('active');
		
		//$data['users']	= $this->MUsers->getCount;
		
		$this->load->vars($data);
		//$this->load->view('template/dashboard');
		$this->load->view('template/admin_template');
		
	}
}

?>
