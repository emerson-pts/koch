<a id="archor"></a>
<div id="title-bar" class="nopadding">
	<div class="container modalidade">
		<div class="row-fluid">
			<div class="span12">
				<?php
				$bg = $modalidade['Modalidade']['image'];
				?>
				<div class="img-modalidade" style="width:100%;  height: 270px; overflow:hidden; background:url('http://kochtavares.com.br/<?php echo $bg; ?>') no-repeat;">
					<div class="icon-modalidade">
						<h2><?php echo $modalidade['Modalidade']['titulo']; ?></h2>
						<?php
							echo $this->Image->thumbImage(
								array(
									'src' 	=> $modalidade['Modalidade']['banner_icone'],
									'size'	=> '90*90',
									//'crop'	=> '1160*200',
									//'crop_pos' => 'center top',
								)
							);
							if(!empty($modalidade['Modalidade']['image'])):
						?>
					</div>
					<a href="javascript:;" class="down" title="Clique para abrir a imagem completa"></a>
					<a href="javascript:;" class="up" title="Clique para fechar a imagem"></a>
					<? endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container case">
		<div class="row-fluid">

			<div class="span12">
				<h2 class="subtitulo"><?php echo $modalidade['Modalidade']['conteudo']; ?></h2>
			</div>

		</div>

		<div class="row-fluid area-texto">
			<?php
			foreach ($textos AS $key => $texto): ?>

			<?php if(count($textos) == 1) { ?>
			<div class="span12">

				<a href="<?php echo $this->Html->url('/textos/'.$texto['Texto']['friendly_url']);?>">
					<?php
						echo $this->Image->thumbImage(
							array(
								'src' 	=> $texto['Texto']['image'],
								'size'=>'1180x228',
								//'crop'	=> '1180*228',
								//'crop_pos' => 'center top',
							)
						);
					?>
				</a>

			<? } // span12
			if(count($textos) == 2) { ?>
			<div class="span6">

				<a href="<?php echo $this->Html->url('/textos/'.$texto['Texto']['friendly_url']);?>">
					<?php
						echo $this->Image->thumbImage(
							array(
								'src' 	=> $texto['Texto']['image'],
								'size'	=> '580*330',
								//'crop'	=> '1160*200',
								//'crop_pos' => 'center top',
							)
						);
					?>
				</a>

			<? } //span6

			if(count($textos) == 3) { ?>
			<div class="span4">

				<a href="<?php echo $this->Html->url('/textos/'.$texto['Texto']['friendly_url']);?>">
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
				</a>

			<? } // span4 ?>

				<br />

				<strong><?php echo $texto['Texto']['titulo'];?></strong>
				<p><?php echo $texto['Texto']['descricao_preview'];?></p>
			</div>

			<? endforeach; ?>

		</div>

		<? if(count($videos)>0): ?>

		<hr />

		<div class="row-fluid modalidade-video">

			<div class="span8">
				<div class="list_carousel responsive">
					<ul id="slide_modalidade">
						<?php
						$i=0;
						foreach ($videos AS $key => $video): ?>
						<li>
							<div class="slide">
								<iframe width="100%" height="315" src="//www.youtube.com/embed/<?echo $video['Video']['embed'];?>?autoplay=<? if($i==0) echo '1'; else echo '0'; ?>"  frameborder="0" allowfullscreen></iframe>
							</div>
						</li>

						<?
						$i++;
						endforeach; ?>

					</ul>
				</div>
			</div>

			<div class="span4">

				<div class="list_carousel responsive">
					<ul id="slide_modalidade_texto">
						<?php
						$i=0;
						foreach ($videos AS $key => $video): ?>
						<li>
							<strong><?php echo $video['Video']['titulo']; ?></strong>
							<p><?php echo $video['Video']['descricao']; ?></p>
						</li>
						<?
						$i++;
						endforeach; ?>
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

		<? endif; ?>
 

		<? if(count($galerias)>0): ?>

		<hr />

		<div class="row-fluid modalidade-galeria">

			<div class="span8">

				<div class="list_carousel responsive">
					<ul id="slide_galeria">
						<?php
						foreach ($galerias AS $key => $galeria):
						?>
						<li>
							<div class="slide">
								<div class="wrap-galeria">
									<!-- Galeria -->
									<div class="wrap-galeria-interna">
										<div>
											<?php
												echo $this->element('galeria/exibe-galeria.v2', array('result' => $galeria));
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
				<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.0.min.js"></script>
				<script type="text/javascript">
				jQuery(function(){
					// slider thumb
					$slider = jQuery('.wj-gallery');
					var thumb_slide_width = 130;
					var thumb_slide_margin = 8;
					var thumb_width_for_controls = 135;
					var thumb_max_slides = Math.floor( ( $slider.width() - 135 ) / ( thumb_slide_width + thumb_slide_margin) );

					$slider.attr('thumb_max_slides', thumb_max_slides);

					//Inicia bx slider do thumb
					$slider.data('bxSliderObj', $slider.find('.wj-gallery-thumb>ul').bxSlider({
						maxSlides: thumb_max_slides,
						slideWidth: thumb_slide_width,
						slideMargin: thumb_slide_margin,
						infiniteLoop: false,
						pager: false,
						controls: true,
						hideControlOnEnd: true,
						nextText: '<?php __( 'Próximo' ); ?>',
						prevText: '<?php __( 'Anterior' ); ?>',
						onSliderLoad: function(){
							//Verifica se solicitou a exibição de uma imagem específica
							currentImage =  (window.location.hash != '' ? (parseInt(window.location.hash.replace('#', '')) - 1) : 0);
							//console.log(currentImage);
							if(currentImage != 0){
								//Ativa a imagem
								$slider.find('li:eq(' + currentImage + ')>a').trigger('click');
							}

							//Verifica se a imagem está dentro da rolagem atual do slide			
							currentSlide = Math.floor(currentImage/thumb_max_slides);
							if(currentSlide != 0){
								$slider.data('bxSliderObj').goToSlide(currentSlide);
							}
							//console.log('Carrega');
						}
					}));

					//Ação de clique no thumb
					jQuery('.wj-gallery-thumb-container li>a').on( 'click', function(event) {
						event.preventDefault();

						$thumb_ul = jQuery(this).parents( 'ul' );	//Seleciona o elemento ul do link clicado
						$thumb_ul.find( 'li>a.pager-active' ).removeClass( 'pager-active' );	//Desativa thumb atual
						jQuery(this).addClass( 'pager-active' );	// Ativa thumb clicado

						$wjGallery = jQuery(this).parents( '.wj-gallery' );	//Seleciona o container da galeria
						currentIndex = jQuery(this).parentsUntil('ul').index()+1;
						jQuery($wjGallery).find('.wj-gallery-current-image').html(currentIndex); //Atualiza a imagem atual

						if(window.location.hash != '' || currentIndex != 1 ) {
							//console.log(currentIndex);
							window.location.href = '#' + currentIndex;
						}
						
						$wjGalleryCurrent = $wjGallery.find( '.wj-gallery-current' );	//Seleciona o elemento da imagem atual
						$wjGalleryCurrent.find( 'img.wj-gallery-current-image' ).attr('src', jQuery(this).attr('data-image-full'));	//Carrega nova imagem
						$wjGalleryCurrent.find( '.wj-gallery-current-caption' ).html(jQuery(this).attr('data-caption'));	//Carrega título
						$wjGalleryCurrent.find( '.wj-gallery-current-legend' ).html(jQuery(this).attr('data-legend'));	//Carrega legenda
						return false;
					});

					//Ações de avançar e voltar da imagem atual
					jQuery('.wj-gallery-current-controls a').on( 'click', function(event){
						event.preventDefault();
						$wjGallery = jQuery(this).parents( '.wj-gallery' );	//Seleciona o container da galeria
						$wjGalleryCurrentThumb = $wjGallery.find('.wj-gallery-thumb li>a.pager-active').parent();	//Identifica o element li que contém o thumb ativo

						currentThumbIndex = $wjGalleryCurrentThumb.index(); //Identifica qual é o índice do li
						if(jQuery(this).hasClass('bx-prev')) {	//Se está clicando no botão anterior...
							if(currentThumbIndex == 0) {	//Se for o primeiro thumb...
								$wjGalleryCurrentThumb.parent().find('li:last>a').trigger('click');	//Vai para a última imagem				
							}
							else{
								$wjGalleryCurrentThumb.prev().find('>a').trigger('click');	//Vai para a imagem anterior
							}		
						}
						//Está avançando
						else {
							if((currentThumbIndex+1) == parseInt($wjGallery.attr('data-num-images'))) {	//Se for o último thumb...
								$wjGalleryCurrentThumb.parent().find('li:first>a').trigger('click');	//Vai para a primeira imagem
							}
							else {
								$wjGalleryCurrentThumb.next().find('>a').trigger('click');	//Vai para a próxima imagem
							}
						}
						
						newThumbIndex = $wjGallery.find('.wj-gallery-thumb li>a.pager-active').parent().index();
						
						$thumb_max_slides = $wjGallery.attr('thumb_max_slides');

						//currentSlide = $slider.data('bxSliderObj').getCurrentSlide();
						currentImage =  (window.location.hash != '' ? (parseInt(window.location.hash.replace('#', '')) - 1) : 0);
						currentSlide = Math.floor(currentImage/thumb_max_slides);
						newSlide = Math.floor(newThumbIndex/$thumb_max_slides);
						
						if(newSlide != currentSlide){
							//$slider.data('bxSliderObj').goToSlide(0);
							$('.wj-gallery-thumb li:first>a').trigger('click');
							$('.wj-gallery-thumb li:first>a').addClass('pager-active');
						}

						return false;
					});
					
					jQuery('a.wj-gallery-thumb-btn').on( 'click', function(event){
						event.preventDefault();

						jQuery(this).parent().find('.wj-gallery-thumb').slideToggle();
						return false;
					});

					jQuery('a.wj-gallery-text-btn').on( 'click', function(event){
						event.preventDefault();

						jQuery(this).parent().find('.wj-gallery-current-text').slideToggle();
						return false;
					});
					
					jQuery('img.wj-gallery-current-image').on( 'click', function(event){
						event.preventDefault();

						$toToggle = jQuery(this).parents('.wj-gallery').find('.wj-gallery-current-text, .wj-gallery-thumb');
						if($toToggle.filter(':visible').length) {
							$toToggle.slideUp();
						}
						else {
							$toToggle.slideDown();
						}		
						return false;
					});

					//Registra teclas de atalho para as setas esquerda e direita do teclado
					jQuery(document).keydown(function(e){
						if(e.keyCode == 37) {
							jQuery('div.wj-gallery-current-controls:first .bx-prev').trigger('click');
						} else if(e.keyCode == 39) {
							jQuery('div.wj-gallery-current-controls:first .bx-next').trigger('click');
						}
					});

				});
				</script>

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

		<? endif; ?>

		<hr />

		<div class="redes-sociais-interna">

			<div class="container">
				<div class="center">
					<div class="span1">
						<a href="javascript:;" title="Curtir"></a>
						<div class="fb-like-bt">
						<iframe src="https://www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fkochtavares%3Ffref%3Dts&width=110&layout=button_count&action=like&show_faces=true&share=false&height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:110px; height:21px;" allowTransparency="true"></iframe>

						</div>
					</div>
					<div class="span1">
						<a target="_blank" href="<?php echo Configure::read('rede.social.facebook'); ?>" title="Facebook"></a>
						<p>facebook</p>
					</div>
					<div class="span1">
						<a target="_blank" href="<?php echo Configure::read('rede.social.twitter'); ?>" title="Twitter"></a>
						<p>twitter</p>
					</div>
					<div class="span1">
						<a target="_blank" href="<?php echo Configure::read('rede.social.instagram'); ?>" title="Instagram"></a>
						<p>instagram</p>
					</div>
					<div class="span1">
						<a target="_blank" href="<?php echo Configure::read('rede.social.pinterest'); ?>" title="Pinterest"></a>
						<p>pinterest</p>
					</div>
					<div class="span1">
						<a target="_blank" href="<?php echo Configure::read('rede.social.youtube'); ?>" title="Youtube"></a>
						<p>youtube</p>
					</div>
					<div class="span1">
						<a href="mailto:<?php echo Configure::read('contato.email'); ?>" title="Email"></a>
						<p>e_mail</p>
					</div>
				</div>
			</div>
		</div>

		<?php if(count($wallpapers)>0 || count($screensavers)>0) { ?>

		<hr />

		<div class="row-fluid wallpaper">

			<?php if(count($wallpapers)>0): ?>
			<div class="span6">
				<h2>Wallpaper</h2>

				<?php
				foreach ($wallpaper AS $key => $wall):

					echo $this->Image->thumbImage(
						array(
							'src' 	=> $wall['Wallpaper']['image'],
							'size'	=> '684*376',
							//'crop'	=> '1160*200',
							//'crop_pos' => 'center top',
						)
					);
				endforeach; ?>

				<?php if(count($wallpapers)>0): ?>

					<ul class="download">
						<?php
						foreach ($wallpapers AS $key => $img): ?>

							<li>
								<a href="<?php echo $this->Html->url('/cases/download/'.$img['Wallpaper']['id']); ?>" target="_blank">
									<?php echo $img['Wallpaper']['descricao']?>
								</a>
							</li>

						<? endforeach; ?>

					</ul>

				<? endif; ?>

			</div>

			<? endif; ?>

			<?php if(count($screensavers)>0): ?>

			<div class="span6">
				<h2>Screensaver</h2>

				<?php
				foreach  ($screensaver AS $key => $screen):

					echo $this->Image->thumbImage(
						array(
							'src' 	=> $screen['Wallpaper']['image'],
							'size'	=> '684*376',
							//'crop'	=> '1160*200',
							//'crop_pos' => 'center top',
						)
					);
				endforeach;
				?>

				<?php if(count($screensavers)>0): ?>

					<ul class="download">
						<?php
						foreach ($screensavers AS $key => $img): ?>

							<li>
								<a href="<?php echo $this->Html->url('/cases/download/'.$img['Screensaver']['id']); ?>" target="_blank">
									<?php echo $img['Screensaver']['descricao']?>
								</a>
							</li>

						<? endforeach; ?>

					</ul>

				<? endif; ?>
			</div>

			<? endif; ?>


		</div>

		<? } ?>

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
			height: '55%',	//	optionally resize item-height
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
		//jQuery('#prev_mod, #next_mod').css('margin-top',jQuery('#slide_modalidade li embed').height()-10+'px');

		jQuery('#prev_mod_text').trigger('click');
	});

	jQuery('#next_mod').click(function(e){
		e.preventDefault();
		//jQuery('#prev_mod, #next_mod').css('margin-top',jQuery('#slide_modalidade li embed').height()-10+'px');

		jQuery('#next_mod_text').trigger('click');
	});

	//jQuery('#prev_mod, #next_mod').css('margin-top','100px');

	jQuery('#slide_galeria').carouFredSel({
		responsive: true,
		width: 325,
		scroll: 1,
		prev: '#prev_gal',
		next: '#next_gal',
		auto: false,
		items: {
			width: 325,
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
		currentImage =0;
		currentSlide=0;

		jQuery('#prev_gal_text').trigger('click');
		$slider.find('li:eq(' + currentImage + ')>a').trigger('click');

	});

	jQuery('#next_gal').click(function(e){
		e.preventDefault();
		currentImage =0;
		currentSlide=0;

		jQuery('#next_gal_text').trigger('click');
		$slider.find('li:eq(' + currentImage + ')>a').trigger('click');
	});

	//jQuery('#prev_gal, #next_gal').css('margin-top','450px');

	/* BANNER */
 // 	$(".img-modalidade").mouseover(function(){
	//     $(this).css('height', 'auto');
	//     $(this).css('position', 'absolute');
	//     $(this).css('z-index', '999');
	//     $('#title-bar').css('height', '270px');
	// });

	// $(".img-modalidade").mouseout(function(){
	//     $(this).css('height', '270px');
	// });

	$(".img-modalidade a.down").on('click',function(){
		$(this).hide();
		$('a.up').show();

		<? if(count($textos) == 1) { ?>
			$(".img-modalidade").css('height', '585px');
		<? } else if(count($textos) == 2) { ?>
			$(".img-modalidade").css('height', '634px');
		<? } else if(count($textos) == 3) { ?>
			$(".img-modalidade").css('height', '545px');
		<? } ?>

//     	$(".img-modalidade").css('position', 'absolute');
    	$(".img-modalidade").css('z-index', '999');
	    $('#title-bar').css('height', '270px');

	    $('html,body').animate({scrollTop: 180 }, 1000,'swing');

	});

	$(".img-modalidade a.up").on('click',function(){
		$(this).hide();
		$('a.down').show();

		$(".img-modalidade").css('height', '270px');
	});

	$('iframe').height($('#slide_modalidade li').height());

});
</script>
