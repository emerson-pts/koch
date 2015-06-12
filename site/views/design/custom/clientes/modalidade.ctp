<div id="title-bar">
	<div class="container modalidade">
		<div class="row-fluid">
			<div class="span12">
				<div class="img-modalidade" style="height: 200px; overflow:hidden; ">
					<?php
						echo $this->Image->thumbImage(
							array(
								'src' 	=> $modalidade['Modalidade']['image'],
								'size'	=> '1180*200',
								//'crop'	=> '1160*200',
								//'crop_pos' => 'center top',
							)
						);
					?>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container modalidade">
		<div class="row-fluid">

			<div class="span12">
				<p><?php echo $modalidade['Modalidade']['conteudo']; ?></p>
			</div>

		</div>

		<div class="row-fluid modalidade-texto">

			<?php
			foreach ($textos AS $key => $texto): ?>
			<div class="span4">
				<?php
					echo $this->Image->thumbImage(
						array(
							'src' 	=> $texto['Texto']['image'],
							'size'	=> '389*228',
							//'crop'	=> '1160*200',
							//'crop_pos' => 'center top',
						)
					);
				?>
				<strong><?php echo $texto['Texto']['titulo'];?></strong>
				<p><?php echo $texto['Texto']['descricao'];?></p>
			</div>

			<? endforeach; ?>

		</div>

		<hr />

		<div class="row-fluid modalidade-video">

			<div class="span8">
				<div class="list_carousel responsive">
					<ul id="slide_modalidade">

						<?php
						foreach ($videos AS $key => $video): ?>
						<li>
							<div class="slide">
								<?php
									echo $video['Video']['embed'];
								?>
							</div>
						</li>

						<? endforeach; ?>

					</ul>
				</div>
			</div>

			<div class="span4">

				<div class="list_carousel responsive">
					<ul id="slide_modalidade_texto">

						<?php
						foreach ($videos AS $key => $video): ?>
						<li>
							<strong><?php echo $video['Video']['titulo']; ?></strong>
							<p><?php echo $video['Video']['descricao']; ?></p>
						</li>
						<? endforeach; ?>

					</ul>
				</div>

				<div style="position:relative; ">

					<a id="prev_mod" class="prev" href="javascript:;">
						<span></span>
					</a>
					<a id="next_mod" class="next" href="javascript:;">
						<span></span>
					</a>

					<a id="prev_mod_text" class="prev" href="javascript:;">
						<span></span>
					</a>
					<a id="next_mod_text" class="next" href="javascript:;">
						<span></span>
					</a>

				</div>
			</div>
		</div>
 
		<hr />

		<div class="row-fluid modalidade-galeria">

			<div class="span8">
				<div class="list_carousel responsive">
					<ul id="slide_galeria">
						<?php
						foreach ($galerias AS $key => $galeria): ?>
						<li>
							<div class="slide">
								<div class="wrap-galeria">
									<!-- Galeria -->
									<div class="wrap-galeria-interna">
										<?php echo $this->element('submenu'); ?>
										<div id="exibicao-galeria-grande">
											<?php
												echo $this->element('galeria/exibe-galeria.v2', array('result' => $galeria_atual)); 
											?>
										</div>
									</div><!-- wrap-galeria-interna -->
									<!-- Galeria -->
								</div>
							</div>
						</li>
						<? endforeach; ?>
					</ul>
				</div>
			</div>

			<div class="span4">

				<div class="list_carousel responsive">
					<ul id="slide_galeria_texto">

						<?php
						foreach ($galerias AS $key => $galeria): ?>
						<li>
							<strong><?php echo $galeria['Galeria']['label']; ?></strong>
							<p><?php echo $galeria['Galeria']['descricao']; ?></p>
						</li>
						<? endforeach; ?>

					</ul>

				</div>

				<div style="position:relative; ">

					<a id="prev_gal" class="prev" href="javascript:;">
						<span></span>
					</a>
					<a id="next_gal" class="next" href="javascript:;">
						<span></span>
					</a>

					<a id="prev_gal_text" class="prev" href="javascript:;">
						<span></span>
					</a>
					<a id="next_gal_text" class="next" href="javascript:;">
						<span></span>
					</a>

				</div>

			</div>

		</div>

		<div class="row-fluid wallpaper">

			<div class="span4">
				<?php
				foreach ($wallpapers AS $key => $wall): ?>

				<?php
					echo $this->Image->thumbImage(
						array(
							'src' 	=> $wallpaper['Texto']['image'],
							'size'	=> '389*228',
							//'crop'	=> '1160*200',
							//'crop_pos' => 'center top',
						)
					);
				?>
				<? endforeach; ?>

					
			</div>

			<div class="span4">

				<?php
				foreach ($screensavers AS $key => $screen): ?>

				<?php
					echo $this->Image->thumbImage(
						array(
							'src' 	=> $screen['Texto']['image'],
							'size'	=> '389*228',
							//'crop'	=> '1160*200',
							//'crop_pos' => 'center top',
						)
					);
				?>
				<? endforeach; ?>

			</div>

		</div>
 
		<hr />

	</div>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() {

	jQuery('#slide_modalidade').carouFredSel({
		responsive: true,
		width: 1700,
		scroll: 1,
		prev: '#prev_mod',
		next: '#next_mod',
		auto: false,
		items: {
			width: 780,
		//	height: '30%',	//	optionally resize item-height
			visible: {
				min: 1,
				max: 1
			}
		},
	});

	jQuery('#slide_modalidade_texto').carouFredSel({
		responsive: true,
		width: 325,
		scroll: 1,
		auto: false,
		prev: '#prev_mod_text',
		next: '#next_mod_text',
		items: {
			width: 325,
		//	height: '30%',	//	optionally resize item-height
			visible: {
				min: 1,
				max: 1
			}
		},
	});

	jQuery('#prev_mod').click(function(e){
		e.preventDefault();
		jQuery('#prev_mod_text').trigger('click');
	});

	jQuery('#next_mod').click(function(e){
		e.preventDefault();
		jQuery('#next_mod_text').trigger('click');
	});

	jQuery('#prev_mod, #next_mod').css('margin-top',jQuery('#slide_modalidade li:first').height()-210+'px');

	jQuery('#slide_galeria').carouFredSel({
		responsive: true,
		width: 1700,
		scroll: 1,
		prev: '#prev_mod_gal',
		next: '#next_mod_gal',
		auto: false,
		items: {
			width: 780,
		//	height: '30%',	//	optionally resize item-height
			visible: {
				min: 1,
				max: 1
			}
		},
	});

	jQuery('#slide_galeria_texto').carouFredSel({
		responsive: true,
		width: 325,
		scroll: 1,
		auto: false,
		prev: '#prev_gal_text',
		next: '#next_gal_text',
		items: {
			width: 325,
		//	height: '30%',	//	optionally resize item-height
			visible: {
				min: 1,
				max: 1
			}
		},
	});

	jQuery('#prev_gal').click(function(e){
		e.preventDefault();
		jQuery('#prev_gal_text').trigger('click');
	});

	jQuery('#next_gal').click(function(e){
		e.preventDefault();
		jQuery('#next_gal_text').trigger('click');
	});

	jQuery('#prev_gal, #next_gal').css('margin-top',jQuery('#slide_galeria li:first').height()-100+'px');

	/* BANNER */
 	// $(".img-modalidade").mouseover(function(){
	//     $(this).css('height', 'auto');
	// });

	// $(".img-modalidade").mouseout(function(){
	//     $(this).css('height', '200px');
	// });

});
</script>