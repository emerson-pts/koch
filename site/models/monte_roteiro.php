<?php
class MonteRoteiro extends AppModel {

	var $name = 'MonteRoteiro';
	var $useTable = false;
	var	$cacheAction = false;
	var $actsAs = array('Tree');

	// var $hasOne = array(
	// 	'Roteiro' => array(
	// 		'className' => 'Roteiro',
	// 		'foreignKey' => 'destino_id',
	// 		'dependent' => true,
	// 		'conditions' => '',
	// 		'fields' => '',
	// 		'order' => ''
	// 	),
	// 	'Destino' => array(
	// 		'className' => 'Destino',
	// 		'foreignKey' => false,
	// 		'dependent' => false,
	// 		'conditions' => 'Destino.id = Roteiro.destino_id',
	// 		'fields' => '',
	// 		'order' => ''
	// 	)
	// );

	var $validate = array(
		'nome' => array(
			'rule' => 'notEmpty',
			'required'	=> true,
			'allowEmpty'=>false,
			'message' => "Campo Obrigatório",
		),
		'email' => array(
			'rule' => 'notEmpty',
			'required'	=> true,
			'allowEmpty'=>false,
			'message' => "Campo Obrigatório",
		),
		'telefone' => array(
			'rule' => 'notEmpty',
			'required'	=> true,
			'allowEmpty'=>false,
			'message' => "Campo Obrigatório",
		),
		// 'imagem' => array(
		// 	'rule' => 'notEmpty',
		// 	'required'	=> true,
		// 	'allowEmpty'=>false,
		// 	'message' => "Campo Obrigatório",
		// ),
	);
}