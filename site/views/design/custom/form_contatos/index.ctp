<?php
	 $this->set('title_for_layout', 'Contato');
?>
<cake:nocache><?php echo $this->Session->flash('form_msg'); ?></cake:nocache>

<?/*?><div class="mapa" itemprop="location">
	<?php echo Configure::read('mapa'); ?>
	<div class="clear"></div>
</div>
<? */?>

<div id="title-bar">
	<div class="container">
		<div class="row-fluid">
			<div class="span6">
				<h1><?php echo Configure::read('titulo.pagina.contatos'); ?></h1>
				<strong><span>koch</span>tavares</strong>
			</div>
			<div class="span6">
				<div class="div"></div>
				<p>
					<?php echo Configure::read('texto.pagina.contato'); ?>
				</p>
			</div>
		</div>
	</div>
</div>

<?php echo $this->element('form/form_contato'); ?>
