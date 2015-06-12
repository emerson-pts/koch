<div id="title-bar">
	<div class="container">
		<div class="row-fluid">
			<div class="span6">
				<h1><?php echo Configure::read('titulo.pagina.areas'); ?></h1>
				<strong><span>KOCH</span>tavares</strong>
			</div>
			<div class="span6">
				<div class="div"></div>
				<p>
					<?php echo Configure::read('texto.pagina.areas'); ?>
				</p>
			</div>
		</div>
	</div>
</div>

<div class="container areas">

	<div class="row-fluid no-space">
		<?php
		$i=0;
		foreach ($areas AS $key => $area):
		$color = $i % 2 ? 'color' : '';

		if(!$mobile) {
			if($i == '0' || $i == '2' || $i == '5' || $i == '7' || $i == '8' || $i == '10' || $i == '13' || $i == '15' || $i == '16' || $i == '18' || $i == '21' || $i == '23' || $i == '26' || $i == '28' || $i == '31') { ?>
				<div class="span3 color">
			<? } else { ?>
				<div class="span3">
			<? }
		} else { ?>			
				<div class="span3 <?php echo $color; ?>">
		<? } ?>

			<a href="<?php echo $this->Html->url('/'.$this->params['originalArgs']['params']['url']['url'].'/'.$area['Area']['friendly_url']); ?>">

				<div class="area">
					<p><?php echo $area['Area']['titulo'] ?></p>
					<p class="descricao"><?php if(!empty($area['Area']['conteudo_preview'])) echo $area['Area']['conteudo_preview']; ?></p>
					<span class="link-overlay-text">
						<? /*?><div>saiba mais</div><? */?>
					</span>
				</div>
			</a>

		</div>

		<?php
		$i++;
		#$i==5;
		endforeach;
		?>

	</div>

</div>