<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Model Class Object for User Group
class UserGroups Extends CI_Model {
	
	protected $table = 'tbl_user_groups'; 
	
	function __contstruct() {
		// Call the Model constructor
		parent::__construct();
				
		$this->load->model('Users');
		
	}
	function install () {
		$insert_data		= FALSE;
		
		if (!$this->db->table_exists($this->table)) {
			$insert_data	= TRUE;

			$sql	= 'CREATE TABLE IF NOT EXISTS `'. $this->table .'` ('
					. '`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, '
					. '`name` VARCHAR(32) NOT NULL, '
					. '`backend_access` TINYINT(1) NOT NULL, '
					. '`full_backend_access` TINYINT(1) NOT NULL, '
					. '`status` ENUM(\'enable\', \'disable\', \'deleted\') NOT NULL, '
					. '`is_system` TINYINT(1) NOT NULL DEFAULT 0, '
					. '`added` INT(11) UNSIGNED NOT NULL, '
					. '`modified` INT(11) UNSIGNED NOT NULL, '
					. 'PRIMARY KEY (`id`), '
					. 'KEY `parent_id` (`status`) '
					. ') ENGINE=MYISAM ';
	
			$this->db->query($sql);
		}

        if(!$this->db->query('SELECT * FROM `'.$this->table.'` LIMIT 0 , 1;')) {
			$insert_data	= TRUE;
		}
        
		if ($insert_data) {
			$sql	= 'INSERT INTO `'. $this->table .'` '
					. '(`id`, `name`, `backend_access`, `full_backend_access`, `status`, `is_system`, `added`, `modified`) '
					. 'VALUES '
					. '(1 , \'super administrator\', \'1\', \'1\', \'enable\', \'1\', '.time().' , 0), '
					. '(2 , \'administrator\', \'1\', \'0\', \'enable\', \'1\', '.time().' , 0), '
					. '(99 , \'user\', \'0\', \'0\', \'enable\', \'1\', '.time().' , 0)';

			$this->db->query($sql);
		}
		
		return $this->db->table_exists($this->table);
	}
	function getUserGroup($id = null){
		if(!empty($id)) {
			$data = array();
			$options = array('id' => $id);
			$Q = $this->db->get_where('user_groups',$options,1);
			if ($Q->num_rows() > 0){
				foreach ($Q->result_object() as $row)
				$data = $row;
			}
			$Q->free_result();
			return $data;
		}
	}
	function getAllUserGroup(){
		$data = array();
		$Q = $this->db->get('user_groups');
			if ($Q->num_rows() > 0){
				//foreach ($Q->result_array() as $row){
					//$data[] = $row;
				//}
				$data = $Q->result_object();
			}
		$Q->free_result();
		return $data;
	}
	function getGroupName_ById($id = null){
		$data = array();
		$options = array('id' => $id);
		$Q = $this->db->get_where('user_groups',$options,1);
		
		if ($Q->num_rows() > 0){
			foreach ($Q->result_object() as $row)
				$data = $row->name;
		}
		$Q->free_result();
	return $data;
	}
	function setUserGroup($object=null){}
}
?>