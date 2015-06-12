<?php
//define('OPORTUNIDADES_FILE_DIR', SITE_DIR.'webroot/img/upload/oportunidades');

class FormOportunidade extends AppModel {

	var $name = 'FormOportunidade';
	var $useTable = false;

	// var $actsAs = array(
 //        'MeioUpload' => array(
 //        	'arquivo' => array(
	// 			'dir' => OPORTUNIDADES_FILE_DIR,
	// 			'url' => 'upload/oportunidades',
	// 			#'useTable' => false,
 //        	),
 //        )
	// 	//'maxSize' => '1024*1024*10',
 //    );

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

		// 'arquivo' => array(
  //           'uploadMimeType' => array(
  //           	'uploadMimeType', array('application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
  //           	),
  //               'message' => 'Tipo do arquivo é inválido.'
  //           ),
  //       )

	);



}