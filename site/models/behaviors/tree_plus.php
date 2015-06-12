<?php
App::import('Behavior', 'Tree');
class TreePlusBehavior extends TreeBehavior {    
    function getfullpath(&$Model, $id, $separator = '/', $label = null) {
		
		$cache_key = Configure::read('Config.language_options.language').'_'.$Model->alias.'_'.get_class($this).'_'.__FUNCTION__.'_'.md5(serialize(func_get_args()));
		if(false !== ($return = Cache::read($cache_key)))return $return;
		
		if(is_numeric($id))
            $cats = $Model->getpath($id);
        else if(is_array($id))
            $cats = $id;
        else
            return false;
        
        $path = array();
        foreach ($cats as $cat) {
            array_push($path, $cat[$Model->name][(empty($label) ? $Model->displayField : $label)]);
        }
		
		$return = implode($separator, $path);
		
		Cache::write($cache_key, $return);
        return $return;
    }

	function findPath(&$Model, $paths, $fieldName, $params = array('contain' => false)) {
		$cache_key = Configure::read('Config.language_options.language').'_'.$Model->alias.'_'.get_class($this).'_'.__FUNCTION__.'_'.md5(serialize(func_get_args()));
		if(false !== ($return = Cache::read($cache_key)))return $return;

		$cache_key_root = Configure::read('Config.language_options.language').'_'.$Model->alias.'_'.get_class($this).'_'.__FUNCTION__.'_find_threaded_'.md5(serialize(func_get_args()));
		if(false === ($root = Cache::read($cache_key_root))){
			$root = $Model->find('threaded', $params);
			Cache::write($cache_key_root, $root);
		}
		
		if(empty($paths)){
			$return = $root;
		}
		else{
			$return = $this->findPathHelper($Model, $root, $paths, $fieldName);
		}
		
		Cache::write($cache_key, $return);
        return $return;
	}

	function findPathHelper(&$Model, $node, $paths, $fieldName) {
		// search for paths from the beginning of the list
		$path = array_shift($paths);
		$newNode = false;
		// looking for the current path in the specified field
		foreach ($node as $nodeNode) {
			if ($nodeNode[$Model->name][$fieldName] == $path) {
				$newNode = $nodeNode;
				break;
			}
		}
		if (empty($paths) || $newNode === false) {
			// done processing the paths, or cannot find a matching node
			return $newNode;
		} else {
			// not done, find based on the found node's children
			return $this->findPathHelper($Model, $newNode['children'], $paths, $fieldName);
		}
	}
	
	function load(&$Model, $id = null, $contain = false){
//		$menu = $this->children(array('id' => $id, 'direct' => true, 'recursive' => true, 'fields' => array('id', 'label', 'friendly_url', 'show_footer',)));
		$menu = $Model->find('all', array('contain' => $contain, 'conditions' => array('parent_id' => $id, 'status' => '1',),));
		foreach($menu AS $key=>$value){
			$menu[$key]['submenu'] = $this->load($Model, $value[$Model->alias]['id'], $contain);
		}
		return $menu;
	}
	

}