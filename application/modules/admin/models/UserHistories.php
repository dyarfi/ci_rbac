<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Model Class Object for Modulel Permission
class UserHistories Extends CI_Model {
	
	public $table = 'tbl_user_histories';
		
	public function __construct(){
		// Call the Model constructor
		parent::__construct();
				
		$this->db = $this->load->database('default', true);		
				
	}
		
	public function install () {
		$insert_data	= FALSE;

		if (!$this->db->table_exists($this->table)) 
                $insert_data	= TRUE;
                
                $sql            = 'CREATE TABLE IF NOT EXISTS `'.$this->table.'` ('
                                    . '`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,'
                                    . '`module` VARCHAR(24) NOT NULL, '
                                    . '`user_id` INT(11) UNSIGNED NOT NULL, '
                                    . '`controller` VARCHAR(160) NOT NULL, '
                                    . '`action` CHAR(20), '
                                    . '`time` INT(11) UNSIGNED NOT NULL, '
                                    . 'INDEX (`id`, `module`,`user_id`) '
                                    . ') ENGINE=MYISAM';

		$this->db->query($sql);

		if ($insert_data) {
			$sql	= 'INSERT INTO `'.$this->table.'` '
					. '(`id`, `module`, `user_id`, `controller`, `action`, `time`) '
					. 'VALUES '
					. '(NULL, \'user\', \'1\', \'history\', \'index\', '.time().'), '
					. '(NULL, \'user\', \'1\', \'history\', \'index\', '.time().')';

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
			$object			= new UserHistories;

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
}