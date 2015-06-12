<?php
class AreasController extends AppController {

	var $name = 'Areas';
	var $uses = array('Area', 'Texto', 'Video', 'Galeria', 'Wallpaper', 'Evento');

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

		if(!empty($this->params['originalArgs']['passedArgs'][2])) {

			$this->area($this->params['originalArgs']['passedArgs'][2]);
			$this->render('area');

			return;

		}

		$areas = $this->Area->find('all', array(
			'order' => array('Area.peso ASC'),
		));

		$this->set('title_for_layout', 'Areas');

		$this->set(compact('areas'));
	}

	//Area
	function area($friendly_url) {

		$area = $this->Area->find('first',array('conditions'=>array(
			'Area.friendly_url' => $friendly_url,
		)));

		$textos = $this->Texto->find('all',array(
			'conditions'=>array(
				'Texto.parent_id' => $area['Area']['id'],
				'Texto.tipo' => 'area',
			),
			'limit'	=> 3,
		));

		$eventos = $this->Evento->find("all",array(
			'conditions'=>array(
				'Evento.parent_id' => $area['Area']['id'],
				'Evento.tipo !=' => 'atleta',
			),
//			'limit'	=> 1,
		));

		// $params = array(
		// 	'conditions' => array('Evento.parent_id' => $area['Area']['id'],'Evento.tipo !=' => 'atleta',),
		// 	'limit'	=> 1,
		// );

		// $this->paginate['Evento'] = $params;

		// $eventos = $this->paginate('Evento');

		$atletas = $this->Evento->find("all",array(
			'conditions'=>array(
				'Evento.parent_id' => $area['Area']['id'],
				'Evento.tipo' => 'atleta',
			)
		));

		$this->set('title_for_layout', 'Area: '.$area['Area']['titulo']);

		$this->set(compact('area', 'textos', 'eventos', 'atletas'));

	}

}