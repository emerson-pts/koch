<?php
class FormNewslettersController extends AppController {

	var $name = 'FormNewsletters';
	var $components = array('Email');
	var	$cacheAction = false;
	
	var $uses = array('FormNewsletter');
		
	function index(){
		$this->autoRender = false;

		if($this->RequestHandler->isPost()){			
			if($this->FormNewsletter->save($this->data)){
				//Envia email usando Email component
				$this->Email->template = 'post_data';
				//$this->Email->delivery = 'debug';
				$this->Email->charset = 'utf-8';

 				$this->Email->from = $this->data['FormNewsletter']['nome'].'<'.Configure::read('from.email').'>';
				$this->Email->to = Configure::read('FormNewsletter.to');
				$this->Email->replyTo = $this->data['FormNewsletter']['email'];
				$this->Email->subject = Configure::read('FormNewsletter.subject');

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
					$this->Session->setFlash(Configure::read('FormNewsletter.mensagem'),'default',array('class'=>'alert alert-success with-close-button'), 'form_newsletter');
					$this->redirect($this->referer().'#box-newsletter');
				}else{
					$this->Session->setFlash(__('Seu e-mail foi cadastrado com sucesso. Porém ocorreu um erro ('.$this->Email->smtpError.') ao enviar a mensagem de notificação!.', true),'default',array('class'=>'alert alert-error with-close-button'), 'form_newsletter');
				}

			}else{
				$this->Session->write('data.FormNewsletter', $this->data['FormNewsletter']);
				$this->Session->setFlash(__('Por favor, preencha o formulário de newsletter corretamente!<br />'.implode(' ', $this->FormNewsletter->validationErrors), true),'default',array('class'=>'alert alert-error with-close-button'), 'form_newsletter');
			}
		}
		$this->redirect($this->referer().'#box-newsletter');
	}
}