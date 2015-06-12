<?php // conta o numero de fotos da galeria
$result =  count($galeria_atual['GaleriaArquivo']); 
?>
<!-- codigo html galeria -->
<div class="wrap-galeria">
	<div class="title_galeria">
		<?php //echo $galeria_atual['Galeria']['titulo']; ?>
		<h2 class="f30 neo orange2 uppercase"><?php echo $galeria_atual['Galeria']['label']; ?></h2>
	</div><!-- title-galeria-atual -->
	<!-- Count thumbs -->
	<div class="right count_thumbs">
		<span class="sevent f8">
			<?php // echo  'foto 1 de '.$result; ?>
			<?php echo  'total de fotos: '.$result; ?>
		</span>
	</div>
	<!-- Count thumbs -->
	<div class="barra-galeria" style="position:absolute;z-index:9;">
		<div class="vitrine-galeria top">
				<ul id="slider1-galeria" style="margin:0px !important;">
					<?php foreach($galeria_atual['GaleriaArquivo'] as $key=>$lista_atual):
						if(empty($galeria_indice)){
							$galeria_indice = $key;
						}
					?>
					<li style="width:140px;">
						<div class="thumbs-galeria">
							<a href="" class="<?php echo 'thumb_id_'.$lista_atual['id'];if($key == 0){echo ' pager-active';} ?>">
								<?php
									echo $this->Html->image(
										array('controller'=>'thumbs','?'=>array('src'=>'/'.$lista_atual['arquivo'],'size'=>'123*82','crop'=>'123*82', ' style' => 'margin:0 40px')),
										array("alt" => $lista_atual['id'],'width'=>'115','height'=>'82','link-lupa' => $this->Html->url('/'.$lista_atual['arquivo']), 'credito_image' => @$galeria_atual['GaleriaArquivo'][$key]['ImageCredito']['nome'])
									);		
								?>
							</a>
						</div><!-- thumbs-galeria -->
					</li>
				    <?php endforeach; ?> 
				</ul>
			<p class="thumb-prev"><a href="" id="thumb-prev"></a></p>
			<p class="thumb-next"><a href="" id="thumb-next"></a></p>
		</div><!-- vitrine-galeria -->
		<!-- btn para galeria -->
		<a class="btn-mostra-thumb" href="javascript://exibir/ocultar Thumbs">
			<div class="esconde-menu-thumbs"></div>
		</a>
		<!-- btn para galeria -->
	</div><!-- barra-galeria -->
	
	<div class="creditos-galeria-atual">credito: <?php if(!empty($galeria_atual['GaleriaArquivo'][0]['ImageCredito']['nome'])){echo $galeria_atual['GaleriaArquivo'][0]['ImageCredito']['nome'];}else{echo 'crédito não cadastrado';}?></div>
	<div class="clear"></div>
	
	<div class="vitrine-galeria bottom">
		<ul id="slider2-galeria" style="list-style:none;">
		 <?php foreach($galeria_atual['GaleriaArquivo'] as $lista_atual): ?> 
			<li class="<?php echo $lista_atual['id']; ?>">
				<div class="vitrine-galeria-img">
					<!--<a href="<?php // echo $this->Html->url('/'.$lista_atual['arquivo']); ?>" rel="prettyPhoto[galeria]">-->						
						<?php
						 echo $this->Html->image(
							"custom/img-transp.png", 
							array(
								//"alt" => $lista_atual['id'],
								"title" => $lista_atual['titulo'], 
								"width" => "850", 
								"height" => "562", 
								"class" => "loading", 
								'style' => 'margin-top:0px;',
								"url_image_full" => $this->Html->url(array('controller'=>'thumbs','?'=>array('src'=>'/'.$lista_atual['arquivo'],'size'=>'850x562','crop'=>'850*562'))),
								//'link-lupa' => $this->Html->url('/'.$lista_atual['arquivo']),
							)
						);
						?>
						<?php
						/*
							echo $this->Html->image(
								array('controller'=>'thumbs','?'=>array('src'=>'/'.$lista_atual['arquivo'],'size'=>'850*562','crop'=>'850x562',)),
								array("alt" => $lista_atual['id'],'width'=>'850','height'=>'562','style' => 'margin-top:0px;', 'link-lupa' => $this->Html->url('/'.$lista_atual['arquivo']))
							);		
						*/
						?>
					<!--</a>-->
					<div style="position:absolute;bottom:0px;">
						<a href="javascript://exibir/ocultar Título" class="btn-mostra-title">
							<div class="mostra-title-img-galeria verdana f11">
								
							</div>
						</a>
						<?php if(empty($lista_atual['legenda'])){echo '';}else{ ?>
							<div class="legenda-img-ativa" style="color:#000;font-size:14px;">
								<?php echo $lista_atual['legenda']; ?>
							</div><!-- legenda-img-ativa -->
						<?php }//if ?>
					</div>
				</div><!-- vitrine-galeria-img -->
				
			</li>
		<?php endforeach; ?>
		</ul>
	<p class="img-prev-big"><a href="" id="img-prev-big"></a></p>
	<p class="img-next-big"><a href="" id="img-next-big"></a></p>
	</div><!-- vitrine-galeria bottom -->
