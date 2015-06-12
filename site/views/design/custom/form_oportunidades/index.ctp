<?php
	 $this->set('title_for_layout', 'Oportunidades');
?>
<cake:nocache><?php echo $this->Session->flash('form_msg'); ?></cake:nocache>

<?/*?><div class="mapa" itemprop="location">
	<?php echo Configure::read('mapa'); ?>
	<div class="clear"></div>
</div>
<? */?>

<div id="title-bar">
	<div class="container">
		<div class="row-fluid contato">
			<div class="span6">
				<h1>oportunidades</h1>
				<strong><span><?php echo Configure::read('titulo.pagina.oportunidades'); ?></span></strong>
			</div>
			<div class="span6">
				<div class="div"></div>
				<p>
					<?php echo Configure::read('texto.pagina.oportunidades'); ?>
				</p>
			</div>
		</div>
	</div>
</div>

<?php echo $this->element('form/form_oportunidade'); ?>
