<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Developers Name
$config['developer_name']	= 'Dentsu Digital Division'; 
$config['developer_url']	= 'http://dentsudigitaldivision.com/';

// Upload PATH and URL
$config['upload_path']		= BASEPATH.'uploads/users/';
$config['upload_url']		= 'uploads/users/';

$config['gender']			= array('male'=>'Male','female'=>'Female');
$config['status']			= array(1=>'Active',0=>'Inactive');


$config['default_page']   = ADMIN . 'user/view/{admin_id}';

/* End of file admin.php */

/* Location: ./application/modules/admin/config/admin.php */