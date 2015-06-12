<?php
class HomeController extends AppController {

	var $name = 'Home';
	var $uses = array('Vitrine', 'Banner', 'Area', 'Noticia', );

	function index(){
		$this->set('title_for_layout', Configure::read('site.title_for_home'));

		// Vitrine 
		$this->set('vitrines', $this->Vitrine->getVitrine());

		// Area de atuação 
		$this->set('areas', $this->Area->find('all'));

		//Noticias
		$this->set('noticias', $this->Noticia->find('all', array(
			//'limit' 	=> 3,
			'order'		=> 'Noticia.data_noticia DESC',
		)));

		// Se tem uma área de banner com o nome home
		$this->set('banners',  $this->Banner->getBanner($area = 'home') );

	}

}