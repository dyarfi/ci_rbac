<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class __admin_vote extends CI_Controller
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
		
	}
	public function vote_video()
	{
		$data['TITLE']="Vote Video";
		$data['media']=$this->media_model->get_media(1);
		$data['MENU']=$this->parser->parse('admin/menu_admin',array(),true);
		$data['FOOTER']=$this->parser->parse('admin/footer',array(),true);
		$data['NAVTOP']=$this->parser->parse('admin/navtop',array(),true);
		$this->parser->parse('admin/vote', $data);
	}
	public function vote_photo()
	{
		$data['TITLE']="Vote Photo";
		$data['media']=$this->media_model->get_media(2);
		$data['MENU']=$this->parser->parse('admin/menu_admin',array(),true);
		$data['FOOTER']=$this->parser->parse('admin/footer',array(),true);
		$data['NAVTOP']=$this->parser->parse('admin/navtop',array(),true);
		$this->parser->parse('admin/vote', $data);
	}
	public function all()
	{
		$data['TITLE']="Vote All";
		$data['media']=$this->media_model->get_media(2);
		$data['MENU']=$this->parser->parse('admin/menu_admin',array(),true);
		$data['FOOTER']=$this->parser->parse('admin/footer',array(),true);
		$data['NAVTOP']=$this->parser->parse('admin/navtop',array(),true);
		$this->parser->parse('admin/vote', $data);
	}
}
?>