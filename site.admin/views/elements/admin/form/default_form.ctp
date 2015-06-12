<?php
if(!isset($setup['topLinkLeft']))$setup['topLinkLeft'] = array();
$setup['topLinkLeft'][$this->Html->image('icons/fugue/navigation-180.png').' Voltar'] = array('url' => $this->params['named'] + array('action' => 'index'), 'htmlAttributes' => array('escape' => false));
$this->set('setup', $setup);
?>
<h1><?php echo $form_title;?></h1>
<p>Por favor, preencha o formulário a seguir. Campos obrigatórios marcados com <em>*</em></p>
<?php 
if(empty($no_form_create)){
	echo $this->Form->create($model,(!empty($setup['formParams']) ? $setup['formParams'] : array()) + array('url' => $this->params['named'], 'class'=>'form inline-medium-label form-submit',));
}
?>
<fieldset>
	<?php
	echo $this->Form->input('id');
	if(!empty($setup['form'])){
		$i = 0;
		foreach($setup['form'] AS $key=>$params){
			//Se o índice é numérico e o valor é uma string...
			if(is_numeric($key) && !is_array($params)){
				//... então exibe o valor
				echo $params;
				continue;
			}
			
			if(!isset($params['type']) || $params['type'] != 'hidden')$i++;
			
			echo $this->Element('admin/form/default_form_input', array( 'key' => $key, 'params' => $params, 'i' => $i));
			
		}
	}
?>
</fieldset>
<?php
if(empty($no_form_submit)) echo $this->Form->submit($form_submit_label,array('class' => 'big-button', 'div'=>false)).' ou '.$html->link(__('Cancelar', true), $this->params['named'] + array('action' => 'index'), array('class' => 'button small red'));

if(!empty($setup['formAddon'])):
	foreach($setup['formAddon'] AS $formAddon):
		echo $this->Element('form/addon/'.$formAddon);
	endforeach;
endif;

if(empty($no_form_end))echo $this->Form->end();
