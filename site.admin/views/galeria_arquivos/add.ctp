<?php
//Se é o envio individual
if(empty($this->params['pass'][0]) || $this->params['pass'][0] != 'multiple'){
	echo $this->Element('admin/add');
	return;
}else{
	$this->set('upload_config', array(
		'multiple_title' => 'Envio de fotos para '.$galeria_atual['Galeria']['label'],
		'params' => array('galeria_id' => $this->params['named']['filter[GaleriaArquivo.galeria_id]'],)
	));
	echo $this->Element('admin/multiple_upload');
	return;
}
