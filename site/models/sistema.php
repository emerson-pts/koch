<?php
define('ARQUIVO_DIR', SITE_DIR.'webroot/uploads/arquivos');

class Sistema extends AppModel {

	var $name = 'Sistema';
	var $uses = array('Sistema', 'Usuario');
	var	$cacheAction = false;

	var $actsAs = array(
        'MeioUpload' => array(
        	'arquivo' => array(
				'dir' => ARQUIVO_DIR,
				'url' => 'uploads/arquivos',
	        ),
        ),
        'Acl' => array('requester')
    );

    var $belongsTo = array(
		'Usuario' => array(
			'className' => 'Usuario',
			'foreignKey' => 'usuario_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

	var $validate = array(
		'arquivo' => array(
			'Empty' => array(
				'check' => false,
			),
		),

		'titulo' => array(
			'MinLength' => array(
				'rule'=>array('minLength',1),
				'required'=>true,
				'allowEmpty'=>false,
				'message'=>'O título está em branco.',
			),
			// 'friendly_url' => array(
			// 	'rule' => 'friendly_url_validate',
			// 	'required'=>true,
			// 	'allowEmpty'=>false,
			// 	'message'=> 'Não foi possível gerar uma url amigável.',
			// ),
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

	function setupAdmin($action = null, $id = null){

		$setupAdmin = array(
			//'displayField' => $this->displayField,

			// 'topLink' => array(
			// 	'Nova area' => array('url' => array('controller' => 'areas', 'action' => 'add'), 'htmlAttributes' => array()),
			// ),

			'listFields' => array(
				'Sistema.created' => array('table_head_cell_param' => 'class="text-align-left" width="200"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Data - Upload', ),
				'Sistema.titulo' => array('table_head_cell_param' => 'class="text-align-left"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Nome do arquivo'),
				'Usuario.nome' => array('table_head_cell_param' => 'class="text-align-left" width="80"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Nome'),
				'Usuario.email' => array('table_head_cell_param' => 'class="text-align-left" width="80"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'E-mail'),
			),

			'save_function' => 'saveAll',
			'save_params' => array('validate' => 'first',),

			'formParams' => array('enctype' => 'multipart/form-data'),

			'listActions' => array(
				'admin/icon-view.gif' => array(
					'url' => array('controller' => 'Sistemas', 'action' => 'download', 'params' => '{/'.$this->alias.'/id}'),
					'params' => array(
						'title' => __('Download do arquivo', true), 
						//'class' => 'picto view',
						'escape' => false,
					),
				),
			),
		);

		$setupAdmin['form'] = array(	
			'usuario_id'	=> array('label' => 'Usuário', 'type'=> 'select', 'empty' => '--Selecione o usuário--', 'options' => $this->Usuario->find('list', array('order'=>'Usuario.nome'))),
			'titulo'		=> array('label' => 'Título', 'type' => 'textarea', 'cols' => 50, 'rows' => 6, 'limit' => 255),
			'arquivo'			=> array('label' => 'Arquivo', 'type' => 'button', ),
		);

		return $setupAdmin;
	}

}