<?php
class SistemasController extends AppController {

	var $name = 'Sistemas';
	var $uses = array('Sistema', 'Usuario');

	var $allowedActions = array('index', 'login', 'logout');
	var $components = array(
		'Cookie',
		'Session', 
		'Acl',
		'RequestHandler', 
		'Auth'
	);

	function beforeFilter() {
		parent::beforeFilter();

		Security::setHash('md5');

		$this->Auth->userModel = 'Usuario';
		$this->Auth->loginAction = array('controller' => 'usuarios', 'action' => 'login', );
		$this->Auth->loginRedirect = '/sistema/';
		$this->Auth->logoutRedirect = '/';
		$this->Auth->authError = __('Área Restrita! Erro de autenticação.', true); // Mensagem ao entrar em area restrita
		$this->Auth->loginError = __('Nome de usuário ou senha não conferem!', true); // Mensagem quando não se autenticar
		$this->Auth->fields = array(
			 'username' => 'email',
			 'password' => 'senha',
		);
		$this->Auth->userScope = array('Usuario.status' => '1', 'Usuario.grupo_id' => '4', );
//		$this->Auth->authorize = 'controller';
		$this->Auth->actionPath = 'controllers/';

		//Se está logado
		if($this->Auth->user('id')){

			//Atribui a permissão da variável allowedAction ao auth
			if(!empty($this->allowedActions)){
				$this->Auth->allowedActions = ($this->allowedActions[0] == '*' ? $this->allowedActions : array_merge($this->allowedActions, (!empty($this->appAllowedActions) ? $this->appAllowedActions : array())));
			}else if(!empty($this->appAllowedActions)){
				$this->Auth->allowedActions = $this->appAllowedActions;
			}
			
			//Verifica se a senha expirou
			$senha_expiracao = Configure::read('Usuario.senha_expiracao');
			if(!empty($senha_expiracao)
				&& !is_null($this->Auth->user('senha_expiracao_original'))
				&& 
					date('Y-m-d', strtotime($this->Auth->user('senha_expiracao_original')) + (24*60*60*($senha_expiracao-1))) 
					<
					date('Y-m-d')
			){
                $this->Session->setFlash(__('A validade de sua senha expirou. Por favor, cadastre uma nova senha de acesso.', true),'default',array('class'=>'message_error'), 'change_pass');
				
				//Se não está na página de troca de senha...
				if($this->name != 'Usuarios' && $this->action != 'change_pass'){
					$this->redirect('/usuarios/change_pass');
				}
			}
		}
		
		//Checa se tem acesso ao controller e a action
		if($this->Auth->user('id') &&
			(empty($this->Auth->allowedActions) 
				|| (!in_array($this->params['action'], $this->Auth->allowedActions) && !in_array('*', $this->Auth->allowedActions))
			) &&
			!$this->Acl->check(array('model'=> 'Usuario', 'foreign_key' => $this->Auth->user('id')), 'controllers/'.$this->name.'/'.$this->params['action'])
		){
			if(isset($this->params['api'])){
				$this->_apiError(004);
			}else{
				$this->redirect('/pages/permissao_negada');
			}
		}

		//Se está com o behavior logable ativo no modelo...
		if ($this->Auth->user('id') && ((!is_null($this->uses) && !is_array($this->uses)) || (is_array($this->uses) && count($this->uses) > 0)) && $this->{$this->modelClass}->Behaviors->attached('Logable')) {
			$this->{$this->modelClass}->setUserData($this->Auth->user());
			$this->{$this->modelClass}->setUserIp($_SERVER['REMOTE_ADDR']);
		} 

	}

	function beforeRender(){
		parent::beforeRender();

		//Api
		if (isset($this->params['api'])) {
			return;
		}

		//Verifica antecipadamente as permissões para gravar o resultado na sessão
		App::import('helper', 'acl');
		$acl_helper = new AclHelper();

	}

	function login(){

		if (!$this->Session->read('Auth.Usuario')){

			if(empty($this->data) && ($this->Session->read('Message.auth.message') == $this->Auth->authError || $this->Session->read('Message.auth.message') == $this->Auth->loginError)){

				$this->Session->delete('Message.auth');
			}


		} else {

			//Armazena informações do grupo
			$this->Session->write('Usuario.Grupo', current($this->Usuario->Grupo->findById($this->Auth->user('grupo_id'))));


			$this->redirect($this->Auth->redirect());
		}

	}

	function logout(){
		$this->redirect($this->Auth->logout()); // efetua logout
	}

	function index() {

		$dir = SITE_DIR.'webroot/uploads/';
		$email_usuario = $this->Auth->user('email'); //email do usuario
		$id_usuario = $this->Auth->user('id'); //id do usuario
		$nome_usuario = $this->Auth->user('nome'); //nome do usuario

		function dirToArray($dir) {

			$result = array(); 

			$cdir = scandir($dir);
			foreach ($cdir as $key => $value) {
				if (!in_array($value,array(".",".."))) {
					if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
						$result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
					} else {
						$result[] = $value;
					}
				}
			}

			return $result; 
		}

