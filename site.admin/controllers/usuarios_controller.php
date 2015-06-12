<?php
class UsuariosController extends AppController {

	var $name = 'Usuarios';
	var $allowedActions = array('login', 'logout', 'recoverpass', 'recoverpass_confirm',);
	var $components = array('Email','Cookie');

	function beforeFilter(){
		parent::beforeFilter();

		//Permite o acesso às funções mesmo quando o usuário não está logado
		$this->Auth->allow('recoverpass', 'recoverpass_confirm');

		if(!empty($this->data['Usuario']) && !empty($this->data['Usuario']['senha'])){
			$this->data['Usuario']['senha_plain'] = $this->data['Usuario']['senha'];
		}
	}

	function login_refresh(){
		$this->layout = 'ajax';
		$this->autoRender = false;
		$this->Session->renew();
		echo 1;
	}
	
	function login(){
		
		if (!$this->Session->read('Auth.Usuario')){
			if(empty($this->data) && ($this->Session->read('Message.auth.message') == $this->Auth->authError || $this->Session->read('Message.auth.message') == $this->Auth->loginError)){
				$this->Session->delete('Message.auth');
			}
		
			if (empty($this->data) && Configure::read('Admin.Usuario.remember_me')) {
				$cookie = $this->Cookie->read('remember_me');

				if (!is_null($cookie)) {
					if ($this->Auth->login(array('Usuario' => $cookie))){
						$this->Session->write('Auth.Usuario.Grupo', current($this->Usuario->Grupo->findById($this->Auth->user('grupo_id'))));
						$this->Cookie->write('remember_me', $cookie, true, '+2 weeks');
						//Clear auth message, just in case we use it.
						$this->Session->delete('Message.auth');
						$this->redirect($this->Auth->redirect());
					} else { // Delete invalid Cookie
						$this->Cookie->delete('remember_me');
					}
				}
			}
			
			
			if ( $this->RequestHandler->isAjax()  ) {
				$this->layout = 'ajax';
				$this->set('data', array('valid' => 0, 'error' => __('Usuário/senha incorretos. Por favor, tente novamente.', true)));
				$this->render('/elements/json');
				return;
			}
			$this->layout = 'login';
		} else {
			//Armazena informações do grupo
			$this->Session->write('Auth.Usuario.Grupo', current($this->Usuario->Grupo->findById($this->Auth->user('grupo_id'))));

        	if(!empty($this->data['Usuario']['remember_me'])) {
				$cookie = array(
					'email' => $this->data['Usuario']['email'],
					'senha'	=> $this->data['Usuario']['senha'],
				);
				$this->Cookie->write('remember_me', $cookie, true, '+2 weeks');
				unset($this->data['Usuario']['remember_me']);
			}

			if ( $this->RequestHandler->isAjax() ) {
				$this->layout = 'ajax';
				$this->set('data', array('valid' => true, 'msg' => __('Autenticação realizada com sucesso.', true), 'redirect' => Router::url('/')));
				$this->render('/elements/json');
				return;
			}
			
			$this->redirect($this->Auth->redirect());
		}
	}

	function logout(){
		$this->Cookie->delete('remember_me');
		$this->redirect($this->Auth->logout()); // Efetuamos logout
	}

	function change_pass(){
		if (!empty($this->data)) {
			if(!empty($this->data['Usuario']['senha'])){
				$senha = $this->data['Usuario']['senha'];
				$this->data = $this->Usuario->read(null, $this->Auth->user('id'));
				
				$nova_senha_hash = Security::hash($senha, null, true);
				if($this->data['Usuario']['senha_hash'] == $nova_senha_hash){
					$this->Usuario->invalidate('senha', __('A senha digitada é igual a anterior. Você deve digitar uma diferente.', true));
				}else{				
					$this->data['Usuario']['senha'] = $nova_senha_hash;
		
					if($this->Usuario->save($this->data)) {
						$this->Session->setFlash(__('Sua senha foi atualizada com sucesso!', true),'default',array('class'=>'message success no-margin'), 'auth');
						$this->redirect('logout');
					} else {
						$this->Session->setFlash(__('Sua senha não foi atualizada. Por favor, verifique os erros apresentados.', true),'default',array('class'=>'message_error'));
					}
				}
			}else{
				$this->Usuario->invalidate('senha', __('Você não digitou a nova senha.', true));
			}
		}
	}
	
