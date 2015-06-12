<?php
class RoteirosViagemTipo extends AppModel {
    var $name = 'RoteirosViagemTipo';

	var $belongsTo = array(
		'Roteiro',

    	'ViagemTipo'=>array(
			'dependent'=> true,
			'counterCache' => 'roteiro_count',
		),
		
		'ViagemTipoAtivo' => array( 
			'className' => 'ViagemTipo',
			'foreignKey' => 'viagem_tipo_id',
			'counterCache' => 'roteiro_ativo_count', 
			'counterScope' => array('Roteiro.status' => '1',),
    	),
	);
	

	function afterSave($created){
		if(array_key_exists('viagem_tipo_id', $this->data[$this->alias]) && empty($this->data[$this->alias]['viagem_tipo_id'])){
			$this->delete($this->id);
		}
		return true;
	}
}