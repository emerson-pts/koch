<?php
define('WALLPAPER_IMAGE_DIR', SITE_DIR.'webroot/img/upload/wallpapers');

class Wallpaper extends AppModel {

	var $name = 'Wallpaper';
	var $displayField = 'descricao';
	var $uses = array('Modalidade',);

	var $tipos = array('modalidade' => 'Modalidade', 'case' => 'Case', 'evento' => 'Eventos proprietários', );

	var $tiposWallpaper = array('wallpaper' => 'Wallpaper', 'screensaver' => 'Screensaver', );

	var $actsAs = array(
        'MeioUpload' => array('image' => array(
			'dir' => WALLPAPER_IMAGE_DIR,
			'url' => 'upload/wallpapers',
        ),)
		//'maxSize' => '1024*1024*10',
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
				'Novo Wallpaper' => array('url' => array('controller' => 'wallpapers', 'action' => 'add'), 'htmlAttributes' => array()),
			),

			'listFields' => array(
				'Wallpaper.id' => array('table_head_cell_param' => 'class="text-align-center" width="70"', 'table_body_cell_param' => 'class="text-align-center"', 'label' => 'Código'),
				'Wallpaper.descricao' => array('table_head_cell_param' => 'class="text-align-left"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Descrição','no_sort'=>true),
				'Wallpaper.tipo' => array('table_head_cell_param' => 'class="text-align-left"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Tipo',),
//				$this->alias.'.friendly_url' => array('table_head_cell_param' => 'class="text-align-left"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Url amigável'),
			),

			'containIndex' => array(),
			'containAddEdit' => array(),

			'formParams' => array('enctype' => 'multipart/form-data'),

			'form'	=> array(
				'parent_id'		=> array('label' => 'parent_id', 'type' => 'hidden',),
				'tipo'				=> array('label' => 'Tipo da Imagem', 'empty' => '--Tipo da imagem--', 'options' => $this->tiposWallpaper),
				'categoria'			=> array('label' => 'Relacionamento', 'empty' => '--Tipo--', 'options' => $this->tipos),
				'evento'		=> array('label' => 'Categoria', 'class'=> 'evento', 'type'=> 'select', 'empty' => '--Selecione a categoria--',  'options' => $this->Evento->find('list', array('fields'=>'Evento.titulo'))),
				'modalidade'	=> array('label' => 'Categoria', 'class'=> 'modalidade', 'type'=> 'select', 'empty' => '--Selecione a categoria--', 'default'=>'{/'.$this->alias.'/parent_id}', 'options' => $this->Modalidade->find('list', array('fields'=>'Modalidade.titulo'))),
				'case'			=> array('label' => 'Categoria', 'class'=> 'case', 'type'=> 'select', 'empty' => '--Selecione a categoria--', 'default'=>'{/'.$this->alias.'/parent_id}', 'options' => $this->Cas->find('list', array('fields'=>'Cas.titulo'))),
				'descricao'			=> array('label' => 'Descrição', 'cols' => 50, 'rows' => 6,),
				'image'			=> array('label' => 'Imagem', 'type' => 'file', 'show_remove' => true, 'show_preview' => '640x480', 'show_preview_url' => '/../'.str_replace('.admin', '', APP_DIR).'/thumbs/'),
				'destaque'		=> array('label' => 'Capa', 'type' => 'checkbox', 'class'=>'switch', 'default' => '0', 'value' => '1'),
			),
		);

		return $setupAdmin;
	}

}