<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Model Class Object for Model lists
class ModelLists Extends CI_Model {
	
	protected $table = 'tbl_model_lists';
	
	function __construct(){
		// Call the Model constructor
		parent::__construct();
		
		$this->load->dbforge();
		
		$this->db = $this->load->database('default', true);		
		
	}
	
	function install () {
		$insert_data		= FALSE;

		if (!$this->db->table_exists($this->table)) {
			$insert_data	= TRUE;

			$sql	= 'CREATE TABLE IF NOT EXISTS `'.$this->table.'` ('
					. '`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,'
					. '`module_id` INT(11) NOT NULL,'
					. '`model` VARCHAR(255) NOT NULL, '
					. 'INDEX (`id`) '
					. ') ENGINE=MYISAM';
	
			$this->db->query($sql);
		}
		
		return $this->db->table_exists($this->table);
	}

}