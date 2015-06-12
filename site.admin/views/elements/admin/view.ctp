<?php 
if(!isset($setup['topLink']))$setup['topLink'] = array();
if($canEdit){
	if(!isset($setup['topLink']))$setup['topLink'] = array();
	$setup['topLink'][$this->Html->image('icons/fugue/pencil.png').' Editar'] = array('url' => $this->params['named'] + array('action' => 'edit', $dados_originais[$model]['id']), 'htmlAttributes' => array('escape' => false));
}

//Trava edição do form
foreach($setup['form'] AS $key=>$value){
	if(is_array($value)){
		$setup['form'][$key]['readonly'] =
		$setup['form'][$key]['disabled'] =
			true
		;
	}
}

//Altera url
if(!isset($setup['formParams']))$setup['formParams'] = array();

$setup['formParams']['url'] = '#';
$setup['formParams']['class'] = 'form inline-medium-label';
$setup['formParams']['type'] = 'get';


$this->set('setup', $setup);

echo $this->element('admin/form/default',
	array(
		'form_title' => (!empty($setup['view_title']) ? $setup['view_title'] : 'Exibindo').': '.(!empty($setup['displayField']) &&  isset($dados_originais[$model][$setup['displayField']]) ? $dados_originais[$model][$setup['displayField']] : '').' (cód. '.$this->params['pass'][0].')',
		'form_submit_label' => false,
		'no_form_submit' => true,
	));
