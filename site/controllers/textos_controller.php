<?php
class TextosController extends AppController {

	var $name = 'Textos';
	var $uses = array('Texto' );

	//textos
	function index($friendly_url = null) {

		if(!empty($friendly_url)){
			$this->texto($friendly_url);
			$this->render('noticia');
			return;			
		}		
	}

	//Texto
	function texto($friendly_url=null) {

		$texto = $this->Texto->find('first',array('conditions'=>array(
			'Texto.friendly_url' => $friendly_url
		)));

		$this->set(compact('texto'));

	}

	function getParent($id) {

		$texto = $this->Texto->find('first',array('conditions'=>array(
			'Texto.friendly_url' => $id
		)));

		$this->set(compact('texto'));

	}
}