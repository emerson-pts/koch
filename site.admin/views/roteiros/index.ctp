<?php
if(!isset($setup['topLinkLeft']))$setup['topLinkLeft'] = array();

if(!empty($destino_atual)){
	$setup['topLinkLeft'][$this->Html->image('icons/fugue/navigation-180.png').' Destino: <i>'.$destino_atual['Destino']['nome'].'</i>'] = array('url' => array('controller' => 'destinos', 'action' => 'edit', $destino_atual['Destino']['id']), 'htmlAttributes' => array('escape' => false));
	$setup['pageTitle'] = 'Roteiros para <i>'.$destino_atual['Destino']['nome'].'</i>';
	unset($setup['listFields']['Destino.nome']);
}
else{
	$setup['topLinkLeft'][$this->Html->image('icons/fugue/navigation-180.png').' Destinos'] = array('url' => array('controller' => 'destinos', 'action' => 'index'), 'htmlAttributes' => array('escape' => false));
}

$this->set('setup', $setup);

echo $this->Element('admin/index');
