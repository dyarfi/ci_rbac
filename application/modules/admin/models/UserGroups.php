<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Model Class Object for User Group
class UserGroups Extends CI_Model {
	
	public $table = 'tbl_user_groups'; 
	
	public function __contstruct() {
		// Call the Model constructor
		parent::__construct();
				
		$this->load->model('Users');
		
	}
	public function install () {
		$insert_data		= FALSE;
		
		if (!$this->db->table_exists($this->table)) {
			$insert_data	= TRUE;

			$sql	= 'CREATE TABLE IF NOT EXISTS `'. $this->table .'` ('
					. '`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, '
					. '`name` VARCHAR(32) NOT NULL, '
					. '`backend_access` TINYINT(1) NULL, '
					. '`full_backend_access` TINYINT(1) NULL, '
					. '`status` TINYINT(1) NOT NULL, '
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
					. '(1 , \'Super Administrator\', \'1\', \'1\', \'1\', \'1\', '.time().' , 0), '
					. '(2 , \'Administrator\', \'1\', \'0\', \'1\', \'1\', '.time().' , 0), '
					. '(99 , \'User\', \'0\', \'0\', \'1\', \'1\', '.time().' , 0)';

			$this->db->query($sql);
		}
		
		return $this->db->table_exists($this->table);
	}
	public function find ($where_cond = '', $order_by = '', $limit = '', $offset = '') {
		/** Build where query **/

		if ($where_cond != '') {
			if (is_array($where_cond) && count($where_cond) != 0) {
				$buffers	= array();

				$operators	= array('LIKE',
									'IN',
									'!=',
									'>=',
									'<=',
									'>',
									'<',
									'=');
                                
				foreach ($where_cond as $field => $value) {
					$operator	= '=';

					if (strpos($field, ' ') != 0)
						list($field, $operator)	= explode(' ', $field);

					if (in_array($operator, $operators)) {
						$field		= '`'.$field.'`';

						if ($operator == 'IN' && is_array($value))
							$buffers[]	= $field.' '.$operator.' (\''.implode('\', \'', $value).'\')';
						else
							$buffers[]	= $field.' '.$operator.' \''.$value.'\'';
					} else if (is_numeric($field)) {
						$buffers[]	= $value;
					} else {
						$buffers[]	= $field.' '.$operator.' \''.$value.'\'';
					}
				}                
				$where_cond	= implode(' AND ', $buffers);                   
			}
		}

		$sql_order = ''; 
		if ($order_by != '') {
			$sql_order = ' ORDER BY '; 
			$i 	   = 1;
			foreach ($order_by as $order => $val) {
				$split = ($i > 1) ? ', ' : ''; 
				$sql_order .= ' '. $split .' `'. $order.'` '.$val.' ';
				$i++;
			}
			$order_by  = $sql_order;
		}
		
		$sql_limit = ''; 
		if ($limit != '' && $offset != '') {
			$offset    = $offset . ','; 
			$sql_limit = 'LIMIT '. $offset . $limit; 
		}
		else if ($limit != '') {
			$sql_limit = 'LIMIT '. $limit; 
		}
		$limit = $sql_limit;
		
		if ($where_cond != '') {
			$rows = $this->db->query('SELECT * FROM `'.$this->table.'` WHERE '. $where_cond . $order_by . $limit, TRUE)->result();
		}
		else {
			$rows = $this->db->query('SELECT * FROM `'.$this->table.'`' . $order_by . $limit, TRUE)->result();
		}

		$returns	= array();
                
		foreach ($rows as $row) {
			$object			= new UserGroups;

			$object_vars	= get_object_vars($row);
			
			foreach ($object_vars as $var => $val) {
				$object->$var	= $val;
			}

			unset($object->table,$object->_model_vars,$object->db);

			$returns[]		= $object;

			unset($object, $vars);
		}
				
		return $returns;
	}
	
	public function getUserGroup($id = null){
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
	
	public function getAllUserGroup(){
		$data = array();
		$this->db->order_by('added');
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
	
	public function getGroupName_ById($id = null){
		$data = '';
		$options = array('id' => $id);
		$Q = $this->db->get_where('user_groups',$options,1);
		
		if ($Q->num_rows() > 0){
			foreach ($Q->result_object() as $row)
				$data = $row->name;
		}
		$Q->free_result();
		return $data;
	}
	
	public function setUserGroup($object=null){
				
		$data = array(
		'name' => $object['name'],
		'backend_access' => @$object['backend_access'],	
		'full_backend_access' => @$object['full_backend_access'],			
		'status' => $object['status']
		);
		
		$this->db->insert('user_groups', $data);
		
	}
	
	public function updateUserGroup($object=null){
		$data = array(
		'name' => $object['name'],
		'backend_access' => @$object['backend_access'],	
		'full_backend_access' => @$object['full_backend_access'],			
		'status' => $object['status'],
		'id' => $object['id']
		);
		$this->db->where('id', $object['id']);
		return $this->db->update('user_groups', $data);
	}
	
	public function deleteUserGroup($id){
		$this->db->where('id', $id);
		return $this->db->delete('user_groups');
	}
}
?>
