<?php
define('ROTEIRO_FILE_DIR', SITE_DIR.'webroot/img/upload/roteiros');

class Roteiro extends AppModel {
    var $name = 'Roteiro';
	var $displayField = 'nome';
    var $actsAs = array(
        'MeioUpload' => array(
        	'imagem_capa' => array(
				'dir' => ROTEIRO_FILE_DIR,
				'url' => 'upload/roteiros',
        	),
        	'imagem_lista' => array(
				'dir' => ROTEIRO_FILE_DIR,
				'url' => 'upload/roteiros',
        	),
        	'imagem_descricao' => array(
				'dir' => ROTEIRO_FILE_DIR,
				'url' => 'upload/roteiros',
        	),
        )
    );
//    var $order = 'Roteiro.order ASC';
    var $belongsTo = array(
    	'Destino'=>array(
			'dependent'=> true,
			'counterCache' => true,
		),
		
		'DestinoAtivo' => array( 
			'className' => 'Destino',
			'foreignKey' => 'destino_id',
			'counterCache' => 'roteiro_ativo_count', 
			'counterScope' => array('Roteiro.status' => '1',),
    	),
/*    	
    	'ViagemTipo'=>array(
			'dependent'=> true,
			'counterCache' => true,
		),
		
		'ViagemTipoAtivo' => array( 
			'className' => 'ViagemTipo',
			'foreignKey' => 'viagem_tipo_id',
			'counterCache' => 'roteiro_ativo_count', 
			'counterScope' => array('Roteiro.status' => '1',),
    	),
*/
	);
	
	var $hasAndBelongsToMany = array(
		'ViagemTipo',
	);
	
	var $hasMany = array(
		'RoteirosViagemTipo',
	);

