<?php
class FormController extends AppController {

	var $name = 'Form';
	var $uses = array();
	
	function beforeFilter(){
		$this->uses = array('FormContato');
		print_r($this->modelClass);
		parent::beforeFilter();
	}
	
	function index(){
		$this->_admin_index();
	}

	function add(){
		$this->_admin_add();
	}

	function edit($id = null){
		$this->_admin_edit($id);
	}

	function delete($id = null){
		$this->_admin_delete($id);
	}

}