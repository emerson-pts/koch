<?php
define('VIAGEM_TIPO_FILE_DIR', SITE_DIR.'webroot/img/upload/viagem_tipos');

class ViagemTipo extends AppModel {
    var $name = 'ViagemTipo';
	var $displayField = 'nome';
    var $actsAs = array(
        'MeioUpload' => array(
        	'imagem_lista' => array(
				'dir' => VIAGEM_TIPO_FILE_DIR,
				'url' => 'upload/viagem_tipos',
        	),
        )
    );
    var $order = 'ViagemTipo.nome ASC';

/*    var $hasMany=array(
    	'Roteiro'=>array(
			'dependent'=> true,
    	),
    );
*/
	var $hasAndBelongsToMany = array(
		'Roteiro',
	);

    var $validate = array(
		'imagem_capa' => array(
			'Empty' => array(
				'check' => false,
			),
		),

		'imagem_lista' => array(
			'Empty' => array(
				'check' => false,
			),
		),

		'nome' => array(
			'notEmpty' => array(
			   'rule'=>'notEmpty', 
				'required'=>true,  
				'allowEmpty'=>false,
				'message'=>'Por favor, digite o rótulo.', 
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
	);
	
	public function __construct($id=false,$table=null,$ds=null){
		parent::__construct($id,$table,$ds);
 		$this->virtualFields = array(
			'nome_status' => "CONCAT(`{$this->alias}`.`nome`, IF(`{$this->alias}`.`status` != 1, ' (inativo)', ''))",
			'nome_roteiro_count' => "CONCAT(`{$this->alias}`.`nome`, IF(`{$this->alias}`.`roteiro_count` > 0, CONCAT(' (', `{$this->alias}`.`roteiro_count`, ')'), ''))",
			'nome_roteiro_totalXativo_count' => "CONCAT(`{$this->alias}`.`nome`, IF(`{$this->alias}`.`roteiro_count` > 0, CONCAT(' (', `{$this->alias}`.`roteiro_ativo_count`, '/', `{$this->alias}`.`roteiro_count`, ')'), ''))",
		);
	}
	   
	function setupAdmin($action = null, $id = null){		        
        $setupAdmin = array(
			'displayField' => $this->displayField,

            'topLink' => array(
				'Novo Tipo de Viagem' => array('url' => array('action' => 'add'), 'htmlAttributes' => array()),
			),
			
			'listFields' => array(
				$this->alias.'.nome' => array('table_head_cell_param' => 'class="text-align-left"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Tipo de Viagem', ),
				$this->alias.'.roteiro_ativo_count' => array('table_head_cell_param' => 'class="text-align-center" width="100"', 'table_body_cell_param' => 'class="text-align-center"', 'label' => 'Rot. Ativos', ),
				$this->alias.'.roteiro_count' => array('table_head_cell_param' => 'class="text-align-center" width="100"', 'table_body_cell_param' => 'class="text-align-center"', 'label' => 'Roteiros', ),
				$this->alias.'.status' => array('table_head_cell_param' => 'class="text-align-center" width="60"', 'table_body_cell_param' => 'class="text-align-center"', 'label' => 'Status', 'field_evaluate' => 'echo "<span title=\"Status ".(empty($r["'.$this->alias.'"]["status"]) ? "Inativo" : "Ativo")."\" class=\"with-tip picto status-".$r["'.$this->alias.'"]["status"]."\"></span>";',),
			),

			'formParams' => array('enctype' => 'multipart/form-data'),

			'form'	=> array(
				'nome'			=> array('label' => 'Nome',),
				'friendly_url'	=> array('label' => 'Url Amigável', 'type' => 'text', 'after' => '&nbsp;<small>Deixe em branco, caso queira defini-la automaticamente.</small>',),
				'status'		=> array('label' => 'Status', 'type' => 'checkbox', 'class'=>'switch', 'default' => '1', 'value' => '1'),
				'</fieldset><fieldset><legend>Descrição</legend>',
				'imagem_lista'	=> array('label' => 'Imagem (lista)', 'type' => 'file', 'show_remove' => true, 'show_preview' => '640x480', 'show_preview_url' => '/../'.str_replace('.admin', '', APP_DIR).'/thumbs/'),
				'descricao'		=> array('label' => 'Descrição', 'cols' => 50, 'rows' => 15, 'style' => 'width: 450px;',),
				
			),
			
			'showLog' => array('index', 'edit'),

			'containIndex' => array(),
			'containAddEdit' => array(),

			'save_function' => 'saveAll',
			'save_params' => array('validate' => 'first',),

			'save_redirect_add' => array('action' => 'edit'),
			'save_redirect_edit' => array('action' => 'edit', $id),
			'listActions' => array(
				'<span>'.__('Roteiros', true).'</span>' => array(
					'url' => array('controller' => 'roteiros', 'action' => 'index', 'params' => 'filter[RoteirosViagemTipoSearch.viagem_tipo_id]:{/'.$this->alias.'/id}'),
					'params' => array(
						'title'	=> __('Roteiros', true), 
						'class' => 'picto image',
						'escape' => false,
					),
				),
			),
		);

		if(!empty($id)){
			$setupAdmin['topLink']['Roteiros <i>'.current(current($this->read('nome', $id))).'</i>'] = array('url' => array('controller' => 'roteiros', 'action' => 'index', 'filter[RoteirosViagemTipoSearch.viagem_tipo_id]:'.$id), 'htmlAttributes' => array('escape' => false));
		}

		return $setupAdmin;
	}    
}