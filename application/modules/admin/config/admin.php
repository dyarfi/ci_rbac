<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


// Developers Name
$config['developer_name']	= 'Dentsu Digital Division'; 
$config['developer_url']	= 'http://dentsudigitaldivision.com/';


// Upload PATH and URL
$config['upload_path']		= BASEPATH.'uploads/users/';
$config['upload_url']		= 'uploads/users/';


// Default Admin Controller List Access and Default Admin User Access 
$config['controller_access']	= array('controller/index' => 'Controller Listing');

$config['controller_menu']		= array(
									'dashboard/index'	=> 'Dashboard Panel',
									'user/index'		=> 'User Listings',
									);

$config['controller_function']	= array(
									'dashboard/add'		=> 'Add New Dashboard',
									'dashboard/view'	=> 'View Dashboard Details',
									'dashboard/edit'	=> 'Edit Dashboard Details',
									'dashboard/delete'	=> 'Delete Dashboard',
									'user/edit'  => 'Edit User Details',
									'user/view'  => 'View User Details',
									'setting/view'	  => 'View Setting Details',
									'setting/edit'    => 'Edit Setting Details',
									'setting/delete'  => 'Delete Setting Details',
                                    );


// Controller and Action Lists
$config['controllers'] = 
	// Controller
	array(
		'dashboard' => 'Admin Dashboard',
		array(
			// Action
			'dashboard/index'	=> 'Dashboard Listing',
			'dashboard/edit'	=> 'Dashboard',
			'dashboard/change'	=> 'Dashboard Change'
		),
	array(
		'user'		=> 'User Panel',
		array(
			// Action
			'user/index'	=> 'User Listing',
			'user/add'		=> 'User Add',			
			'user/edit'		=> 'User Edit',
			'user/change'	=> 'User Change',
		),
		'user'		=> 'User Panel',
		array(
			// Action
			'user/index'	=> 'User Listing',
			'user/add'		=> 'User Add',			
			'user/edit'		=> 'User Edit',
			'user/change'	=> 'User Change',
		)
	)	
);

$config['genders']			= array(
									'male'=>'Male',
									'female'=>'Female'
								);

$config['default_page']   = ADMIN . 'user/view/{admin_id}';

/* End of file admin.php */

/* Location: ./application/modules/admin/config/admin.php */
