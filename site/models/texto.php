<?php
define('TEXTO_IMAGE_DIR', SITE_DIR.'webroot/img/upload/videos');

class Texto extends AppModel {

	var $name = 'Texto';
	var $displayField = 'titulo';

	var $tipos = array('modalidade' => 'Modalidade', 'case' => 'Case', 'area' => 'Area de atuação', 'evento' => 'Eventos proprietários', );

	var $actsAs = array(
        'MeioUpload' => array('image' => array(
			'dir' => TEXTO_IMAGE_DIR,
			'url' => 'upload/textos',
        ),)
    );

    var $belongsTo = array(
		'Modalidade' => array(
    		'className' => 'Modalidade',
			'foreignKey' => 'parent_id',
    	),
    	'Cas' => array(
    		'className' => 'Cas',
			'foreignKey' => 'parent_id',
    	),
    	'Area' => array(
    		'className' => 'Area',
			'foreignKey' => 'parent_id',
    	),
    	'Evento' => array(
    		'className' => 'Evento',
			'foreignKey' => 'parent_id',
    	),
	);

    var $hasMany = array(
    	'Modalidade' => array(
    		'className' => 'Modalidade',
			'foreignKey' => 'id',
    	),
    	'Cas' => array(
    		'className' => 'Cas',
			'foreignKey' => 'id',
    	),
    	'Area' => array(
    		'className' => 'Area',
			'foreignKey' => 'id',
    	),
    	'Evento' => array(
    		'className' => 'Evento',
			'foreignKey' => 'id',
    	),
    );

	var $validate = array(
		'image' => array(
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
				'required'=>false,
				'allowEmpty'=>true,
				'message'=> 'Não foi possível gerar uma url amigável.',
			),
		),

	);

	function setupAdmin($action = null, $id = null) {

		$setupAdmin = array(
			'displayField' => $this->displayField,

			'topLink' => array(
				'Novo Texto' => array('url' => array('controller' => 'textos', 'action' => 'add'), 'htmlAttributes' => array()),
			),

			'listFields' => array(
				'Texto.id' => array('table_head_cell_param' => 'class="text-align-center" width="70"', 'table_body_cell_param' => 'class="text-align-center"', 'label' => 'Código'),
				'Texto.descricao' => array('table_head_cell_param' => 'class="text-align-left"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Descrição','no_sort'=>true),
				'Texto.tipo' => array('table_head_cell_param' => 'class="text-align-left"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Tipo'),
			),

			'formParams' => array('enctype' => 'multipart/form-data'),
		);

		$setupAdmin['form'] = array(
			'tipo'			=> array('label' => 'Tipo', 'empty' => '--Tipo--', 'options' => $this->tipos),
			'modalidade'	=> array('label' => 'Categoria', 'class'=> 'modalidade', 'type'=> 'select', 'empty' => '--Selecione a categoria--', 'default'=>'{'.$this->alias.'parent_id}', 'options' => $this->Modalidade->find('list', array('fields'=>'Modalidade.titulo'))),
		);

		$setupAdmin['form']['case'] = array('label' => 'Categoria', 'class'=> 'case', 'type'=> 'select', 'empty' => '--Selecione a categoria--', 'default'=>'{'.$this->alias.'parent_id}', 'options' => $this->Cas->find('list', array('fields'=>'Cas.titulo')));
		$setupAdmin['form']['area'] = array('label' => 'Categoria', 'class'=> 'area', 'type'=> 'select', 'empty' => '--Selecione a categoria--', 'default'=>'{'.$this->alias.'parent_id}', 'options' => $this->Area->find('list', array('fields'=>'Area.titulo')));
		$setupAdmin['form']['evento'] = array('label' => 'Categoria', 'class'=> 'evento', 'type'=> 'select', 'empty' => '--Selecione a categoria--', 'default'=>'Texto.parent_id', 'options' => $this->Evento->find('list', array('fields'=>'Evento.titulo')));

		$setupAdmin['form'] += array(
			'parent_id'		=> array('label' => 'parent_id', 'type' => 'hidden',),
			'titulo'		=> array('label' => 'Título', 'type' => 'textarea', 'cols' => 50, 'rows' => 6, 'limit' => 255),
			'descricao_preview'			=> array('label' => 'Preview do conteúdo', 'cols' => 50, 'rows' => 6,),
			'descricao'		=> array('label' => 'Conteúdo', 'div' => 'ckeditor', 'class' => 'ckeditor', 'cols' => 50, 'rows' => 15, ),
			'image'			=> array('label' => 'Imagem', 'type' => 'file', 'show_remove' => true, 'show_preview' => '640x480', 'show_preview_url' => '/../'.str_replace('.admin', '', APP_DIR).'/thumbs/'),
		);

		return $setupAdmin;

	}

}