<?php
class HistoriasController extends AppController {

	var $name = 'Historias';
	var $uses = array('Historia', 'Banner', );
	var	$cacheAction = false;

	function index(){

		// Se tem uma área de banner com o nome home
		$this->set('banners', $this->Banner->getBanner($area = 'historia') );

		$historias = $this->Historia->find('all');

		$this->set(compact('pagina', 'historias' ));
		
	}
}