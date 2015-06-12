<?php
define('DESTINO_FLAT_FILE_DIR', SITE_DIR.'webroot/img/upload/destinos');

class DestinoFlat extends AppModel {
    var $name = 'Destino';
	var $displayField = 'nome';
    var $actsAs = array(
        'MeioUpload' => array(
        	'imagem_capa' => array(
				'dir' => DESTINO_FLAT_FILE_DIR,
				'url' => 'upload/destinos',
        	),
        	'imagem_lista' => array(
				'dir' => DESTINO_FLAT_FILE_DIR,
				'url' => 'upload/destinos',
        	),
        )
		//'maxSize' => '1024*1024*10',
    );

	function beforeSave(){
		return false;
	}
	
	function beforeDelete(){
		return false;
	}
}