<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Model Class Object for Model lists
class ModuleLists Extends CI_Model {
	
	protected $table = 'tbl_module_lists';

	function __construct(){
		// Call the Model constructor
		parent::__construct();		
		
		$this->db = $this->load->database('default', true);		
		
	}
	
	public function install () {
		$insert_data	= FALSE;

		if (!$this->db->table_exists($this->table)) {
			$insert_data	= TRUE;

			$sql	= 'CREATE TABLE IF NOT EXISTS `'. $this->table .'` ('
					. '`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,'
					. '`parent_id` INT(11) NOT NULL,'
					. '`module_name` VARCHAR(255) NOT NULL, '
					. '`module_link` VARCHAR(255) default NULL, '
					. '`order` INT(11) NOT NULL,'
					. 'INDEX (`id`) '
					. ') ENGINE=MYISAM';
	
			$this->db->query($sql);
		}
		
        return $this->db->table_exists($this->table);
	}
	
	public function module_check () {
		$modules	= array();
		
		/*
		// List all custom modules
		foreach (Kohana::modules() as $row) {
			$module_app			= strstr($row, MODPATH . APPMOD);
			$module				= str_replace(MODPATH . APPMOD, '', $module_app);
			$class_name			= str_replace(DS, '', $module);
			$config_module[]	= $class_name;
		}
		*/
		
		// List all custom modules		
		$directory[] = Modules::lists('./application/modules');
		
		// Loop to get module name			
		foreach ($directory as $row) {
			$config_module = array_keys($row);
		}
		/*
		// Check config module
		if(is_array($config_module) && count($config_module) > 0) {			
							
			// List DB module
			$module_list	= array();
			$where_cond		= array('parent_id'		=> 0);
			$module_db		= $this->find($where_cond);
			
			$user_levels	= Model_UserLevel::instance()->find();
			
			$buffers		= array();
			if(is_array($module_db) && count($module_db) != 0) {
				foreach($module_db as $module) {
					//$buffers[$module->id]	= $module->module_name;
					$buffers[$module->id]	= str_replace(' ', '_', $module->module_name);
				}
				
				$module_list	= $buffers;
				unset($buffers);
			}			
			
			$new_module_perm_idx = '';
			$new_module_perm_fnc = '';
			
			foreach($config_module as $row) {

				// Check Module Revoke Access							
				$revoke	= Lib::config($row.'.revoke');

				if ($revoke) {
					// Find module id
					$revoke_ids = $this->find(array('module_name'=>$row));

					// Check if empty
					if (!empty($revoke_ids) && is_array($revoke_ids)) {

						// Loop through ids
						foreach ($revoke_ids as $ids) {		

							//print_r($ids);
							//exit;
							// Find module_permission with module_id
							$permission_id = Model_ModulePermission::instance()->find(array('module_id'=>$ids->id));

							// Looping through permission
							foreach ($permission_id as $perm_id) {								
								// Deleted User Permission
								Model_UserLevelPermission::instance()->delete_by_permission_id($perm_id->id);
							}		

							// Deleted Permission
							Model_ModulePermission::instance()->delete_by_module_id($ids->id);

							// Deleted Module					
							$this->delete($ids->id);

							// Deleted Child Module					
							$this->delete_by_parent_id($ids->id);
						}
					} 
				}

				// Mark for main site modules to not included
				if($row	!= 'site' && !empty($row)) {
					
					// Check new module and install it	
					if(!in_array($row, $module_list)) {
						if (is_file(MODPATH . APPMOD . DS . $row . DS .'config/' .$row. '.php')) {	
														
							// Module install
							$models	= Lib::config($row.'.models');
							if (!is_array($models)) {
								continue;
							}
							// Insert modules to db
							$where_cond			= array('parent_id'		=> 0);
							$order_by			= array('order'			=> 'DESC');
							$module_last_order	= $this->find($where_cond, $order_by, 1);

							$i	= (isset($module_last_order[0])) ? $module_last_order[0]->order + 1 : 0;
							
							$params		= array('parent_id'		=> 0,
												'module_name'	=> str_replace('_', ' ', $row),
												'module_link'	=> '#',
												'order'			=> $i);
							
							$module_id	= $this->add($params);

							foreach ($models as $model) {
								$object_name	= 'Model_' . implode('_', array_map('ucfirst', explode('_', $model)));
								$object			= new $object_name;
								
								// Check if install method is exists
								if (method_exists($object, 'install')) {
								
									$object->install();

									// Add to modules to model list
									$params				= array('module_id'		=> $module_id,
																'model'			=> $object_name);
									
									$new_module_list[]	= Model_ModelList::instance()->add($params);
								}

								unset($object, $params);
							}

							// Module Menu Check
							$module_menu	= Lib::config($row.'.module_menu');
							
							// Params Permissions
							// $params_perm	= array();
							
							if(is_array($module_menu)) {
								$menu_order		= 0;
								foreach($module_menu as $menu => $menu_name) {
									$params		= array(
														'parent_id'		=> $module_id,
														'module_name'	=> $menu_name,
														'module_link'	=> $menu,
														'order'			=> $menu_order);

									$new_module_function[] = $this->add($params);
									//$new_module_function[] = $params1;
									
									// Set module_id var
									$params['module_id'] = $params['parent_id'];
									
									// Unset parent_id var
									unset($params['parent_id']);
									
									// Adding initial controller index to module permission
									$new_module_perm_idx[] = Model_ModulePermission::instance()->add($params);

									$menu_order++;
								}
								unset($params);
							}
							
							// Module Function Check
							$module_function	= Lib::config($row.'.module_function');
							
							if(is_array($module_function)) {
								$function_order	= $menu_order;
								foreach($module_function as $function => $function_name) {
									if (!$this->find(array('module_name' =>$function_name))) {
									$params		= array(
														'module_id'	 	 => $module_id,
														'module_name'	 => $function_name,
														'module_link'	 => $function,
														'order'			 => $function_order);
									
									// Adding action controller to module permission
									$new_module_perm_fnc[] = Model_ModulePermission::instance()->add($params);

									//$new_module_perm_fnc[] = $params;

									$function_order++;
									}
								}
								unset($params);
							}
							
							$i++;
						}
					}
				}
			}
			
			if (!empty($new_module_perm_idx) && !empty($new_module_perm_fnc)) {
				
				$new_module_permission = array_merge($new_module_perm_idx, $new_module_perm_fnc);

				// Check user level permission for a new modules just installed
				if (!empty($new_module_permission) && is_array($new_module_permission)) {
					foreach ($user_levels as $levels) {
						foreach($new_module_permission as $new_permission) {

							if($levels->id == 1 || $levels->id == 2) {
								$value	= 1;
							} else { 
								$value	= 0;
							}

							$params		= array('permission_id'	=> $new_permission,
												'level_id'		=> $levels->id,
												'value'			=> $value,
												'added'			=> time(),
												'modified'		=> 0);

							$user_level_permission = Model_UserLevelPermission::instance()->add($params);
						}
					}
				}

			}
			
			// Check deleted module
			$deleted_module	= array_diff($module_list, $config_module);

			if(count($deleted_module) != 0) {
				foreach($deleted_module as $key	=> $value) {
					if($this->delete($key)) {
						$this->delete_by_parent_id($key);
						$where_cond	= array('module_id'	=> $key);
						$model_list	= Model_ModelList::instance()->find($where_cond);
						if(is_array($model_list) && count($model_list) != 0) {
							foreach($model_list as $model) {
								$model_name	= strtolower(str_replace('_Model','',$model->model));
								if ($this->db->list_tables($model_name)) 
									$this->db->query('DROP TABLE `'.$model_name.'`'); // $this->db->query('DROP TABLE `'.$model_name.'`');	
							}							 
						}

						Model_ModelList::instance()->delete_by_module_id($key);
						Model_ModulePermission::instance()->delete_by_module_id($key);
						Model_UserLevelPermission::instance()->delete_by_permission_id($key);
						if ($this->db->list_tables($value)) 
							$this->db->query('DROP TABLE `'.$value.'`');//$this->db->query('DROP TABLE `'.$value.'`');	
					}
				}
			}
			
		}
		*/
	}

}