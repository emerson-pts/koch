<div id="title-bar">
	<div class="container">
		<div class="row-fluid">
			<div class="span6">
				<h1><?php echo Configure::read('titulo.pagina.cases'); ?></h1>
				<strong><span>confira</span></strong>
			</div>
			<div class="span6">
				<div class="div"></div>
				<p>
					<?php echo Configure::read('texto.pagina.cases'); ?>
				</p>
			</div>
		</div>
	</div>
</div>

<div class="container cases">

	<div class="row-fluid">

		<?php
		foreach ($cases AS $key => $case): ?>

		<div class="span3">

			<div class="case">
				<a href="<?php echo $this->Html->url('/cases/'.$case['Cas']['friendly_url']);?>">
					<p>
					<?php
						echo $this->Image->thumbImage(
							array(
								'src' 	=> $case['Cas']['image_chamada'],
								'size'	=> '295*295',
								//'crop'	=> '295*265',
							),
							array('class' => 'link-overlay-case',)
						);
					?>
					</p>
					<span class="link-overlay-text">
						<div><?php echo $case['Cas']['titulo'] ?></div>
					</span>
				</a>
			</div>

		</div>

		<? endforeach; ?>

	</div>

</div>