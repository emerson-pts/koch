<?php
define('CLIENTES_IMAGE_DIR', SITE_DIR.'webroot/img/upload/clientes');

class Cliente extends AppModel {

	var $name = 'Cliente';
	var $displayField = 'titulo';
	
	var $actsAs = array(
        'MeioUpload' => array('image' => array(
			'dir' => CLIENTES_IMAGE_DIR,
			'url' => 'upload/clientes',
        ),)
    );

	var $validate = array(
		'image' => array(
			'Empty' => array(
				'check' => false,
			),
		),
		
		// 'titulo' => array(
		// 	'MinLength' => array(
		// 		'rule'=>array('minLength',1),
		// 		'required'=>true,
		// 		'allowEmpty'=>false,
		// 		'message'=>'O título está em branco.',
		// 	),
		// 	'friendly_url' => array(
		// 		'rule' => 'friendly_url_validate',
		// 		'required'=>true,
		// 		'allowEmpty'=>false,
		// 		'message'=> 'Não foi possível gerar uma url amigável.',
		// 	),
		// ),
	);

	function setupAdmin($action = null, $id = null){

		$setupAdmin = array(
			'displayField' => $this->displayField,
			
			'searchFields' => array(
				'Cliente.id',
				'Cliente.titulo',
			),

			'topLink' => array(
				'Novo cliente' => array('url' => array('controller' => 'clientes', 'action' => 'add'), 'htmlAttributes' => array()),
			),

			'listFields' => array(
              	'Cliente.id' => array('table_head_cell_param' => 'class="text-align-center" width="70"', 'table_body_cell_param' => 'class="text-align-center"', 'label' => 'Código'),
				'Cliente.titulo' => array('table_head_cell_param' => 'class="text-align-left"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Título'),
			),

			'save_function' => 'saveAll',
			'save_params' => array('validate' => 'first',),

			'formParams' => array('enctype' => 'multipart/form-data'),
		);
		
		$setupAdmin['form'] = array(
			'peso'		=> array('label' => 'Prioridade', 'type' => 'text', 'maxlength' => 2, 'size' => 5, 'after' => ' (<small>Valores entre 1 e 99, utilizado para definir a prioridade de exibição</small>)', 'class' => 'txtbox-auto onlyNumber',),
			'titulo'		=> array('label' => 'Título', 'limit' => 255, ),		
			'image'			=> array('label' => 'Imagem', 'type' => 'file', 'show_remove' => true, 'show_preview' => '640x480', 'show_preview_url' => '/../'.str_replace('.admin', '', APP_DIR).'/thumbs/', 'after' => ' (<small>Tamanho recomendado: 261x261.</small>)',  ),
			'video'		=> array('label' => 'Vídeo/Embed', 'type' => 'textarea', 'cols' => 50, 'rows' => 6, 'limit' => 255),
		);
		
		return $setupAdmin;
	}

}