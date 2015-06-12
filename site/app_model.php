<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
class AppModel extends Model {
	var $actsAs = array('DateFormatter','Containable','EnumSet',);
		
	function beforeSave(){
		foreach($columns = $this->getColumnTypes() AS $field=>$type){
			if (preg_match('/^data_(cadastro|alteracao)$/',$field) && preg_match('/^(date|datetime)$/',$type) && !isset($this->data[$this->alias][$field]))
				$this->data[$this->alias][$field] = date('Y-m-d'.($type == 'datetime' ? ' H:i:s' : ''));
		}
		
		//Meio Upload - limpa caminho completo do campo dir
		if(isset($this->actsAs['MeioUpload'])){
			foreach($this->actsAs['MeioUpload'] AS $upload_field=>$upload_conf){
				if(!empty($this->data[$this->alias][$upload_field])){
					$this->data[$this->alias][$upload_field] = preg_replace('/^'.preg_quote(SITE_DIR, '/').'(webroot\/)?/', '', $upload_conf['dir']).$this->data[$this->alias][$upload_field];
				}
			}
		}
		
		return true;
	}
	
	function invalidate($field, $value = true) {
		return parent::invalidate($field, __($value, true));
	}
}
