<?php
class CategoriasController extends AppController {

	var $name = 'Categorias';
	
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
	
	function autocomplete(){
		$conf = array(
			'itemLabel' => 'CONCAT(Categoria.Nome, " (", DATE_FORMAT(Categoria.data, "%d/%m/%Y %h:%i"), " - cód. " COLLATE utf8_bin, Categoria.id, ")")',
//			'conditions'=> array('Noticia.tipo' => 'noticia')
		);
		$this->_autocomplete($conf);
	}

}