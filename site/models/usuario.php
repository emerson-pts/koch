<?php
class Usuario extends AppModel {
	var $name = 'Usuario';
	var $displayField = 'nome';
	var $actsAs = array('Acl' => array('requester'));
	var $order = 'Usuario.nome ASC';

	var $options = array('status' => array('1' => 'Ativo', '0' => 'Inativo'));
	
	var $belongsTo = array(
		'Grupo' => array(
			'className' => 'Grupo',
			'foreignKey' => 'grupo_id',
			'conditions' => '',
			'fields' => array('id','nome'),
			'order' => ''
		)
	);

	var $validate = array(
		'email' => array(
			'email' => array(
				'rule'=>'email',
				'required'=>true,
				'allowEmpty'=>false,
				'message'=>	'E-mail inválido.',
			),
			'maxLength' => array(
				'rule' => array('maxLength', 50),
				'message' => 'O e-mail deve conter no máximo 50 caracteres.',
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'Este e-mail já está cadastrado.',
			),
		),
	
		'grupo_id' => array(
			'rule' => 'numeric',
			'required'=>true,
			'allowEmpty'=>false,
			'message'=>'Por favor, selecione um grupo.', 
		),
			
			
		'nome' => array(
			'rule' => 'notEmpty',
			'required'=>true,  
			'allowEmpty'=>false,
			'message'=>'Por favor, digite seu nome completo.', 
		),
		
		'senha' => array(
			'rule'=>'_validateSenha', 
			'required'=>true,  
			'allowEmpty'=>false,
			'message'=>'Por favor, digite uma senha com pelo menos 6 caracteres.', 
		),
		
		'status' => array(
			'rule'=>array('inList', array('0', '1')), 
			'required'=>true,  
			'allowEmpty'=>false,
			'message'=>'Por favor, informe o status.', 
		),
		
	);

	function parentNode(){
		if(!$this->id & empty($this->data)){
			return null;
		}
		if(empty($this->data)){
			$data = $this->read();
		}else{
			$data = $this->data;
		}
		if(empty($data['Usuario']['grupo_id'])){
			return null;
		}else{
			return array('Grupo' => array('id' => $data['Usuario']['grupo_id']));
		}
	}
	
	function _validateSenha($senha){	

		//Se solicitou a geração de senha
		if(!empty($this->data[$this->alias]['password_create'])){
			$this->data[$this->alias]['senha'] = '';
			return true;
		}
		//Se a senha está com menos de 6 letras
		else if (!empty($this->data[$this->alias]['senha_plain']) && strlen($this->data[$this->alias]['senha_plain']) < 6 ){
			return false;
		}
		//se a senha está em branco
		else if (Security::hash('', null, true) == $senha['senha']){
			if (is_numeric($this->data['Usuario']['id'])){ 
 				//se está atualizando, então mantém a atual
				unset($this->data['Usuario']['senha']);
				return true;
			}else
				//se é novo, exige senha
				return false;
		}else
			return true;
	}
	
	function afterFindExecute($result){
		$result = parent::afterFindExecute($result);
		if (isset($result['senha'])){
			$result['senha_hash'] = $result['senha'];
			$result['senha'] = '';
		}
		if (isset($result['status']))$result['status_formatado'] = $this->options['status'][$result['status']];
		return $result;
	}

	function beforeValidate(){
		parent::beforeValidate();
		if(empty($this->data[$this->alias]['id'])){
			$this->data[$this->alias]['api_key'] = $this->update_api_key();
		}else{
			unset($this->data[$this->alias]['api_key']);
		}
		return true;
	}

	function beforeSave(){
		if(!empty($this->data[$this->alias]['password_create'])){
			$this->data[$this->alias]['senha'] = '';
			$this->data[$this->alias]['uid'] = md5(uniqid());
		}
		if(!empty($this->data[$this->alias]['senha'])){
			$this->data[$this->alias]['senha_expiracao'] = date('Y-m-d');
		}
		
		return true;
	}
		
