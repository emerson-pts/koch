<?php
	 $this->set('title_for_layout', 'História');
?>

<div id="title-bar">
	<div class="container">
		<div class="row-fluid contato">
			<div class="span6">
				<h1><?php echo Configure::read('titulo.pagina.historia'); ?></h1>
				<strong><span>koch</span>tavares</strong>
			</div>
			<div class="span6">
				<div class="div"></div>
				<p>
					<?php echo Configure::read('texto.pagina.historia'); ?>
				</p>
			</div>
		</div>
	</div>
</div>

<?php echo $this->element('historia/historia'); ?>