		//se usuario estiver fazendo upload
		if($this->RequestHandler->isPost()){

			if($this->Sistema->save($this->data)) {

				$this->Session->setFlash('Seu arquivo foi salvo','default',array('class'=>'alert alert-success with-close-button'), 'form_msg');
				$this->redirect('/sistema/arquivos');

			}
		}

		if(!empty($this->params['pass'])) {

			//logout
			if($this->params['pass'][0] == 'usuarios') {
				if($this->params['pass'][1] == 'logout') {
			 		$this->redirect($this->Auth->logout());
			 	}
			}

			//delete img
			if($this->params['pass'][0] == 'delete') {
				$this->delete($this->params['pass'][1]);
			}

			if($this->params['pass'][0] == 'arquivos') {

				$arquivos = $this->Sistema->find('all', array('conditions'=>array(
					'Sistema.usuario_id' => $id_usuario,
				)));

				$this->set(compact('arquivos', 'nome_usuario'));
				$this->render('arquivos');
			}

			if($this->params['pass'][0] == 'enviar-arquivos') {

				$this->set(compact('id_usuario', 'nome_usuario'));

				$this->render('enviar-arquivos');
			}

			if($this->params['pass'][0] == 'arquivos-restritos') {

				$path = dirToArray($dir);

				$restritos = $path[$email_usuario];

				if($this->params['pass'][1] == 'download') {

					$pasta = $this->params['pass'][2];
					$friendly_url = $this->params['pass'][3];

					if (is_file(SITE_DIR.'webroot/uploads/'.$email_usuario.'/'.$pasta.'/'.$friendly_url)) {

						header('Content-Description: File Transfer');
						header('Content-Type: application/octet-stream');
						header('Content-Disposition: attachment; filename="'.$friendly_url.'"');
						header('Content-Transfer-Encoding: binary');
						header('Expires: 0');
						header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
						header('Pragma: public');
						header('Content-Length: ' . filesize(SITE_DIR.'webroot/uploads/'.$email_usuario.'/'.$pasta.'/'.$friendly_url)); 
						ob_clean();
						flush();
						readfile(SITE_DIR.'webroot/uploads/'.$email_usuario.'/'.$pasta.'/'.$friendly_url);
					    exit();
					}
				}

				$this->set(compact('restritos', 'nome_usuario'));
				$this->render('restritos');
			}

			if($this->params['pass'][0] == 'download') {

				$path = dirToArray($dir);

				$pasta = $this->params['pass'][1];
				$friendly_url = $this->params['pass'][2];

				if (is_file(SITE_DIR.'webroot/uploads/comuns/'.$pasta.'/'.$friendly_url)) {

					header('Content-Description: File Transfer');
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename="'.$friendly_url.'"');
					header('Content-Transfer-Encoding: binary');
					header('Expires: 0');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: public');
					header('Content-Length: ' . filesize(SITE_DIR.'webroot/uploads/comuns/'.$pasta.'/'.$friendly_url)); 
					ob_clean();
					flush();
					readfile(SITE_DIR.'webroot/uploads/comuns/'.$pasta.'/'.$friendly_url);
				    exit();
				}

				$comuns = $path['comuns'];
				$this->set(compact('comuns', 'nome_usuario'));

			}

		} else {

			$path = dirToArray($dir);
			$comuns = $path['comuns'];
			$this->set(compact('comuns', 'nome_usuario'));

		}

	}

	function _apiAuth($api_key = null) {	
		if ($api_key == null) {
			return false;
		}
		
		$userModel = $this->Auth->userModel;
		
		if(!property_exists($this, $userModel)){
			$this->loadModel($userModel);
		}

		$user = $this->$userModel->find('first', array(
			'conditions'=>array($userModel.'.api_key'=>$api_key),
			'contain'=>false
		));
		return $this->Auth->login($user[$userModel]['id']);
	}
	
	function _apiError($code, $msg = false){
		$errors = array(
			001 => __('A chave da API não foi informada', true),
			002 => __('A chave da API é inválida', true),
			003 => __('O método solicitado não existe', true),
			004 => __('Você não tem permissão de acesso a esta função', true),
		);

		$data = array(
			'error' => array(
				'code' => $code,
				'code_msg' => $errors[$code],
				'msg' => $msg,
			)
		);
		
		switch($this->params['url']['ext']){
			case 'xml':
				$xml = new SimpleXMLElement(WebjumpUtilities::array2xml($data));
				echo $xml->asXML();
				break;	
			case 'json':
				echo json_encode($data);
				break;
		}
		exit;
	}

	//Função a chamada em cada action da api imediatamente após o último comando da function 
	function _apiRender(){
		//Define layout
		if($this->RequestHandler->isAjax()){
			$ext = 'json';
		}else{
			$ext = $this->params['url']['ext'];
		}
		
		//Carrega helper do Xml se necessário
		if($ext == 'xml'){
			$this->helpers[] = 'Xml';
		}
		
		$this->render('/elements/'.$ext);
		return;
	}

	function delete($id = null) {

		$this->Sistema->delete('first', array('conditions'=>array(
			'Sistema.id' => $id,
		)));

		$this->Session->setFlash('Seu arquivo deletado com sucesso','default',array('class'=>'alert alert-success with-close-button'), 'form_msg');
		$this->redirect('/sistema/arquivos');
		
	}

}
