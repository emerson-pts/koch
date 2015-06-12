<?php
define('CASES_IMAGE_DIR', SITE_DIR.'webroot/img/upload/cases');

class Cas extends AppModel {

	var $name = 'Cas';
	var $displayField = 'titulo';

	var $actsAs = array(
        'MeioUpload' => array(
        	'image' => array(
				'dir' => CASES_IMAGE_DIR,
				'url' => 'upload/cases',
	        ),
	        'image_chamada' => array(
				'dir' => CASES_IMAGE_DIR,
				'url' => 'upload/cases',
	        ),
        )
    );

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	// var $hasAndBelongsToMany = array(
	// 	'VideoRelacionado' => array(
	// 		'className' => 'Video',
	// 		'order'		=> 'VideoRelacionado.data DESC',
	// 		'joinTable' => 'noticias_videos',
	// 		'foreignKey' => 'noticia_id',
	// 		'associationForeignKey' => 'video_id',
	// 		'fields' => array('id', 'titulo', 'descricao', 'data', 'embed'),
	// 	),
		
	// 	'GaleriaRelacionada' => array(
	// 		'className' => 'Galeria',
	// 		'order'		=> 'GaleriaRelacionada.data DESC',
	// 		'joinTable' => 'noticias_galerias',
	// 		'foreignKey' => 'noticia_id',
	// 		'associationForeignKey' => 'galeria_id',
	// 		'fields' => array('id', 'label', 'data', 'descricao', 'imagem_capa', 'friendly_url'),
	// 	),

	// );

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
		'image' => array(
			'Empty' => array(
				'check' => false,
			),
		),
		'image_chamada' => array(
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
			'friendly_url' => array(
				'rule' => 'friendly_url_validate',
				'required'=>true,
				'allowEmpty'=>false,
				'message'=> 'Não foi possível gerar uma url amigável.',
			),
		),
	);

	function setupAdmin($action = null, $id = null){

		$align 	= array('left' => 'Esquerda', 'center' => 'Centro', 'right' => 'Direita',);

		$setupAdmin = array(
			'displayField' => $this->displayField,

			'searchFields' => array(
				'Cas.id',
				'Cas.data',
				'Cas.titulo',
				'Cas.conteudo',
			),

			'topLink' => array(
				'Novo case' => array('url' => array('controller' => 'cases', 'action' => 'add'), 'htmlAttributes' => array()),
			),

			'listFields' => array(
             
				'Cas.titulo' => array('table_head_cell_param' => 'class="text-align-left"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Título'),
			),

		    //'showLog' => array('index', 'edit'),

			//'containAddEdit' => array('VideoRelacionado', 'GaleriaRelacionada', ),

			'save_function' => 'saveAll',
			'save_params' => array('validate' => 'first',),

			'formParams' => array('enctype' => 'multipart/form-data'),
		);
		
		$setupAdmin['form'] = array(	
			'titulo'		=> array('label' => 'Título', 'type' => 'textarea', 'cols' => 50, 'rows' => 6, 'limit' => 255),
			'subtitulo'		=> array('label' => 'Sub-Título', 'type' => 'textarea', 'cols' => 50, 'rows' => 6, 'limit' => 255),
			'image'			=> array('label' => 'Imagem', 'type' => 'file', 'show_remove' => true, 'show_preview' => '640x480', 'show_preview_url' => '/../'.str_replace('.admin', '', APP_DIR).'/thumbs/', 'after' => ' (<small>Recomendado para 1 Texto: 1180x584 | 2 Textos: 1180x634 | 3 Textos: 1180x545</small>)', ),
			'image_chamada'	=> array('label' => 'Imagem Chamada', 'type' => 'file', 'show_remove' => true, 'show_preview' => '640x480', 'show_preview_url' => '/../'.str_replace('.admin', '', APP_DIR).'/thumbs/', 'after' => ' (<small>Recomendado:295x295</small>)', ),
			'image_align'	=> array('label' => 'Alinhamento', 'type'=> 'select', 'default' => key($align), 'options' => $align),
			'image_legenda'	=> array('label' => 'Legenda',),
			'conteudo_preview'	=> array('label' => 'Preview do conteúdo', 'cols' => 50, 'rows' => 6,),
			'conteudo'		=> array('label' => 'conteudo', 'div' => 'ckeditor', 'class' => 'ckeditor', 'cols' => 50, 'rows' => 15, ),
		);
		
		return $setupAdmin;
	}

}
