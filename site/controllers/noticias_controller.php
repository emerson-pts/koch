<?php
class NoticiasController extends AppController {

	var $name = 'Noticias';
	var $uses = array('Noticia', 'Categoria', 'Pagina' );
	var	$noticia_tipos = array('noticia' => 'Notícia',);
	var	$noticias_tipos = array('noticia' => 'Notícias',);

	var	$noticias_url_tipo = array('noticias' => 'noticia',);
	//var	$cacheAction = "5 seconds";

	function beforeFilter(){
		parent::beforeFilter();
		//Se é ajax, não traz o layout
		if ( $this->RequestHandler->isAjax()  ){
			$this->layout = null;
		}
	}

	function beforeRender(){
		parent::beforeRender();
		$this->set('noticia_tipos', $this->noticia_tipos);
		//$this->set('noticias_categorias', $this->Noticia->categorias);

		$filtro_meses = $this->Noticia->getMeses($this->viewVars['filtro_ano']);
		$this->set(compact('filtro_meses'));
	}

	function _valida_tipo($noticia_tipo){
		if(empty($this->noticia_tipos[$noticia_tipo])){
			$this->Session->setFlash(__('Ops! O tipo de conteúdo solicitado é inválido (código 1)', true),'default',array('class'=>'message_error'));
			$this->redirect('index');			
		}
		$this->set('title_for_layout', $this->noticias_tipos[$noticia_tipo]);
		return true;
	}

	//últimas notícias
	function index($noticia_tipo = 'noticia', $filtro_ano = null, $filtro_mes = null, $friendly_url = null) {

		$pagina_noticia = $this->Pagina->find('first',array(
			'conditions'=>array(
				"OR" =>array(
					"friendly_url"=>'noticias'
				)
			)
		));
		$this->set(compact('pagina_noticia'));

		if(!empty($this->params['originalArgs']['passedArgs'])) {
			$args = array('noticia_tipo', 'filtro_ano', 'filtro_mes', 'friendly_url');
			$intersect_values = array_intersect_key($this->params['originalArgs']['passedArgs'], $args);
			$intersect_keys = array_intersect_key($args, $intersect_values);
			$overwrite_args = array_combine($intersect_keys, $intersect_values);
			extract($overwrite_args);
			$noticia_tipo = $this->noticias_url_tipo[$noticia_tipo];
		}

		if(!empty($friendly_url)) {
			$this->noticia($noticia_tipo, $filtro_ano, $filtro_mes, $friendly_url);
			$this->render('noticia');
			return;			
		}

		$filtro_anos=$this->Noticia->getAnos();

		//Se o ano enviado não tem na lista
		if(is_numeric($filtro_ano) && !in_array($filtro_ano, $filtro_anos)){
			$filtro_anos[] = $filtro_ano;
			rsort($filtro_anos);
		}

		$this->_valida_tipo($noticia_tipo);

		//if(empty($filtro_ano) || !is_numeric($filtro_ano))$filtro_ano = $filtro_anos[0];
		if(empty($filtro_mes) || !is_numeric($filtro_mes)) {
			$ultima_noticia = $this->Noticia->find('first', array(
				'contain' => false,
				'fields'	=> array(
					'DATE_FORMAT(Noticia.data_noticia, "%m") as mes',
				),
				'conditions' => array('Noticia.data_noticia LIKE' => $filtro_ano.'-%'),
				'order'		=> 'Noticia.data_noticia DESC',
			));

			if(empty($ultima_noticia)) {
				$filtro_mes = date('m');
			}else{
				$filtro_mes = $ultima_noticia[0]['mes'];
			}
		}

		// $noticia_destaque = $this->Noticia->find('all', array(
		// 	'order' => array('Noticia.data_noticia DESC', 'Noticia.id DESC'),
		// 	'limit' => 1
		// ));

		if(!empty($this->params['originalArgs']['passedArgs'])) {

			if(!empty($this->params['url']['busca'])) {

				$params = array(
					'conditions'=>array(
						"OR" =>array(
							'Noticia.titulo LIKE' => '%'.$this->params['url']['busca'].'%',
							'Noticia.conteudo LIKE' => '%'.$this->params['url']['busca'].'%'
						)
					),
					'order' => array('Noticia.data_noticia DESC', 'Noticia.id DESC'),
				);

			} else {

				if($this->params['originalArgs']['passedArgs'][1] == 'categoria') {

					$categoria = $this->Categoria->find('first', array(
						'conditions' => array('Categoria.friendly_url' => $this->params['originalArgs']['passedArgs'][2]),
					));

					$params = array(
						'order' => array('Noticia.data_noticia DESC', 'Noticia.id DESC'),
						'conditions' => array('Noticia.tipo' => $noticia_tipo, 'Noticia.id_categoria' => $categoria['Categoria']['id'], 'Noticia.id <>' => $noticia_destaque[0]['Noticia']['id'],),
						'contain' => false,
						'limit'	=> 3,
					);

				} else {
					$params = array(
						'order' => array('Noticia.data_noticia DESC', 'Noticia.id DESC'),
						'conditions' => array('Noticia.tipo' => $noticia_tipo, 'Noticia.id <>' => $noticia_destaque[0]['Noticia']['id'],),
						'contain' => false,
						'limit'	=> 3,
					);

				}
			}
		}

		//Rss notícias
		if( $this->RequestHandler->isRss() ) {
			$noticias = $this->Noticia->find('all', array(
				//'conditions' => array('Noticia.tipo' => $noticia_tipo,  'Noticia.status' => 'aprovada',),
				'contain' => array('Usuario'),
				'order' => array('Noticia.data_noticia DESC', 'Noticia.id DESC'),
				'limit'	=> 20,
			));
			return $this->set(compact('noticias'));
		}

		$this->paginate['Noticia'] = $params;

		if(!empty($filtro_ano) && is_numeric($filtro_ano)) {
			$this->paginate['Noticia']['conditions']['Noticia.data_noticia LIKE'] = $filtro_ano.'-'.(!empty($filtro_mes) ? $filtro_mes.'-' : '').'%';
		}

		if(!empty($this->params['named']['categoria'])) {
			if(isset($this->Noticia->categorias[$this->params['named']['categoria']]))
				$this->paginate['Noticia']['conditions'][] = array('OR' => array(
					'Noticia.categoria' => null,
					'Noticia.categoria REGEXP' => '(^|,)'.$this->params['named']['categoria'].'(,|$)',
				));
			else
				unset($this->params['named']['categoria']);
		}
		$noticias_destaque = $this->Noticia->find('all', array(
			'conditions' => array('Noticia.destaque' => '1'),
			'limit'	=> 1,
		));

		$noticias = $this->paginate('Noticia');

		// echo '<pre>';
		// print_r($noticias);
		// die;
		$categorias = $this->Categoria->find('all');

		//aplica filtro no sidebar
		//$this->noticiasSidebarFilter = Set::extract('/Noticia/id', $noticias);

		$this->set(compact('noticias', 'noticia_tipo', 'filtro_ano', 'filtro_anos', 'filtro_mes', 'categorias', 'noticias_destaque'));
	}

