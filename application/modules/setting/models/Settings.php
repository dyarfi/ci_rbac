<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Model Class Object for Settings
class Settings Extends CI_Model {
	
	protected $table = 'tbl_settings';
	
	public function __construct(){
		// Call the Model constructor
		parent::__construct();
		
		$this->db = $this->load->database('default', true);		
				
	}
	
	public function install() {
		
		$insert_data	= FALSE;

		if (!$this->db->table_exists($this->table)) 
                $insert_data	= TRUE;
                
               	$sql	= 'CREATE TABLE IF NOT EXISTS `'.$this->table.'` ('
					. '`id` int(11) unsigned NOT NULL AUTO_INCREMENT,'
					. '`parameter` varchar(255) DEFAULT NULL,'
					. '`alias` varchar(255) DEFAULT NULL,'
					. '`value` varchar(255) DEFAULT NULL,'
					. '`is_system` tinyint(1) DEFAULT 1,'
					. '`status` tinyint(1) DEFAULT 1,'
					. '`added` int(11) DEFAULT NULL,'
					. '`modified` int(11) DEFAULT NULL,'
					. 'PRIMARY KEY (`id`),'
					. 'KEY `name` (`parameter`,`status`)'
					. ') ENGINE=MyISAM DEFAULT CHARSET=latin1';
				
				
		$this->db->query($sql);
		
        if(!$this->db->query('SELECT * FROM `'.$this->table.'` LIMIT 0 , 1;'))
			$insert_data	= TRUE;
		
		if ($insert_data) {
			$sql	= 'INSERT INTO `'.$this->table.'` (`id`, `parameter`, `alias`, `value`, `status`, `added`, `modified`) VALUES '
						.'(1, \'email_marketing\', \'Email Marketing\', \'marketing@\', \'1\', 1334835773, NULL), '
						.'(2, \'email_administrator\', \'Email Administrator\', \'administrator@\', \'1\', 1334835773, 1336122482), '
						.'(3, \'email_hrd\', \'Email HRD\', \'hrd@\', \'1\', 1334835773, NULL), '
						.'(4, \'email_info\', \'Email Info\', \'info@\', \'1\', 1334835773, NULL), '
						.'(5, \'email_template\', \'Email Template\', \'&dash;\', \'1\', 1334835773, NULL), '					
						.'(6, \'maintenance_template\', \'Maintenance Mode Template\', \'<h2>The site is off for <span><h1>MAINTENANCE</h1></span></h2>\', \'1\', 1334835773, NULL), '						
						.'(7, \'contactus_address\', \'Contact Address\', \'&dash;\', \'1\', 1334835773, NULL), '
						.'(8, \'contactus_gmap\', \'GMaps Location\', \'http://maps.google.com/maps?q=-6.217668,106.812992&num=1&t=m&z=18\', \'1\', 1334835773, NULL), '
						.'(9, \'no_phone\', \'Number Phone\', \'(021) 522.3715\', \'1\', 1334835773, NULL), '
						.'(10, \'no_fax\',  \'Number Fax\', \'(021) 522.3718\', \'1\', 1334835773, NULL), '
						.'(11, \'title_default\', \'Website Title Default\', \'We build on solid foundation, effective, construction and visual appeal\', \'1\', NULL, NULL), '
						.'(12, \'title_name\', \'Company Title Name\', \'PT. Default (Web Agency in Jakarta)\', \'1\', NULL, 1336118568), '	
						.'(13, \'language\', \'Default Language\', \'en\', \'1\', NULL, 1336118568), '	
						.'(14, \'counter\', \'Site Counter\', \'123\', \'1\', NULL, 1336118568), '
						.'(15, \'copyright\', \'Copyright\', \'© 2012 COMPANY NAME COPYRIGHT. All Rights Reserved.\', \'1\', NULL, 1336118568), '
						.'(16, \'site_name\', \'Site Name\', \' Default <br/> PT. Default (Web Agency in Jakarta).\', \'1\', NULL, 1336118568), '
						.'(17, \'site_quote\', \'Quote\', \'We provide solution for your Websites\', \'1\', NULL, 1336118568), '
						.'(18, \'site_description\', \'Website Description\', \'We provide solution for your Company Website \', \'1\', NULL, 1336118568), '						
						.'(19, \'socmed_facebook\', \'Facebook\', \'http://facebook.com\', \'1\', NULL, 1336118568), '
						.'(20, \'socmed_twitter\', \'Twitter\', \'http://twitter.com\', \'1\', NULL, 1336118568), '
						.'(21, \'socmed_gplus\', \'Google Plus\', \'http://plus.google.com\', \'1\', NULL, 1336118568), '
						.'(22, \'socmed_linkedin\', \'LinkedIn\', \'http://linkedin.com\', \'1\', NULL, 1336118568), '
						.'(23, \'socmed_pinterest\', \'Pinterest\', \'http://pinterest.com\', \'1\', NULL, 1336118568), '
						.'(24, \'registered_mark\', \'Registered\', \'We provide solution for your Websites\', \'1\', NULL, 1336118568),'
						.'(25, \'google_analytics\', \'Analytics\', \'Code Snippet\', \'1\', NULL, 1336118568), '
						.'(26, \'ext_link\', \'Ext Link\', \'http://www.apb-career.net\', \'1\', NULL, 1336118568);';

			$this->db->query($sql);
		}

		return $this->db->table_exists($this->table);
		
	}
	public function getCount($status = null){
		$data = array();
		$options = array('status' => $status);
		$this->db->where($options,1);
		$this->db->from($this->table);
		$data = $this->db->count_all_results();
		return $data;
	}
	public function getSetting($id = null){
		if(!empty($id)){
			$data = array();
			$options = array('id' => $id);
			$Q = $this->db->get_where($this->table,$options,1);
			if ($Q->num_rows() > 0){
				foreach ($Q->result_object() as $row)
				$data = $row;
			}
			$Q->free_result();
			return $data;
		}
	}
	public function getByParameter($param = null){
		if(!empty($param)){
			$data = array();
			$options = array('parameter' => $email);
			$Q = $this->db->get_where($this->table,$options,1);
			if ($Q->num_rows() > 0){
				foreach ($Q->result_object() as $row)
				$data = $row;
			}
			$Q->free_result();
			return $data;
		}
	}
	public function getAllSetting($admin=null){
		$data = array();
		$this->db->order_by('added');
		$Q = $this->db->get($this->table);
			if ($Q->num_rows() > 0){
				//foreach ($Q->result_object() as $row){
					//$data[] = $row;
				//}
				$data = $Q->result_object();
			}
		$Q->free_result();
		return $data;
	}
	public function setSetting($object=null){
		
		// Set User data
		$data = array(			
					'parameter' => $object['username'],
					'alias' => $object['alias'],
					'value' => $object['value'],
					'is_system' => $object['is_system'],
					'added'		=> time(),	
					'status' => $object['status']
				);
		
		// Insert User data
		$this->db->insert($this->table, $data);
		
		// Return last insert id primary
		$insert_id = $this->db->insert_id();					
			
		// Return last insert id primary
		return $insert_id;
		
	}	
	public function deleteSetting($id) {
		
		// Check Setting id
		$this->db->where('id', $id);
		
		// Delete setting form database
		return $this->db->delete($this->table);
		
	}	
}