</div><!-- wrap-galeria -->
<!-- codigo html galeria -->

<!-- js -->
<script type="text/javascript">
$(function(){
  // slider thumb
  var qtd_thumb = 5;
  
  var slider_thumb = $('#slider1-galeria').bxSlider({
  	displaySlideQty: qtd_thumb,
    moveSlideQty: qtd_thumb,
	infiniteLoop: false,
	wrapperClass: 'bx-wrapper',
	controls: false,
	startingSlide: (window.location.hash != '' ? parseInt(window.location.hash.replace('#', '')) - 1 : 0)<?php /*echo ($galeria_indice -1);*/?>
  });
  
  $('#thumb-prev').click(function(){
    slider_thumb.goToPreviousSlide();
	
    return false;
  });

  $('#thumb-next').click(function(){
    slider_thumb.goToNextSlide();
    return false;
  });
  // slider thumb
  
  // slider 
  var slider = $('#slider2-galeria').bxSlider({
    controls: false,
	auto: false,
	pause: 8000,
	autoHover: true,
//	infiniteLoop: false,
	mode: 'fade',
	startingSlide: (window.location.hash != '' ? parseInt(window.location.hash.replace('#', '')) - 1 : 0),<?php /*echo ($galeria_indice -1);*/?>
	//pager: 'true',
	//pagerType: 'short',
	//pagerLocation: 'top'
	//pagerShortSeparator: 'de'
	onBeforeSlide: function(currentSlide, totalSlides){
		//$('.creditos-galeria-atual').html('Credito: ' + $('.thumbs-galeria a.pager-active img').attr("credito_image"));
	    },
	onAfterSlide: function(currentSlide, totalSlides){
	      //$('.identificador-qtd-img').append('<p class="check">Slide index ' + currentSlide + ' of ' + totalSlides + ' total slides has completed.');
		  $('.identificador-qtd-img').html('FOTO ' + (currentSlide+1) + ' DE ' + totalSlides);
		  $('.ampliar-galeria a').attr("href", $('.thumbs-galeria a.pager-active img').attr("link-lupa"));
		  $('.creditos-galeria-atual').html('Crédito: ' + $('.thumbs-galeria a.pager-active img').attr("credito_image"));
		  //alert('www');
		 
		  img = $('#slider2-galeria li:eq(' + currentSlide + ') img.loading');
		 
		  img.attr('src', img.attr('url_image_full').replace(/&amp;/g, "&"));
		  //Atualiza hash no endereço
		  
		  	if(window.location.hash != '' || currentSlide != 0 ){
				window.location.href = '#' + (currentSlide+1);
			}
		    
		  
		  
	    }
	});
	
	if(window.location.hash != ''){
		// assisgn "pager-active" to clicked thumb
		$('.thumbs-galeria:eq(' + (slider.getCurrentSlide() + qtd_thumb) + ') a').addClass('pager-active');
	}
	
	$('#img-prev-big').click(function(){
   	slider.goToPreviousSlide();
//	if((slider_thumb.getCurrentSlide() + (qtd_thumb-1)) < slider.getCurrentSlide()){
		slider_thumb.goToSlide(slider.getCurrentSlide());
//    }
    
	$('.thumbs-galeria a').removeClass('pager-active');
	// assisgn "pager-active" to clicked thumb
	$('.thumbs-galeria:eq(' + (slider.getCurrentSlide() + qtd_thumb) + ') a').addClass('pager-active');
	return false;
  });

  $('#img-next-big').click(function(){
    slider.goToNextSlide();
//	if((slider_thumb.getCurrentSlide() + (qtd_thumb-1)) < slider.getCurrentSlide()){
		slider_thumb.goToSlide(slider.getCurrentSlide());
//    }
    
	$('.thumbs-galeria a').removeClass('pager-active');
    // assisgn "pager-active" to clicked thumb
	$('.thumbs-galeria:eq(' + (slider.getCurrentSlide() + qtd_thumb) + ') a').addClass('pager-active');
	
	return false;
  });
  // slider 
  
  // assign a click event to the external thumbnails
  $('.thumbs-galeria a').click(function(){
   var thumbIndex = $('.thumbs-galeria a').index(this);
  
    // call the "goToSlide" public function
    slider.goToSlide(thumbIndex-qtd_thumb);

    // remove all active classes
    $('.thumbs-galeria a').removeClass('pager-active');
    // assisgn "pager-active" to clicked thumb
    $(this).addClass('pager-active');
    // very important! you must kill the links default behavior
    return false;
  });

  // assign "pager-active" class to the first thumb
  $('.thumbs-galeria a:eq(1)').addClass('pager-active');
  
  // Oculta e exibe o titulo do album
	$(".btn-mostra-thumb").click(function() {
		$('div.vitrine-galeria.top').slideToggle()
	});
  
  
  // Oculta e exibe a descrição da foto
	jQuery(".btn-mostra-title").click(function() {
		jQuery('.legenda-img-ativa').slideToggle()
	});
	
  
  $('.vitrine-galeria.bottom > .bx-wrapper .bx-window').css('width','850');	
  
});

  
</script>
<!-- js -->