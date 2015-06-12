<?php
class FormNewslettersController extends AppController {

	var $name = 'FormNewsletters';
	var $uses = array('FormNewsletter',);
	
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

	function export_xls(){
		$this->set('filename', 'FormNewsletter_'.date('Y_m_d'));
		$this->set('result', $this->FormNewsletter->find('all'));
		$this->helpers[] = 'xls';
		$this->set('fields', array(
			'FormNewsletter.id'		=> 'Código',
			'FormNewsletter.nome'	=> 'Nome',
			'FormNewsletter.email'	=> 'E-mail',
			'FormNewsletter.created'=> 'Data',
		));
		$this->render('/elements/export_xls');
	}

}