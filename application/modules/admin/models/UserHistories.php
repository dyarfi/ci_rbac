<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Model Class Object for Modulel Permission
class UserHistories Extends CI_Model {
	
	protected $table = 'tbl_user_histories';
		
	function __construct(){
		// Call the Model constructor
		parent::__construct();
				
		$this->db = $this->load->database('default', true);		
				
	}
		
	function install () {
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

}