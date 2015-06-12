<?php
define('AREAS_IMAGE_DIR', SITE_DIR.'webroot/img/upload/areas');

class Area extends AppModel {

	var $name = 'Area';
	var $displayField = 'titulo';

	var $actsAs = array(
        'MeioUpload' => array(
        	'image' => array(
				'dir' => AREAS_IMAGE_DIR,
				'url' => 'upload/areas',
	        ),
	        'image_chamada' => array(
				'dir' => AREAS_IMAGE_DIR,
				'url' => 'upload/areas',
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
		'peso'	=> array(
			'rule' => array('between', 1, 99),
			'message' => 'O peso informado é inválido.',
			'required'=>true,
			'allowEmpty'=>false,
		),
	);

	function setupAdmin($action = null, $id = null){

		$align 	= array('left' => 'Esquerda', 'center' => 'Centro', 'right' => 'Direita',);

		$setupAdmin = array(
			'displayField' => $this->displayField,

			'searchFields' => array(
				'Area.id',
				'Area.data',
				'Area.titulo',
				'Area.conteudo',
			),

			'topLink' => array(
				'Nova area' => array('url' => array('controller' => 'areas', 'action' => 'add'), 'htmlAttributes' => array()),
			),

			'listFields' => array(
              //'Noticia.id' => array('table_head_cell_param' => 'class="text-align-center" width="70"', 'table_body_cell_param' => 'class="text-align-center"', 'label' => 'Código'),
//				'Noticia.tipo' => array('table_head_cell_param' => 'class="text-align-left" width="100"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Tipo', ),
				'Area.titulo' => array('table_head_cell_param' => 'class="text-align-left"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Título'),
			),

		    //'showLog' => array('index', 'edit'),

			//'containAddEdit' => array('VideoRelacionado', 'GaleriaRelacionada', ),

			'save_function' => 'saveAll',
			'save_params' => array('validate' => 'first',),

			/*
			'box_order' => array(
				'Noticia.id' => 'Código',
				'Noticia.titulo' => 'Título',
			),
			*/		

			// 'box_filter' => array(
			// 	'Modalidade.status' => array('title' => 'Filtrar status', 'options' => array('*' => 'Todos',) + $this->status,),
			// 	// 'Modalidade.usuario_id' => array('title' => 'Filtrar autor', 'options' => array('*' => 'Todos',) + $this->Usuario->find('list', array('order' => 'apelido'))),
			// 	//'Noticia.categoria' => array('title' => 'Filtrar categoria', 'options' => array('*' => 'Todos',) + $this->categorias,),
			// ),

			'formParams' => array('enctype' => 'multipart/form-data'),
		);

		// $setupAdmin['form'] = array(
		// 	'tipo'			=> array('label' => 'Tipo',  'type' => 'select', 'default' => 'noticia', 'options' => $this->tipos),
		// 	'data_noticia'	=> array('label' => 'Data da Notícia', 'class' => 'dateMaskDiaHora', 'type' => 'text', 'default' => date('d/m/Y H:i'), ),
		// 	'status'		=> array('label' => 'Status', 'type'=> 'select', 'default' => key($this->status), 'options' => $this->status),
		// 	'usuario_id'	=> array('label' => 'Autor', 'type'=> 'select', 'empty' => '--Selecione o autor--', 'default' => $this->usuario['id'], 'options' => $this->Usuario->find('list', array('order'=>'Usuario.status DESC, Usuario.nome'))),
		// );
		
		$setupAdmin['form'] = array(	
			'peso'		=> array('label' => 'Prioridade', 'type' => 'text', 'maxlength' => 2, 'size' => 5, 'after' => ' (<small>Valores entre 1 e 99, utilizado para defirnir a prioridade de exibição</small>)', 'class' => 'txtbox-auto onlyNumber',),
			'titulo'		=> array('label' => 'Título', 'type' => 'textarea', 'cols' => 50, 'rows' => 6, 'limit' => 255),
			'subtitulo'		=> array('label' => 'Sub-Título', 'type' => 'textarea', 'cols' => 50, 'rows' => 6, 'limit' => 255, 'after' => ' (<small>Recomendado para 1 Texto: 1180x584 | 2 Textos: 1180x634 | 3 Textos: 1180x545</small>)', ),
			'image'			=> array('label' => 'Imagem', 'type' => 'file', 'show_remove' => true, 'show_preview' => '640x480', 'show_preview_url' => '/../'.str_replace('.admin', '', APP_DIR).'/thumbs/'),
			//'image_chamada'	=> array('label' => 'Imagem Chamada', 'type' => 'file', 'show_remove' => true, 'show_preview' => '640x480', 'show_preview_url' => '/../'.str_replace('.admin', '', APP_DIR).'/thumbs/', 'after' => ' (<small>Recomendado:295x295</small>)', ),
			//'image_align'	=> array('label' => 'Alinhamento', 'type'=> 'select', 'default' => key($align), 'options' => $align),
			'image_legenda'	=> array('label' => 'Legenda',),
			'conteudo_preview'	=> array('label' => 'Preview do conteúdo', 'cols' => 50, 'rows' => 6,),
			'conteudo'		=> array('label' => 'conteudo', 'div' => 'ckeditor', 'class' => 'ckeditor', 'cols' => 50, 'rows' => 15, ),
		);
		
		return $setupAdmin;
	}

}
