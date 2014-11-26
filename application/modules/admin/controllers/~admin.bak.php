<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Class for Admins
class Admin extends Admin_Controller {
	var $userdata = '';
	var $auth_message = '';
	function __construct() {
		parent::__construct();
		
		//Acl::instance();
		//exit;
		//Load security helper
		$this->load->helper('security');
		
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
		$this->UserGroupPermissions->getUserGroupPermissions($this->userdata['group_id']);
		$this->UserGroupPermissions->setUserGroupPages($pages,$allowed_groups);
		
		//Debugging user session variable
		//print_r($this->session->userdata('user_session')); exit();
		//$this->session->sess_destroy('user_session');
		
		//Debugging cart session variable
		//print_r($this->cart->contents()); exit();
		//$this->cart->destroy();
		
		//Set authentication message if exists
		$this->auth_message = ($this->session->flashdata('auth_message')) ? $this->session->flashdata('auth_message') : '';
		$data['auth_message'] = $this->auth_message;
		
	}
	function index() {
				
		$user_id = $this->userdata['user_id'];
		$user_group_id = $this->userdata['group_id'];
		//print_r($user_group_id); exit();
		//print_r($this->auth_message); exit();

		$data['title'] = "Welcome to your profile page in my first CI page";
		$data_users = $this->User->getAllUser();
		$users_rows = array();
		
		if($data_users) {
			$i = 0;
			foreach($data_users as $data_user ){
				$users_rows[$i]['id'] = $data_user['id'];
				$users_rows[$i]['username'] = $data_user['username'];
				$users_rows[$i]['email'] = $data_user['email'];
				$users_rows[$i]['password'] = substr_replace($data_user['password'], "********", 0, strlen($data_user['password']));
				$users_rows[$i]['status'] = $data_user['status'];
				$users_rows[$i]['group_id'] = $this->UserGroups->getGroupName_ById($data_user['group_id']);
				$i++;
			}
		}
		if (@$users_rows) $data['users'] = $users_rows;
		
		$data['user_profiles'] = $this->UserProfiles->getUserProfile($user_id);
		
		$this->load->vars($data);
		
		switch($user_group_id){
			case 1: // Administrator Access
				//$data['main'] = 'users/default_admin';
				$data['main'] = 'admin/admin_home';
				$this->load->view('template/admin_template', $data);
			break;
			default: // Public Access
				$data['main'] = 'users/default_user';
				$this->load->view('template/static_template', $data);
			break;
		}
	}
	/*
	function login () {
		// load helper if not auto loaded
		//$this->load->helper(array('form','url'));

		// load library if not auto loaded
		$this->load->library('form_validation');

		// load model if not auto loaded
		// $user = new MAdmins();
		
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|min_length[5]|max_length[24]|xss_clean');
		$this->form_validation->set_rules('password', 'Password','trim|required|min_length[5]|max_length[24]|xss_clean');

		if ($this->form_validation->run() == FALSE)
		{
			//$this->load->view('login');
			//return false;
		}
		else
		{
			//$this->load->view('formsuccess');
			//return true;
		}

		if($_SERVER['REQUEST_METHOD'] === 'POST'){
			$userObj = $_POST;
			//Make sure login object was true
			if($userObj['email'] == '' OR $userObj['password'] == '') {
				//return false;
			}
			//Check if already logged in
			if($this->session->userdata('username') == $userObj['email']) {
				//Admin is already logged in.
				//return false;
			}
            //Destroy old session
            //$this->session->sess_destroy();

            //Create a fresh, brand new session
            //$this->session->sess_create();
			
			//Check Admin login info
			$row = $this->User->login($userObj);
			//print_r($row); exit();
			
			if(!empty($row)) {
				//Remove the password field
				//print_r($row); exit();

				$user_id = $row['id'];
				
				unset($row['id']);
				unset($row['password']);
				
				$user['user_session'] = $row;
				$user['user_session']['user_id'] = $user_id;
				$user['user_session']['logged_in'] = true;
				
				//Set session data
				$this->session->set_userdata($user);
				//print_r($this->session->userdata); exit();

				//Set logged_in to true
				//$this->session->set_userdata(array('logged_in' => true));
				
				//Set logged_in to true
				//$this->session->set_userdata(array('user_id' => true));
				//print_r($this->session->userdata); exit();
				
				//Login was successful
				//return true;
				 redirect('/', 'refresh');
			} else {
				$userObj = 'Error Submission';
				$this->session->set_flashdata('message', $userObj);
				//$this->form_validation->set_message('email', 'The %s field can not be the word "test"');
				//print_r($this->session->set_flashdata('Error', $userObj)); //exit();
				//return false;
			}
		}
		
		$data['user']	= $this->session->userdata;
		$data['title']	= "Welcome to my first CI Login page";
		$data['main']	= 'users/login';
		
		
		$this->load->vars($data);
		$data['main']	= $this->load->view('users_view', $data, true);
		$this->load->view('template/login_template');
	}
	 * 
	 */
	function logout() {
        //Destroy only user session
        $this->session->unset_userdata('user_session');
		redirect('/', 'refresh');
    }
	function edit($id = null) {
		echo "fubar edit";
	}
	function create($id = null) {
		echo "fubar create";
	}
	function search() {
        //use this for the search results
		//$data = $this->input->xss_clean($this->input->post('term'));
		//$data = $this->input->post('term', true);
		//var_dump($data);
		//var_dump($this->input->post('term'));

		if ($this->input->post('term')){
			$search['results'] = $this->MProducts->search($this->input->post('term'));
		} else {
			redirect('/','refresh');
		}
		$data['results'] = $search['results'];
		$data['main'] = 'search_view';
		$data['title'] = "Claudia's Kids | Search Results";
		$data['navlist'] = $this->MCats->getCategoriesNav();

		$this->load->vars($data);
		$this->load->view('template/home_template',$data);
	}
}