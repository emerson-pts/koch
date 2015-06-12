<?php
class FormOportunidadesController extends AppController {

	var $name = 'FormOportunidades';
	var $components = array('Email',);
	//var $uses = array('Oportunidade', 'Banner', );
	// var $uses=array('FormOportunidade');
	var	$cacheAction = false;

	function index_ok() {

	}

	function index(){

		if(end($this->params['originalArgs']['params']['pass']) == 'sucesso'){
			$this->loadModel("Banner");
			$this->set('banners', $this->Banner->getBanner($area = 'oportunidade') );

			//Seta título da página
			$this->set('title_for_layout', 'Oportunidades');
			$this->render('index_ok');
			return;
		}

		$this->loadModel("Oportunidade");
		$this->set('oportunidades', $this->Oportunidade->find('all') );

		$this->loadModel("Banner");
		$this->set('banners', $this->Banner->getBanner($area = 'oportunidade') );

		if ($this->RequestHandler->isPost()) {

			$this->FormOportunidade->set($this->data);

			if ($this->FormOportunidade->validates()) {

//				move_uploaded_file($this->data['FormOportunidade']['arquivo']['tmp_name'],SITE_DIR.'webroot/uploads/form_oportunidade/'.$this->data['FormOportunidade']['arquivo']['name']);

				$this->Email->attachments = array($this->data['FormOportunidade']['arquivo']['name'] => $this->data['FormOportunidade']['arquivo']['tmp_name']);
				$this->Email->template = 'oportunidades';
				$this->Email->charset = 'utf-8';
				$this->Email->to = Configure::read('form_oportunidade.to');
				$this->Email->cc = $this->data['FormOportunidade']['email'];
				$this->Email->subject = Configure::read('form_oportunidade.subject');
				$this->Email->from = $this->data['FormOportunidade']['email'];
				$this->Email->sendAs = 'both';

				//As configurações estão no bootstrap
/*				$this->Email->smtpOptions = array(
					'auth' 		=> true,
					'timeout'	=> 10, 
					'port'		=> Configure::read('smtp.port'), 
					'host' 		=> Configure::read('smtp.host'), 
					'username' 	=> Configure::read('smtp.username'), 
					'password' 	=> Configure::read('smtp.password'),
				);
				$this->Email->delivery = 'smtp';
*/
				if(true == $this->Email->send()) {

					$this->redirect('/'.(!isset($this->params['originalArgs']) ? 
						$this->params['url']['url']
						:
						$this->params['originalArgs']['params']['url']['url']
					).'/sucesso');

				} else {

					$this->Session->setFlash(__('Ocorreu um erro ('.$this->Email->smtpError.') ao enviar a mensagem!<br />Por favor, tente novamente.', true),'default',array('class'=>'message_error'),'form');
					//$this->Session->setFlash(__('Por favor, preencha o formulário corretamente!<br />Por favor, tente novamente.', true),'default',array('class'=>'message_error'),'form_msg');

				}
			} else {

				$this->Session->setFlash(__('Por favor, preencha o formulário corretamente!', true),'default',array('class'=>'message_error'), 'form_msg');

			}
		}
		//Seta título da página
		//$this->set('title_for_layout', !empty($pagina['Pagina']['titulo'])?$pagina['Pagina']['titulo']:'Sites recomendados');
		$this->set(compact('pagina'));
		
	}
}