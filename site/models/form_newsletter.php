<?php
class FormNewsletter extends AppModel {

	var $name = 'FormNewsletter';
	var $useTable = 'form_newsletter';
	
	var $validate = array(
		/*'nome' => array(
			'rule' => 'notEmpty', 
			'required'	=> true,
			'allowEmpty'=>false,
			'message' => "Campo Obrigatório",
		),*/
		'email' => array(
			'email' => array(
				'rule' => 'email', 
				'required'	=> true,
				'allowEmpty'=>false,
				'message' => "E-mail inválido",
			),
			'unique' => array(
				'rule' => 'isUnique', 
				'message' => "E-mail já cadastrado",
			),
			
		),
		
	);
		
	function setupAdmin($action = null, $id = null){
		
		$setupAdmin = array(
			'displayField' => $this->displayField,
			
			'searchFields' => array(
				'FormNewsletter.id',
				'FormNewsletter.nome',
				'FormNewsletter.email',
			),
				
			'topLink' => array(
				'Novo assinante' => array('url' => array('controller' => 'FormNewsletters', 'action' => 'add'), 'htmlAttributes' => array()),
			),
			
			'listFields' => array(
				'FormNewsletter.id' => array('table_head_cell_param' => 'class="text-align-center" width="70"', 'table_body_cell_param' => 'class="text-align-center"', 'label' => 'Código'),
				'FormNewsletter.nome' => array('table_head_cell_param' => 'class="text-align-left"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Nome'),
				'FormNewsletter.email' => array('table_head_cell_param' => 'class="text-align-left" width="100"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Email', ),
				'FormNewsletter.created' => array('table_head_cell_param' => 'class="text-align-left" width="80"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Data'),
			),
			
			'defaultOrder' => array($this->alias.'.created' => 'DESC',),
			'defaultLimit' => 100,
			
			'showLog' => array('index', 'edit'),
			
			'containIndex' => array(),
			'containAddEdit' => array(),
			
			'box_order' => array(
				'FormNewsletter.id' => 'Código',
				'FormNewsletter.nome' => 'Nome',
				'FormNewsletter.email' => 'Email',
			),
		
			
			'form'	=> array(
				'nome'				=> array('label' => 'Nome','type' => 'text','maxlength' => 100),
				'email'				=> array('label' => 'Email','type' => 'text','maxlength' => 100),
			),
		);
		
		return $setupAdmin;
	}
	
}