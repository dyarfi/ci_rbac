<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Class for Admins
class Admin extends Admin_Controller {
	var $userdata = '';
	var $auth_message = '';
	function __construct() {
		parent::__construct();
		
		//Acl::instance();
		
		//Load user profiles model
		$this->load->model('Users');
		$this->load->model('UserProfiles');
		$this->load->model('UserGroups');
		
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
						'users',
						'edit',
						'login',
						'logout',
						'search',
						'23',
					  );
		//Set which groups that have the access permission
		//Always set as an array
		$allowed_groups = array(
									"Admin"=>"1",
									"Vendor"=>"2",
									"Publisher"=>"4"
								);
		//Get user's group permission
		//$this->UserGroupPermissions->getUserGroupPermissions($this->userdata['group_id']);
		//$this->UserGroupPermissions->setUserGroupPages($pages,$allowed_groups);
		
		//Debugging user session variable
		//print_r($this->session->userdata('user_session')); exit();
		//$this->session->sess_destroy('user_session');
		
		//Debugging cart session variable
		//print_r($this->cart->contents()); exit();
		//$this->cart->destroy();
		
		//Set authentication message if exists
		$this->auth_message = ($this->session->flashdata('auth_message')) ? $this->session->flashdata('auth_message') : '';
		$data['auth_message'] = $this->auth_message;
		exit;
	}
	function index() {				
		exit;
	}	
}