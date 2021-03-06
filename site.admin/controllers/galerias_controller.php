<?php
class GaleriasController extends AppController {

	var $name = 'Galerias';
	var $components = array('TreeAdmin');

	function movedown($id, $delta = 1) {
		$this->TreeAdmin->movedown($id, $delta);
	}
	
	function moveup($id, $delta = 1) {
		$this->TreeAdmin->moveup($id, $delta);
	}
	
	function update_parent(){
		$this->TreeAdmin->update_parent($this->data);
	}

	function index(){
		$this->_admin_index();
	}

	function add($parent_id = null){
		//Se definiu o pai

		if(!empty($this->data['Galeria']['case'])) {
			$this->data['Galeria']['related_id'] = $this->data['Galeria']['case'];
		}

		if(!empty($this->data['Galeria']['modalidade'])) {
			$this->data['Galeria']['related_id'] = $this->data['Galeria']['modalidade'];
		}

		if(!empty($this->data['Galeria']['evento'])) {
			$this->data['Galeria']['related_id'] = $this->data['Galeria']['evento'];
		}

		if(!empty($parent_id)){
			$this->data['Galeria']['parent_id'] = $parent_id;
		}

		$this->_admin_add();

	}

	function edit($id = null){

		if(!empty($this->data['Galeria']['case'])) {
			$this->data['Galeria']['related_id'] = $this->data['Galeria']['case'];
		}

		if(!empty($this->data['Galeria']['modalidade'])) {
			$this->data['Galeria']['related_id'] = $this->data['Galeria']['modalidade'];
		}

		if(!empty($this->data['Galeria']['evento'])) {
			$this->data['Galeria']['related_id'] = $this->data['Galeria']['evento'];
		}

 		$this->_admin_edit($id);
	}

	function delete($id = null){
		$this->_admin_delete($id);
	}

}