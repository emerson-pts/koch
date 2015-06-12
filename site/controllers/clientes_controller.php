<?php
class ClientesController extends AppController {

	var $name = 'Clientes';
	var $uses = array('Cliente', );

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

	//últimas notícias
	function index() {

		$clientes = $this->Cliente->find('all', array(
			'order' => array('Cliente.peso ASC'),
		));

		$this->set(compact('clientes'));

	}
}
