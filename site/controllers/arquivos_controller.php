<?php
class ArquivosController extends AppController {

	var $name = 'Arquivos';
	var $uses = array('Arquivo');

	function beforeFilter(){
		parent::beforeFilter();

		//Se é ajax, não traz o layout
		if ( $this->RequestHandler->isAjax()  ){
			$this->layout = null;
		}
	}

	function beforeRender(){
		parent::beforeRender();
	}

	function index() {

		//se usuario estiver fazendo upload
		if($this->RequestHandler->isPost()) {

			print_r($this->data);
			die;

			if($this->FormNewsletter->save($this->data)) {

			}
		}

	}

}
