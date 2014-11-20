<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class __admin_login extends CI_Controller
{
	
	
	public function index()
	{
		//echo "masuk";
		//$this->parser->parse('admin/login',array());
		$this->parser->parse('admin/login', array());
	}
	public function action()
	{
		$user_name=$this->input->post('username');
		$password=$this->input->post('password');
		$admin=$this->login_model_admin->login_act($user_name,$password);
		//echo $admin[0]['user_name'];exit;
		if((count($admin)!=0))
		{
			$this->session->set_userdata('user_name', $admin[0]['user_name']);
			redirect('__admin_dashboard');
		}else
		{
			redirect('__admin_login/relogin');
		}
		
	}
	public function logout()
	{
		user_logout();
	}
}
?>