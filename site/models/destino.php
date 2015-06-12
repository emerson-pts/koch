<?php
define('DESTINO_FILE_DIR', SITE_DIR.'webroot/img/upload/destinos');

class Destino extends AppModel {
    var $name = 'Destino';
	var $displayField = 'nome';
    var $actsAs = array(
		'TreePlus',
        'MeioUpload' => array(
        	'imagem_capa' => array(
				'dir' => DESTINO_FILE_DIR,
				'url' => 'upload/destinos',
        	),
        	'imagem_lista' => array(
				'dir' => DESTINO_FILE_DIR,
				'url' => 'upload/destinos',
        	),
        )
		//'maxSize' => '1024*1024*10',
    );
    var $order = 'Destino.lft ASC';
    var $hasMany=array(
    	'Roteiro'=>array(
			'dependent'=> true,
    	),
    	'DestinoFoto' => array(
			'dependent'=> true,
			'order' => 'DestinoFoto.order ASC',
		),

/*    	'Noticia'=>array(
			'dependent'=> true,
    	),
*/  	
    );

	var $hasOne = array(
		'Seo' => array(
			'conditions'   => array(
				'Seo.model' => 'Destino',
			),
			'dependent'    => true,
			'foreignKey' => 'model_id',
		),
	);
		
    var $validate = array(
    	'parent_id' => array(
    		array(
    			'rule' => 'validateFlagRoteiro',
    			'message' => 'O destino selecionado não permite subníveis por permitir cadastrar roteiros',
    		),
    		
    	),
    	
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
			'rule' => array('checkUnique', array('friendly_url', 'parent_id')),
			'message'=> 'A URL amigável deve ser única.',
		),
	);
	
	public function __construct($id=false,$table=null,$ds=null){
		parent::__construct($id,$table,$ds);
 		$this->virtualFields = array(
			'nome_roteiro_count' => "CONCAT(`{$this->alias}`.`nome`, IF(`{$this->alias}`.`roteiro_count` > 0, CONCAT(' (', `{$this->alias}`.`roteiro_count`, ')'), ''))",
			'nome_roteiro_totalXativo_count' => "CONCAT(`{$this->alias}`.`nome`, IF(`{$this->alias}`.`flag_roteiros` = 1, CONCAT(' (', `{$this->alias}`.`roteiro_ativo_count`, '/', `{$this->alias}`.`roteiro_count`, ')'), ''))",
		);
	}
	
	function validateFlagRoteiro($data){
		//Verifica a flag_roteiros do destino selecionado
		$modelDestino = new Destino();
		if(current($data) == ''){
			return true;
		}
		else if(current(current($modelDestino->read('flag_roteiros', current($data))))){
			return false;
		}
		else{
			return true;
		}
	}
	
	function setupAdmin($action = null, $id = null){		        
  		//Monta opções de Referência
        if(!empty($id))$current_path = $this->getfullpath($id);
		$this->options['parent_id'] = $this->generatetreelist($conditions=null, $keyPath=null, $valuePath=null, $spacer= '_', $recursive=null);
		foreach($this->options['parent_id'] AS $key=>$value){
            $path = $this->getfullpath($key);
            
            if(empty($current_path) || !preg_match('/^'.preg_quote($current_path, '/').'/', $path))
                $this->options['parent_id'][$key] = $path;
            else
                unset($this->options['parent_id'][$key]);
		}

		//Desabilita destinos que permitem cadastro de roteiro
		$destinos = $this->find('list', array('contain' => false, 'fields' => array('id', 'flag_roteiros'), 'conditions' => array('flag_roteiros' => '1')));

		foreach($destinos AS $key=>$value){
			if(isset($this->options['parent_id'][$key])){
				$this->options['parent_id'][$key] = array(
					'name' => $this->options['parent_id'][$key],
					'value' => $key,
					'disabled' => true,
				);
			}
		}

		//Seta flag para automaticamente incluir o full path no find
		$this->afterFindGetfullpath = array('id', $this->displayField,);

		if(!empty($id)){
			$roteiro_count = current(current($this->read('roteiro_count', $id)));
			$has_children = $this->find('count', array('contain' => false, 'conditions' => array('parent_id' => $id)));
			$flag_roteiros = current(current($this->read('flag_roteiros', $id)));
		}

        $setupAdmin = array(
			'displayField' => $this->displayField,
			'displayFieldTreeIndex' => 'nome_roteiro_totalXativo_count',
			'displayFieldTreeIndexClass' => 'status-0{Destino.status} flag-roteiros-{Destino.flag_roteiros}',
			
			'pageDescriptionIndex' => __('Arraste os itens para reposicioná-los. Para acessar o menu de opções, passe o mouse sobre eles.', true),

            'topLink' => array(
				'Novo Destino' => array('url' => array('action' => 'add'), 'htmlAttributes' => array()),
			),
			'listFields' => array(
				$this->alias.'.nome' => array('table_head_cell_param' => 'class="text-align-left"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Destino', ),
			),
			
			'defaultLimit' => 999999,

			'formParams' => array('enctype' => 'multipart/form-data'),

			'form'	=> array(
				'parent_id'		=> array('label' => 'Referência', 'empty' => '--Raiz--', 'options' => $this->options['parent_id'],),
				'nome'			=> array('label' => 'Destino',),
				'friendly_url'	=> array('label' => 'Url Amigável', 'type' => 'text', 'after' => '&nbsp;<small>Deixe em branco, caso queira defini-la automaticamente.</small>',),
				'status'		=> array('label' => 'Status', 'type' => 'checkbox', 'class'=>'switch', 'default' => '0', 'value' => '1'),
				'flag_roteiros'	=> array('label' => 'Tem roteiros', 'type' => 'checkbox', 'disabled' => (!empty($id) && (!empty($roteiro_count) || $has_children) ? 'disabled' : ''),  'class'=>'switch', 'default' => '0', 'value' => '1', 'onchange'=> 'chkFlagRoteiros()',
					'after' => 
						(!empty($id) && (!empty($roteiro_count) || $has_children) ? 
							'<small> '.(!empty($roteiro_count) ? 'Este destino contém roteiros cadastrados' : 'Este destino contém subníveis').'</small>'
							:
							''
						).
					'<script>
						function chkFlagRoteiros(){
							if(jQuery("#DestinoFlagRoteiros").is(":checked")){
								jQuery("div.controller-Destinos ul.tabs li.destino-flag_roteiros-1").show();
								if(jQuery("#btnRoteiros").size()){jQuery("#btnRoteiros").show();}
							}
							else{
								jQuery("div.controller-Destinos ul.tabs li").removeClass("current").filter(":first-child").addClass("current");
								jQuery("div.controller-Destinos div.tabs-content>div").hide().filter(":first-child").show();
								jQuery("div.controller-Destinos ul.tabs li.destino-flag_roteiros-1").hide();
								if(jQuery("#btnRoteiros").size()){jQuery("#btnRoteiros").hide();}
							}
						}
						jQuery(document).ready(function(){
							chkFlagRoteiros();
						});
						jQuery(window).load(function(){
							chkFlagRoteiros();
						});
					</script>',
				),
			),
			
			'formAddon' => array('seo', ),
			
			'showLog' => array('index', 'edit'),

			'containIndex' => array(),
			'containAddEdit' => array('DestinoFoto', 'Seo',),

			'save_function' => 'saveAll',
			'save_params' => array('validate' => 'first',),

			'save_redirect_add' => array('action' => 'edit'),
			'save_redirect_edit' => array('action' => 'edit', $id),
		);

	
		if(!empty($id) && $flag_roteiros){
			$setupAdmin['topLink']['Roteiros para <i>'.current(current($this->read('nome', $id))).'</i>'] = array('url' => array('controller' => 'roteiros', 'action' => 'index', 'filter[Roteiro.destino_id]:'.$id), 'htmlAttributes' => array('id' => 'btnRoteiros', 'escape' => false));
		}

		return $setupAdmin;
	}    
}