	//Notícia
	function noticia($noticia_tipo= null, $filtro_ano=null, $filtro_mes=null, $friendly_url=null) {

		$filtro_anos = $this->Noticia->getAnos();

		//Se o ano enviado não tem na lista
		if(is_numeric($filtro_ano) && !in_array($filtro_ano, $filtro_anos)) {
			$filtro_anos[] = $filtro_ano;
			rsort($filtro_anos);
		}

		$this->_valida_tipo($noticia_tipo);

		if (!$filtro_ano || !$filtro_mes || !$friendly_url) {
			$this->Session->setFlash(__('Ops! Página não encontrada', true),'default',array('class'=>'message_error'));
			$this->redirect('index');
		}

		$noticia=$this->Noticia->find('first',array('conditions'=>array(
			'Noticia.tipo' => $noticia_tipo,
			'Noticia.data_noticia LIKE' => $filtro_ano.'-'.$filtro_mes.'%',
			'Noticia.friendly_url' => $friendly_url
		)));

		if (!$noticia) {
			$this->Session->setFlash(__('Ops! Notícia não encontrada', true),'default',array('class'=>'message_error'));
			$this->redirect('index');	
		}

		$this->noticiasSidebarFilter = array($noticia['Noticia']['id']);

		$categorias = $this->Categoria->find('all');

//		$this->_fotosMiniCalendario();

		$this->set('title_for_layout', $this->noticia_tipos[$noticia_tipo].': '.$noticia['Noticia']['titulo']);

		$this->set(compact('noticia', 'noticia_tipo', 'filtro_ano', 'filtro_anos', 'filtro_mes', 'categorias'));

	}
}
