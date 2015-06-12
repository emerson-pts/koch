<?php
class DestinosController extends AppController {

	var $name = 'Destinos';
	var $components = array('Email');
	var $uses = array('MonteRoteiro', 'Destino', 'Roteiro', 'Noticia');

	function index(){
		$this->helpers[] = 'Youtube';

		#POST form aba pre-reserva
		if ($this->RequestHandler->isPost()) {

			$this->MonteRoteiro->set($this->data);

			if ($this->MonteRoteiro->validates()) {

				$resultado_busca_destinos = $this->Destino->find('all', array(
					'conditions' => array(
						'Destino.id' => $this->data['MonteRoteiro']['destinos'],
					)
				));

	 			$this->set('resultado_destino',$resultado_busca_destinos['0']['Destino']['nome']);
	 			$this->set('resultado_roteiro',$this->data['MonteRoteiro']['roteiros']);

				//Envia email usando Email component
				$this->Email->template = 'post_data_monte';
				$this->Email->charset = 'utf-8';
				$this->Email->to = Configure::read('Monte_roteiro.to');
				$this->Email->subject = Configure::read('Monte_roteiro.subject');
				$this->Email->from = $this->data['MonteRoteiro']['nome'].'<'.$this->data['MonteRoteiro']['email'].'>';
				$this->Email->sendAs = 'both';

				//As configurações estão no bootstrap
				$this->Email->smtpOptions = array(
					'auth' 		=> true,
					'timeout'	=> 10, 
					'port'		=> Configure::read('smtp.port'), 
					'host' 		=> Configure::read('smtp.host'), 
					'username' 	=> Configure::read('smtp.username'), 
					'password' 	=> Configure::read('smtp.password'),
				);
				$this->Email->delivery = 'smtp';

				if(true == $this->Email->send()){
					//$this->Session->setFlash(Configure::read('Monte_roteiro.mensagem'),'default',array('class'=>'message_success'),'form');
					unset($this->data);

					$this->Session->setFlash(__('Sua mensagem foi enviada com sucesso !', true),'default',array('class'=>'message_error'),'form');
					$this->redirect('/'.(!isset($this->params['originalArgs']) ? 
						$this->params['url']['url']
						:
						$this->params['originalArgs']['params']['url']['url'].'#pre-reserva'
					));

				}else{
					$this->Session->setFlash(__('Ocorreu um erro ('.$this->Email->smtpError.') ao enviar a mensagem!<br />Por favor, tente novamente.', true),'default',array('class'=>'message_error'),'form');
				}
			}else{
				$this->Session->setFlash(__('Por favor, preencha o formulário corretamente!', true),'default',array('class'=>'message_error'), 'form');
			}
		}
		#fim POST pré reserva

		//Caminho solicitado
		$url = $this->params['originalArgs']['passedArgs'];

		//Identificação de roteiro ou destino...
		//Verifica se tem ao menos 3 caminhos destino/roteiros/nome do roteiro
		if( count($url) >= 3 && current(array_slice($url, -2, 1)) == 'roteiros' ){
			//Página do roteiro
			$template = 'roteiro';
			$slug_destino = array_slice($url, 0, -2);

			//Recupera o roteiro...
			$slug_roteiro = array_slice($url, -1);
			if(!$roteiro = $this->Destino->Roteiro->find('first', array(
				'contain' => array( 'ViagemTipo', 'Seo', ),
				'conditions' => array(
					'Roteiro.friendly_url' => $slug_roteiro,
				),
			))) {
				//Página não encontrada
				$this->cakeError('error404');
				return;
			}

			$destino_select = $this->Destino->find('first', array(
				'conditions' => array(
					'Destino.friendly_url' => $url[2],
				),
				array('fields' => 
					array('Destino.nome', ),
				),
			));

			$roteiro_select = $this->Roteiro->find('first', array(
				'conditions' => array(
					'Destino.friendly_url' => $url[4],
				),
				array('fields' => 
					array('Roteiro.nome', ),
				),
			));
			#print_r($roteiro_select);

			#pagina pre reserva
			$this->set('destinos', $this->Destino->generatetreelist(null, null, null, '&nbsp;&nbsp;&nbsp;'));
			$this->set('roteiros', $this->Destino->Roteiro->find('list', 
					array('fields' => 
						array('Roteiro.nome', ), 'recursive' => -1, 'order' => array('Roteiro.nome')
					)				
				)
			);
			$this->set('roteiro', $roteiro);
			$this->set('destino_select', $destino_select);
			$this->set('roteiro_select', $roteiro_select['Roteiro']['nome']);

			$this->helpers[] = 'BoomViagens';		
		}
			//Página de destino/destinos
		else{
			if( count($url) >= 2 && current(array_slice($url, -1)) == 'roteiros' ){
				//Página do destino
				$template = 'destino';
				$slug_destino = array_slice($url, 0, -1);
			}
			else{
				//Página de destinos (flag_roteiros = 0) ou destino (flag_roteiros = 1)
				$template = 'destinos';
				$slug_destino = $url;
			}
		}

		//Remove o caminho do sitemap do caminho do destino
		$slug_destino = array_diff( $slug_destino, Set::extract('/Sitemap/friendly_url', $this->params['sitemapPath']));

		//Campos padrões a serem recuperados pelo destino
		$destino_fields = array(
			'Destino.id',
			'Destino.parent_id',
			'Destino.nome',
			'Destino.friendly_url',
			'Destino.flag_roteiros',
			'Destino.roteiro_ativo_count',
			'Destino.imagem_lista',
			'Destino.resumo',
		);

		//Se não recuperar o destino solicitado...
		if(!$destino = $this->Destino->findPath($slug_destino, 'friendly_url', array(
				'contain' => false,
				'fields' => $destino_fields,
			),
			false
		)){
			//Página não encontrada
			$this->cakeError('error404');
			return;
		}

		//Se a página é de destinos e o destino pode conter roteiros...
		if($template == 'destinos' && !empty($destino['Destino']['flag_roteiros'])) {

			//Exibe página do destino aberto
			$template = 'destino';
		}

		//Se está exibindo página do destino...
		if($template == 'destino') {
			//Recupera todos os dados do destino
			$currentDestino = $this->Destino->find('first', array(
				'contain' => array('DestinoFoto',),
				'conditions' => array('Destino.id' => $destino['Destino']['id']),
			));
			$destino['Destino'] = $currentDestino['Destino'];
			$destino['DestinoFoto'] = $currentDestino['DestinoFoto'];

			//Recupera a lista de roteiros...
			$roteiros = $this->Destino->Roteiro->find('all', array(
				'contain' => array( 'ViagemTipo', ),
				'conditions' => array(
					'Roteiro.destino_id' => $destino['Destino']['id'],
				),
			));
			$this->set('roteiros', $roteiros);

			$this->Noticia->bindModel(
				array(
					'hasOne' => array(
						'NoticiasDestino' => array(							
							'foreignKey' => 'noticia_id',
							'fields'     => 'id'
						),
						'Noticia' => array(							
							'foreignKey' => false,
							'conditions' => 'Noticia.id = NoticiasDestino.noticia_id',
							'fields'     => 'id'
						)
					)
				)
			);

			$noticias = $this->Noticia->find('all', array(
//				'conditions' => array('Noticia.tipo' => $noticia_tipo,  'Noticia.status' => 'aprovada',),
				'contain' => array('NoticiasDestino'),
				'order' => array('Noticia.data_noticia DESC', 'Noticia.id DESC'),
				'limit'	=> 10,
				'conditions' => array(
					'NoticiasDestino.destino_id' => $destino['Destino']['id'],
				),
			));
			$this->set('noticias', $noticias);
		}

		//Se está acessando qualquer nível de destino...
		if(!empty($destino['Destino'])) {
			//Recupera o caminho completo do destino atual
			$this->Destino->contain('Seo');
			$destinoPath = $this->Destino->getpath( $destino['Destino']['id'], array('id', 'friendly_url', 'nome', 'Seo.*',), 0);

			//Adiciona caminho completo do destino ao breadcrumbs
			foreach($destinoPath AS $key => $value){
				end($this->breadcrumbs);
				$this->breadcrumbs[ key($this->breadcrumbs) . '/' . $value['Destino']['friendly_url'] ] = $value['Destino']['nome'];
			}

			//Adiciona SEO dos Destinos
			$this->params['seo'] = array_merge($this->params['seo'], Set::extract($destinoPath, '/Seo'));

			$this->set('destinoPath', $destinoPath);

		}
		
		//Se está acessando um roteiro
		if(!empty($roteiro)){
			//Adiciona SEO do Roteiro
			$this->params['seo'][] = array('Seo' => $roteiro['Seo']);
		}

		$this->set('template', $template);
		$this->set('destino', $destino);
		$this->render($template);
	}
}