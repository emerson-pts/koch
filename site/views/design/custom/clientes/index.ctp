<div id="title-bar">
	<div class="container">
		<div class="row-fluid">
			<div class="span6">
				<h1><?php echo Configure::read('titulo.pagina.clientes'); ?></h1>
				<strong><span>koch</span>tavares</strong>
			</div>
			<div class="span6">
				<div class="div"></div>
				<p>
					<?php echo Configure::read('texto.pagina.clientes'); ?>
				</p>
			</div>
		</div>
	</div>
</div>

<div class="container clientes">

	<div class="row-fluid no-space">

		<?php
		foreach ($clientes AS $key => $cliente): ?>

		<div class="span3">

			<div class="cliente">		
				<p>
				<?php
					echo $this->Image->thumbImage(
						array(
							'src' 	=> $cliente['Cliente']['image'],
							'size'	=> '261*261',
							//'crop'	=> '100*182',
						),
						array('class' => '',)
					);
				?>
				</p>

				<?php
				if ($cliente['Cliente']['video']): ?>
					<a class="fancybox" href="#inline<?php echo $key; ?>">
						<div class="btn-video">
							<span class="btn-custom">+</span>
							<span class="link">ver depoimento em video</span>
						</div>
					</a>
				<? endif; ?>
			</div>

			<div id="inline<?php echo $key; ?>" style="display: none;">
				<?php echo $cliente['Cliente']['video']; ?>
			</div>

		</div>

		<?php
		endforeach;
		?>

	</div>

</div>

<!-- <div class="container">
	<div class="row-fluid">
		<hr />
	</div>
</div> -->

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
	$(".fancybox").fancybox();
});
</script>