<?php
//Se nenhum texto foi informado para a imagem de capa, utiliza o nome do roteiro
if(empty($roteiro['Roteiro']['imagem_capa_txt'])){
	$roteiro['Roteiro']['imagem_capa_txt'] = $roteiro['Roteiro']['nome'].'<br />'.$roteiro['Roteiro']['qtd_dias'];
}
 
//IMAGEM DE CAPA
?>
<div 
	class="img-capa roteiro"
	style="background: #ffe7d2 url(<?php 
					if(!$mobile){
						$crop = false;
					}
					else{
						$crop = '1024x1024';
					}
					
					$crop_pos = 'center '.(empty($roteiro['Roteiro']['imagem_capa_align']) ? 'center' : $roteiro['Roteiro']['imagem_capa_align']);
					
					$thumb = $this->Image->thumb(array('src' => $roteiro['Roteiro']['imagem_capa'], 'size' => '1600x940', 'crop_pos' => $crop_pos, 'crop' => $crop, 'output' => 'jpg', 'jpg_quality' => 70));
					echo $this->Html->url($thumb['url']);
				?>) center <?php echo (empty($roteiro['Roteiro']['imagem_capa_align']) ? 'center' : $roteiro['Roteiro']['imagem_capa_align']);?> no-repeat;"
>
	<div class="container seal-container"><div class="sprite seal">a partir de<br /><?php echo $this->Formatacao->priceTags($roteiro['Roteiro']['preco_a_partir']);?></div></div>
	<div class="caption">
		<?php
			//Replace pois no CKEDITOR dois espaços são representados por "&nbsp; " e em resoluções pequenas pode ocorrer quebras de linha adicionais
			#echo str_replace('&nbsp; ', '&nbsp;&nbsp;', $roteiro['Roteiro']['imagem_capa_txt']); 
		?>
	</div>
	<a class="btn-scroll" href="#roteiro">&darr;</a>
</div>
<?php
//Ajuste da posição do título e scroll
$this->viewVars['scripts_for_layout_footer'] .= 
	'<script>
		$navbar = jQuery("div.navbar");
		$imgCapa = jQuery(".destinos .img-capa");
		$imgCapaCaptionCenter = $imgCapa.find(".caption");
		$titleBar = jQuery("#title-bar");
		$imgCapaBtnScroll = $imgCapa.find("a.btn-scroll")
		$imgSeal = $imgCapa.find(".seal");
		$destinoTabs = jQuery(".destino-tabs");
		$container = jQuery("div.container:first");
		
		function adjustCaption(){
			$imgCapaCaptionCenter.each(function(){
				scale = Number(jQuery(this).css("transform").replace(/^matrix\(([0-9\.]+),.*$/, "$1"));
				if(isNaN(scale)){
					scale = 1;
				}

				marginTop = parseInt(
					(
						$imgCapa.height() 
						- (
							$imgCapaBtnScroll.is(":visible")
							?
							$imgCapaBtnScroll.height() + parseInt($imgCapaBtnScroll.css("bottom"))
							:
							-parseInt($destinoTabs.css("margin-top")) //Se o scroll estiver oculto, considera altura do tab
						)
						- (jQuery(this).height()*scale)
					)/2
				);
				
				scale = Number($imgSeal.css("transform").replace(/^matrix\(([0-9\.]+),.*$/, "$1"));
				if(isNaN(scale)){
					scale = 1;
				}
				
				maxWidth = $container.width() - ($imgSeal.width()*scale) - 20;
				
				//Escala o maxWidth
				if(scale != 1){
					maxWidth = maxWidth*(1/scale);
				}
				
				marginLeft = -(parseInt(jQuery(this).width()/2)) - ($imgSeal.width()*scale)/2;

				if(marginTop > 0){
					jQuery(this).css({
						"margin-top": marginTop,
						"margin-left": marginLeft,
						"top": 0,
						"left": "50%",
						"max-width": maxWidth
					});
				}
				else{
					jQuery(this).css({
						"margin-top": 0,
						"margin-left": marginLeft,
						"top": 0,
						"left": "50%",
						"max-width": maxWidth
					});
				}
			});
		}
		
		jQuery(window).resize(function(){
			//Ajusta altura da imagem de capa para ocupar toda a tela	
			imgCapaHeight = jQuery(window).height() - $titleBar.outerHeight() - ($navbar.css("position") == "static" ? $navbar.outerHeight() : parseInt(jQuery("body").css("margin-top")));
			if(imgCapaHeight < 350){
				imgCapaHeight = 350;
			}

			$imgCapa.height(imgCapaHeight);
			adjustCaption();//Precisa ser executado duas vezes por conta do ajuste na largura
			adjustCaption();//Precisa ser executado duas vezes por conta do ajuste na largura
		});

		jQuery(document).ready(function(){
			jQuery(window).trigger("resize");
			
			//Clique para descer para o conteúdo
			$imgCapaBtnScroll.on("click", function(event){
				event.preventDefault();
				scrollPos = $destinoTabs.offset().top;
				if($navbar.css("position") == "fixed"){
					scrollPos -= $navbar.height() + 10
				}
				//Se está em aba posicionada para cima				
				else if(parseInt($destinoTabs.css("margin-top")) != 0){
					scrollPos -= 10;
				}

				if(scrollPos > jQuery(document).scrollTop()){
					
					//Tempo da animação é proporcional ao scroll que deve ser dado
					jQuery("html, body").animate({
						scrollTop: scrollPos
					}, parseInt((1 - (window.pageYOffset/scrollPos)) * 1000));
				}
			});
			
			$destinoTabs.find(".nav-tabs li a").on("shown, click", function(){
				$imgCapaBtnScroll.trigger("click");
				return true;
				
			});
		});
	</script>
';


$tabs = array(
	'geral'	=> 'Geral',
	'roteiro'	=> 'Roteiro',
	'servicos'	=> 'Serviços',
	'precos'	=> 'Preços',
	'documentos' => 'Doc<span>umento</span>s',
	'pre-reserva' => 'Pré-reserva',
	'observacoes' => 'Observações',
);
	
$activeTab = 'geral';
?>
<div class="container destino-tabs">
	<ul class="nav nav-tabs">
		<?php foreach( $tabs AS $key => $value) : ?>
			<li class="<?php echo $key;?><?php if($key == $activeTab):?> active<?php endif; ?>"><a href="#<?php echo $key;?>" data-toggle="tab"><?php echo $value; ?></a></li>
		<?php endforeach; ?>
	</ul>
</div>
<div class="container clearfix">
	<div class="tab-content">
		<?php foreach( $tabs AS $key => $value) : ?>
			<h2 class="hidden"><?php echo $value; ?></h2>
			<div class="tab-pane <?php if($key == $activeTab){ echo 'active'; } ?>" id="<?php echo $key;?>"><?php echo $this->Element('roteiros/_'.$key);?></div>
		<?php endforeach; ?>
	</div>
</div>