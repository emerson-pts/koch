<?php
define('ARQUIVO_DIR', SITE_DIR.'webroot/uploads/arquivos');

class Arquivo extends AppModel {

	var $name = 'Arquivo';
	var $displayField = 'titulo';
	var $uses = array('Arquivo',);

	var $actsAs = array(
        'MeioUpload' => array(
        	'arquivo' => array(
				'dir' => ARQUIVO_DIR,
				'url' => 'uploads/arquivos',
	        ),
        )
    );

	//var $tipos = array('video' => 'Vídeos');

	// var $actsAs = array(
 //        'MeioUpload' => array('image' => array(
	// 		'dir' => ARQUIVO_IMAGE_DIR,
	// 		'url' => 'upload/textos',
 //        ),)
 //    );

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

		'nome' => array(
			'MinLength' => array(
				'rule'=>array('minLength',1),
				'required'=>true,
				'allowEmpty'=>false,
				'message'=>'O campo Nome está em branco.',
			),
			'friendly_url' => array(
				'rule' => 'friendly_url_validate',
				'required'=>false,
				'allowEmpty'=>true,
				'message'=> 'Não foi possível gerar uma url amigável.',
			),
		),

		
	);

	function setupAdmin($action = null, $id = null) {

		//Lê dados do usuário e armazena na variável usuario do modelo
		App::import('Core', 'CakeSession'); 
        $session = new CakeSession(); 
		if(!$session->started())$session->start();
		$this->usuario = $session->read('Auth.Usuario');		

		$setupAdmin = array(
			'displayField' => $this->displayField,

			'topLink' => array(
				'Novo Arquivo' => array('url' => array('controller' => 'textos', 'action' => 'add'), 'htmlAttributes' => array()),
			),

			'listFields' => array(
				'Arquivo.id' => array('table_head_cell_param' => 'class="text-align-center" width="70"', 'table_body_cell_param' => 'class="text-align-center"', 'label' => 'Código'),
				'Arquivo.descricao' => array('table_head_cell_param' => 'class="text-align-left"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Descrição','no_sort'=>true),
			),

			'defaultOrder' => array($this->alias.'.data' => 'ASC',),

			'containIndex' => array(),
			'containAddEdit' => array(),

			'formParams' => array('enctype' => 'multipart/form-data'),

			'form'	=> array(
				'titulo'		=> array('label' => 'Título', 'type' => 'textarea', 'cols' => 50, 'rows' => 6, 'limit' => 255),
				'descricao'			=> array('label' => 'Descrição', 'cols' => 50, 'rows' => 6,),
				'image'			=> array('label' => 'Imagem', 'type' => 'file', 'show_remove' => true, 'show_preview' => '640x480', 'show_preview_url' => '/../'.str_replace('.admin', '', APP_DIR).'/thumbs/'),
			),
		);

		return $setupAdmin;
	}

}