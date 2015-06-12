<?php
class FormDepoimentosController extends AppController {

	var $name = 'FormDepoimentos';
	var $components = array('Email');
	var	$cacheAction = false;
	
	function index_ok(){
	}

	function index(){
		if(end($this->params['originalArgs']['params']['pass']) == 'sucesso'){
			$this->render('index_ok');
			return;
		}
		
		$pagina_depoimentos = $this->Pagina->find('first', array(
			'conditions'=>array(
				array('Pagina.friendly_url' => 'depoimentos'),
			),
		));
		$this->set(compact('pagina_depoimentos'));		
				
		//Pegando os depoimentos  e listando com o paginate
		$this->paginate = array( 
			'conditions'=> array('FormDepoimento.status' => '1'),       
			'limit' => 4   
			); 
			//exit;   
		$depoimentos = $this->paginate('FormDepoimento');
		$this->set(compact('depoimentos'));

		if ($this->RequestHandler->isPost()) {

			//$this->FormDepoimento->set($this->data);
			//Inicia um novo registro
			$this->FormDepoimento->create();
			//e tenta gravar
			if ($this->FormDepoimento->save($this->data)) {

				//Envia email usando Email component
				$this->Email->template = 'post_data';
				$this->Email->charset = 'utf-8';
				$this->Email->to = Configure::read('form_depoimentos.to');
				$this->Email->subject = Configure::read('form_depoimentos.subject');
				$this->Email->from = $this->data['FormDepoimento']['nome'].'<'.Configure::read('smtp.username').'>';
				$this->Email->replyTo = $this->data['FormDepoimento']['email'];
				//$this->Email->cc = array($this->data['FormDepoimento']['email']);
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

//					$this->render('index_ok');
//					return true;
/*					
					$this->Session->setFlash(__('Mensagem enviada com sucesso!', true),'default',array('class'=>'message_success  alert alert-success'), 'contato');
					$this->redirect('/'.(!isset($this->params['originalArgs']) ? 
						$this->params['url']['url']
						:
						$this->params['originalArgs']['params']['url']['url']
					));
*/
				}else{
					$this->Session->setFlash(__('Ocorreu um erro ('.$this->Email->smtpError.') ao enviar a mensagem!<br />Porém seus dados foram cadastrados em nosso banco de dados.', true),'default',array('class'=>'message_error alert alert-error'),'form');
				}

//				$this->render('index_ok');

				$this->redirect('/'.(!isset($this->params['originalArgs']) ? 
						$this->params['url']['url']
						:
						$this->params['originalArgs']['params']['url']['url']
					).'/sucesso');

			}else{
				$this->redirect('/'.(!isset($this->params['originalArgs']) ? 
						$this->params['url']['url']
						:
						$this->params['originalArgs']['params']['url']['url']
					).'/#form');
				$this->Session->setFlash(__('Por favor, preencha o formulário corretamente!', true),'default',array('class'=>'message_error alert alert-error'), 'form');

			}
		}
	}
}