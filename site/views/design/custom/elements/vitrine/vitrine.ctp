<?php
$vitrines_count = count($vitrines);

//Se não tem vitrines...
if($vitrines_count == 0) {
	return;
}

?>
<div id="vitrine" class="carousel slide">
	<?php if($vitrines_count > 1 ): ?>
		<ol class="carousel-indicators">
			<?php for ($i = 0; $i < $vitrines_count; $i++ ): ?>
				<li data-target="#vitrine" data-slide-to="<?php echo $i;?>" <?php if($i == 0):?>class="active"<?php endif;?>></li>
			<?php endfor; ?>
		</ol>
	<?php endif; ?>
	<!-- Carousel items -->
	<div class="carousel-inner">
		<?php foreach($vitrines as $key => $vitrine): ?>
			<div 
				class="<?php if($key == 0){ echo 'active';}?> item"
				style="background: url(<?php 
					if(!$mobile) {
						$crop = '1180x340';
					}
					else{
						$crop = '1024x1024';
					}

					$crop_pos = 'center center';

					$thumb = $this->Image->thumb(array('src' => $vitrine['Vitrine']['imagem'], 'size' => '1180*340', 'crop_pos' => $crop_pos, 'crop' => $crop));
					echo $this->Html->url($thumb['url']);
				?>) center <?php echo (empty($vitrine['Vitrine']['imagem_align']) ? 'center' : $vitrine['Vitrine']['imagem_align']);?> no-repeat;"
			><?php if(!empty($vitrine['Vitrine']['url'])):?><a href="<?php echo $vitrine['Vitrine']['url']; ?>" title="<?php echo htmlspecialchars($vitrine['Vitrine']['titulo']);?>"><?php endif; ?>
				<?php if(!empty($vitrine['Vitrine']['chamada'])): ?>
					<?php if($vitrine['Vitrine']['chamada_position'] != 'center-center'):?><div class="container height-full position-relative"><?php endif; ?>
						<div class="carousel-caption align-<?php echo $vitrine['Vitrine']['chamada_position'];?>">
							<?php
								//Replace pois no CKEDITOR dois espaços são representados por "&nbsp; " e em resoluções pequenas pode ocorrer quebras de linha adicionais
								#echo str_replace('&nbsp; ', '&nbsp;&nbsp;', $vitrine['Vitrine']['chamada']); 
							?>
						</div>
					<?php if($vitrine['Vitrine']['chamada_position'] != 'center-center'):?></div><?php endif; ?>
				<?php endif; ?>
				<?php if(!empty($vitrine['Vitrine']['url'])):?></a><?php endif; ?>
			</div>
		<?php endforeach; ?>	
	</div>
	<?php if($vitrines_count > 1 ): ?>
		<!-- Carousel nav -->
		<a class="carousel-control left" href="#vitrine" data-slide="prev"><span>&lsaquo;</span></a>
		<a class="carousel-control right" href="#vitrine" data-slide="next"><span>&rsaquo;</span></a>
	<?php endif; ?>
</div>
<?php /*
$this->viewVars['scripts_for_layout_footer'] .= 
	$this->Html->script('jquery.touchwipe.min').
	'<script>
		$navbar = jQuery("div.navbar");
		$btnNavbar = $navbar.find("a.btn-navbar");
		$vitrine = jQuery("#vitrine");
		$vitrineItem = jQuery("#vitrine .item");
		$vitrineItemCaptionCenter = jQuery("#vitrine .item .carousel-caption.align-center-center");

		//Se tem títulos centralizados
		if($vitrineItemCaptionCenter.size() > 0){
			$vitrine
				.on("slid", function(){
					//Para cada título...
					$vitrineItem.filter(".active").find(".carousel-caption.align-center-center").each(function(){
						jQuery(this).css({
							"margin-top": -(parseInt(jQuery(this).height()/2)),
							"margin-left": -(parseInt(jQuery(this).width()/2)),
							"top": "50%",
							"left": "50%"
						});
					});
				})
				.touchwipe({
					 wipeLeft: function() { $vitrine.carousel("next");  },
					 wipeRight: function() { $vitrine.carousel("prev");  },
					 min_move_x: 20,
					 min_move_y: 20,
					 preventDefaultEvents: false
				})
			;
		}
				
		//Debouncer, faz o resize ser disparado somente ao final do redimensionamento
		jQuery( window ).resize( debouncer( function ( e ) {
		    // do stuff
		    
		    //Continua somente se mudou a dimensão
		    //Se for android verifica somente a largura, pois o android altera a altura da janela durante o scroll
		    widthXheight = jQuery(window).width() + (navigator.userAgent.toLowerCase().indexOf("android") != -1 ? "" : "x" + jQuery(window).height());
		    if(widthXheight == jQuery("body").attr("widthXheight")){
		    	return;
		    }
		    jQuery("body").attr("widthXheight", widthXheight);

			//Ajusta altura da vitrine para ocupar toda a tela	
			vitrineItemHeight = jQuery(window).height() - ($navbar.css("position") == "static" ? $navbar.outerHeight() : parseInt(jQuery("body").css("margin-top")));
			if(vitrineItemHeight < 350){
				vitrineItemHeight = 350;
			}
			$vitrineItem.height(vitrineItemHeight);
			
			//Se o menu mobile está aberto...
			if(!$btnNavbar.hasClass("collapsed")){
				//Recolhe o menu, caso contrário dá problema ao retornar da versão desktop para mobile
				$btnNavbar.trigger("click");
			}
		} ) );

		jQuery(document).ready(function(){
			jQuery(window).trigger("resize");
			
			//Clique para descer para o conteúdo
			jQuery("a.carousel-scroll").on("click", function(event){
				event.preventDefault();
				scrollPos = jQuery("#vitrine").outerHeight();
				
				if($navbar.css("position") == "static"){
					scrollPos += jQuery("#vitrine").offset().top;
				}
				
				//Tempo da animação é proporcional ao scroll que deve ser dado
				jQuery("html, body").animate({
					scrollTop: scrollPos
				}, parseInt((1 - (window.pageYOffset/scrollPos)) * 1000));
			});
		});
		
	</script>
';
*/