<?php
class BuscaController extends AppController {

	var $name = 'Busca';
	var $uses = array('Destino', 'Roteiro');
//	var	$noticia_tipos = array('blog' => 'Blog', /*'noticia' => 'Notícia'*/);
//	var	$noticia_categorias = array('noticia' => 'Notícias');

//	var	$noticias_url_tipo = array('blog' => 'blog', /*'noticia' => 'noticia'*/);
//	var	$cacheAction = "5 seconds";

	function index() {

		if(!empty($this->params['url']['campo_buscar'])) {

			//Busca Roteiros
			$resultado_busca = $this->Roteiro->find('all', array(
				'contain' => array('ViagemTipo'),
				'conditions' => array(
					'Roteiro.nome LIKE' => '%'.$this->params['url']['campo_buscar'].'%',
				),
				'order'		=> 'Roteiro.id DESC',
				'group'=> 'Roteiro.id',
			));

			foreach ($resultado_busca AS $key => $busca):

				$resultado_busca[$key]['Roteiro']['fullpath'] = $this->Destino->getfullpath($busca['Roteiro']['destino_id'], '/', $label = 'friendly_url');

			endforeach;
			$this->set('resultado_busca',$resultado_busca);

			//Busca Destinos
			$resultado_busca_destinos = $this->Destino->find('all', array(
				'conditions' => array(
					'Destino.nome LIKE' => '%'.$this->params['url']['campo_buscar'].'%',
				),
				'order'		=> 'Destino.id DESC',
				'group'=> 'Destino.id',
			));

			foreach ($resultado_busca_destinos AS $key => $busca_destino):

				$resultado_busca_destinos[$key]['Destino']['fullpath'] = $this->Destino->getfullpath($busca_destino['Destino']['id'], '/', $label = 'friendly_url');

			endforeach;
			$this->set('resultado_busca_destinos',$resultado_busca_destinos);

			//$busca_destino = $this->set(compact('resultado_busca_destinos'));

		} else {
			echo '';
		}

		//$this->set(compact('resultado_busca'));

		/*Rss notícias
		if( $this->RequestHandler->isRss() ){
			$noticias = $this->Noticia->find('all', array(
//				'conditions' => array('Noticia.tipo' => $noticia_tipo,  'Noticia.status' => 'aprovada',),
				'contain' => array('Usuario',),
				'order' => array('Noticia.data_noticia DESC', 'Noticia.id DESC'),
				'limit'	=> 20,
			));
			return $this->set(compact('noticias'));
		}

		//xml hands
		if($this->RequestHandler->isXml()) {
			$params = array(
				'conditions'=>array('Noticia.status' => 'aprovada', 'Noticia.data_noticia <=' => date('Y-m-d H:i')),
				'contain' => array('Usuario'),
				'order' => array('Noticia.data_noticia DESC', 'Noticia.id DESC'),
				'limit'	=> 20,
			);

			if(!is_null($noticia_tipo)) {
				$params['conditions']['Noticia.tipo'] = $noticia_tipo;
			}

			$noticias = $this->Noticia->find('all', $params);

			return $this->set(compact('noticias'));
			//$this->Render('xml/index');
		}*/

		/*if(!empty($this->params['named']['categoria'])){
			if(isset($this->Noticia->categorias[$this->params['named']['categoria']]))
				$this->paginate['Noticia']['conditions'][] = array('OR' => array(
					'Noticia.categoria' => null,
					'Noticia.categoria REGEXP' => '(^|,)'.$this->params['named']['categoria'].'(,|$)',
				));
			else
				unset($this->params['named']['categoria']);
		}

		$noticias = $this->paginate('Noticia');
		$this->paginate = array( 
			'conditions'=>array('Noticia.status' => 'aprovada', 'Noticia.data_noticia <=' => date('Y-m-d H:i')),
			'limit' => 2 
		);*/ 
		//$noticias = $this->paginate('Noticia');

		//aplica filtro no sidebar
		//$this->noticiasSidebarFilter = Set::extract('/Noticia/id', $noticias);

	}

}