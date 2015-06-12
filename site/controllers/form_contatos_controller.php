<?php
class FormContatosController extends AppController {

	var $name = 'FormContatos';
	var $components = array('Email');
	var $uses = array('Banner', );
	var	$cacheAction = false;

	function index_ok(){
	}
	function index(){

		$this->set('banners', $this->Banner->getBanner($area = 'contato') );

		if ($this->RequestHandler->isPost()){

			$this->FormContato->set($this->data);

			if ($this->FormContato->validates()) {

				//Envia email usando Email component
				$this->Email->template = 'post_data';
				$this->Email->charset = 'utf-8';
				$this->Email->to = Configure::read('form_contato.to');
				$this->Email->subject = Configure::read('form_contato.subject');
				$this->Email->from = $this->data['FormContato']['email'];
				$this->Email->sendAs = 'both';

				/*$this->Email->from = $this->data['FormContato']['nome'].'<'.$this->data['FormContato']['email'].'>';
				$this->Email->from = Configure::read('site.title').'<'.Configure::read('smtp.from_email').'>';
				$this->Email->replyTo = $this->data['FormContato']['email'];
				$this->Email->cc = array($this->data['FormContato']['email']);
				$this->Email->sendAs = 'both';*/

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
					$this->Session->setFlash(Configure::read('form_contato.mensagem'),'default',array('class'=>'message_success'),'form_msg');
					unset($this->data);
					$this->redirect('/');
				}else{
					$this->Session->setFlash(__('Ocorreu um erro ('.$this->Email->smtpError.') ao enviar a mensagem!<br />Por favor, tente novamente.', true),'default',array('class'=>'message_error'),'form');
					//$this->Session->setFlash(__('Por favor, preencha o formulário corretamente!<br />Por favor, tente novamente.', true),'default',array('class'=>'message_error'),'form_msg');
				}
			}else{
				$this->Session->setFlash(__('Por favor, preencha o formulário corretamente!', true),'default',array('class'=>'message_error'), 'form_msg');
			}
		}
		//Seta título da página
		//$this->set('title_for_layout', !empty($pagina['Pagina']['titulo'])?$pagina['Pagina']['titulo']:'Sites recomendados');
		$this->set(compact('pagina'));
		
	}
}