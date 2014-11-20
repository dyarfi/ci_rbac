<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Model Class Object for Configurations
class Configurations Extends CI_Model {
	
	protected $table = 'tbl_configurations';
	
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
					. '`parameter` VARCHAR(150) NOT NULL DEFAULT \'\', '
					. '`value` VARCHAR(150) NOT NULL DEFAULT \'\', '
					. 'PRIMARY KEY (`parameter`, `value`) '
					. ') ENGINE=MYISAM';

			$this->db->query($sql);
		}
		
		if ($insert_data) {
			$sql	= 'INSERT INTO `'.$this->table.'` '
					. '(`parameter`, `value`) '
					. 'VALUES '
					. '(\'install\', \'0\'),'
					. '(\'maintenance\', \'0\'),'
					. '(\'environment\', \'0\'),'
					. '(\'theme\', \'0\')';

			$this->db->query($sql);
		}

		return $this->db->table_exists($this->table);
	}

}