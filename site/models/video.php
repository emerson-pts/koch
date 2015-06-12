<?php
define('VIDEO_IMAGE_DIR', SITE_DIR.'webroot/img/upload/videos');

class Video extends AppModel {

	var $name = 'Video';
	var $displayField = 'titulo';

	var $tipos = array('modalidade' => 'Modalidade', 'case' => 'Case', 'evento' => 'Eventos proprietários', );

    var $belongsTo = array(
		'Modalidade' => array(
			'className' => 'Modalidade',
			'foreignKey' => 'parent_id',
		),
		'Cas' => array(
			'className' => 'Cas',
			'foreignKey' => 'parent_id',
		),
		'Evento' => array(
			'className' => 'Evento',
			'foreignKey' => 'parent_id',
		),
	);

    var $hasMany=array(
    	'Modalidade' => array(
    		'className' => 'Modalidade',
			'foreignKey' => 'id',
    	),
    	'Cas' => array(
    		'className' => 'Cas',
			'foreignKey' => 'id',
    	),
    	'Evento' => array(
    		'className' => 'Evento',
			'foreignKey' => 'id',
    	),
    );

	var $validate = array(
		// 'image' => array(
		// 	'Empty' => array(
		// 		'check' => false,
		// 	),
		// ),

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

		// 'friendly_url' => array(
		// 	'rule' => 'isUnique',
		// 	'message'=> 'A URL amigável deve ser única.',
		// ),

		// 'data' => array(
		// 	'rule'=>array('date','dmy'),
		// 	'required'=>true,
		// 	'allowEmpty'=>false,
		// 	'message'=>'Data inválida',
		// ),

	);

	function setupAdmin($action = null, $id = null) {
		$setupAdmin = array(
			'displayField' => $this->displayField,

			'topLink' => array(
				'Novo Video' => array('url' => array('controller' => 'videos', 'action' => 'add'), 'htmlAttributes' => array()),
			),

			'listFields' => array(
				'Video.id' => array('table_head_cell_param' => 'class="text-align-center" width="70"', 'table_body_cell_param' => 'class="text-align-center"', 'label' => 'Código'),
				'Video.descricao' => array('table_head_cell_param' => 'class="text-align-left"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Descrição','no_sort'=>true),
				'Video.tipo' => array('table_head_cell_param' => 'class="text-align-left"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Descrição','no_sort'=>true),
			),

			'containIndex' => array(),
			'containAddEdit' => array(),

			'formParams' => array('enctype' => 'multipart/form-data'),

			'form'	=> array(
				'parent_id'		=> array('label' => 'parent_id', 'type' => 'hidden',),
				'tipo'			=> array('label' => 'Tipo', 'empty' => '--Tipo--', 'options' => $this->tipos),
				'modalidade'	=> array('label' => 'Categoria', 'type'=> 'select', 'class'=> 'modalidade', 'empty' => '--Selecione a categoria--', 'default'=>'{/'.$this->alias.'/parent_id}', 'options' => $this->Modalidade->find('list', array('fields'=>'Modalidade.titulo'))),
				'case'			=> array('label' => 'Categoria', 'type'=> 'select', 'class'=> 'case', 'empty' => '--Selecione a categoria--', 'default'=>'{/'.$this->alias.'/parent_id}', 'options' => $this->Cas->find('list', array('fields'=>'Cas.titulo'))),
				'evento'		=> array('label' => 'Categoria', 'type'=> 'select', 'class'=> 'evento', 'empty' => '--Selecione a categoria--', 'default'=>'{/'.$this->alias.'/parent_id}', 'options' => $this->Evento->find('list', array('fields'=>'Evento.titulo'))),
				'titulo'		=> array('label' => 'Título', 'type' => 'textarea', 'cols' => 50, 'rows' => 6, 'limit' => 255),
				'descricao'			=> array('label' => 'Descrição', 'cols' => 50, 'rows' => 6,),
				'embed'			=> array('label' => 'Embed', 'cols' => 50, 'rows' => 6, 'after' => '&nbsp;<small>Copie o código após "watch?v=". Exemplo: <strong>0ajme2ThqBg</strong></small>'),
				'destaque'		=> array('label' => 'Autoplay', 'type' => 'checkbox', 'class'=>'switch', 'default' => '0', 'value' => '1'),
			),
		);

		return $setupAdmin;
	}	

}