	var $hasOne = array(
		'Seo' => array(
			'conditions'   => array(
				'Seo.model' => 'Roteiro',
			),
			'dependent'    => true,
			'foreignKey' => 'model_id',
		),

		'RoteirosViagemTipoSearch' => array(
			'className' => 'RoteirosViagemTipo',
			'limit' => 1,
		),
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

		'destino_id' => array(
			'notEmpty' => array(
			   'rule'=>'notEmpty', 
				'required'=>true,  
				'allowEmpty'=>false,
				'message'=>'Por favor, selecione o destino.', 
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
	
    
	function setupAdmin($action = null, $id = null){		        
		$this->options['destino_id'] = $this->Destino->generatetreelist($conditions=null, $keyPath=null, $valuePath=null, $spacer= '_', $recursive=null);
		
		//Desabilita destinos que não permitem cadastro de roteiro
		$destinos = $this->Destino->find('list', array('contain' => false, 'fields' => array('id', 'flag_roteiros'), 'conditions' => array('flag_roteiros' => '0', 'flag_roteiros' => null)));
		foreach($destinos AS $key=>$value){
			$this->options['destino_id'][$key] = array(
				'name' => $this->options['destino_id'][$key],
				'value' => $key,
				'disabled' => true,
			);
		}

		$this->options['viagem_tipo_id'] = $this->ViagemTipo->find('list');

        $setupAdmin = array(
        	'options' => $this->options,
			'displayField' => $this->displayField,
			
            'topLink' => array(
				'Novo Roteiro' => array('url' => array('action' => 'add'), 'include_params_in_url' => true, 'htmlAttributes' => array()),
			),
			'listFields' => array(
				$this->alias.'.nome' => array('table_head_cell_param' => 'class="text-align-left"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Roteiro', ),
				$this->alias.'.friendly_url' => array('table_head_cell_param' => 'class="text-align-left" width="200"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Url', ),
				'Destino.nome' => array('table_head_cell_param' => 'class="text-align-left" width="150"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Destino', ),
				$this->alias.'.flag_destaque' => array('table_head_cell_param' => 'class="text-align-center" width="70"', 'table_body_cell_param' => 'class="text-align-center"', 'label' => 'Detaque', 'field_evaluate' => 'echo "<span title=\"Destaque ".(empty($r["'.$this->alias.'"]["flag_destaque"]) ? "Inativo" : "Ativo")."\" class=\"with-tip picto status-".$r["'.$this->alias.'"]["flag_destaque"]."\"></span>";',),
				$this->alias.'.status' => array('table_head_cell_param' => 'class="text-align-center" width="70"', 'table_body_cell_param' => 'class="text-align-center"', 'label' => 'Status', 'field_evaluate' => 'echo "<span title=\"Status ".(empty($r["'.$this->alias.'"]["status"]) ? "Inativo" : "Ativo")."\" class=\"with-tip picto status-".$r["'.$this->alias.'"]["status"]."\"></span>";',),
			),

			'defaultOrder' => array($this->alias.'.nome' => 'ASC',),
			
			'formParams' => array('enctype' => 'multipart/form-data'),

			'form'	=> array(
				'destino_id'	=> array('label' => 'Destino', 'empty' => '--Selecione--', 'options' => $this->options['destino_id'], ),
//				'viagem_tipo_id'=> array('label' => 'Tipo de Viagem', 'empty' => '--Selecione--', 'options' => $this->options['viagem_tipo_id'],),
				'nome'			=> array('label' => 'Roteiro',),
				'friendly_url'	=> array('label' => 'Url Amigável', 'type' => 'text', 'after' => '&nbsp;<small>Deixe em branco, caso queira defini-la automaticamente.</small>',),
				'status'		=> array('label' => 'Status', 'type' => 'checkbox', 'class'=>'switch', 'default' => '0', 'value' => '1'),
				'flag_destaque'	=> array('label' => 'Destacar na home', 'type' => 'checkbox', 'class'=>'switch', 'default' => '0', 'value' => '1'),
				'flag_destaque_txt'	=> array('label' => 'Descrição do destaque', 'cols' => 50, 'rows' => 5, 'style' => 'width: 580px; height: 120px;', 'limit' => 155, 'after' => '
					<script>
						jQuery(document).ready(function(){
							jQuery("#RoteiroFlagDestaque")
								.change(function(){
									if(jQuery(this).is(":checked")){
										jQuery("#RoteiroFlagDestaqueTxt").parent().slideDown();
									}
									else{
										jQuery("#RoteiroFlagDestaqueTxt").parent().slideUp();
									}
								})
								.trigger("change")
							;
						});
					</script>
				'),

			),
			
			'formAddon' => array('seo',),
			
			'box_filter' => array(
				$this->alias.'.destino_id' => array('title' => 'Filtrar destino', 'options' => array('*' => 'Todos',) + $this->Destino->generatetreelist($conditions=null, $keyPath=null, $valuePath= '{n}.Destino.nome_roteiro_totalXativo_count', $spacer= '_', $recursive=null)),
				'RoteirosViagemTipoSearch.viagem_tipo_id' => array(
					'title' => 'Filtrar tipo de viagem',
					'options' => 
						array('*' => 'Todos',) + 
						Set::combine(
							$this->ViagemTipo->find('all', array('contain' => false, 'fields' => array('ViagemTipo.id', 'ViagemTipo.nome_roteiro_totalXativo_count', ))),
							'{n}.ViagemTipo.id',
							'{n}.ViagemTipo.nome_roteiro_totalXativo_count'
						),
					
				),
			),
			'showLog' => array('index', 'edit'),

			'containIndex' => array('Destino', ),
			'containAddEdit' => array('ViagemTipo','RoteirosViagemTipo', 'Seo', ),

			'save_function' => 'saveAll',
			'save_params' => array('validate' => 'first',),

			'save_redirect_add' => array('action' => 'edit'),
			'save_redirect_edit' => array('action' => 'edit', $id),

		);
		
		//Adiciona modelo de RoteirosViagemTipoSearch, caso esteja filtrando o tipo
		if(preg_match('/\/filter\[RoteirosViagemTipoSearch\.viagem_tipo_id\]:[^\*]/', $_SERVER['REQUEST_URI'])){
			$setupAdmin['containIndex'][] = 'RoteirosViagemTipoSearch';
		}
		return $setupAdmin;
	}
	
	function beforeSave(){
		parent::beforeSave();
		if(empty($this->data[$this->alias]['id'])){
			$this->data['Roteiro']['precos'] = '[[Alta Temporada]]*preços por pessoa
[Single]
opção 1=US$ XX,XX
opção 2=US$ XX,XX
opção 3=US$ XX,XX

[Double]
opção 1=US$ XX,XX
opção 2=US$ XX,XX
opção 3=US$ XX,XX

[[Baixa Temporada]]*preços por pessoa
[Single]
opção 1=US$ XX,XX
opção 2=US$ XX,XX
opção 3=US$ XX,XX

[Double]
opção 1=US$ XX,XX
opção 2=US$ XX,XX
opção 3=US$ XX,XX';
		}
		return true;
	}
}