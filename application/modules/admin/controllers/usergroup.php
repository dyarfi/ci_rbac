<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Class for User Groups
class UserGroup extends Admin_Controller {
	// var $userdata = '';
	var $auth_message = '';
	//var $User = '';
	public function __construct() {
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
	public function index() {		
		//$user_id = $this->userdata['user_id'];
		//$user_group_id = $this->userdata['group_id'];
			
		//print_r($user_group_id); exit();
		//print_r($this->auth_message); exit();

		
		$rows = $this->UserGroups->getAllUserGroup();
		
		if (@$rows) $data['rows'] = $rows;
		
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
		$data['statuses']	= array('Active'=>'active','Inactive'=>'inactive');
		$data['main'] = 'users/usergroups_index';
		
		$this->load->view('template/admin_template', $data);
				
	}
	/*
	public function login () {
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
	public function logout() {
        //Destroy only user session
        $this->session->unset_userdata('user_session');
		redirect('/', 'refresh');
    }
	public function add(){
		
		//Default data setup
		$fields = array(
					'name'=>'',
					'backend_access'=>'',
					'full_backend_access'=>'',
					'status'=>'');
		
		$errors = $fields;
		
		// Set form validation rules
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('status', 'Status','trim|required|xss_clean');
		
		// Check if post is requested
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			
			// Validation form checks
			if ($this->form_validation->run() == FALSE) {

				// Set error fields
				$error = array();
				foreach(array_keys($fields) as $error) {
					$errors[$error] = form_error($error);
				}

				// Set previous post merge to default
				$fields = array_merge($fields, $this->input->post());

			} else {

				// Set data to add to database
				$this->UserGroups->setUserGroup($this->input->post());

				// Set message
				$this->session->set_flashdata('message','User Group created!');

				// Redirect after add
				redirect('admin/usergroup');

			}
		}	
							
		// Set Action
		$data['action'] = 'add';
				
		// Set Param
		$data['param']	= '';
				
		// Set error data to view
		$data['errors'] = $errors;

		// Set field data to view
		$data['fields'] = $fields;
		
		// Group Status Data
		$data['statuses']	= array('Active'=>1,'Inactive'=>0);	
		
		// Post Fields
		$data['fields']		= (object) $fields;
		
		// Main template
		$data['main']		= 'users/usergroups_form';		
		
		// Admin view template
		$this->load->view('template/admin_template', $this->load->vars($data));
		
	}
	public function edit($id=0){
		
		// Check if param is given or not and check from database
		if (empty($id) || !$this->UserGroups->getUserGroup($id)) {
			$this->session->set_flashdata('message','Item not found!');
			// Redirect to index
			redirect(base_url().'admin/usergroup');
		}				
		
		// Default data setup
		$fields = array(
					'name' => '',
					'backend_access' => '',
					'full_backend_access' => '',
					'status' => '');
		
		$errors = $fields;
		
		// Set form validation rules
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('status', 'Status','trim|required|xss_clean');
		
		// Check if post is requested		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			
			// Validation form checks
			if ($this->form_validation->run() == FALSE) {

				// Set error fields
				$error = array();
				foreach(array_keys($fields) as $error) {
					$errors[$error] = form_error($error);
				}

				// Set previous post merge to default
				$fields = array_merge($fields, $this->input->post());						

			} else {

				$posts = array(
					'id'=>$id,
					'name' => $this->input->post('name'),
					'backend_access' => $this->input->post('backend_access'),
					'full_backend_access' => $this->input->post('full_backend_access'),
					'status' => $this->input->post('status')
				);
				
				// Set data to add to database
				$this->UserGroups->updateUserGroup($posts);

				// Set message
				$this->session->set_flashdata('message','User Group updated');

				// Redirect after add
				redirect('admin/usergroup');

			}
		
		} else {	
			
			// Set fields from database
			$fields = $this->UserGroups->getUserGroup($id);		
		}

		// Set Action
		$data['action'] = 'edit';
				
		// Set Param
		$data['param']	= $id;
		
		// Set error data to view
		$data['errors'] = $errors;

		// Set field data to view
		$data['fields'] = $fields;		
			
		// Set user group status
		$data['statuses'] = array('Active'=>1,'Inactive'=>0);							
		
		// Set form to view
		$data['main'] = 'users/usergroups_form';			
		
		// Set admin template
		$this->load->view('template/admin_template', $this->load->vars($data));

	}
	public function delete($id){
		$this->UserGroups->deleteUserGroup($id);
		$this->session->set_flashdata('message','User Group deleted');
		redirect('admin/usergroup');
	}	
	public function view($id=null){
		
		//Load form validation library if not auto loaded
		$this->load->library('form_validation');

		if (empty($id) && (int)$id > 0) {
			$this->session->set_flashdata('message',"Error submission.");
			redirect("users","refresh");
		}

		$user = $this->Users->getUser($id);
		if (!count($user)){
			redirect('home/index');
		}
		
		$data['upload_path']	= $this->config->item('upload_path');
		
		$data['upload_url']		= $this->config->item('upload_url');
		
		$data['user']			= $this->Users->getUser($id);
		
		$data['user_profile']	= $this->UserProfiles->getUserProfile($id);
				
		$this->load->vars($data);
		
		$data['main']	= 'users/users_view';
		
		$this->load->view('template/admin_template',$data);
	}
	
	public function ajax($action='') {
				
		//Check if the request via AJAX
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');		
		}	
		
		//Define initialize result
		$result['result'] = '';
				
		//Update user profile via Ajax
		if ($action == 'update' && $this->input->post() !== '') {
			
			//Set User Data
			$user_profile = $this->UserProfiles->setUserProfiles($this->input->post());
			
			//Reload session if the user is logged in
			//Set session data
			//$this->session->set_userdata($user_profile);

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
				
		}
				
		
		$data['json'] = $result;
				
		$this->load->view('json', $data);	
	}
	
	public function forgot_password() {
			
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
	public function search() {
        //use this for the search results
		//$data = $this->input->xss_clean($this->input->post('term'));
		//$data = $this->input->post('term', true);
		//var_dump($data);
		//var_dump($this->input->post('term'));

		if ($this->input->post('term')){
			$search['results'] = $this->MProducts->search($this->input->post('term'));
		} else {
			redirect('/');
		}
		$data['results'] = $search['results'];
		$data['main'] = 'search_view';
		$data['title'] = "Claudia's Kids | Search Results";
		$data['navlist'] = $this->MCats->getCategoriesNav();

		$this->load->vars($data);
		$this->load->view('template/home_template',$data);
	}
}