	function recoverpass(){
		//Se está logado
		if($this->Auth->user('id')) {
			//Faz logout
			$this->Auth->logout();
		}

		$this->layout = 'login';

		//Força mensagem no html
		$this->Session->setFlash(__('Por favor, digite seu usuário', true),'default',array('class'=>'message info no-margin'), 'auth');
		
		//Se enviou os dados
		if($this->RequestHandler->isPost() && !empty($this->data['Usuario']['email'])){
			if($usuario = $this->Usuario->find('first', array('contain' => false, 'conditions' => array('email' => $this->data['Usuario']['email'])))){
				$this->Usuario->id = $usuario['Usuario']['id'];

				$uid = md5(uniqid());
				if($this->Usuario->saveField('uid', $uid)){
					//Envia email usando Email component
					$this->Email->template = 'usuario_recoverpass';
					$this->Email->charset = 'utf-8';
					$this->Email->to = $usuario['Usuario']['email'];
					$this->Email->subject = __('Recuperação de Senha', true);
					$this->Email->from = Configure::read('from.nome').' <'.Configure::read('from.email').'>';
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

					//Define variáveis na view do email
					$this->set('usuario', $usuario);
					$this->set('uid', $uid);
					
					if(true == $this->Email->send()){
						$this->Session->setFlash(__('A troca de sua senha foi solicitada com sucesso. <br />Por favor, clique no link de confirmação que está na mensagem enviada para o seu e-mail.', true),'default',array('class'=>'message success no-margin'), 'auth');

						if ( $this->RequestHandler->isAjax()  ){
							$this->layout = 'ajax';
							$this->set('data', array('valid' => true, 'msg' => __('Solicitação realizada com sucesso.', true), 'redirect' => Router::url(array('action' => 'login'))));
							$this->render('/elements/json');
							return;
						}
						
						$this->redirect(array('action' => 'login'));
					}else{
						$msg = __('Ocorreu um erro ('.$this->Email->smtpError.') ao enviar a mensagem!<br />Por favor, tente novamente.', true);
					}
				}else{
					$msg = __('Ocorreu uma falha na geração da nova senha!', true);
				}
			}else{
				$msg = __('O e-mail informado não está cadastrado!', true);
			}

			if ( $this->RequestHandler->isAjax() ){
				$this->layout = 'ajax';
				$this->set('data', array('valid' => 0, 'error' => $msg));
				$this->render('/elements/json');
				return;
			}

			$this->Session->setFlash($msg,'default',array('class'=>'message error no-margin'), 'auth');
		}
	}
	
