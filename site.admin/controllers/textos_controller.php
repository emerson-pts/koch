<?php
class TextosController extends AppController {

	var $name = 'Textos';

	function index(){
		$this->_admin_index();
	}

	function add(){

		if(!empty($this->data['Texto']['case'])) {
			$this->data['Texto']['parent_id'] = $this->data['Texto']['case'];
		}

		if(!empty($this->data['Texto']['modalidade'])) {
			$this->data['Texto']['parent_id'] = $this->data['Texto']['modalidade'];
		}

		if(!empty($this->data['Texto']['area'])) {
			$this->data['Texto']['parent_id'] = $this->data['Texto']['area'];
		}

		if(!empty($this->data['Texto']['evento'])) {
			$this->data['Texto']['parent_id'] = $this->data['Texto']['evento'];
		}

		$this->_admin_add();
	}

	function edit($id = null){

		if(!empty($this->data['Texto']['case'])) {
			$this->data['Texto']['parent_id'] = $this->data['Texto']['case'];
		}

		if(!empty($this->data['Texto']['modalidade'])) {
			$this->data['Texto']['parent_id'] = $this->data['Texto']['modalidade'];
		}

		if(!empty($this->data['Texto']['area'])) {
			$this->data['Texto']['parent_id'] = $this->data['Texto']['area'];
		}

		if(!empty($this->data['Texto']['evento'])) {
			$this->data['Texto']['parent_id'] = $this->data['Texto']['evento'];
		}

		$this->_admin_edit($id);
	}

	function delete($id = null){
		$this->_admin_delete($id);
	}
	
	function autocomplete(){
		$conf = array(
			'itemLabel' => 'CONCAT(Texto.titulo, " (", DATE_FORMAT(Texto.data, "%d/%m/%Y %h:%i"), " - cód. " COLLATE utf8_bin, Texto.id, ")")',
//			'conditions'=> array('Noticia.tipo' => 'noticia')
		);
		$this->_autocomplete($conf);
	}

}