<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Class for Users
class User extends Admin_Controller {
	// var $userdata = '';
	var $auth_message = '';
	// var $User = '';
	public function __construct() {
		parent::__construct();
				
		// Load user related model
		$this->load->model('Users');
		$this->load->model('UserProfiles');
		$this->load->model('UserGroups');		
		$this->load->model('Captcha');		
		
		//$this->load->helper('directory');
		
		//$map = directory_map('./application/modules');
		
		//print_r($this->session->userdata);
		//print_r($map);
		
		//print_r(Modules::lists('./application/modules'));
		
		// Load user config
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
		
		$data['statuses'] = array(1=>'Active',0=>'Inactive');
		
		$data['main'] = 'users/users_index';
		
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
        // Destroy only user session
        $this->session->unset_userdata('user_session');
		redirect('/', 'refresh');
    }
	
	public function add() {
		
		//Default data setup
		$fields	= array(
				'username'		=> '',
				'email'			=> '',
				'password'		=> '',
				'password1'		=> '',
				'gender'		=> '',				
				'group_id'		=> '',
				'first_name'	=> '',
				'last_name'		=> '',				
				'birthday'		=> '',
				'phone'			=> '',	
				'mobile_phone'	=> '',				
				'fax'			=> '',
				'website'		=> '',
				'about'			=> '',
				'division'		=> '',
				'status'		=> '');
		
		$errors	= $fields;
		
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[24]|xss_clean');
		$this->form_validation->set_rules('email', 'Email','trim|valid_email|required|min_length[5]|max_length[24]|callback_match_email|xss_clean');
		$this->form_validation->set_rules('password', 'Password','trim|required');
		$this->form_validation->set_rules('password1', 'Retype Password','trim|required|matches[password]');
		$this->form_validation->set_rules('gender', 'Gender','required');		
		$this->form_validation->set_rules('group_id', 'Group','required');
		$this->form_validation->set_rules('first_name', 'First Name','trim');
		$this->form_validation->set_rules('last_name', 'Last Name','required');
		$this->form_validation->set_rules('birthday', 'Birthday','required');
		$this->form_validation->set_rules('phone', 'Phone','trim|is_natural|xss_clean|max_length[25]');
		$this->form_validation->set_rules('mobile_phone', 'Mobile Phone','trim');		
		$this->form_validation->set_rules('fax', 'Fax','trim|is_natural|xss_clean|max_length[25]');
		$this->form_validation->set_rules('website', 'Website','trim|prep_url|xss_clean|max_length[35]');
		$this->form_validation->set_rules('about', 'About','trim|xss_clean|max_length[1000]');
		$this->form_validation->set_rules('division', 'Division','trim|xss_clean|max_length[55]');				
		$this->form_validation->set_rules('status', 'Status','required');
		
		
		// Check if post is requested
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			
			// Validation form checks
			if ($this->form_validation->run() == FALSE)
			{
				// Set error fields
				$error = array();
				foreach(array_keys($fields) as $error) {
					$errors[$error] = form_error($error);
				}

				// Set previous post merge to default
				$fields = array_merge($fields, $this->input->post());
			}
			else
			{

				// Set data to add to database
				$this->Users->setUser($this->input->post());
				
				// Set message
				$this->session->set_flashdata('message','User created!');
				
				// Redirect after add
				redirect('admin/user');
			}
			
		}	
			
		// Set Action
		$data['action'] = 'add';
				
		// Set Param
		$data['param']	= '';
				
		// Set error data to view
		$data['errors'] = $errors;
		
		// User Groups Data
		$data['user_groups'] = $this->UserGroups->getAllUserGroup();
		
		// User Status Data
		$data['statuses']	= array('Active'=>1,'Inactive'=>0);	
		
		// Post Fields
		$data['fields']		= (object) $fields;

		// Main template
		$data['main']		= 'users/users_form';		
		
