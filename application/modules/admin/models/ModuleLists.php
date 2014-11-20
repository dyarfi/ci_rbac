<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Model Class Object for Model lists
class ModuleLists Extends CI_Model {
	
	protected $table = 'tbl_module_lists';

	function __construct(){
		// Call the Model constructor
		parent::__construct();		
		
		$this->db = $this->load->database('default', true);		
		
	}
	
	function install () {
		$insert_data	= FALSE;

		if (!$this->db->table_exists($this->table)) {
			$insert_data	= TRUE;

			$sql	= 'CREATE TABLE IF NOT EXISTS `'. $this->table .'` ('
					. '`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,'
					. '`parent_id` INT(11) NOT NULL,'
					. '`module_name` VARCHAR(255) NOT NULL, '
					. '`module_link` VARCHAR(255) default NULL, '
					. '`order` INT(11) NOT NULL,'
					. 'INDEX (`id`) '
					. ') ENGINE=MYISAM';
	
			$this->db->query($sql);
		}
		
        return $this->db->table_exists($this->table);
	}

}