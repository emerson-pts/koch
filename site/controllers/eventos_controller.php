<?php
class EventosController extends AppController {

	var $name = 'Eventos';
	var $uses = array('Evento', 'Texto', 'Video', 'Galeria', 'Wallpaper', );

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

		if(!empty($this->params['pass'][0])) {

			$this->abreEvento($this->params['pass'][0]);
			$this->render('case');

			return;

		}

		$Eventos = $this->Evento->find('all', array(
			'order' => array('Evento.id DESC'),
		));

		$this->set(compact('Eventos'));
	}

	//Modalidade
	function abreEvento($friendly_url) {

		$evento = $this->Evento->find('first',array('conditions'=>array(
			'Evento.friendly_url' => $friendly_url,
		)));

		$textos = $this->Texto->find('all',array(
			'conditions'=>array(
				'Texto.parent_id' => $evento['Evento']['id'],
				'Texto.tipo' => 'evento',
			),
			'limit'	=> 3,
		));

		$videos = $this->Video->find('all',array('conditions'=>array(
			'Video.parent_id' => $evento['Evento']['id'],
			'Video.tipo' => 'evento',
		)));

		$galerias = $this->Galeria->find('all',array('conditions'=>array(
			'Galeria.related_id' => $evento['Evento']['id'],
			'Galeria.tipo' => 'evento',
		)));

		$galeria_atual['Galeria'] = array();

		//Abre o álbum se foi solicitado		
		if(!$galeria_atual = $this->Galeria->find('first', array('contain' => array('GaleriaArquivo'), 'conditions' => array('Galeria.related_id' => $evento['Evento']['id'])))){
			#$this->Session->setFlash(__('Ops! Álbum não encontrado.', true),'default',array('class'=>'message_error'));
		} else {
			$galeria_atual['Galeria']['fullpath'] = $this->Galeria->getfullpath($galeria_atual['Galeria']['id'], ' > ');
			$galeria_atual['Galeria']['parent'] = $this->Galeria->find('first', array('contain' => false, 'conditions' => array('Galeria.id' => $galeria_atual['Galeria']['parent_id'])));
		}

		$wallpaper = $this->Wallpaper->find('all',array(
			'conditions'=>array(
				'Wallpaper.parent_id' => $evento['Evento']['id'],
				'Wallpaper.destaque' =>'1',
				'Wallpaper.tipo' =>'wallpaper',
				'Wallpaper.categoria' =>'evento'
				
			),
			'limit'	=> 1,
		));

		$wallpapers = $this->Wallpaper->find('all',array(
			'conditions'=>array(
				'Wallpaper.parent_id' => $evento['Evento']['id'],
				'Wallpaper.destaque' =>'0',
				'Wallpaper.tipo' =>'wallpaper',
				'Wallpaper.categoria' =>'evento'
			),
		));

		$screensaver = $this->Wallpaper->find('all',array(
			'conditions'=>array(
				'Wallpaper.parent_id' => $evento['Evento']['id'],
				'Wallpaper.destaque' =>'1',
				'Wallpaper.tipo' =>'screensaver',
				'Wallpaper.categoria' =>'evento'
			),
			'limit'	=> 1,
		));

		$screensavers = $this->Wallpaper->find('all',array(
			'conditions'=>array(
				'Wallpaper.parent_id' => $evento['Evento']['id'],
				'Wallpaper.destaque' =>'0',
				'Wallpaper.tipo' =>'screensaver',
				'Wallpaper.categoria' =>'evento'
			),
		));

		if($this->params['pass'][0] == 'download') {

			//force download
			$down = $this->Wallpaper->find('first', array(
				'conditions' => array('Wallpaper.id' => $this->params['pass'][1]),
			));

			$file = $down['Wallpaper']['image'];

			if (is_file('./'.$file)) {
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename="'.$file.'"');
				header('Content-Transfer-Encoding: binary');
				header('Expires: 0');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Pragma: public');
				header('Content-Length: ' . filesize('./'.$file)); 
				ob_clean();
				flush();
				readfile('./'.$file);
			    exit();
			}
		}

		$this->set('title_for_layout', 'Evento: '.$evento['Evento']['titulo']);

		$this->set('galeria_atual',$galeria_atual);
		$this->set(compact('evento', 'textos', 'videos', 'galerias', 'wallpaper', 'wallpapers', 'screensaver', 'screensavers'));

	}

}
