<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Class for Module List
class ModuleList extends Admin_Controller {
	
	public function __construct() {
		parent::__construct();
				
		//Load user related model
		$this->load->model('ModuleLists');
		$this->load->model('UserGroups');		
		$this->load->model('UserGroupPermissions');
		$this->load->model('ModulePermissions');				
		
		// Load Module List
		$this->modules			= $this->db->where('parent_id',0)->get('module_lists')->result();
		
		// Load User Group
		$this->user_group		= $this->db->where('id !=',1)->where('id !=',99)->where('status',1)->get('user_groups')->result();
		
		// Load User Group Permission
		$_user_group_permission	= $this->db->where('group_id !=',1)->where('group_id !=', 99)->get('group_permissions')->result();
				
		$buffers = array();
		foreach ($_user_group_permission as $key) {
			$buffers[$key->group_id][$key->permission_id] = $key;
		}
		
		$this->user_group_permission = $buffers;
		unset($buffers);
		
		// Load Module Permission List
		$this->db->select()->from('module_permissions')->order_by('module_link','ASC');
		// Load into objects
		$this->module_permission = $this->db->get()->result();
				
	}
	
	public function index() {		
		
		/** Table sorting **/
		$table_headers	= array('class_name' => 'Module');
		foreach($this->user_group as $row) {
			$table_headers['group_id_'.$row->id]	= ucwords($row->name);
		}
		
		/** Execute list query **/
		$listings	= $this->db->where('parent_id',0)->order_by('id','ASC')->get('module_lists')->result();
		
		$total_rows	= count($listings);				
		
		/** Views **/
		$data['user_group']				= $this->user_group;
		$data['module_permission']		= $this->module_permission;
		$data['user_group_permission']	= $this->user_group_permission;
		$data['listings']				= $listings;
		
		$data['table_headers']			= $table_headers;
		
		$data['statuses']	= array('Active'=>'active','Inactive'=>'inactive');
		$data['main']		= 'users/module_list';
		
		// Set admin title page with module menu
		$data['page_title'] = $this->module_menu;
		
		$this->load->view('template/admin/admin_template', $data);
				
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