<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Class for Users
class Authenticate extends CI_Controller {
	var $userdata = '';
	var $auth_message = '';
	function __construct() {
		parent::__construct();
		
		//Load user profiles model
		$this->load->model('Users');
		$this->load->model('UserProfiles');
		$this->load->model('UserGroups');
		$this->load->model('UserGroupPermissions');
				
		$this->load->model('ModuleLists');
		$this->load->model('ModelLists');
		$this->load->model('ModulePermissions');
		
		$this->load->model('Configurations');		
		$this->load->model('UserHistories');	
		$this->load->model('Captcha');
		//Put session check in constructor
		//$data['user'] = $this->session->userdata('user_session');
		//Load user session in data
		//$this->load->vars($data);
		//Load into class object 
		//$this->userdata = $data['user'];		
		//Set which controller pages that have the permission
		/*
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
		$permission = new MUserPermissions();
		$permission->getUserGroupPermissions($this->userdata['group_id']);
		$permission->setUserGroupPages($pages,$allowed_groups);
		*/
		//Debugging user session variable
		//print_r($this->session->userdata('user_session')); exit();
		//$this->session->sess_destroy('user_session');
		
		//Debugging cart session variable
		//print_r($this->cart->contents()); exit();
		//$this->cart->destroy();

		//Set authentication message if exists
		$this->auth_message = ($this->session->flashdata('auth_message')) ? $this->session->flashdata('auth_message') : '';
		$data['auth_message'] = $this->auth_message;
		
		
		//Destroy old session
		//$this->session->sess_destroy();

		//Create a fresh, brand new session
		//$this->session->sess_create();		

	}
	function index() {
		//Redirect to dashboard if user already logged
		if (!empty($this->userdata)) {
			redirect('admin/dashboard');
		} else {
			redirect('admin/authenticate/login', 'refresh');
		}
				
		$user_id = $this->userdata['user_id'];
		$user_group_id = $this->userdata['group_id'];
		//print_r($user_group_id); exit();
		//print_r($this->auth_message); exit();

		$data['title'] = "Welcome to your profile page in my first CI page";
		$data_users = $this->Users->getAllUser();
		$users_rows = array();
		
		if($data_users) {
			$i = 0;
			foreach($data_users as $data_user ){
				$users_rows[$i]['id']		= $data_user['id'];
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
				$data['main'] = 'users/default_admin';
				$this->load->view('template/admin_template', $data);
			break;
			default: // Public Access
				$data['main'] = 'users/default_user';
				$this->load->view('template/static_template', $data);
			break;
		}
	}
	function login () {
		//Redirect to dashboard if user already logged
		if (!empty($this->userdata)) {
			redirect('admin/dashboard');
		}
		// load helper if not auto loaded
		//$this->load->helper(array('form','url'));

		// load library if not auto loaded
		$this->load->library('form_validation');

		if($_SERVER['REQUEST_METHOD'] === 'POST'){
			$userObj = $_POST;
			
			// load model if not auto loaded
			// $user = new User();

			$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[24]|xss_clean');
			$this->form_validation->set_rules('password', 'Password','trim|required|min_length[5]|max_length[24]|xss_clean');

			if ($this->form_validation->run() == FALSE)
			{
				
				/*
				// Module Installer default
				$this->User->install();
				$this->UserGroup->install();
				$this->UserProfile->install();
				$this->ModuleList->install();
				$this->ModelList->install();
				$this->Configuration->install();
				$this->ModulePermission->install();
				$this->UserGroupPermission->install();
				$this->UserHistory->install();
				
				// Authenticate User Accounts and return User ID
				$user       = new Model_User();
				$return		= $user->authenticate($request['email'], sha1($request['password']), '');

				// Check User Level from User ID given
				$user_level		= $user->get_user_level($return);

				// Check for Enable Level from User Level given
				$where_cond		= array('status'=>'enable','id'=>$user_level);
				$level_enable	= $this->UserGroup->find($where_cond,'',1);

				// Check for Disabled or Deleted Level and return message
				if (intval($return) && !$level_enable) {
					// Change return value
					$return = 'level_disable';
				}
						
				if (intval($return) != 0 && !empty($level_enable)) {
					$this->session->set('user_id', $return);

					// Where condition query for user level checking
					$where_cond		= array('status'=>'enable','id'=>$user_level);
					$level_enable	= Model_UserLevel::instance()->find($where_cond,'',1);

					if (intval($user_level) != 0) {
							$this->session->set('level_id', $user_level);

							$privillage		= Model_UserLevel::instance()->full_level_access($user_level);

							if (intval($privillage) == 1) {
									// Install module table
									// $modules	= Kohana::modules();
									// print_r( $modules ); exit();
									Model_ModuleList::instance()->module_check();
									// Model_ModuleListPermission::instance()->module_function_check();
							}
							// Auth::instance()->logged_in(TRUE);								
							// $acl = new ACL();
							// $acl->user = TRUE;
					} 

					$module_list	= Model_ModuleList::instance()->get_modules($user_level);
					$function_list	= Model_UserLevelPermission::instance()->get_module_function($user_level);
					
					// Set Module List for All Access
					$this->session->set('module_list', json_encode($module_list));
					//ACL::instance()->_module_list($module_list);
					
					// Set Module List Function for All Access
					$this->session->set('module_function_list', json_encode($function_list));
					//ACL::instance()->_module_function_list($function_list);
					
					// Clean All auth_error Session
					$this->session->set('auth_error', '');
					
					if ($this->session->get('prev_url') != '') {
						// Redirect if to recent url if true
						$this->redirect($this->session->get('prev_url'));
					} else {
						// Redirect to view profile
						$this->redirect(str_replace('{admin_id}', $return, Lib::config('admin.default_page')));
					}
						
					return;
				} else {
					switch ($return) {
							case 'blocked':
								$this->session->set('auth_error', 'Your User ID has been blocked by Administrator');
								break;
							case 'inactive':
								$this->session->set('auth_error', 'Your User ID has been inactive by Administrator');
								break;							
							case 'level_disable':
								$this->session->set('auth_error', 'Your User Level has been disable by Administrator');
								break;							
							default:
								$this->session->set('auth_error', 'Invalid User Email or Password');
					}
					//$this->template->page_title = i18n::get('error_login');
					$errors = array('error_login' => i18n::get('error_login'));
				}
				*/
				
			}
			else
			{
				//$this->load->view('formsuccess');
				//return true;
			}
			//print_r($userObj);
			//Make sure login object was true
			if($userObj['username'] == '' OR $userObj['password'] == '') {
				//return false;
			}
			//Check if already logged in
			if($this->session->userdata('username') == $userObj['username']) {
				//User is already logged in.				
				//return false;
			}
			
			//Check User login info
			$user				= $this->Users->login($userObj);
			if(!empty($user)) {
				
				$this->Users->install();
				$this->UserGroups->install();
				$this->UserProfiles->install();
				$this->ModuleLists->install();
				$this->ModelLists->install();
				$this->Configurations->install();
				$this->ModulePermissions->install();
				$this->UserGroupPermissions->install();
				$this->UserHistories->install();
				$this->Captcha->install();
				
				//print_r($user);
				
				$module_list	= $this->UserGroupPermissions->getModuleList($user->group_id);
				
				$function_list	= $this->UserGroupPermissions->getModuleFunction($user->group_id);

				// Set Module List for All Access
				$this->session->set_userdata('module_list', json_encode($module_list));
				//ACL::instance()->_module_list($module_list);

				// Set Module List Function for All Access
				$this->session->set_userdata('module_function_list', json_encode($function_list));
			
				//$user_id = $user->id;
												
				$user_session['user_session']->id = $user->id;
				$user_session['user_session']->username = $user->username;
				$user_session['user_session']->email = $user->email;
				$user_session['user_session']->password = substr_replace($user->password, "********", 0, strlen($user->password));
				$user_session['user_session']->group_id = $user->group_id;
				$user_session['user_session']->status = $user->status;				
				$user_session['user_session']->last_login = $user->last_login;				
				$user_session['user_session']->logged_in = true;
				$user_session['user_session']->name = $this->UserProfiles->getName($user->id);
				
				//Set session data
				$this->session->set_userdata($user_session);
				
				//Set logged_in to true
				//$this->session->set_userdata(array('logged_in' => true));
				
				//Set logged_in to true
				//$this->session->set_userdata(array('user_id' => true));
				//print_r($this->session->userdata); exit();
				
				//Login was successful
				//return true;
				
				 redirect('admin/dashboard', 'refresh');
			} else {
				//$userObj = 'Error Submission';
				$userObj = 'No user with that account';				
				//$this->session->set_flashdata('message', $userObj);
				$this->session->set_flashdata('flashdata', $userObj);				
				$this->session->set_flashdata("error", "Sorry, your username or password is incorrect!");
				//$this->form_validation->set_message('email', 'The %s field can not be the word "test"');
				//print_r($this->session->set_flashdata('Error', $userObj)); //exit();
				//return false;
				redirect('admin/authenticate/login', 'refresh');
			}
		}
		
		$data['user']	= $this->session->userdata;
		$data['title']	= "Welcome to my first CI Login page";
		$data['main']	= 'admin/login';
		
		
		$this->load->vars($data);
		//$data['main']	= $this->load->view('users/default_user', $data, true);		
		$this->load->view('template/login_template');
	}
	function logout() {
		//Set user's last login 
		$this->Users->setLastLogin(Acl::instance()->user->id);		
        //Destroy user session		
		$this->session->unset_userdata('module_list');
		$this->session->unset_userdata('module_function_list');
		$this->session->unset_userdata('user_session');		
		$this->session->unset_userdata('user_data');
		
		//Redirect admin to refresh
		redirect('admin', 'refresh');
    }
	function edit($id = null) {
		echo "fubar";
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