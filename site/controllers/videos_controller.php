<?php
class VideosController extends AppController {

	var $name = 'Videos';		
	var	$cacheAction = false;

	function index(){

		$params = array(
			'order' => array('Video.data DESC', 'Video.id DESC'),
			'conditions' => array(),
			//'contain' => array('busca_video_params')
		);
		
		//Se enviou o vídeo a ser exibido...
		if(!empty($this->params['pass'][0])){
			$video_destaque = $this->Video->find('first', array(
			 	'conditions' => array(
					'Video.friendly_url' => $this->params['pass'][0]
				),
			));
		}else{
			$video_destaque =$this->Video->find('first', array(
					'order' => 'Video.id DESC'
				)
			
			);
		}
		//print_r($video_destaque);
		//$params['conditions']['Video.id !='] = $video_destaque['Video']['id'];
		
		
		//Busca titulo video
		//echo '<pre>';print_r($this->params);echo '</pre>';
		if(!empty($this->params['url']['busca_video'])){
			$busca_video= $this->Video->find('all', array('conditions' => array(
                                           'Video.titulo LIKE' => '%'.$this->params['url']['busca_video'].'%',
											),
										   'order'		=> 'Video.data DESC',
										   ));
			//$params['conditions']['Video.id'] = array_keys($busca_video);	
		}
		$this->set(compact('busca_video'));
		//$this->paginate['Video'] = $params;
		
		//echo '<pre>';print_R($busca_video);echo '</pre>';
		
		$params['limit'] = 6;
		$this->paginate['Video'] = $params;
		$videos = $this->paginate('Video');
		
		//print_r($videos);exit;
		
		//$this->set('filtro_tipos', $this->Promocao->tipos);
		$this->set('filtro_anos',$this->Video->getAnos());
		
		$this->set(compact('video_destaque', 'videos', 'filtro_ano', 'filtro_mes'));
		
		if(!empty($this->params['pass'][0])){
			$this->render('video');
			return;
		}
	}
}