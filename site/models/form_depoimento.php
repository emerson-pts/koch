<?php
define('DEPOIMENTO_FILE_DIR', SITE_DIR.'webroot/img/upload/depoimentos');
class FormDepoimento extends AppModel {

	var $name = 'FormDepoimento';
    var $order = 'FormDepoimento.created DESC';

    var $actsAs = array(
        'MeioUpload' => array(
        	'imagem' => array(
				'dir' => DEPOIMENTO_FILE_DIR,
				'url' => 'upload/depoimentos',
        	),
        )
		//'maxSize' => '1024*1024*10',
    );

	var $validate = array(
		'nome' => array(
			'rule' => 'notEmpty',
			'required'	=> true,
			'allowEmpty'=>false,
			'message' => 'Informe seu nome',
		),
	
		'email' => array(
			array(
				'rule' => 'notEmpty',
				'required'	=> true,
				'allowEmpty'=>false,
				'message' => 'Digite seu e-mail',
			),
		
			array(
				'rule' => 'email',
				'message' => 'E-mail incorreto',
			),
		),
				
		'depoimento' => array(
			'rule' => 'notEmpty',
			'required'	=> true,
			'allowEmpty'=>false,
			'message' => 'Digite seu depoimento', 
		),
		
		'image' => array(
			'Empty' => array(
				'check' => true,
			),
		),
	);
	
	var $options = array(
		'status'	=> array('1' => 'Publicado', '0' => 'Oculto'),
	);
	
	function setupAdmin($action = null, $id = null){
	
		$setupAdmin = array(
			'displayField' => $this->displayField,
			
//			'pageTitle'				=> __('Páginas', true),
//			'pageDescriptionIndex'	=> __('Modelo de conteúdo com texto e imagens', true),
			
			'searchFields' => array(
				$this->alias.'.id',
				$this->alias.'.created',
				$this->alias.'.nome',
			),
			
			'topLink' => array(
				'Novo depoimento' => array('url' => array('controller' => 'form_depoimentos', 'action' => 'add'), 'htmlAttributes' => array()),
			),
			
			'listFields' => array(
//				$this->alias.'.id' => array('table_head_cell_param' => 'class="text-align-center" width="70"', 'table_body_cell_param' => 'class="text-align-center"', 'label' => 'Código'),
				$this->alias.'.nome' => array('table_head_cell_param' => 'class="text-align-left"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Nome'),
				$this->alias.'.email' => array('table_head_cell_param' => 'class="text-align-left"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'E-mail', 'field_format' => array('class', 'TextHelper', 'autoLinkEmails'),),
				$this->alias.'.destino' => array('table_head_cell_param' => 'class="text-align-left"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Destino'),
				$this->alias.'.created' => array('table_head_cell_param' => 'class="text-align-left" width="80"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Cadastro'),
				$this->alias.'.status' => array('table_head_cell_param' => 'class="text-align-center" width="60"', 'table_body_cell_param' => 'class="text-align-center"', 'label' => 'Status', 'field_evaluate' => 'echo "<span title=\"Status ".(empty($r["'.$this->alias.'"]["status"]) ? "Inativo" : "Ativo")."\" class=\"with-tip picto status-".$r["'.$this->alias.'"]["status"]."\"></span>";',),
			),
			
			'defaultOrder' => array($this->alias.'.created' => 'DESC',$this->alias.'.id' => 'DESC',),
			'defaultLimit' => 100,
			
//			'showLog' => array('index', 'edit'),
			
			'containIndex' => array(),
			'containAddEdit' => array(),
			
			'box_order' => array(
//				$this->alias.'.id' => 'Código',
				$this->alias.'.created' => 'Created',
				$this->alias.'.nome' => 'Nome',

			),
			'box_filter' => array(
				$this->alias.'.status' => array('title' => 'Filtrar status', 'options' => $this->options['status'] ,),
			),

			'formParams' => array('enctype' => 'multipart/form-data'),
			
			'form'	=> array(
				'nome'	=> array('label' => 'Nome', 'type' => 'text','maxlength'=>50),
				'email'	=> array('label' => 'E-mail', 'type' => 'text','maxlength'=>50),
				'cidade'	=> array('label' => 'Cidade', 'type' => 'text','maxlength'=>50),
				'destino'	=> array('label' => 'Destino', 'type' => 'text','maxlength'=>50),
				'depoimento' => array('label' => 'Depoimento', 'cols' => 50, 'rows' => 15, ),
				'imagem'			=> array('label' => 'Imagem', 'type' => 'file', 'show_remove' => true, 'show_preview' => '640x480', 'show_preview_url' => '/../'.str_replace('.admin', '', APP_DIR).'/thumbs/'),
				'status'=> array('label' => 'Status', 'type' => 'checkbox', 'class'=>'switch', 'default' => '1', 'value' => '1'),
			),
		);
		
		return $setupAdmin;
	}
	
	function beforeSave(){
		parent::beforeSave();
		if(!empty($this->data[$this->alias]['depoimento'])){
			$this->data[$this->alias]['depoimento'] = strip_tags($this->data[$this->alias]['depoimento']);
		}

		return true;
	}
}