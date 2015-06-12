<?php
class ModalidadesController extends AppController {

	var $name = 'Modalidades';
	var $uses = array('Modalidade', 'Texto', 'Video', 'Galeria', 'Wallpaper', );

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

			$this->modalidade($this->params['pass'][0]);
			$this->render('modalidade');

			return;

		}

		$modalidades = $this->Modalidade->find('all', array(
			'order' => array('Modalidade.peso ASC'),

		));

		$this->set(compact('modalidades'));
	}

	//Modalidade
	function modalidade($friendly_url) {

		$modalidade = $this->Modalidade->find('first',array('conditions'=>array(
			'Modalidade.friendly_url' => $friendly_url,
		)));

		$textos = $this->Texto->find('all',array(
			'conditions'=>array(
				'Texto.parent_id' => $modalidade['Modalidade']['id'],
				'Texto.tipo' =>'modalidade'
			),
			'limit'	=> 3,
		));

		$videos = $this->Video->find('all',array('conditions'=>array(
			'Video.parent_id' => $modalidade['Modalidade']['id'],
			'Video.tipo' =>'modalidade'
		)));

		$galerias = $this->Galeria->find('all',array('conditions'=>array(
			'Galeria.related_id' => $modalidade['Modalidade']['id'],
			'Galeria.tipo' =>'modalidade'
		)));

		$galeria_atual['Galeria'] = array();

		//Abre o álbum se foi solicitado
		if(!$galeria_atual = $this->Galeria->find('first', array('contain' => array('GaleriaArquivo'), 'conditions' => array('Galeria.related_id' => $modalidade['Modalidade']['id'])))){
			//$this->Session->setFlash(__('Ops! Álbum não encontrado.', true),'default',array('class'=>'message_error'));
		} else {
			$galeria_atual['Galeria']['fullpath'] = $this->Galeria->getfullpath($galeria_atual['Galeria']['id'], ' > ');
			$galeria_atual['Galeria']['parent'] = $this->Galeria->find('first', array('contain' => false, 'conditions' => array('Galeria.id' => $galeria_atual['Galeria']['parent_id'])));
		}

		// echo '<pre>';
		// print_r($galerias);
		// die;

		$wallpaper = $this->Wallpaper->find('all',array(
			'conditions'=>array(
				'Wallpaper.parent_id' => $modalidade['Modalidade']['id'],
				'Wallpaper.destaque' =>'1',
				'Wallpaper.tipo' =>'wallpaper',
				'Wallpaper.categoria' =>'modalidade'
				
			),
			'limit'	=> 1,
		));

		$wallpapers = $this->Wallpaper->find('all',array(
			'conditions'=>array(
				'Wallpaper.parent_id' => $modalidade['Modalidade']['id'],
				'Wallpaper.destaque' =>'0',
				'Wallpaper.tipo' =>'wallpaper',
				'Wallpaper.categoria' =>'modalidade'
			),
		));

		$screensaver = $this->Wallpaper->find('all',array(
			'conditions'=>array(
				'Wallpaper.parent_id' => $modalidade['Modalidade']['id'],
				'Wallpaper.destaque' =>'1',
				'Wallpaper.tipo' =>'screensaver',
				'Wallpaper.categoria' =>'modalidade'
			),
			'limit'	=> 1,
		));

		$screensavers = $this->Wallpaper->find('all',array(
			'conditions'=>array(
				'Wallpaper.parent_id' => $modalidade['Modalidade']['id'],
				'Wallpaper.destaque' =>'0',
				'Wallpaper.tipo' =>'screensaver',
				'Wallpaper.categoria' =>'modalidade'
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

		$this->set('title_for_layout', 'Modalidade: '.$modalidade['Modalidade']['titulo']);

		$this->set('galeria_atual',$galeria_atual);
		$this->set(compact('modalidade', 'textos', 'videos', 'galerias', 'wallpaper', 'wallpapers', 'screensaver', 'screensavers'));

	}

}
