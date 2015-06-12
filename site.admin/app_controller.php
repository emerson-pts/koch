<?php
if($_SERVER['REMOTE_ADDR'] == '::1')$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
class AppController extends Controller {
	var $helpers = array('Session', 'Html', 'Javascript', 'Text', 'Form', 'Formatacao', 'Acl', 'Js' => array('Jquery'), 'Webjump',);
	var $components = array(
		'Session', 
		'Acl',
		'RequestHandler', 
		'Auth',
	);
	var $layout = 'admin';
	var $uses = array('Configuration',);
	
	function beforeFilter(){
		Security::setHash('md5');

		//Carrega configurações
		if(!isset($this->Configuration)){App::import('Model', 'Configuration');$this->Configuration = new Configuration();}
		if(is_object($this->Configuration))$this->Configuration->load();

		$this->Auth->userModel = 'Usuario';
		$this->Auth->loginAction = array('controller' => 'usuarios', 'action' => 'login', );
		$this->Auth->loginRedirect = (($loginRedirect = Configure::read('Admin.loginRedirect')) ? $loginRedirect : '/');
		$this->Auth->logoutRedirect = '/';
		$this->Auth->authError = __('Área Restrita! Erro de autenticação.', true); // Mensagem ao entrar em area restrita
		$this->Auth->loginError = __('Nome de usuário ou senha não conferem!', true); // Mensagem quando não se autenticar
		$this->Auth->fields = array(
			 'username' => 'email',
			 'password' => 'senha',
		);
		$this->Auth->userScope = array('Usuario.status' => '1');
//		$this->Auth->authorize = 'controller';
		$this->Auth->actionPath = 'controllers/';

		//Se a ação é ajax, então desliga o redirecionamento automático do auth
		if ($this->RequestHandler->isAjax()) { 
			$this->layout = 'ajax';
			$this->Auth->autoRedirect = false;
		}

		//login via api
		if (isset($this->params['api'])) {
			//Define layout
			$this->layout = $this->params['url']['ext'];
			
			//Carrega funções de xml
			if($this->params['url']['ext'] == 'xml'){
				App::import('Vendor','WebjumpUtilities');
			}
			
			//Se enviou a chave do api
			if (!isset($this->params['url']['api_key'])){
				$this->_apiError(001);//API key não enviada
			}
			else {
				//Authenticate a user using api key
				if($this->_apiAuth($this->params['url']['api_key'])) {
					if(!method_exists($this, $this->params['action'])){
						$this->_apiError(003);//Método não existe
					}
				}
				//Não autenticou
				else {
					$this->_apiError(002);//Falha para autenticar
				}
			}
		}

		//Descomente a linha abaixo para inibir a requisição de senha no admin
		//$this->Auth->allow('*');		

		//Força a action padrão aparecer no URL quando ela não aparecer na variável url
		if(!preg_match('/^'.preg_quote($this->params['controller'], '/').'\/'.$this->params['action'].'(\/|$)/', $this->params['url']['url'])){
			$this->params['url']['url'] = preg_replace('/^('.preg_quote($this->params['controller'], '\/?/').')(\/|$)/','\1/'.$this->params['action'], $this->params['url']['url']);
		}
		
		if($this->params['url']['url'] == '/')$this->params['url']['url'] = $this->params['controller'].'/'.$this->params['action'];

		//Se está logado
		if($this->Auth->user('id')){
			//Atribui a permissão da variável allowedAction ao auth
			if(!empty($this->allowedActions)){
				$this->Auth->allowedActions = ($this->allowedActions[0] == '*' ? $this->allowedActions : array_merge($this->allowedActions, (!empty($this->appAllowedActions) ? $this->appAllowedActions : array())));
			}else if(!empty($this->appAllowedActions)){
				$this->Auth->allowedActions = $this->appAllowedActions;
			}
			
			//Verifica se a senha expirou
			$senha_expiracao = Configure::read('Admin.Usuario.senha_expiracao');
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

		//KCFINDER - início
		//Ajusta configurações do KCFinder
		$_SESSION['KCFINDER'] = array(); //Reseta configurações do KCFINDER
		$_SESSION['KCFINDER']['denyExtensionRename'] = true;
		$_SESSION['KCFINDER']['uploadURL'] = str_replace('.admin', '', $this->base.'/img/upload/');
		$_SESSION['KCFINDER']['uploadDir'] = SITE_DIR.'webroot/img/upload/';
		$_SESSION['KCFINDER']['dirPerms'] = (strstr($_SERVER['SERVER_NAME'], 'localhost') ? 0777 : 0755);
		$_SESSION['KCFINDER']['disabled'] = true; //Desativa o KCFinder

		if($this->Auth->user('id')){
			$_SESSION['KCFINDER']['disabled'] = false; //Habilita KCFinder somente se estiver logado
		}
		//KCFINDER - fim

		return true;
	}
	
	function beforeRender(){
		//Api
		if (isset($this->params['api'])) {
			return;
		}

		if ($this->RequestHandler->isAjax()){$this->set('isAjax', true);}

		//Verifica se o nome do controller tem tradução humanizada
		if (!Configure::read('controllerTraduzido.'.$this->name))Configure::write('controllerTraduzido.'.$this->name, (!empty($this->pageTitle) ? $this->pageTitle : $this->name));
		
		//Seta o título da página
		$this->set('controller',preg_replace('/^\*/','',Configure::read('controllerTraduzido.'.$this->name)));
		$this->set('title_for_layout', preg_replace('/^\*/','',Configure::read('controllerTraduzido.'.$this->name)));

		//Verifica antecipadamente as permissões para gravar o resultado na sessão
		App::import('helper', 'acl');
		$acl_helper = new AclHelper();
		
		$menu = Configure::read('Admin.menu');
		array_walk_recursive($menu,create_function('$v, $k, $func', 'if(is_string($v) && $v != "/")$func->check("controllers".preg_replace("#^(/[^/]+/[^/]+).*$#", "\\\1",$v), "*", true);'), $acl_helper);

		$this->set('menu', $menu);

		//Verifica se alguma das tabelas do modelo aceita tradução
		$translate_avaliable = false;
		if(Configure::read('Config.languages_options')){
			if(!empty($this->uses)){
				$modelos = (!is_array($this->uses) ? array($this->uses) : $this->uses);
			}else{
				$modelos = array(Inflector::singularize($this->name));
			}
	
			foreach($modelos AS $modelo){
				if(!empty($this->{$modelo}->useDbConfig) && $this->{$modelo}->useDbConfig == 'translated'){
					$translate_avaliable = true;
					break;
				}
			}
		}
		$this->set('translate_avaliable', $translate_avaliable);
		
		//breadcrumbs
		$breadcrumbs = array('/' => 'Home');
		
		//Controller??
		if(!($controller_atual = Configure::read('controllerTraduzido.'.$this->name)))$controller_atual = $this->name;
		$breadcrumbs[ '/'.$this->params['controller'] ] = $controller_atual;

		//Action??
		if(!($controller_atual = Configure::read('controllerTraduzido.'.$this->params['action'])))$controller_atual = $this->params['action'];
		$breadcrumbs[ null ] = '<span>'.$controller_atual.'</span>';
		
		$this->set('breadcrumbs', $breadcrumbs);
		
		//Verifica se foi realizado o setup através do modelo. Caso não tenha sido, seta variáveis padrão
		if(!isset($this->viewVars['setup'])){
			$this->viewVars['setup'] = array(
				'topLink' => array(),
				'topLinkLeft' => array(),
			);
		}
		
	}
	
	function _admin_index(){
		if(empty($this->modelClass))return;
		
		$model = (!is_array($this->modelClass) ? $this->modelClass : $this->modelClass[0]);
		$model_obj = $this->$model;
		$setupAdmin = $model_obj->setupAdmin($this->action);
		$this->set('setup', $setupAdmin);
	
		$this->paginate[$model] = array(
			'order' => (!empty($setupAdmin['defaultOrder']) ? $setupAdmin['defaultOrder'] : (isset($model_obj->order) ? $model_obj->order : array($model.'.id' => 'DESC'))),
			'conditions' => array(),
		);

		//Limite padrão
		$this->paginate[$model]['limit'] = (!empty($setupAdmin['defaultLimit']) ? $setupAdmin['defaultLimit'] : 50);
		
		//Ativa somente modelos especificados, caso esteja configurado no modelo
		if(array_key_exists('containIndex', $setupAdmin)){
			$this->paginate[$model]['contain'] = $setupAdmin['containIndex'];
		}

		//Ativa grupo, caso esteja configurado no modelo
		if(array_key_exists('groupIndex', $setupAdmin)){
			$this->paginate[$model]['group'] = $setupAdmin['groupIndex'];
		}

		//Filtros
		foreach($this->params['named'] AS $param=>$filter_value){
			if(!preg_match('/^filter\[(.*)\]$/',$param, $filter_key)){
				continue;
			}
			
			$filter_key = $filter_key[1];
			if((isset($setupAdmin['allowFilter']) && $setupAdmin['allowFilter'] === true) 
			|| (isset($setupAdmin['allowFilter'][$filter_key]) && $filter_value != '*' && (empty($setupAdmin['allowFilter'][$filter_key]['only_options']) || ($setupAdmin['allowFilter'][$filter_key]['only_options'] && array_key_exists($this->params['named']['filter['.$filter_key.']'], $setupAdmin['allowFilter'][$filter_key]['options']))))
			|| (isset($setupAdmin['box_filter'][$filter_key]) && $filter_value != '*' && (empty($setupAdmin['box_filter'][$filter_key]['only_options']) || ($setupAdmin['box_filter'][$filter_key]['only_options'] && array_key_exists($this->params['named']['filter['.$filter_key.']'], $setupAdmin['box_filter'][$filter_key]['options']))))){
				$this->paginate[$model]['conditions'][$filter_key] = (preg_match('/ LIKE$/i', $filter_key) ? str_replace('*', '%', $filter_value) : $filter_value);
			}
		}

		//Busca
		if(!empty($setupAdmin['searchFields']) && !empty($this->params['named']['search'])){
			$search = str_replace(array("'","-","*","/","\\","(",")"," "),'%',$this->params['named']['search']);
			$search_fields = $setupAdmin['searchFields'];
			
			
			$search_condition = array();
			foreach($search_fields AS $value){
				$search_condition[$value.' LIKE'] = '%'.$search.'%';
			}
			$this->paginate[$model]['conditions'][] = array('OR' => $search_condition);
		}

		//Filtro de limite
		if (!empty($this->params['named']['limit']))$this->paginate[$model]['limit'] = $this->params['named']['limit'];

		$results = $this->paginate($model);
		$this->set(compact('results', 'model'));

		//Exibe log de alterações
		if(!empty($setupAdmin['showLog']) && ($setupAdmin['showLog'] === true || in_array('index', $setupAdmin['showLog'])))
			$this->set('log', array('models' => array($model)));
			
		//Se não existe uma view para esta action, então usa o admin padrão
		if(!file_exists(VIEWS.Inflector::underscore($this->params['controller']).DS.Inflector::underscore($this->params['action']).'.ctp'))
			$this->render('/elements/admin/index');
		
		return $results;
	}
	
	function _admin_add() {
		
		$model = (!is_array($this->modelClass) ? $this->modelClass : $this->modelClass[0]);
		$model_obj = $this->$model;
		$setupAdmin = $model_obj->setupAdmin($this->action);
		if(!empty($setupAdmin['helpers'])){$this->helpers = array_merge($this->helpers, $setupAdmin['helpers']);}

		if (($this->RequestHandler->isPost() || $this->RequestHandler->isPut() || $this->RequestHandler->isAjax()) && !empty($this->data)) {

			$model_obj->create();
			
			//Carrega configuração de gravação do modelo
			if(empty($setupAdmin['save_function']))$setupAdmin['save_function'] = 'save';
			
			if(!empty($setupAdmin['save_params']))
				$params = $setupAdmin['save_params'];
			else
				$params = array();
			
			if ($model_obj->$setupAdmin['save_function']((empty($setupAdmin['save_data']) ? $this->data : $this->data[$setupAdmin['save_data']]), $params)) {
				//Atualiza informações do setup levando em conta o id
				$setupAdmin = $model_obj->setupAdmin($this->action, $model_obj->id);
				
				$msg = __('O cadastro realizado com sucesso!', true);
				
				//Se a chamada foi via api ou ajax, define o retorno
				if(isset($this->params['api']) || $this->RequestHandler->isAjax()){
					$this->set('data', array(
						'return' => true, 
						'id' => $model_obj->id, 
						'msg' => $msg,
						'data'=> $this->data,
					));
					$this->_apiRender();
					return;
				}
				
                $this->Session->setFlash($msg, 'default',array('class'=>'message_success'));
				$this->redirect((empty($setupAdmin['save_redirect_add']) ? array('action' => 'index') : $setupAdmin['save_redirect_add'] + array(0 => $model_obj->id)) + $this->params['named']);
			} else {
				$msg = __('O cadastro não foi efetuado. Por favor, verifique os erros apresentados.', true);
				
				//Se a chamada foi via api ou ajax, define o retorno
				if(isset($this->params['api']) || $this->RequestHandler->isAjax()){
					$this->set('data', array(
						'return' => false, 
						'msg' => $msg,
						'validationErrors' => $model_obj->validationErrors,
						'data' => $this->data,
					));
					$this->_apiRender();
					return;
				}
                $this->Session->setFlash($msg, 'default', array('class'=>'message_error'));
			}
		}
		
		if(isset($this->params['api'])){
			$this->set('data', array(
				'return' => false, 
				'msg' => __('Nenhuma informação foi enviada', true),
				'data'=> $this->data,
			));
			$this->_apiRender();
			return;
		}
		
		$this->set(compact('model'));
		if(!empty($setupAdmin)){
			$this->set('setup', $setupAdmin);
		}

		$arquivo = Inflector::singularize( $this->params['controller'] );
		if(!file_exists(VIEWS.'elements/form/'.$arquivo.'.ctp')){
			$this->set('form_file', 'admin/form/default');
		}else{
			$this->set('form_file', 'form/'.$arquivo);
		}

		//Se não existe uma view para esta action, então usa o admin padrão
		if(!file_exists(VIEWS.Inflector::underscore($this->params['controller']).DS.Inflector::underscore($this->params['action']).'.ctp')){
			$this->render('/elements/admin/add');
		}
	}
	
	function _admin_edit($id = null) {
		//Se necessitar editar diversos registros, ou o carregamento dos dados originais não for convencional
		//envie no lugar do $id, a array dos dados originais
		
		$model = (!is_array($this->modelClass) ? $this->modelClass : $this->modelClass[0]);
		$model_obj = $this->$model;
		$setupAdmin = $model_obj->setupAdmin($this->action, $id);
		
		if(!empty($setupAdmin['helpers'])){$this->helpers = array_merge($this->helpers, $setupAdmin['helpers']);}

		$redirect = (!empty($setupAdmin['save_redirect_edit']) ? 
			$setupAdmin['save_redirect_edit'] + $this->params['named']
			:
			(!preg_match('/^\/'.$this->params['controller'].'\//', $this->referer()) ?
				$this->referer()
				:
				array('action' => 'index') + $this->params['named']
			)
		);
		
		if (
			($this->RequestHandler->isPost() || $this->RequestHandler->isPut() || $this->RequestHandler->isAjax()) && 
			!$id && 
			empty($this->data)
		){
			$this->Session->setFlash(__('Cadastro não informado!', true),'default',array('class'=>'message_error'));
			$this->redirect($redirect);
		}

		//Ativa somente modelos especificados, caso esteja configurado no modelo
		if(array_key_exists('containAddEdit', $setupAdmin)){
			$model_obj->contain($setupAdmin['containAddEdit']);
		}

		//Recupera dados originais para exibir no form, se o id não é array
		//Se não conseguir, retorna erro
		if(!is_array($id) && !$dados_originais = $this->$model->read(null, $id)){
			$this->Session->setFlash(__('Cadastro não encontrado!', true),'default',array('class'=>'message_error'));
			$this->redirect($redirect);
		}else if(is_array($id)){
			$dados_originais = $id;
		}

		$this->set('dados_originais', $dados_originais);

		if (!empty($this->data)) {
			//Verifica qual a função de save que deve utilizar (ex.: save // saveAll
			if(empty($setupAdmin['save_function']))$setupAdmin['save_function'] = 'save';

			//Carrega configuração de gravação do modelo
			if(!empty($setupAdmin['save_params'])){
				$params = $setupAdmin['save_params'];
			}else{
				$params = array();
			}
			
			$model_obj->create();
			
			if ($model_obj->$setupAdmin['save_function']((empty($setupAdmin['save_data']) ? $this->data : $this->data[$setupAdmin['save_data']]), $params)) {
				$this->Session->setFlash(__('O cadastro foi atualizado com sucesso!', true),'default',array('class'=>'message_success'));
				$this->redirect($redirect);
			} else {
				$this->Session->setFlash(__('O cadastro não foi atualizado. Por favor, verifique os erros apresentados.', true), 'default',array('class'=>'message_error'));
			}
		}

		if (empty($this->data)) {
			$this->data = $dados_originais;
			$this->data[$model]['redirect'] = $this->referer();
		}

		$this->set(compact('model'));

		//Exibe log de alterações
		if(!empty($setupAdmin['showLog']) && ($setupAdmin['showLog'] === true || in_array('edit', $setupAdmin['showLog'])))
			$this->set('log', array('models' => array($model), 'data' => array($model => array('id' => $dados_originais[$model]['id']))));

		$this->set('setup', $setupAdmin);

		$arquivo = Inflector::singularize( $this->params['controller'] );
		if(!file_exists(VIEWS.'elements/form/'.$arquivo.'.ctp')){
			$this->set('form_file', 'admin/form/default');
		}else{
			$this->set('form_file', 'form/'.$arquivo);
		}

		//Se não existe uma view para esta action, então usa o admin padrão
		if(!file_exists(VIEWS.Inflector::underscore($this->params['controller']).DS.Inflector::underscore($this->params['action']).'.ctp')){
			$this->render('/elements/admin/edit');
		}

	}

	function _admin_delete($id = null) {
		$model = (!is_array($this->modelClass) ? $this->modelClass : $this->modelClass[0]);
		$model_obj = $this->$model;
		$setupAdmin = $model_obj->setupAdmin($this->action, $id);

		//Se não enviou id
		if (!$id) {
            $this->Session->setFlash(__('O registro não informado.', true),'default',array('class'=>'message_error'));
			$this->redirect(array('action'=>'index') + $this->params['named']);
		}
		
		//Se não enviou os dados através de ajax ou post...
		if (!(($this->RequestHandler->isPost() || $this->RequestHandler->isPut() || $this->RequestHandler->isAjax()) && !empty($this->data))){
			//Exibe formulário de confirmação
			if(!$dados_originais = $this->$model->read(null, $id)){
				$this->Session->setFlash(__('Cadastro não encontrado!', true),'default',array('class'=>'message_error'));
				$this->redirect(array('action'=>'index') + $this->params['named']);
			}
			
			$this->set('setup', $setupAdmin);
			$this->set(compact('model', 'dados_originais'));
	
			//Se não existe uma view para esta action, então usa o admin padrão
			if(!file_exists(VIEWS.Inflector::underscore($this->params['controller']).DS.Inflector::underscore($this->params['action']).'.ctp')){
				$this->render('/elements/admin/delete');
			}
			return;
		}
		
		//Verifica se enviou a confirmação
		if(empty($this->data[$model]['delete_confirm'])){
			$this->Session->setFlash(__('Você não confirmou que deseja apagar o registro!', true),'default',array('class'=>'message_error'));
			$this->redirect('/'.$this->params['url']['url']);
			return;
		}
		//Se o modelo utiliza o id para remover
		else if ((empty($setupAdmin['delete_id']) || $setupAdmin['delete_id'] == 'id') && $model_obj->delete($id)) {
			$this->Session->setFlash(__('O registro foi removido com sucesso!', true),'default',array('class'=>'message_success'));
		}
		//Se o modelo utiliza outro campo para condição de remoção
		else if (!empty($setupAdmin['delete_id']) && $setupAdmin['delete_id'] != 'id' && $model_obj->deleteAll(array($setupAdmin['delete_id'] => $id),$cascade = true, $callbacks = true)) {
			$this->Session->setFlash(__('O registro foi removido com sucesso!', true),'default',array('class'=>'message_success'));
		}
		//Se falhou na remoção
		else{
			if(isset($model_obj->deleteErrorMsg)){
				$this->Session->setFlash($model_obj->deleteErrorMsg, 'default',array('class'=>'message_error'));
			}else{
				$this->Session->setFlash(__('O registro não foi removido!', true), 'default',array('class'=>'message_error'));
			}
		}
		$this->redirect(array('action'=>'index') + $this->params['named']);
	}
	
	function _admin_view($id = null) {		
		//Se não enviou id
		if (!$id) {
            $this->Session->setFlash(__('O registro não foi informado.', true),'default',array('class'=>'message_error'));
			$this->redirect(array('action'=>'index') + $this->params['named']);
		}
	
		$model = (!is_array($this->modelClass) ? $this->modelClass : $this->modelClass[0]);
		$model_obj = $this->$model;
		$setupAdmin = $model_obj->setupAdmin($this->action, $id);
		
		if(!empty($setupAdmin['helpers'])){$this->helpers = array_merge($this->helpers, $setupAdmin['helpers']);}

		//Ativa somente modelos especificados, caso esteja configurado no modelo
		if(array_key_exists('containView', $setupAdmin)){
			$model_obj->contain($setupAdmin['containView']);
		}
		else if(array_key_exists('containAddEdit', $setupAdmin)){
			$model_obj->contain($setupAdmin['containAddEdit']);
		}

		//Recupera dados originais
		//Se não conseguir, retorna erro
		if(!$dados_originais = $this->$model->read(null, $id)){
			$this->Session->setFlash(__('Cadastro não encontrado!', true),'default',array('class'=>'message_error'));
			$this->redirect(array('action'=>'index') + $this->params['named']);
		}

		$this->set('dados_originais', $dados_originais);
		$this->data = $dados_originais;
		
		$this->set(compact('model'));

		//Exibe log de alterações
		if(!empty($setupAdmin['showLog']) && ($setupAdmin['showLog'] === true || in_array('view', $setupAdmin['showLog']) || in_array('edit', $setupAdmin['showLog']))){
			$this->set('log', array('models' => array($model), 'data' => array($model => array('id' => $dados_originais[$model]['id']))));
		}
		
		$this->set('setup', $setupAdmin);

		//Se não existe uma view para esta action, então usa o admin padrão
		if(!file_exists(VIEWS.Inflector::underscore($this->params['controller']).DS.Inflector::underscore($this->params['action']).'.ctp')){
			$this->render('/elements/admin/view');
		}
	}

	function _autocomplete($conf) { 
		//if ($this->RequestHandler->isAjax() && $this->RequestHandler->isPost()) { 
			$fieldsQuery = $fields = explode(",",$this->params['form']['fields']); 
			$key = array_search('itemLabel', $fieldsQuery);
			if(!is_null($key)){
				unset($fieldsQuery[$key]);
			}
			
			if(isset($conf['itemLabel']))$itemLabel = $conf['itemLabel'];
			
			
			if(!empty($itemLabel)){
				$fieldsQuery[] = $itemLabel.' as itemLabel';
			}else{
				$fieldsQuery[] = $this->params['form']['search'].'` as `itemLabel';
			}
			
			$conditions = array('OR' => array());
			
			foreach(explode('|', str_replace(array('{','}'), '', $this->params['form']['search'])) AS $search){
				if($search == $this->{$this->params['form']['model']}->alias.'.id' && is_numeric($this->params['form']['query'])){
					$conditions['OR'][$search.' LIKE'] = '%'.(int)$this->params['form']['query'].'%';
				}else{
					$conditions['OR'][$search.' LIKE'] = '%'.$this->params['form']['query'].'%';
				}
			}
			
			if(isset($conf['conditions']))$conditions += $conf['conditions'];
			
			$results = $this->{$this->params['form']['model']}->find('all', array(
				'conditions'=> $conditions,
				'fields'	=> $fieldsQuery,
				'order'		=> preg_replace('/^\{?[^\.]*\.(.*?)(?:\|.*|$)/', '\1', $this->params['form']['search']).' ASC',
				'limit'		=> $this->params['form']['numresult'],
				'contain'	=> array(),
			)); 
			$this->set('results',$results);
			$this->set('fields',$fields); 
			$this->set('query', $this->params['form']['query']);
			$this->set('model',$this->params['form']['model']); 
			$this->set('input_id',$this->params['form']['rand']); 
			$this->render('/elements/ajax/autocomplete');//,'ajax');                 
//			$this->render('autocomplete','ajax','/elements/ajax/autocomplete');                 
		//} 
	}


	/**
	 * Helper function to authenticate a user given their api key.
	 *
	 * @param $api_key String API key for the request
	 * @return Boolean
	 */
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
}