<?php
if(!isset($gallery_setup) || !is_array($gallery_setup)){
	if(isset($gallery_setup) && Configure::read('debug')){
		echo '<div class="message_error">A configuração da galeria não foi definida corretamente.</div>';
	}
	$gallery_setup = array();
}

$gallery_setup += array(
	'id' 					=> 'gallery-'.($uid = String::uuid()),
	'id_main'				=> 'gallery-main-'.$uid,
	'id_thumb'				=> 'gallery-thumbnail-'.$uid,
	'model_arquivos'		=> 'GaleriaArquivo',
	'indicators'			=> true,
	'thumbnails'			=> true,
);

//Se nenhuma imagem foi enviada...
if(empty($result[ $gallery_setup['model_arquivos'] ])){
	return;
}

$this->viewVars['scripts_for_layout_footer'] .= 
	$this->Html->script('jquery.touchwipe.min').
	"<script>
	jQuery(document).ready(function(){
		jQuery('#" . $gallery_setup['id_main'] . "')
			.on('slid', function(){
				\$currentActive = jQuery(this).find('.active');
				\$currentActiveIndex = \$currentActive.index();
				
				\$currentActive.find('img').attr({'src': \$currentActive.find('img').attr('url_image_full')});

				\$carouselCurrent = jQuery(this).find('.carousel-current-info');
				if(\$carouselCurrent.length){
					\$carouselCurrent.html(\$currentActiveIndex+1);
				}

				jQuery('#" . $gallery_setup['id_thumb'] . " li').removeClass('active');
				jQuery('#" . $gallery_setup['id_thumb'] . ">li:eq(' + \$currentActiveIndex + ')').addClass('active');
				
				
			})
			.touchwipe({
				 wipeLeft: function() { jQuery('#" . $gallery_setup['id_main'] . "').carousel('next');  },
				 wipeRight: function() { jQuery('#" . $gallery_setup['id_main'] . "').carousel('prev');  },
				 min_move_x: 20,
				 min_move_y: 20,
				 preventDefaultEvents: false
		    })
		;

		//Registra teclas de atalho para as setas esquerda e direita do teclado
		jQuery(document).keydown(function(e){
			if(e.keyCode == 37){
				jQuery('#" . $gallery_setup['id_main'] . "').carousel('prev').trigger('click');
			}else if(e.keyCode == 39){
				jQuery('#" . $gallery_setup['id_main'] . "').carousel('next').trigger('click');
			}
		});
	
	});
</script>
";

?>
<div id="<?php echo $gallery_setup['id']; ?>">
	<ul id="<?php echo $gallery_setup['id_thumb']; ?>" class="thumbnails">
		<!-- Carousel items -->
		<?php foreach($result[ $gallery_setup['model_arquivos'] ] as $key=>$lista_atual): 
			?>
			<li data-target="#<?php echo $gallery_setup['id_main']; ?>" data-slide-to="<?php echo $key;?>" <?php if($key == 0):?>class="active"<?php endif; ?>>
				<a href="<?php echo $this->Image->thumbUrl(array('src'=>$lista_atual['arquivo'],'size'=>'864x562', ));?>">
					<?php
					echo $this->Image->thumbImage(
						array(
							'src' 	=> $lista_atual['arquivo'],
							'size'	=> '70*70',
							'crop'	=> '70*70',
						),
						array(
							'alt' => $lista_atual['titulo'],
						)
					);
					?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
	<div id="<?php echo $gallery_setup['id_main']; ?>" class="carousel slide main">
		<?php if($gallery_setup['indicators']): ?>
			<ol class="carousel-indicators">
				<?php
				$i_count = count($result[ $gallery_setup['model_arquivos'] ]); 
				for($i = 0; $i < $i_count; $i++):
				?>
					<li data-target="#<?php echo $gallery_setup['id_main']; ?>" data-slide-to="<?php echo $i;?>" <?php if($i == 0):?>class="active"<?php endif; ?>></li>
				<?php endfor; ?>
			</ol>
		<?php endif; ?>
		<div class="carousel-current label label-inverse">foto <span class="carousel-current-info">1</span> de <?php echo count($result[ $gallery_setup['model_arquivos'] ]); ?></div>
		<!-- Carousel items -->
		<div class="carousel-inner">
		<?php foreach($result[ $gallery_setup['model_arquivos'] ] as $key=>$lista_atual): 
			$key++;
			?>
			<div class="<?php if($key == 1):?>active<?php endif; ?> item">
				<?php
				echo $this->Image->thumbImage(
					array(
						'src' 	=> $lista_atual['arquivo'],
						'size'	=> ($key == 1 ? '864*562' : '200x130'),
					),
					array(
						'alt' => $lista_atual['titulo'],
						'url_image_full' => $this->Image->thumbUrl(array('src'=>$lista_atual['arquivo'],'size'=>'864x562', )),
						'width' => '100%',
					)
				);
				?>
				<?php if(!empty($lista_atual['titulo']) || !empty($lista_atual['legenda'])):?>
				<div class="carousel-caption">
					<?php if(!empty($lista_atual['titulo'])): ?><p class="lead"><?php echo $lista_atual['titulo']; ?></p><?php endif; ?>
					<?php if(!empty($lista_atual['legenda'])): ?><p><?php echo $lista_atual['legenda']; ?></p><?php endif; ?>
				</div>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
		</div>

		<!-- Carousel nav -->
		<a class="carousel-control left" href="#<?php echo $gallery_setup['id_main']; ?>" data-slide="prev"><span>&lsaquo;</span></a>
		<a class="carousel-control right" href="#<?php echo $gallery_setup['id_main']; ?>" data-slide="next"><span>&rsaquo;</span></a>
	</div>
</div><!-- exibicao-galeria-peq -->