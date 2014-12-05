<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

									
/* MODULE MENU 
 * 
 * Current MENU is only set to user and and setting
 * Accessed by administrators only
 */

// Module Menu List
$config['admin_list.module_menu']	= array(
						'userhistory/index'	=> 'User History Listings',
						'dashboard/index'	=> 'Dashboard Panel',
						'user/index'		=> 'User Listings',
						'usergroup/index'	=> 'User Group Listings',			
						'modulelist/index'	=> 'Module Listing'	
					);
									
/* MODULE FUNCTION
 * 
 * Current FUNCTION is only set to user and and setting
 * Accessed by administrators only
 */

// Module Function Menu List
$config['admin_list.module_function']	= array(							
												'dashboard/add'		=> 'Add New Dashboard',
												'dashboard/view'	=> 'View Dashboard Details',
												'dashboard/edit'	=> 'Edit Dashboard Details',
												'dashboard/delete'	=> 'Delete Dashboard',			
												'modulelist/edit'	=> 'Edit Module Details'
										);

$config['module_list.models']			= array('ModuleLists');
$config['module_list.module_menu']		= array('modulelist/index' => 'Module Listing');
$config['module_list.module_function']	= array('modulelist/edit' => 'Edit Module Details');

// Default modules
$config['modulelist'] = array(
	
	// Admin module
	'Admin' => array(
		// Admin Model list
		'models'		=> array(
							'Users',
							'UserGroups',
							'UserProfiles',
							'UserHistories',
							'ModulePermissions'
						),
		// Admin module menu
		'module_menu'	=> array(
							'dashboard/index'	=> 'Dashboard Panel',
							'user/index'		=> 'User Listings',
							'usergroup/index'	=> 'User Group Listings',
						),
		// Admin module function
		'module_function'	=> array(
							'dashboard/add'		=> 'Add New Dashboard',
							'dashboard/view'	=> 'View Dashboard Details',
							'dashboard/edit'	=> 'Edit Dashboard Details',
							'dashboard/delete'	=> 'Delete Dashboard',
							'user/add'			=> 'Add User Details',
							'user/view'			=> 'View User Details',
							'user/edit'			=> 'Edit User Details',
							'user/delete'		=> 'Delete User Details',
							'usergroup/add'		=> 'Add User Group Details',
							'usergroup/view'	=> 'View User Group Details',
							'usergroup/edit'	=> 'Edit User Group Details',
							'usergroup/delete'	=> 'Delete User Group Details',		
							)
	),
	
	// Page module
	'Page' => array (
		// Page Model list
		'models'			=> array('Pages','PageMenus'),
		// Page module menu
		'module_menu'		=> array('page/index'	=> 'Page Listings'),
		// Page module function
		'module_function'	=> array(
									'page/view'		=> 'Add Page Details',									
									'page/view'		=> 'View Page Details',
									'page/edit'		=> 'Edit Page Details',
									'page/delete'	=> 'Delete Page Details',
                                    ),
	),
	
	// Setting module
	'Setting' => array (
		// Setting model list
		'models'			=> array('Settings'),
		// Setting module menu
		'module_menu'		=> array('setting/index'	=> 'Setting Listings'),
		// Setting module function
		'module_function'	=> array(
									'setting/add'	  => 'Add Setting Details',
									'setting/view'	  => 'View Setting Details',
									'setting/edit'    => 'Edit Setting Details',
									'setting/delete'  => 'Delete Setting Details',
									)
	)
);

/* End of file modules.php */
/* Location: ./application/config/modules.php */