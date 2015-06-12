<?php
class MonteRoteirosController extends AppController {

	var $name = 'MonteRoteiros';
	var $components = array('Email');
	var	$cacheAction = false;
	var $uses = array('MonteRoteiro', 'Destino', 'Roteiro', );

	function ajax() {

		if ($this->RequestHandler->isPost()) {

			$treelistConditions = array(
				'conditions' => array(
					"OR"=>array(
						'Destino.id' =>$this->data, 'Destino.parent_id' => $this->data
					)
				),
				'contain' => array('Roteiro',),
				array('fields' => 
					array('Roteiro.nome', ), 'order' => array('Roteiro.nome')
				),
			);

			#busca destinos, pesquisando se há id ou parent_id na tbl Destinos
			#Ex: Nacionais não possue vinculo com outro destino pois é raíz, ja Bonito possue vinculo com o destino Nacionais
			$response = $this->Destino->find('all', $treelistConditions);

			#extract para pegar o nome do roteiro, baseado no $response
			$results = Set::extract('/Roteiro/nome', $response);
			$this->set('roteiros', $results);
			$this->set('roteiro_select', $this->params['form']['roteiro']);

		}

		$this->render('ajax');
		return true;
    }

	function index_ok(){
	}

	function index(){
		if(end($this->params['originalArgs']['params']['pass']) == 'sucesso'){
			$this->render('index_ok');
			return;
		}

		#$this->set('destinos', $this->Destino->generatetreelist($conditions=array('status' => 1), $keyPath='{n}.Destino.nome'));
		#$this->set('roteiros', $this->Destino->Roteiro->find('list', array('fields' => array('Roteiro.nome', 'Roteiro.nome', 'Destino.nome'), 'recursive' => 1, 'order' => array('Destino.nome') )));
		$this->set('destinos', $this->Destino->generatetreelist(null, null, null, '&nbsp;&nbsp;&nbsp;'));
		$this->set('roteiros', $this->Destino->Roteiro->find('list', 
				array('fields' => 
					array('Roteiro.nome', ), 'recursive' => -1, 'order' => array('Roteiro.nome')
				)
			)
		);

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

				//Busca Roteiros
				// $resultado_busca = $this->Roteiro->find('all', array(
				// 	'conditions' => array(
				// 		'Roteiro.id' => $this->data['MonteRoteiro']['roteiros'],
				// 	),
				// ));

				// $this->set('resultado_roteiro',$resultado_busca['0']['Roteiro']['nome']);

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
					//$this->redirect('/');
					$this->Session->setFlash(__('Sua mensagem foi enviada com sucesso!', true),'default',array('class'=>'message_error'), 'form');
					$this->redirect('/'.(!isset($this->params['originalArgs']) ? 
						$this->params['url']['url']
						:
						$this->params['originalArgs']['params']['url']['url']
					).'/sucesso');
					#$this->render('index_ok');
					#return true;

					/*$this->Session->setFlash(__('Mensagem enviada com sucesso!', true),'default',array('class'=>'message_success'), 'contato');
					$this->redirect('/'.(!isset($this->params['originalArgs']) ? 
						$this->params['url']['url']
						:
						$this->params['originalArgs']['params']['url']['url']
					));*/

				}else{
					$this->Session->setFlash(__('Ocorreu um erro ('.$this->Email->smtpError.') ao enviar a mensagem!<br />Por favor, tente novamente.', true),'default',array('class'=>'message_error'),'form');
				}
			}else{
				$this->Session->setFlash(__('Por favor, preencha o formulário corretamente!', true),'default',array('class'=>'message_error'), 'form');
			}
		}
	}
}