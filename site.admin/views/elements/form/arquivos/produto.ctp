<?php
if(!isset($setup['topLinkLeft']))$setup['topLinkLeft'] = array();
$setup['topLinkLeft'][$this->Html->image('icons/fugue/navigation-180.png').' Voltar'] = array('url' => $this->params['named'] + array('action' => 'index'), 'htmlAttributes' => array('escape' => false));
$this->set('setup', $setup);
?>
<section class="grid_12">
	<div class="block-border"><div class="block-content">
		<?php
			echo $this->element('admin/form/default_form', array(
				'form_title' => $form_title, 
				'form_submit_label' => $form_submit_label,
				'no_form_submit' => true,
				'no_form_end' => true,
			));
			?>

<ul class="tabs js-tabs same-height">
	<?php for($i=0; $i <= 5; $i++){ ?>
		<li class="current"><a href="#subproduto-<?php echo $i; ?>"><?php echo 'Subitem '.$j = $i + 1; ?></a></li> 
	<?php } ?>
</ul>
<div class="tabs-content">
	<?php for($i=0; $i <= 5; $i++): ?>
		<div id="subproduto-<?php echo $i; ?>">
			<p>
				<?php
					echo $form->hidden('ProdutoInfo.'.$i.'.id');
					echo $form->input('ProdutoInfo.'.$i.'.titulo'   	,array('label' => 'Título', 'type' => 'text'));
					echo $form->input('ProdutoInfo.'.$i.'.descricao'    ,array('label' => 'Descrição', 'class' => 'ckeditor', 'cols' => 50, 'rows' => 15,));
					echo $form->input('ProdutoInfo.'.$i.'.imagem'   	,array('label' => 'Foto', 'type' => 'file', 'show_remove' => true, 'show_preview' => '640x480', 'show_preview_url' => '/../'.str_replace('.admin', '', APP_DIR).'/thumbs/'));
				?>
			</p>
	    </div>
	<?php endfor ?>
	<br clear="all" />
</div>
<?php echo $this->Form->submit($form_submit_label,array('class' => 'big-button', 'div'=>false)).' ou '.$html->link(__('Cancelar', true), $this->params['named'] + array('action' => 'index'), array('class' => 'button small red'));?>
<?php echo $this->Form->end();?>

	</div></div>
</section>