	function afterSave($created){
		parent::afterSave($created);
		
		$this->read();

		if(!$created){
			$parent = $this->parentNode();
			$parent = $this->node($parent);
			$node = $this->node();
			$aro = $node[0];
			$aro['Aro']['parent_id'] = $parent[0]['Aro']['id'];
			$this->Aro->save($aro);
		}

		//Caso tenha solicitado a geração da senha
		if(!empty($this->data[$this->alias]['password_create'])){
			//Importa componente e controller para permitir enviar o email a partir do model
			App::import('Component', 'Email');
			App::import('Core', 'Controller');
			
			//Define variáveis na view do componente email
			$controller =& new Controller();

			$email = new EmailComponent();
			$email->startup($controller);
			$email->Controller = $controller;
			$email->Controller->set('usuario', $this->data);
			$email->Controller->set('uid', $this->data[$this->alias]['uid']);
			
			//Envia email usando Email component
			$email->template = 'usuario_createpass';
			$email->charset = 'utf-8';
			$email->to = $this->data['Usuario']['email'];
			$email->subject = __('Senha de Acesso', true);
			$email->from = Configure::read('from.nome').' <'.Configure::read('from.email').'>';
			$email->cc = array(Configure::read('from.nome').' <'.Configure::read('from.email').'>');
			$email->sendAs = 'both';

			//As configurações estão no bootstrap
			$email->smtpOptions = array(
				'auth' 		=> true,
				'timeout'	=> 10, 
				'port'		=> Configure::read('smtp.port'), 
				'host' 		=> Configure::read('smtp.host'), 
				'username' 	=> Configure::read('smtp.username'), 
				'password' 	=> Configure::read('smtp.password'),
			);
			$email->delivery = 'smtp';
			if(true === $email->send()){
			}else{
				print_r($mail->smtpError);
				exit;
			}
		}
	
		//Se havia solicitado o envio de senha
		if(!empty($this->data[$this->alias]['password_create'])){
			//Reseta dados de geração de senha
			$this->saveField('password_create', null);
		}	
		
		//Se editou o próprio usuário
		App::import('Core', 'CakeSession'); 
        $session = new CakeSession(); 
		if(!$session->started())$session->start();
		if($session->read('Auth.Usuario.id') == $this->id){
			$session->delete('Auth');
		}

		return true;
	}

	function setupAdmin($action = null, $id = null){
	
		//Options de grupo
		$this->options['grupo'] = $this->Grupo->find('list');
	
		$setupAdmin = array(
			'displayField' => $this->displayField,
			
			'searchFields' => array(
				'Usuario.id',
				'Usuario.nome',
				'Usuario.apelido',
				'Usuario.email',
			),
			
			'topLink' => array(
				'Novo usuário' => array('url' => array('controller' => 'usuarios', 'action' => 'add'), 'htmlAttributes' => array()),
			),
			
			'defaultOrder' => array($this->alias.'.nome' => 'ASC',),

			'listFields' => array(
				'Usuario.id' => array('table_head_cell_param' => 'class="text-align-center" width="60"', 'table_body_cell_param' => 'class="text-align-center"', 'label' => 'Código'),
				'Usuario.nome' => 'Nome',
				'Usuario.email' => 'Email',
				'Usuario.apelido' => 'Apelido',
				'Grupo.nome' => 'Grupo',
				'Usuario.status_formatado' => array('table_head_cell_param' => 'class="text-align-center" width="60"', 'table_body_cell_param' => 'class="text-align-center"', 'label' => 'Status'),
			),
			
//			'contain' => false,
	
			'box_filter' => array(
				'Usuario.grupo_id' => array('title' => 'Filtrar grupo', 'options' => array('*' => 'Todos',) + $this->options['grupo']),
				'Usuario.status' => array('title' => 'Filtrar status', 'options' => array('*' => 'Todos', '1' => 'Ativos', '0' => 'Inativos',)),
			),
			
			'form'	=> array(
				'nome'		=> array(),
				'apelido'	=> array(),
				'email'		=> array('label' => 'E-mail'),
				'senha'		=> array('label' => 'Senha', 'type' => 'password', 'value' => '',),
				'password_create' => array('label' => 'Gerar senha', 'after' => ' <small>Enviar um e-mail com link para geração de nova senha</small>', 'type' => 'checkbox', 'class'=>'mini-switch', 'default' => '0',),
				'grupo_id'	=> array('label' => 'Grupo', 'type' => 'select', 'empty' => '--Selecione--', 'options' => $this->options['grupo']),
				'status'	=> array('label' => 'Status', 'type' => 'checkbox', 'class' => 'switch', 'value' => '1') + (!empty($id) ? array() : array('checked' => true,)) ,
			),

			'listActions' => array(
				'<span>'.__('Permissões', true).'</span>' => array(
					'url' => array('controller' => 'acl', 'action' => 'index', 'params' => 'Usuario/{/'.$this->alias.'/id}'),
					'params' => array(
						'title' => __('Permissões', true), 
						'class' => 'picto permission',
						'escape' => false,
					),
				),
			),
		);
		
		if(!empty($id)){
			$setupAdmin['form']['api_key'] = array('label' => 'Chave da API', 'type' => 'text', 'class' => 'disabled', 'readonly' => true, 'after' => ' <a href="../update_api_key/'.$id.'">Gerar nova chave</a>');
		}
		
		return $setupAdmin;
	}
	
	function update_api_key(){
		return String::uuid();
	}
}
