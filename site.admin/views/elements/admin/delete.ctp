<?php 
if(!isset($setup['topLinkLeft']))$setup['topLinkLeft'] = array();
$setup['topLinkLeft'][$this->Html->image('icons/fugue/navigation-180.png').' Voltar'] = array('url' => $this->params['named'] + array('action' => 'index'), 'htmlAttributes' => array('escape' => false));

//Altera url
if(!isset($setup['formParams']))$setup['formParams'] = array();

$setup['formParams']['url'] = '#';
$setup['formParams']['class'] = 'form inline-medium-label';
$setup['formParams']['type'] = 'get';
$this->set('setup', $setup);

$form_title = (!empty($setup['delete_title']) ? $this->Webjump->extract($dados_originais, $setup['delete_title']) : sprintf(__('Você tem certeza que deseja remover o registro: %s (cód. %s)?', true), (!empty($setup['displayField']) && isset($dados_originais[$model][$setup['displayField']]) ? $dados_originais[$model][$setup['displayField']] : ''), $this->params['pass'][0]));
?>
<section class="grid_12">
	<div class="block-border"><div class="block-content">
		<h1><?php echo $form_title;?></h1>
		<?php 
			if(!empty($setup['delete_alert'])):
		?>
			<p class="message warning"><?php echo $setup['delete_alert'];?></p>
		<?php
			endif;
		
			echo $this->Form->create(null,array('type' => 'post', 'class'=>'form inline-medium-label',) + (!empty($setup['formParams']) ? $setup['formParams'] : array()));
		?>
		<fieldset>
			<?php echo $this->Form->input('delete_confirm', array('type' => 'checkbox', 'class' => 'switch', 'label' => 'Sim, quero apagar'));?>
		</fieldset>
		<div class="clear"></div>
		<br />
		<?php
		echo $this->Form->submit('Apagar registro', array('class' => 'big-button red', 'div'=>false)).' ou '.$html->link(__('Cancelar', true), $this->params['named'] + array('action' => 'index'), array('class' => 'button small'));
		echo $this->Form->end();
		?>
	</div></div>
</section>

