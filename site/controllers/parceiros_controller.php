<?php
class ParceirosController extends AppController {

	var $name = 'Parceiros';
	var $uses = array('Parceiro', );

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

		$parceiros = $this->Parceiro->find('all', array(
			'order' => array('Parceiro.peso ASC'),
		));
	

		$this->set('title_for_layout', 'Parceiros');

		$this->set(compact('parceiros'));

	}
}
