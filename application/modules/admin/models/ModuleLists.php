<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Model Class Object for Model lists
class ModuleLists Extends CI_Model {
	
	public $table = 'module_lists';

	public function __construct(){
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
	
	public function load_by_name ($name) {
		$where_cond	= array('module_name' => $name);

		$objects	= $this->db->get_where($this->table,$where_cond,1)->result();
		
		print_r($objects);
		exit;
		return !empty($objects[0]) ? $objects[0] : FALSE;
	}
	
	public function load_by_link ($link) {
		$where_cond	= array('module_link' => $link);

		$objects		= $this->find($where_cond, '', 1);
		
		return !empty($objects[0]) ? $objects[0] : FALSE;
	}
	
	public function parent_level_module ($id = '') {
		if ($id == '')
			$id	= $this->id;

		$where_cond	= array('id'	=> $id);
		$module		= $this->find($where_cond, '', 1);

		if (!isset($module[0]))
			return FALSE;

		return $module[0]->parent_id;
		
	}
	
	public function getModules ($user_group) {
		if($user_group == '')
			return array();
	
		$modules			= array();
	
		// Check admin url
		$where_cond			= array('id'	=> $user_group);
		
		//$user_permission	= Model_UserLevel::instance()->find($where_cond, '', 1);
		$user_permission	= $this->db->get_where('user_groups', $where_cond, 1)->result();
				
		// Check backend permission
		if(!$user_permission[0]->backend_access) {
			redirect(ADMIN . 'authenticate');
		}
		// Load user admin menu modules
		$item = $this->load->config('modules', TRUE);	
		$modules['Admin'] = $item['admin_list.module_menu'];
				
		// Check full backend permission
		if ($user_permission[0]->full_backend_access) { 
			// Load user module menu function
			$modules['Module'] = $item['module_list.module_menu'];			
		}
										
		$modules_perm		= $this->load->model('UserGroupPermissions')->getModuleFunction($user_group);		
		$modules_cols		= array_keys($modules_perm);
		
		$where_cond			= array();
		if(is_array($modules_cols)) {
			$buffers = array();
			foreach ($modules_cols as $cols) {
				$buffers[]	= strtolower($cols);
			}
			
			//$where_cond	= array('module_name IN' => $buffers);
			$where_in		= $buffers;	
			
		}
		
		//$where_cond	  = (is_array($where_cond)) ? array_merge($where_cond,array('parent_id' => 0)) : array('parent_id' => 0);
		
		//$order_by	  = array('order' => 'ASC');
		
		$this->db->where('parent_id', 0);
		$this->db->where_in('module_name',$where_in);		
		$this->db->order_by('order','ASC');

		$module_lists = $this->db->get($this->table)->result();
		
		// Set temp modules
		$_modules = '';
		
		if(count($module_lists) != 0) {
			foreach($module_lists as $module) {
			
				$class_name	= $module->module_name;
								
				$this->db->where('parent_id', $module->id);
				$this->db->order_by('order','ASC');
				
				$menu_modules	= $this->db->get($this->table)->result();
				
				$buffers	= array();
				
				if(count($menu_modules) != 0) {
					foreach ($menu_modules as $menu) {
						$buffers[$menu->module_link]	= $menu->module_name;
					}
				}
										
				//$_modules[ucfirst($class_name)]	= $buffers;
				$modules[ucfirst($class_name)] = $buffers;
				unset($buffers);
				
			}
		}
		
		//$modules = array_merge($_modules,$modules);
		
		//print_r($modules);
		//exit;
		
		return $modules;
	}	
	
	public function module_check () {
		$modules	= array();
				
		// List all custom modules		
		$directory[] = Modules::lists('./application/modules');				

		//$config_module = array();				
	
		// Loop to get module name			
		foreach ($directory as $row) {
			$config_module = array_keys($row);
		}
		
		// Check config module
		if(is_array($config_module) && count($config_module) > 0) {			
			
			// List DB module
			$module_list	= array();
			
			$module_db		= $this->db->get_where($this->table, array('parent_id' => 0))->result();
			
			$user_groups	= $this->db->get_where('user_groups', array('status' => 1))->result();
			
			$buffers		= array();
			
			if(is_array($module_db) && count($module_db) != 0) {
				
				foreach($module_db as $module) {
					$buffers[$module->id]	= $module->module_name;
				}
				
				$module_list	= $buffers;
				unset($buffers);
			}		
						
			$new_module_perm_idx = '';
			$new_module_perm_fnc = '';
									
			foreach($config_module as $row) {
				
				// Mark for main site modules to not included
				if($row	!= 'site' && !empty($row)) {
											
						// Check new module and install it	
						if(!in_array($row, $module_list)) {													

							// Check if config per module existed
							if(is_dir(APPPATH.'modules/'.$row)) {

								$config		= $this->load->config('modules',TRUE);

								// Model install
								$models		= @$config['modulelist'][ucfirst($row)]['models'];
								
								if (!is_array($models)) {
									continue;
								}
																
								$this->db->select('*')
										->from($this->table)
										->where('parent_id',0)
										->order_by('order','DESC')
										->limit(1);

								$module_last_order	= $this->db->get()->result();

								$i	= (isset($module_last_order[0])) ? $module_last_order[0]->order + 1 : 0;							
								$params		= array('parent_id'		=> 0,
													'module_name'	=> $row,
													'module_link'	=> '#',
													'order'			=> $i);

								// Add module new
								$this->db->insert($this->table,$params);
								$module_id	= $this->db->insert_id();
								
								unset($params);		
								
								/* Installing via code igniter loader class how to ???
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
								*/
								
								foreach ($models as $model) {
									
									// Get object class
									$object_name	= ucfirst($model);
									
									// Add to modules to model list
									$params			= array('module_id'		=> $module_id,
															'model'			=> $object_name);
									
									Modules::run('modules/models/install');
									
									// Add new model lists
									$this->db->insert('model_lists', $params);
									$new_module_list[] = $this->db->insert_id();
									
									unset($object, $params);
								}

								// Module Menu Check
								$module_menu		= @$config['modulelist'][ucfirst($row)]['module_menu'];

								if(is_array($module_menu)) {
									$menu_order		= 0;
									foreach($module_menu as $menu => $menu_name) {
										
										$params		= array('parent_id'		=> $module_id,
															'module_name'	=> $menu_name,
															'module_link'	=> $menu,
															'order'			=> $menu_order);

										// Add module
										$this->db->insert($this->table,$params);
										$new_module_function[] = $this->db->insert_id();

										// Set module_id var
										$params['module_id'] = $params['parent_id'];

										// Unset parent_id var
										unset($params['parent_id']);

										// Adding initial controller index to module permission
										$this->db->insert('module_permissions', $params);
										$new_module_perm_idx[] = $this->db->insert_id();

										$menu_order++;
									}
									unset($params);
								}

								// Module Function Check
								$module_function	= @$config['modulelist'][ucfirst($row)]['module_function'];

								if(is_array($module_function)) {
									$function_order	= $menu_order;
									foreach($module_function as $function => $function_name) {
										$this->db->select('*')->from($this->table)->where('module_name',$function_name);										if (!$this->db->get()->result()) {											
										$params		= array('module_id'	 	 => $module_id,
															'module_name'	 => $function_name,
															'module_link'	 => $function,
															'order'			 => $function_order);

										// Adding action controller to module permission
										$this->db->insert('module_permissions', $params);
										$new_module_perm_fnc[] = $this->db->insert_id();

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
								
				// Check user group permission for a new modules just installed
				if (!empty($new_module_permission) && is_array($new_module_permission)) {
					foreach ($user_groups as $groups) {
						foreach($new_module_permission as $new_permission) {

							if($groups->id == 1 || $groups->id == 2) {
								$value	= 1;
							} else { 
								$value	= 0;
							}
							
							unset($params);
							
							$params		= array('permission_id'	=> $new_permission,
												'group_id'		=> $groups->id,
												'value'			=> $value,
												'added'			=> time(),
												'modified'		=> 0);

							// Adding user group permission to database
							$this->db->insert('group_permissions', $params);
							//$user_group_permission = $this->db->insert_id();

						}
					}
				}

			}

			/*
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
			 * 
			 */
		}
				
	}

}