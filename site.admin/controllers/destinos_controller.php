<?php
class DestinosController extends AppController {

	var $name = 'Destinos';
	var $components = array('TreeAdmin');

	function movedown($id, $delta = 1) {
		$this->TreeAdmin->movedown($id, $delta);
	}
	
	function moveup($id, $delta = 1) {
		$this->TreeAdmin->moveup($id, $delta);
	}
	
/*
	//Desativar drag drop
	function update_parent(){
		$this->TreeAdmin->update_parent($this->data);
	}
*/

	function index(){
		$this->_admin_index();
	}

	function add($parent_id = null){
		//Se definiu o pai
		if(!empty($parent_id)){
			$this->data['Destino']['parent_id'] = $parent_id;
		}
		$this->_admin_add();
		
	}

	function edit($id = null){

 		$this->set('setup_destino_foto', $this->Destino->DestinoFoto->setupAdmin());
 		$this->_admin_edit($id);
	}

	function delete($id = null){
		$this->_admin_delete($id);
	}

	function autocomplete(){
		$conf = array(
			'itemLabel' => 'CONCAT(Destino.nome, " (cód. " COLLATE utf8_bin, Destino.id, ")")',
//			'conditions'=> array('Noticia.tipo' => 'noticia')
		);
		$this->_autocomplete($conf);
	}
}