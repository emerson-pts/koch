<div id="title-bar">
	<div class="container">
		<div class="row-fluid">
			<div class="span6">
				<h1><?php echo Configure::read('titulo.pagina.modalidades'); ?></h1>
				<strong><?php echo Configure::read('subtitulo.pagina.modalidades'); ?></strong>
			</div>
			<div class="span6">
				<div class="div"></div>
				<p>
					<?php echo Configure::read('texto.pagina.modalidades'); ?>
				</p>
			</div>
		</div>
	</div>
</div>

<div class="container modalidades">

	<div class="row-fluid no-space">

		<?php
		$i=0;
		foreach ($modalidades AS $key => $modalidade):
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

			<div class="modalidade">

				<a href="<?php echo $this->Html->url('/modalidades/'.$modalidade['Modalidade']['friendly_url']);?>">					
					<p>
					<?php
						echo $this->Image->thumbImage(
							array(
								'src' 	=> $modalidade['Modalidade']['image_chamada'],
								'size'	=> '169*169',
								//'crop'	=> '169*169',
							),
							array('class' => 'link-overlay-modalidade',)
						);
					?>
					</p>
					<p class="descricao"><?php echo $modalidade['Modalidade']['titulo']; ?></p>
					<span class="link-overlay-text">
						<? /*?><div>saiba mais</div><?*/?>
					</span>
				</a>
			</div>

		</div>

		<?
		$i++;
		endforeach; ?>

	</div>

</div>