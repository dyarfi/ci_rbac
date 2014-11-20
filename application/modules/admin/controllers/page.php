<?php
class Pages extends CI_Controller {
	var $userdata = '';
	var $auth_message = '';
	function __construct() {
		parent::__construct();
		//Load user permission
		$this->load->model('UserPermissions');
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
		$permission = new UserPermissions();
		//$permission->getUserGroupPermissions($this->userdata['group_id']);
		//$permission->setUserGroupPages($pages,$allowed_groups);

		//Debugging user session variable
		//print_r($this->session->userdata('user_session')); exit();
		//$this->session->sess_destroy('user_session');
		
		//Debugging cart session variable
		//print_r($this->cart->contents()); exit();
		//$this->cart->destroy();
		
		$this->tinyMce = '
						<!-- TinyMCE -->
						<script type="text/javascript" src="'.base_url().'js/tiny_mce/tiny_mce.js"></script>
						<script type="text/javascript">
						tinyMCE.init({
						// General options
							mode : "textareas", theme : "simple"
						});
						</script>
						<!-- /TinyMCE -->
						';

		//Set authentication message if exists
		$this->auth_message = ($this->session->flashdata('auth_message')) ? $this->session->flashdata('auth_message') : '';
		$data['auth_message'] = $this->auth_message;

		// Load product configuration
		$this->config->load('products');
	} 
	function index(){
		$data['title'] = "Manage Pages";
		$data['main'] = 'admin/admin_pages_home';
		$data['pages'] = $this->Pages->getAllPages();
		$this->load->vars($data);
		//$this->load->view('dashboard');
		$this->load->view('template/admin_template');
	}
	function create(){
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
			$this->MPages->addPage();
			$this->session->set_flashdata('message','Page created');
			redirect('admin/pages/index','refresh');
		}else{
			$data['title'] = "Create Page";
			$data['main'] = 'admin/admin_pages_create';
			$this->load->vars($data);
			//$this->load->view('dashboard');
			$this->load->view('template/admin_template');
		}
	}
	function edit($id=0){
		if ($this->input->post('name')){
			$this->MPages->updatePage();
			$this->session->set_flashdata('message','Page updated');
			redirect('admin/pages/index','refresh');
		}else{
			$data['title'] = "Edit Page";
			$data['main'] = 'admin/admin_pages_edit';
			$data['page'] = $this->MPages->getPage($id);
			$this->load->vars($data);
			//$this->load->view('dashboard');
			$this->load->view('template/admin_template');
		}
	}
	function delete($id){
		$this->MPages->deletePage($id);
		$this->session->set_flashdata('message','Page deleted');
		redirect('admin/pages/index','refresh');
	}
} // end class
