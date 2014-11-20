<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		
		$data=array();
		//$data['MENU']=$this->parser->parse('manu', $datas,true);
		//$data['FOOTER']=$this->parser->parse('footer', $datas,true);
		
		//$json_data_db = $this->gallery_model->get_all_gallery(array('status'=>'active'),TRUE);
		//$data['collection'] = $json_data_db;		
		//$this->parser->parse('home', $data);
		$this->parser->parse('welcome_message', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */