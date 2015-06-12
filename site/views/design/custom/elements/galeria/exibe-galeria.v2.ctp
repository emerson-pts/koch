<?php
if(!isset($gallery_setup) || !is_array($gallery_setup)) {
	if(isset($gallery_setup) && Configure::read('debug')) {
		echo '<div class="message_error">A configuração da galeria não foi definida corretamente.</div>';
	}
	$gallery_setup = array();
}

$gallery_setup += array(
	'selector' 				=> 'gallery-'.String::uuid(),
	'count_thumbs_label' 	=> __( 'Foto: %1$s de %2$s', true),
	'model_arquivos'		=> 'GaleriaArquivo',
	'model'					=> 'Galeria',
	'thumb_width'			=> 130,
	'thumb_height'			=> 88,
	'thumb_margin'			=> 8,
	'thumb_width_for_controls' => 135,
);

//Se nenhuma imagem foi enviada...
if(empty($result)) {
	return;
}

// echo '<pre>';
// print_r($result);

$num_images = count( $result[$gallery_setup['model_arquivos']] );
?>
<div id="<?php echo $gallery_setup['selector'];?>" class="wj-gallery galleryid-<?php echo $result[$gallery_setup['model']]['id'];?>" data-num-images="<?php echo $num_images;?>">
	<div class='wj-gallery-count-thumbs'>
		<?php #printf( $gallery_setup['count_thumbs_label'], '<span class="wj-gallery-current-image">1</span>', $num_images); ?>
	</div>
	<div class='wj-gallery-container'>
		<div class='wj-gallery-thumb-container'>
			<div class='wj-gallery-thumb'>
				<ul>
				<?php
				foreach ( $result[$gallery_setup['model_arquivos']] as $key => $r ):
					$i = $key+1;
					
					if( $i == 1 ){
						$first_image = $r;
					}
					else if($i == 2){
						$second_image = $r;
					}
					else if( $i == $num_images ){
						$last_image = $r;
					}
					?>
					<li>
						<?php echo $this->Html->link(
							$this->Image->thumbImage(
								array(
									'src' 	=> $r['arquivo'],
									'size'	=> $gallery_setup['thumb_width'].'*'.$gallery_setup['thumb_height'],
									'crop'	=> $gallery_setup['thumb_width'].'*'.$gallery_setup['thumb_height']
								),
								array("alt" => $r['titulo'],'width'=> $gallery_setup['thumb_width'],'height'=> $gallery_setup['thumb_height'],)
							),
							$this->Html->url('/'.$r['arquivo']),
							array(
								'escape' 		=> false,
								'class' 		=> ($i == 1 ? 'pager-active' : ''),
								'data-caption' 	=> $r['titulo'],
								'data-legend'	=> $r['legenda'],
								'data-image-full'=> $this->Html->url('/'.$r['arquivo']),
							)
						);
						?>
					</li>
				<?php
				endforeach;
				?>
				</ul>
			</div>
			<!-- <a class='wj-gallery-thumb-btn' href='javascript://exibir/ocultar Thumbs'></a> -->
		</div>
		<div class='wj-gallery-current'>
			<div class='wj-gallery-current-controls'>
				<?php echo $this->Html->link( __('Anterior', true), '/'.$last_image['arquivo'], array('class' => 'bx-prev'));?>
				<?php echo $this->Html->link( __('Próximo', true), '/'.$second_image['arquivo'], array('class' => 'bx-next'));?>
			</div>
			<img src="<?php echo $this->Html->url('/'.$first_image['arquivo']);?>" class="wj-gallery-current-image" />
			<div class="wj-gallery-text-container">
				<!-- <a class="wj-gallery-text-btn" galeria="<?php echo $result['Galeria']['id']; ?>" href="javascript://exibir/ocultar Descrição"></a> -->
				<div class="wj-gallery-current-text">
					<!-- <div class="wj-gallery-current-caption"><?php #echo $first_image['titulo'];?></div> -->
					<div class="wj-gallery-current-legend"><?php #echo $first_image['legenda'];?></div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class='clear'></div>