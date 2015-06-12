<?php
class VideosController extends AppController {

	var $name = 'Videos';
	
	function index(){
		$this->_admin_index();
	}

	function add(){

		if(!empty($this->data['Video']['case'])) {
			$this->data['Video']['parent_id'] = $this->data['Video']['case'];
		}

		if(!empty($this->data['Video']['modalidade'])) {
			$this->data['Video']['parent_id'] = $this->data['Video']['modalidade'];
		}

		if(!empty($this->data['Video']['evento'])) {
			$this->data['Video']['parent_id'] = $this->data['Video']['evento'];
		}

		$this->_admin_add();
	}

	function edit($id = null){

		if(!empty($this->data['Video']['case'])) {
			$this->data['Video']['parent_id'] = $this->data['Video']['case'];
		}

		if(!empty($this->data['Video']['modalidade'])) {
			$this->data['Video']['parent_id'] = $this->data['Video']['modalidade'];
		}

		if(!empty($this->data['Video']['evento'])) {
			$this->data['Video']['parent_id'] = $this->data['Video']['evento'];
		}

		$this->_admin_edit($id);
	}

	function delete($id = null){
		$this->_admin_delete($id);
	}
	
	function autocomplete(){
		$conf = array(
			'itemLabel' => 'CONCAT(Video.titulo, " (", DATE_FORMAT(Video.data, "%d/%m/%Y %h:%i"), " - cód. " COLLATE utf8_bin, Video.id, ")")',
//			'conditions'=> array('Noticia.tipo' => 'noticia')
		);
		$this->_autocomplete($conf);
	}

}