		// Admin view template
		$this->load->view('template/admin_template', $this->load->vars($data));
				
	}
	public function edit($id=0){
				
		// Check if param is given or not and check from database
		if (empty($id) || !$this->Users->getUser($id)) {
			$this->session->set_flashdata('message','Item not found!');
			// Redirect to index
			redirect(base_url().'admin/user');
		}	
		
		//Default data setup
		$fields	= array(
				'username'		=> '',
				'email'			=> '',
				'password'		=> '',
				'password1'		=> '',
				'gender'		=> '',				
				'group_id'		=> '',
				'first_name'	=> '',
				'last_name'		=> '',				
				'birthday'		=> '',
				'phone'			=> '',	
				'mobile_phone'	=> '',				
				'fax'			=> '',
				'website'		=> '',
				'about'			=> '',
				'division'		=> '',
				'status'		=> '');
		
		$errors	= $fields;
			
		
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
				$this->Users->updateUser($posts);

				// Set message
				$this->session->set_flashdata('message','User updated');

				// Redirect after add
				redirect('admin/user');

			}
		
		} else {	
			
			// Set fields from database
			$fields					= (array) $this->Users->getUser($id);
			
			$fields['password1']	= '';
			
			$profile	= (array) $this->UserProfiles->getUserProfile($id);
						
			$fields		= (object) array_merge($fields,$profile);

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
		
		// User Groups Data
		$data['user_groups'] = $this->UserGroups->getAllUserGroup();
		
		// Set form to view
		$data['main'] = 'users/users_form';			
		
		// Set admin template
		$this->load->view('template/admin_template', $this->load->vars($data));
		
	}
	public function delete($id){
		$this->Users->deleteUser($id);
		$this->session->set_flashdata('message','User deleted');
		redirect('admin/user');
	}	
	public function view($id=null){
		
		// Load form validation library if not auto loaded
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
		
		$data['captcha']		= $this->Captcha->image();
		
		$data['user']			= $this->Users->getUser($id);		
		
		$data['user_profile']	= $this->UserProfiles->getUserProfile($id);
				
		$this->load->vars($data);
		
		$data['main']	= 'users/users_view';
		
		$this->load->view('template/admin_template',$data);
	}
	
	// Ajax Methods for this controller and module
	public function ajax($action='') {
				
		// Check if the request via AJAX
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');		
		}	
		
		// Define initialize result
		$result['result'] = '';
		
		// Action Update User Profile via Ajax
		if ($action === 'update') {			
						
			// Set validation config
			$config = array(
               array('field' => 'first_name', 
                     'label' => 'First Name', 
                     'rules' => 'trim|required|xss_clean|max_length[25]'),	
               array('field' => 'last_name', 
                     'label' => 'Last Name', 
                     'rules' => 'trim|xss_clean|max_length[25]'),
               array('field' => 'captcha', 
                     'label' => 'Captcha', 
                     'rules' => 'trim|xss_clean|max_length[6]|callback_match_captcha'),
               array('field' => 'phone', 
                     'label' => 'Phone', 
                     'rules' => 'trim|is_natural|xss_clean|max_length[25]'),
			   array('field' => 'mobile_phone', 
                     'label' => 'Mobile Phone', 
                     'rules' => 'trim|is_natural|xss_clean|max_length[25]'),
			   array('field' => 'website', 
                     'label' => 'Website', 
                     'rules' => 'trim|prep_url|xss_clean|max_length[35]'),
			   array('field' => 'about', 
                     'label' => 'About', 
                     'rules' => 'trim|xss_clean|max_length[1000]'),
			   array('field' => 'division', 
                     'label' => 'Division', 
                     'rules' => 'trim|xss_clean|max_length[55]')
            );
			
			// Set rules to form validation
			$this->form_validation->set_rules($config);
			
			// Run validation for checking
			if ($this->form_validation->run() === FALSE) {
				
				// Send errors to JSON text
				$result['result']['code'] = 0;
				$result['result']['text'] = validation_errors();
				
			} else {
				
				// Unset captcha post
				unset($_POST['captcha']); 
				
				// Set User Data
				$user_profile = $this->UserProfiles->setUserProfiles($this->input->post());			

				// Check data if user is exists and status is active
				if (!empty($user_profile) && $user_profile->status == 1) {
					
					// Send message if true 
					$result['result']['code'] = 1;
					$result['result']['text'] = 'Changes saved !';
					
				} else if (!empty($user_profile) && $user->status != 1) { 
					
					// Send message if account is not active
					$result['result']['code'] = 2;
					$result['result']['text'] = 'Your account profile is not active';			
					
				} else {
					
					// Send message if account not found					
					$result['result']['code'] = 0;
					$result['result']['text'] = 'Profile not found';			
				}
			}
										
		// Checking Action via Ajax
		} else if ($action === 'check') {			
			
			// Check Username users via Ajax
			if ($this->uri->segments[5] === 'username') {
				
				// Set User Data
				$user = $this->Users->getUserByUsername($this->input->post('username'));			
				
				// Check data
				if (!empty($user) && $user->status == 1) {
					
					// Send message if true 
					$result['result']['code'] = 1;
					$result['result']['text'] = 'Username already exist!';
					
				} else if (!empty($user) && $user->status != 1) {
					
					// Send message if account is not active
					$result['result']['code'] = 2;
					$result['result']['text'] = 'Your account profile is not active';			
					
				} else {
					
					// Send message if account not found
					$result['result']['code'] = 0;
					$result['result']['text'] = 'Profile not found';			
					
				}	
			
			// Check Email users via Ajax	
			} else if ($this->uri->segments[5] === 'email') {			
				
				// Set User Data
				$user = $this->Users->getUserByEmail($this->input->post('email'));			
				
				// Check data
				if (!empty($user) && $user->status == 1) {
					
					// Send message if true 
					$result['result']['code'] = 1;
					$result['result']['text'] = 'Email already exist!';
					
				} else if (!empty($user) && $user->status != 1) { 
					
					// Send message if account is not active
					$result['result']['code'] = 2;
					$result['result']['text'] = 'Your account profile is not active';		
					
				} else {
					
					// Send message if account not found
					$result['result']['code'] = 0;
					$result['result']['text'] = 'Email not found';			
					
				}	
			
			// Check Password users via Ajax	
			} else if ($this->uri->segments[5] === 'password') {		
				
				// Default hash
				$hash_password = '';
						
				// Change to Password hash from POST
				if ($_POST['password'] !== '') {
					$hash_password		= sha1($_POST['username'].$_POST['password']);
					$_POST['password']	= $hash_password;								
				}
				
				//print_r($this->Users->getUserPassword($this->input->post('password')));
				
				// Set validation config
				$config = array(
						array(
							'field'   => 'password1', 
							'label'   => 'New Password' ,
							'rules'   => 'trim|required'),						
						array(
							'field'   => 'password2', 
							'label'   => 'Re-type New Password', 
							'rules'   => 'trim|required|matches[password1]'),
						array(
							'field'   => 'password', 
							'label'   => 'Password', 
							'rules'   => 'trim|required|max_length[255]|callback_match_password')						
				);

				// Set rules to form validation
				$this->form_validation->set_rules($config);
								
				// Run validation for checking
				if ($this->form_validation->run() === FALSE) {

					// Send errors to JSON text
					$result['result']['code'] = 0;
					$result['result']['text'] = validation_errors();

				} else {
					
					// Get user with the user id post
					$user	= $this->Users->getUser($this->input->post('user_id'));					
					$newp	= $this->Users->setPassword($user, $this->input->post('password1')); 
										
					// Check if the password is changed
					if (!empty($newp)) {
						
						// Send success update password result
						$result['result']['code'] = 1;
						$result['result']['text'] = 'Password changed, new password is <b>'.$newp.'</b>';
						
					} else {
						
						// Send success update password result
						$result['result']['code'] = 2;
						$result['result']['text'] = 'Can not change password, please come back later';

					}
									
				}
			}		
		} 		
		// Check user data and Add via Ajax	
		else if($action === 'add') {
			
			$result['result'] = '';
			
		}
				
		// Return data esult
		$data['json'] = $result;
		// Load data into view		
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
						
		if (!empty($user) && $user->status === 1) {
			
			$password = $this->Users->setPassword($user);
			
			$result['result']['code'] = 1;
			$result['result']['text'] = 'Your new password: <b>'. $password .'</b>';			
			
			$this->load->library('email');

			$this->email->from('noreply');
			$this->email->to($user->email);
			$this->email->subject('Your new password');
			$this->email->message('Hey <b>'.$user->username.'</b>, this is your new password: <b>'.$password.'</b>');

			$this->email->send();
			
		} else if (!empty($user) && $user->status !== 1) { 
			
			// Account is not Active
			$result['result']['code'] = 2;
			$result['result']['text'] = 'Your account is not active';			
			
		} else {
			
			// Account is not existed
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
	
	// -------------- CALLBACKS -------------- //

	// Match Email post to Database
	public function match_email($email) {		
		
		// Check email if empty
		if ($email == '') {
			$this->form_validation->set_message('match_email', 'The %s can not be empty.');
			return false;
		}
		// Check password if match
		else if ($this->Users->getUserEmail($email) == 1) {
			$this->form_validation->set_message('match_email', 'The %s is already taken.');			
			return false;
		// Match current password
		} else {
			return true;
		} 
		
	}
	
	// Match Captcha post to Database
	public function match_captcha($captcha) {		
		
		// Check captcha if empty
		if ($captcha == '') {
			$this->form_validation->set_message('match_captcha', 'The %s code can not be empty.');
			return false;
		}
		// Check captcha if match
		else if ($this->Captcha->match($captcha)) {
			return true;
		} 
		
	}
	
	// Match Password post to Database
	public function match_password($password) {
		
		// Check password if empty
		if ($password == '') {
			$this->form_validation->set_message('match_password', 'The %s can not be empty.');
			return false;
		}
		// Check password if match
		else if ($this->Users->getUserPassword($password) != 1) {
			$this->form_validation->set_message('match_password', 'The %s not match with your current password.');			
			return false;
		// Match current password
		} else {
			return true;
		}
		 
	}
	
	// Reload Captcha to the view
	public function reload_captcha() {
		
		// Send image to display Captcha
		$captcha = $this->Captcha->image();
		// Echo captcha Image
		echo $captcha['image'];
		exit;
		
	}
}