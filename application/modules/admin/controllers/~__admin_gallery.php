<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class __admin_gallery extends CI_Controller
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
		security_check_login();
		$data['TITLE']="List Media";
		$data['media']=$this->gallery_model->get_all_gallery();
		$data['FOOTER']=$this->parser->parse('admin/footer',array(),true);
		$data['NAVTOP']=$this->parser->parse('admin/navtop',array(),true);
		$data['MENU']=$this->parser->parse('admin/menu_admin',array(),true);
		$this->parser->parse('admin/gallery_list', $data);
	}
	public function delete()
	{
		$original_id = $this->uri->segment(3);
		$url_fb = 'http://client.nolimitid.com/api.lalights/facebook/deleteStream/';
		$url_tw = 'http://client.nolimitid.com/api.lalights/twitter/deleteStream/';
		
		//twitter/deleteStream
		
		//$deletefb = Curl::post($params);
		//$deletefb = Curl::post($params);		
		
		//$this->db->delete('tbl_media_std', array('id' => $id)); 
		
		$data = array(
               'status' => 'inactive',
            );

		$this->db->where('original_id', $original_id);
		$this->db->update('tbl_gallery_std', $data); 
		
		redirect('__admin_gallery/deleted_succes');
	}
}
?>