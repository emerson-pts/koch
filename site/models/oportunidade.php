<?php
class Oportunidade extends AppModel {

	var $name = 'Oportunidade';
	var $displayField = 'titulo';

	var $validate = array(

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
				'Nova Oportunidade' => array('url' => array('controller' => 'oportunidades', 'action' => 'add'), 'htmlAttributes' => array()),
			),

			'listFields' => array(
				'Oportunidade.id' => array('table_head_cell_param' => 'class="text-align-center" width="70"', 'table_body_cell_param' => 'class="text-align-center"', 'label' => 'Código'),
				'Oportunidade.titulo' => array('table_head_cell_param' => 'class="text-align-left"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Título','no_sort'=>true),
//				$this->alias.'.friendly_url' => array('table_head_cell_param' => 'class="text-align-left"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Url amigável'),
			),

			'containIndex' => array(),
			'containAddEdit' => array(),

			'formParams' => array('enctype' => 'multipart/form-data'),

			'form'	=> array(
				'titulo'			=> array('label' => 'Título', 'limit' => 50, ),
				'descricao'		=> array('label' => 'Descrição', 'type' => 'textarea', 'cols' => 50, 'rows' => 6, 'limit' => 230),
			),
		);

		return $setupAdmin;
	}

}