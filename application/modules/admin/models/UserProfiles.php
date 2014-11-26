<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Model Class Object for Users
class UserProfiles Extends CI_Model {
	
	protected $table = 'tbl_user_profiles';
	
	function __construct() {
		// Call the Model constructor
		parent::__construct();
		
		$this->db = $this->load->database('default', true);		
	}
	function install(){
		$insert_data		= FALSE;

		if (!$this->db->table_exists($this->table)) {
			$insert_data	= TRUE;

		$sql	= 'CREATE TABLE IF NOT EXISTS `'.$this->table.'` ('
				. '`user_id` INT(11) UNSIGNED NOT NULL,'
				. '`gender` ENUM(\'male\',\'female\') NOT NULL DEFAULT \'male\', '
				. '`about` TEXT NULL, '
				. '`first_name` VARCHAR(64) NULL, '
				. '`last_name` VARCHAR(64) NULL, '
				. '`division` VARCHAR(64) NULL, '
				. '`country` VARCHAR(64) NULL, '
				. '`state` VARCHAR(64) NULL, '
				. '`city` VARCHAR(128) NULL, '
				. '`address` TEXT NULL, '
				. '`postal_code` VARCHAR(8) NULL, '
				. '`birthday` DATE, '
				. '`phone` VARCHAR(16) NULL, '
				. '`mobile_phone` VARCHAR(16) NULL, '
				. '`fax` VARCHAR(16) NULL, '
				. '`website` VARCHAR(255) NULL, '
				. '`file_type` VARCHAR(64) NULL, '
				. '`file_name` VARCHAR(48) NULL, '
				. '`status` INT(1) UNSIGNED NOT NULL,'
				. '`added` INT(11) UNSIGNED NOT NULL, '
				. '`modified` INT(11) UNSIGNED NOT NULL, '
				. 'INDEX (`user_id`, `phone`) '
				. ') ENGINE=MYISAM';
	
			$this->db->query($sql);
		}

        if(!$this->db->query('SELECT * FROM `'.$this->table.'` LIMIT 0 , 1;'))
			$insert_data	= TRUE;
        
		if ($insert_data) {			
			$sql = 'INSERT INTO `'. $this->table .'` VALUES '
					.'(\'1\', \'male\', \'Superadmin of this Website\', \'\',\'\', \'Web Programmer\', \'DKI Jakarta\', \'Jakarta\', \'Jl. Gading Putih 1 F2 No. 4\', \'14240\', \'\', \'2010/09/06\', \'1234\', \'\', \'0\', \'-\', \'image/jpeg\', \'78d57b4b5a0c6048b75bb0c9d91a8392.jpg\', \'1\', \'1283760138\', \'1283831030\'), '

					.'(\'2\', \'male\', \'Administrator of this Website\', \'\',\'\', \'Web Designer\', \'DKI Jakarta\', \'Jakarta\', \'Jl. Gading Putih 1 F2 No. 4\', \'14240\', \'\', \'2010/09/06\', \'1234\', \'\', \'0\', \'-\', \'image/jpeg\', \'78d57b4b5a0c6048b75bb0c9d91a8392.jpg\', \'1\', \'1283760138\', \'1283831030\'), '
					.'(\'3\', \'male\', \'User of this Website\', \'\',\'\', \'Jakarta\', \'\', \'\', \'Jl. Pulomas Barat 1 No. 31\', \'\', \'\', \'0000/00/00\', \'1234\', \'\', \'\', \'\', \'image/jpeg\', \'a8a484572c007e1e17648ae2c7ad629c.jpg\', \'1\', \'1285152397\', \'0\'), '
					.'(\'4\', \'male\', \'\', \'\', \'Jakarta\', \'\',\'\', \'\', \'Jl. Pulomas Barat 1 No. 31\', \'\', \'\', \'0000/00/00\', \'081807244697\', \'\', \'\', \'\', \'image/jpeg\', \'eb068fc7204f01f8cd25375b42fc6953.jpg\', \'1\', \'1285152397\', \'1326110970\'), '
					.'(\'5\', \'male\', \'\', \'\', \'mimipopo\', \'\',\'\', \'\', \'Jl. Pulomas Barat 1 No. 31\', \'\', \'\', \'0000/00/00\', \'081807244697\', \'\', \'\', \'\', \'image/jpeg\', \'eb068fc7204f01f8cd25375b42fc6953.jpg\', \'1\', \'1285152397\', \'1326110970\'), '
					.'(\'111\', \'male\', \'\', \'Web Developer\', \'\', \'\',\'\', \'\', \'\', \'\', \'\', \'0000/00/00\', \'\', \'\', \'\', \'\', \'\', \'\', \'1\', \'1333442128\', \'1333442192\'), '
					.'(\'110\', \'male\', \'\', \'Web Developer\', \'\',\'\', \'\', \'\', \'\', \'\', \'\', \'0000/00/00\', \'\', \'\', \'\', \'\', \'\', \'\', \'1\', \'1333441986\', \'1333442058\');';
			
			
			$this->db->query($sql);
		}
		
		return $this->db->table_exists($this->table);
	}
	function getUserProfile($id=''){
		if(!empty($id)) {
			$data = array();
			$options = array('user_id' => $id);
			$Q = $this->db->get_where('user_profiles',$options,1);
			if ($Q->num_rows() > 0){
				foreach ($Q->result_object() as $row)
				$data = $row;
			}
			$Q->free_result();
			return $data;
		}
	}	
	function getName($id=''){
		if(!empty($id)) {
			$data = array();
			$options = array('user_id' => $id);
			$Q = $this->db->get_where('user_profiles',$options,1);
			if ($Q->num_rows() > 0){
				foreach ($Q->result_object() as $row) {
					$data = ucfirst($row->first_name).' '.ucfirst($row->last_name);
				}
			}
			$Q->free_result();
			return $data;
		}
	}
	function setUserProfiles($profile=''){
		if (!empty($profile)) {
			$this->db->where('user_id', $profile['user_id']);		
			$this->db->update($this->table, $profile);
			return $this->getUserProfile($profile['user_id']);			
		}		
	}
	
	
}
?>
