<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Class for Users
class User extends CI_Controller {
	// var $userdata = '';
	var $auth_message = '';
	//var $User = '';
	function __construct() {
		parent::__construct();
				
		//Load user related model
		$this->load->model('Users');
		$this->load->model('UserProfiles');
		$this->load->model('UserGroups');		
		
		//Load user config
		$this->config->load('admin');
		
		//$this->load->class('acl');
		//$asdf = Acl::instance();
		//print_r(Acl::instance()->access_control());		
		
		/*
		//Load user permission
		$this->load->model('MUserPermissions');
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
						'user',
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
		$permission = new MUserPermissions();
		$permission->getUserGroupPermissions($this->userdata['group_id']);
		$permission->setUserGroupPages($pages,$allowed_groups);

		//Debugging user session variable
		//print_r($this->session->userdata('user_session')); exit();
		//$this->session->sess_destroy('user_session');
		
		//Debugging cart session variable
		//print_r($this->cart->contents()); exit();
		//$this->cart->destroy();

		//Set authentication message if exists
		$this->auth_message = ($this->session->flashdata('auth_message')) ? $this->session->flashdata('auth_message') : '';
		$data['auth_message'] = $this->auth_message;
		*/
			
		//$this->User = $this->load->model('User');
		//print_r($this->session->all_userdata());
	}
	function index() {		
		//$user_id = $this->userdata['user_id'];
		//$user_group_id = $this->userdata['group_id'];
			
		//print_r($user_group_id); exit();
		//print_r($this->auth_message); exit();

		//print_r($this);
		//exit;
		
		$data['title'] = "Welcome to your profile page in my first CI page";
		$rows = $this->Users->getAllUser();
		$temp_rows = array();
		if($rows) {
			$i = 0;
			foreach($rows as $row ){		
				$temp_rows[$i]->id = $row->id;
				$temp_rows[$i]->username = $row->username;
				$temp_rows[$i]->email = $row->email;
				$temp_rows[$i]->password = substr_replace($row->password, "********", 0, strlen($row->password));
				$temp_rows[$i]->status = $row->status;
				$temp_rows[$i]->group_id = $this->UserGroups->getGroupName_ById($row->group_id);
				$i++;
			}
		}
		if (@$temp_rows) $data['rows'] = $temp_rows;
				
		$data['user_profiles'] = $this->UserProfiles->getUserProfile(Acl::instance()->user->id);
				
		$this->load->vars($data);
		/*
		switch(Acl::instance()->user->group_id){
			case 1: // Administrator Access
				$data['main'] = 'users/default_admin';
				$this->load->view('template/admin_template', $data);
			break;
			default: // Public Access
				$data['main'] = 'users/default_users';
				$this->load->view('template/static_template', $data);
			break;
		}
		 * 
		 */
		
		$data['main'] = 'users/users_index';
		
		$this->load->view('template/admin_template', $data);
				
	}
	/*
	function login () {
		// load helper if not auto loaded
		//$this->load->helper(array('form','url'));
		// load library if not auto loaded
		$this->load->library('form_validation');

		// load model if not auto loaded
		// $user = new User();
		
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
				//User is already logged in.
				//return false;
			}
            //Destroy old session
            //$this->session->sess_destroy();

            //Create a fresh, brand new session
            //$this->session->sess_create();
			
			//Check User login info
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
		
		//$data['title']	= "Welcome to my first CI Login page";
		//$data['main']	= 'user/login';
		
		
		$this->load->vars($data);
		$data['main']	= $this->load->view('users/default_user', $data, true);
		$this->load->view('template/login_template');
	}
	 * 
	 */
	function logout() {
        //Destroy only user session
        $this->session->unset_userdata('user_session');
		redirect('/', 'refresh');
    }
	function add(){
		// load library if not auto loaded
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('name', 'Name', 'trim|required|valid_email|min_length[5]|max_length[24]|xss_clean');
		$this->form_validation->set_rules('keywords', 'Keywords','trim|required|min_length[5]|max_length[24]|xss_clean');
		$this->form_validation->set_rules('description', 'Description','trim|required|min_length[5]|max_length[24]|xss_clean');
		$this->form_validation->set_rules('path', 'Path', 'trim|required|min_length[5]|max_length[24]|xss_clean');
		$this->form_validation->set_rules('content', 'Content','trim|required|min_length[5]|max_length[24]|xss_clean');
		
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

		
		if ($this->input->post('name')){
			$this->Users->addUser();
			$this->session->set_flashdata('message','Page created');
			redirect('admin/users/index','refresh');
		}else{
			$data['main']		 = 'users/users_form';
			$data['user_groups'] = $this->UserGroups->getAllUserGroup();
			$this->load->vars($data);
			//$this->load->view('dashboard');
			$this->load->view('template/admin_template');
		}
	}
	function edit($id=0){
		if ($this->input->post('name')){
			$this->Users->updateUser();
			$this->session->set_flashdata('message','Page updated');
			redirect('admin/users/index','refresh');
		}else{
			$data['title'] = "Edit Page";
			$data['main'] = 'users/users_form';
			$data['page'] = $this->Users->getUser($id);
			$this->load->vars($data);
			//$this->load->view('dashboard');
			$this->load->view('template/admin_template');
		}
	}
	function delete($id){
		$this->Users->deleteUser($id);
		$this->session->set_flashdata('message','Page deleted');
		redirect('admin/users/index','refresh');
	}	
	function view($id=null){
		
		//Load form validation library if not auto loaded
		$this->load->library('form_validation');

		if (empty($id) && (int)$id > 0) {
			$this->session->set_flashdata('message',"Error submission.");
			redirect("users","refresh");
		}

		$user = $this->Users->getUser($id);
		if (!count($user)){
			redirect('home/index','refresh');
		}
		
		//print_r($this->session->userdata);
		
		//Get the user's entered captcha value from the form
		//$userCaptcha			= set_value('captcha');
    
		//Get the actual captcha value that we stored in the session (see below)
		//$word					= $this->session->userdata('captcha');
	
		$data['upload_path']	= $this->config->item('upload_path');
		
		$data['upload_url']		= $this->config->item('upload_url');
		
		$data['captcha']		= create_captcha($this->config->load('captcha'));
		
		$data['user']			= $this->Users->getUser($id);		
		
		$data['user_profile']	= $this->UserProfiles->getUserProfile($id);
		
		/* Store the captcha value (or 'word') in a session to retrieve later */
		$this->session->set_userdata('captchaWord',$data['captcha']['word']);
				
		$this->load->vars($data);
		
		$data['main']	= 'users/users_view';
		
		$this->load->view('template/admin_template',$data);
	}
	