	function recoverpass_confirm($uid = null){
		//Se está logado
		if($this->Auth->user('id')) {
			//Faz logout
			$this->Auth->logout();
		}

		if(empty($uid)){
			$msg = __('O código de confirmação não foi informado.', true);
			if ( $this->RequestHandler->isAjax() ){
				$this->layout = 'ajax';
				$this->set('data', array('valid' => 0, 'error' => $msg));
				$this->render('/elements/json');
				return;
			}
			$this->Session->setFlash($msg, 'default',array('class'=>'message error no-margin'), 'auth');
			$this->redirect('login');
		}
		
		if(!$usuario = $this->Usuario->find('first', array('contain' => false, 'conditions' => array('uid' => $uid)))){
			$msg = __('O código de confirmação informado é inválido.', true);
			if ( $this->RequestHandler->isAjax() ){
				$this->layout = 'ajax';
				$this->set('data', array('valid' => 0, 'error' => $msg));
				$this->render('/elements/json');
				return;
			}
			$this->Session->setFlash($msg, 'default',array('class'=>'message error no-margin'), 'auth');
			$this->redirect('login');
		}
		
		$this->Session->setFlash(__('Olá '.$usuario['Usuario']['apelido'].', por favor digite sua nova senha e clique em <i>Gerar nova senha</i>.', true),'default',array('class'=>'message info no-margin'), 'auth');

		if(($this->RequestHandler->isPost() || $this->RequestHandler->isPut()) && !empty($this->data['Usuario'])){
			$this->data['Usuario']['uid'] = null;
			
			$this->data['Usuario']['id'] = $usuario['Usuario']['id'];
			
			$this->Usuario->set($this->data);

			$this->Usuario->validate['senha_confirmacao'] = array(
				'rule' => array('equalTo', $this->data['Usuario']['senha']),
				'message' => 'A confirmação da senha está diferente.',
			);

			$this->data['Usuario']['senha'] = Security::hash($this->data['Usuario']['senha'], null, true);

			if($this->Usuario->validates(array('fieldList' => array('senha', 'senha_confirmacao'))) && $this->Usuario->save($this->data, array('fieldList' => array('senha','uid','senha_expiracao', 'modified'), 'validate' => false))){
				$this->Session->setFlash(__('Sua senha foi alterada com sucesso.<br />Por favor, faça seu login.', true),'default',array('class'=>'message success no-margin'), 'auth');

				if ( $this->RequestHandler->isAjax()  ){
					$this->layout = 'ajax';
					$this->set('data', array('valid' => true, 'msg' => __('Alteração realizada com sucesso.', true), 'redirect' => Router::url(array('action' => 'login'))));
					$this->render('/elements/json');
					return;
				}

				$this->redirect('login');
			}else{
				$msg = implode('<br />', $this->Usuario->validationErrors);
				if ( $this->RequestHandler->isAjax()  ){
					$this->layout = 'ajax';
					$this->set('data', array('valid' => 0, 'error' => $msg));
					$this->render('/elements/json');
					return;
				}

				$this->Session->setFlash($msg,'default',array('class'=>'message error no-margin'), 'auth');

			}
		}
		
		$this->layout = 'login';
		
		$this->data = $usuario;
		$this->set(compact('uid', 'usuario'));
	}

	function update_api_key($id = null){
		if(empty($id)){
			$this->Session->setFlash(__('O código do usuário não foi informado.', true),'default',array('class'=>'message_error'));
			$this->redirect('index');
		}
		else if(!($this->data = $this->Usuario->read(null, $id))){
			$this->Session->setFlash(__('Não foi possível ler os dados do usuário informado.', true), 'default',array('class'=>'message_success'));
			$this->redirect('index');
		}
		else{
			$api_key = $this->Usuario->update_api_key();
			$this->data['Usuario']['api_key'] = $api_key;

			if($this->Usuario->save($this->data, array('fieldList' => array('api_key'), 'validate' => false))) {
				$this->Session->setFlash(sprintf(__('A chave da API é <b>%s</b>.', true), $api_key),'default',array('class'=>'message_success'));
			}
			else{
				$this->Session->setFlash(__('Sua chave não foi atualizada. Por favor, verifique os erros apresentados.', true),'default',array('class'=>'message_error'));
			}
			$this->redirect('edit/'.$id);
		}
	}
	
	function index() {
		$this->_admin_index();
	}

	function add() {

		if($this->data['Usuario']['grupo_id'] == '4') {
			$pasta = SITE_DIR.'webroot/uploads/';

			$dir = new Folder($pasta.$this->data['Usuario']['email'], true, 0777);
		}

		$this->_admin_add();
	}

	function edit($id = null) {

		$this->_admin_edit($id);
	}

	function delete($id = null) {
		if($this->Session->read('Auth.Usuario.id') == $id){
			$this->Session->setFlash(__('Você não pode remover seu próprio usuário.', true),'default',array('class'=>'message_error'));
			$this->redirect('index');
		}
	
		$this->_admin_delete($id);
	}

}
