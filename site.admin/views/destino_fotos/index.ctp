<?php
if(!isset($setup['topLinkLeft']))$setup['topLinkLeft'] = array();
$setup['topLinkLeft'][$this->Html->image('icons/fugue/navigation-180.png').' Voltar para <i>'.$destino_atual['Destino']['nome'].'</i>'] = array('url' => array('controller' => 'destinos', 'action' => 'edit', $destino_atual['Destino']['id']), 'htmlAttributes' => array('escape' => false));
$setup['pageTitle'] = 'Imagens em <i>'.$destino_atual['Destino']['nome'].'</i>';
$this->set('setup', $setup);

echo $this->Element('admin/sortable_index');
