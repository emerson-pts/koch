<?php
define('EVENTOS_IMAGE_DIR', SITE_DIR.'webroot/img/upload/eventos');

class Evento extends AppModel {

	var $name = 'Evento';
	var $displayField = 'titulo';

	var $tipos = array('atleta' => 'Atleta', 'evento' => 'Evento', 'proprietario' => 'Evento proprietário', );

	var $actsAs = array(
        'MeioUpload' => array(
        	'image' => array(
				'dir' => EVENTOS_IMAGE_DIR,
				'url' => 'upload/eventos',
	        ),
	        'image_chamada' => array(
				'dir' => EVENTOS_IMAGE_DIR,
				'url' => 'upload/eventos',
	        ),
        )
    );
	
	// var $belongsTo = array(
	// 	'Usuario' => array(
	// 		'className' => 'Usuario',
	// 		'foreignKey' => 'usuario_id',
	// 		'conditions' => '',
	// 		'fields' => '',
	// 		'order' => ''
	// 	),
	// );

	var $hasMany=array(
    	'Cas' => array(
    		'className' => 'Cas',
			'foreignKey' => 'id',
    	),
    	'Area' => array(
    		'className' => 'Area',
			'foreignKey' => 'id',
    	),
    );
    var $belongsTo = array(
		'Case' => array(
			'className' => 'Cas',
			'foreignKey' => 'related_id',
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
				'Novo evento' => array('url' => array('controller' => 'eventos', 'action' => 'add'), 'htmlAttributes' => array()),
			),

			'listFields' => array(
             
				'Evento.titulo' => array('table_head_cell_param' => 'class="text-align-left"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Título'),
			),

		    //'showLog' => array('index', 'edit'),

			//'containAddEdit' => array('VideoRelacionado', 'GaleriaRelacionada', ),

			'save_function' => 'saveAll',
			'save_params' => array('validate' => 'first',),

			'formParams' => array('enctype' => 'multipart/form-data'),
		);

		$setupAdmin['form'] = array(
			'tipo'			=> array('label' => 'Tipo',  'type' => 'select', 'options' => $this->tipos),
			'parent_id'		=> array('label' => 'Area de atuação', 'type'=> 'select', 'empty' => '--Selecione a area de atuação --', 'after' => ' (se o evento for específico de uma Area de atuação, selecione-a ao lado)<span class="clearFix">&nbsp;</span>', 'options' => $this->Area->find('list', array('fields'=>'Area.titulo'))),
			'related_id'	=> array('label' => 'Case', 'type'=> 'select', 'empty' => '--Selecione o case --', 'options' => $this->Cas->find('list', array('fields'=>'Cas.titulo'))),
			'titulo'		=> array('label' => 'Título', 'type' => 'textarea', 'cols' => 50, 'rows' => 6, 'limit' => 255),
			'subtitulo'		=> array('label' => 'Sub-Título', 'type' => 'textarea', 'cols' => 50, 'rows' => 6, 'limit' => 255),
			'image'			=> array('label' => 'Imagem', 'type' => 'file', 'show_remove' => true, 'show_preview' => '640x480', 'show_preview_url' => '/../'.str_replace('.admin', '', APP_DIR).'/thumbs/'),
			'image_chamada'	=> array('label' => 'Imagem Chamada', 'type' => 'file', 'show_remove' => true, 'show_preview' => '640x480', 'show_preview_url' => '/../'.str_replace('.admin', '', APP_DIR).'/thumbs/'),
			'image_align'	=> array('label' => 'Alinhamento', 'type'=> 'select', 'default' => key($align), 'options' => $align),
			'image_legenda'	=> array('label' => 'Legenda',),
			'link'			=> array('label' => 'Url','after' => ' (<small>caminho completo com http://</small>)'),
			'conteudo_preview'	=> array('label' => 'Preview do conteúdo', 'cols' => 50, 'rows' => 6,),
			'conteudo'		=> array('label' => 'conteudo', 'div' => 'ckeditor', 'class' => 'ckeditor', 'cols' => 50, 'rows' => 15, ),
			//'conteudo'		=> array('label' => 'Conteudo', 'cols' => 50, 'rows' => 15, ),
		);

		return $setupAdmin;
	}

}
