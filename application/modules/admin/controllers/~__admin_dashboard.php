<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class __admin_dashboard extends CI_Controller
{
	public function __construct()
       {
            parent::__construct();
            // Your own constructor code
			security_check_login();
       }
	
	public function index()
	{
		//echo "masuk";
		$data['FOOTER']=$this->parser->parse('admin/footer',array(),true);
		$data['NAVTOP']=$this->parser->parse('admin/navtop',array(),true);
		$data['MENU']=$this->parser->parse('admin/menu_admin',array('gallery'=>'Gallery'),true);
		$this->parser->parse('admin/dashboard', $data);
	}
	
}
?>