	function ajax($action='') {
				
		//Check if the request via AJAX
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');		
		}	
		
		//Define initialize result
		$result['result'] = '';
		
		//Update User Profile via Ajax
		if ($action === 'update') {			
						
			//Set User Data
			$user_profile = $this->UserProfiles->setUserProfiles($this->input->post());			
			//Check data				
			if (!empty($user_profile) && $user_profile->status === 'active') {
				$result['result']['code'] = 1;
				$result['result']['text'] = 'Changes saved !';
			} else if (!empty($user_profile) && $user->status !== 'active') { 
				$result['result']['code'] = 2;
				$result['result']['text'] = 'Your account profile is not active';			
			} else {
				$result['result']['code'] = 0;
				$result['result']['text'] = 'Profile not found';			
			}				
		//Checking Action via Ajax
		} else if($action === 'check') {			
			//Check Username users via Ajax
			if ($this->uri->segments[5] === 'username' && $this->input->post('username') !== '') {			
				//Set User Data
				$user = $this->Users->getUserByUsername($this->input->post('username'));			
				//Check data
				if (!empty($user) && $user->status === 'active') {
					$result['result']['code'] = 1;
					$result['result']['text'] = 'Username already exist!';
				} else if (!empty($user) && $user->status !== 'active') { 
					$result['result']['code'] = 2;
					$result['result']['text'] = 'Your account profile is not active';			
				} else {
					$result['result']['code'] = 0;
					$result['result']['text'] = 'Profile not found';			
				}				
			}
			//Check Email users via Ajax
			if ($this->uri->segments[5] === 'email' && $this->input->post('email') !== '') {			
				//Set User Data
				$user = $this->Users->getUserByEmail($this->input->post('email'));			
				//Check data
				if (!empty($user) && $user->status === 'active') {
					$result['result']['code'] = 1;
					$result['result']['text'] = 'Email already exist!';
				} else if (!empty($user) && $user->status !== 'active') { 
					$result['result']['code'] = 2;
					$result['result']['text'] = 'Your account profile is not active';			
				} else {
					$result['result']['code'] = 0;
					$result['result']['text'] = 'Email not found';			
				}				
			}
			//Check Password users via Ajax
			if ($this->uri->segments[5] === 'password' 
					&& $this->input->post('password') !== '' 
						&& $this->input->post('user_id') !== '') {			
				//Set User Data
				$user = $this->Users->getUserPassword($this->input->post());				
				//Check data
				if (!empty($user) && $user->status === 'active') {
					$result['result']['code'] = 1;
					$result['result']['text'] = 'Email already exist!';
				} else if (!empty($user) && $user->status !== 'active') { 
					$result['result']['code'] = 2;
					$result['result']['text'] = 'Your account profile is not active';			
				} else {
					$result['result']['code'] = 0;
					$result['result']['text'] = 'Email not found';			
				}				
			}
		//Check user data and Add via Ajax
		} else if($action === 'add') {
			
			$result['result'] = '';
			
		}
				
		//Return data esult
		$data['json'] = $result;
		//Load data into view		
		$this->load->view('json', $data);	
	}
	
	function forgot_password() {
			
		// Check if the request via AJAX
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');		
		}
		
		// Define initialize result
		$result['result'] = '';
		
		// Get User Data
		$user = $this->Users->getUserByEmail($this->input->post('email'));
						
		if (!empty($user) && $user->status === 'active') {
			$password = $this->Users->setPassword($user);
			
			$result['result']['code'] = 1;
			$result['result']['text'] = 'Your new password: <b>'. $password .'</b>';			
			
			$this->load->library('email');

			$this->email->from('noreply');
			$this->email->to($user->email);
			$this->email->subject('Your new password');
			$this->email->message('Hey <b>'.$user->username.'</b>, this is your new password: <b>'.$password.'</b>');

			$this->email->send();
			
		} else if (!empty($user) && $user->status !== 'active') { 
		
			$result['result']['code'] = 2;
			$result['result']['text'] = 'Your account is not active';			
			
		} else {
			
			$result['result']['code'] = 0;
			$result['result']['text'] = 'Email or User not found';			
		}
				
		$data['json'] = $result;
				
		$this->load->view('json', $data);				
		
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
?>