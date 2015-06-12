<?php
define('DESTINO_FILE_DIR', SITE_DIR.'webroot/img/upload/destinos');

class Busca extends AppModel {
    var $name = 'Busca';
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

}