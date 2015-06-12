<?php
class ClientesController extends AppController {

	var $name = 'Clientes';
	
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