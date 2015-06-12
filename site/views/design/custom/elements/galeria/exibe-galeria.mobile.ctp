<?php
if(!isset($gallery_setup) || !is_array($gallery_setup)){
	if(isset($gallery_setup) && Configure::read('debug')){
		echo '<div class="message_error">A configuração da galeria não foi definida corretamente.</div>';
	}
	$gallery_setup = array();
}

$gallery_setup += array(
	'selector' 				=> 'gallery-'.String::uuid(),
	'model_arquivos'		=> 'GaleriaArquivo',
);

//Se nenhuma imagem foi enviada...
if(empty($result[ $gallery_setup['model_arquivos'] ])){
	return;
}

?>
<script>
	jQuery(document).ready(function(){
		jQuery('#myCarousel').on('slid', function(){
			jQuery(this).find('.active img').attr({'src': jQuery(this).find('.active img').attr("url_image_full")});
			
		});
	});
	
</script>
<div id="exibicao-galeria-peq">
	<div id="myCarousel" class="carousel slide">
		<!-- Carousel items -->
		<div class="carousel-inner">
		<!--<div class="active item"><?php echo $this->Html->image("ex-vitrine001.png", array("alt" => ""));?></div>
		<div class="item"><?php echo $this->Html->image("ex-vitrine001.png", array("alt" => ""));?></div>
		<div class="item"><?php echo $this->Html->image("ex-vitrine001.png", array("alt" => ""));?></div>-->
		<?php foreach($result[ $gallery_setup['model_arquivos'] ] as $key=>$lista_atual): 
			$key++;
			if($key == 1):
			?>
				<div class="active item">
					<?php
					echo $this->Image->thumbImage(
						array(
							'src' 	=> $lista_atual['arquivo'],
							'size'	=> '864x562',
//							'crop'	=> '864x562',
						),
						array(
							'alt' => $lista_atual['titulo'],
							'url_image_full' => $this->Image->thumbUrl(array('src'=>$lista_atual['arquivo'],'size'=>'864x562',)),
							'class' => 'img-galeria-pequena',
							'width' => '100%',
						)
					);
					?>
				</div>
			<?php else: ?>
				<div class="item">
					<?php
					echo $this->Image->thumbImage(
						array(
							'src' 	=> $lista_atual['arquivo'],
							'size'	=> '200x130',
//							'crop'	=> '200x130',
						),
						array(
							'alt' => $lista_atual['titulo'],
							'url_image_full' => $this->Image->thumbUrl(array('src'=>$lista_atual['arquivo'],'size'=>'864x562',)),
							'class' => 'img-galeria-pequena',
							'width' => '100%',
						)
					);
					?>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>
		</div>
		<!-- Carousel nav -->
		<a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
		<a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
	</div>
</div><!-- exibicao-galeria-peq -->
