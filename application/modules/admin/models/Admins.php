<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Model Class Object for Admins
class Admins extends CI_Model {
	function __construct(){
		// Call the Model constructor
		parent::__construct();
		$this->db = $this->load->database('default', true);		
	}
}