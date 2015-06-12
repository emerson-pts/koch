<?php
//define('TEXTO_IMAGE_DIR', SITE_DIR.'webroot/img/upload/videos');

class Categoria extends AppModel {

	var $name = 'Categoria';
	var $displayField = 'Nome';
	var $uses = array('Categoria',);


 //    var $belongsTo = array(
	// 	'Modalidade' => array(
	// 		'className' => 'Modalidade',
	// 		'foreignKey' => 'parent_id',
	// 		'conditions' => '',
	// 		'fields' => '',
	// 		'order' => ''
	// 	),
	// );

   //  var $hasMany=array(
   //  	'Modalidade' => array(
   //  		'className' => 'Modalidade',
			// 'foreignKey' => 'parent_id',
   //  	),
   //  );

	var $validate = array(
		// 'image' => array(
		// 	'Empty' => array(
		// 		'check' => false,
		// 	),
		// ),

		'nome' => array(
			'MinLength' => array(
				'rule'=>array('minLength',1),
				'required'=>true,
				'allowEmpty'=>false,
				'message'=>'O nome está em branco.',
			),
			'friendly_url' => array(
				'rule' => 'friendly_url_validate',
				'required'=>false,
				'allowEmpty'=>true,
				'message'=> 'Não foi possível gerar uma url amigável.',
			),
		),

		'friendly_url' => array(
			'rule' => 'isUnique',
			'message'=> 'A URL amigável deve ser única.',
		),

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
				'Nova categoria' => array('url' => array('controller' => 'categorias', 'action' => 'add'), 'htmlAttributes' => array()),
			),

			'listFields' => array(
				'Categoria.id' => array('table_head_cell_param' => 'class="text-align-center" width="70"', 'table_body_cell_param' => 'class="text-align-center"', 'label' => 'Código'),
				'Categoria.nome' => array('table_head_cell_param' => 'class="text-align-left"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Descrição','no_sort'=>true),
				$this->alias.'.friendly_url' => array('table_head_cell_param' => 'class="text-align-left"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Url amigável'),
			),

			'containIndex' => array(),
			'containAddEdit' => array(),

			'formParams' => array('enctype' => 'multipart/form-data'),

			'form'	=> array(
				//'tipo'			=> array('label' => 'Tipo', 'empty' => '--Tipo--', 'options' => $this->tipos),
				//'parent_id'		=> array('label' => 'Categoria', 'type'=> 'select', 'empty' => '--Selecione a categoria--', 'options' => $this->Modalidade->find('list', array('fields'=>'Modalidade.titulo'))),
				//'data'			=> array('label' => 'Data', 'class' => 'dateMask datepicker', 'type' => 'text', 'default' => date('d/m/Y'), ),
				'nome'		=> array('label' => 'Nome', ),
				'friendly_url'	=> array('label' => 'Url Amigável', 'type' => 'text', 'limit' => 255, 'after' => '&nbsp;<small>Deixe em branco, caso queira defini-la automaticamente.</small>',),
				//'image'			=> array('label' => 'Imagem', 'type' => 'file', 'show_remove' => true, 'show_preview' => '640x480', 'show_preview_url' => '/../'.str_replace('.admin', '', APP_DIR).'/thumbs/'),
				//'descricao'			=> array('label' => 'Descrição', 'cols' => 50, 'rows' => 6,),
				//'image'			=> array('label' => 'Imagem', 'type' => 'file', 'show_remove' => true, 'show_preview' => '640x480', 'show_preview_url' => '/../'.str_replace('.admin', '', APP_DIR).'/thumbs/'),
			),
		);

		return $setupAdmin;
	}

}