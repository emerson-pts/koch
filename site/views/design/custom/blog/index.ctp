<?php
// variavel
//$noticias

//Faz com que os endereços de página e ordenação gerados pelo paginator incluam as variáveis submetidas na url
$paginator->options(array('url' => $this->passedArgs));

//Só executa quando não é ajax
if(empty($isAjax)):
	?>
	<!-- topo da notícia -->
	<?php	
	//Se não tem notícias
	if(empty($noticias)){
		echo '<div class="message_error">Nenhum conteúdo foi encontrado.</div>';
		$noticias_lista = $noticias;
	}else{
		//Destaques
		$noticias_destaque = array_slice($noticias, 0, 2);
		$noticias_lista = array_slice($noticias, 2);
		foreach ($noticias_destaque AS $key => $noticia):
			/*
			echo $noticia['Noticia']['titulo'];
			echo $noticia['Noticia']['image'];
			echo $noticia['Noticia']['olho'];
			echo $noticia['Noticia']['link'];
			*/
		endforeach;//fim destaques
		if(!empty($noticias_lista)){
		?>
		<!-- Notícia em destaque --><!-- Lista de notícias -->
		<?php 
		/*
			switch($this->params['action']){
				case 'piloto':
					echo 'Outras '.Inflector::pluralize($noticia_tipos[$noticia_tipo]).' do '.$piloto['Piloto']['apelido'];
					break;
				default:
					echo 'Outras ' . Inflector::pluralize($noticia_tipos[$noticia_tipo]);
				break;
			}
		*/
		?>
	<?php
		}
	}
else:
	//Se é ajax..
	$noticias_lista = $noticias;
endif;//fim Só executa quando não é ajax

foreach ($noticias_lista AS $key => $noticia){
	if(!isset($data_atual) || $data_atual != $noticia['Noticia']['data_noticia_data']){
		if(isset($data_atual)) echo '</ul></div>';
		$data_atual = $noticia['Noticia']['data_noticia_data'];
		echo '
		<div class="noticia-lista-item"> 
			<div class="noticia-lista-data">'.$noticia['Noticia']['data_noticia_data'].'</div>
			<ul data="'.$data_atual.'">'
		;
	}
	echo '<li>'.$this->Html->link($noticia['Noticia']['data_noticia_hora'], $noticia['Noticia']['link']).' - ';
	echo $this->Html->link($noticia['Noticia']['titulo'], $noticia['Noticia']['link']).'</li>';
}
if(!empty($noticias_lista))echo '</ul></div>';
//Só executa quando não é ajax
if(empty($isAjax)):
	if(!empty($noticias_lista))echo '</div>';
?>
<a name="paging_more"></a>
<div class="paging_footer"><?php echo $this->Element('paginacao/paginacao');?></div>
<script type="text/javascript">
$(document).ready(function(event){
	if($('span.paging_current').html() != $('span.paging_total').html()){
		$('div.paging_counter').prepend('<a href="#paging_more" class="paging_more noticia-lista-mais" current_page="1"><span>mais</span></a>');
		$('a.paging_more')
			.click(function(event){
				$(this).addClass('active');
				var offset = $(this).offset();
				setTimeout(function(){$('html, body').animate({scrollTop:(parseInt(offset.top) - 100)});}, 400);
				var current_page = parseInt($(this).attr('current_page')) + 1;
				$('div.noticia-lista').append('<div class="loading">&nbsp;</div>');
				$(this).attr('current_page', current_page);
				$.ajax({
					method: 'get',
					cache: false,
					url : window.location.pathname.replace(/\/page:[0-9]+/, '') + '/page:' + current_page,
					context: $(this),
					dataType : 'text',
					success: function (data) { 
						$('div.noticia-lista div.loading').replaceWith(data);
						$(this).removeClass('active');
						$('span.paging_current').html($('div.noticias-box, div.noticia-lista-item li').size());
						if($('span.paging_current').html() == $('span.paging_total').html()){
							$(this).fadeOut();
						}
					},
					error: function(){
						alert('Não foi possível atualizar a lista');
					}
				 });
				 event.stopPropagation();
				 event.preventDefault();
				 return false;
			})
		;
	}
	$('div.paging_header, span.paging_showing, div.paging').remove();
});
</script>
<?php
endif;//Só executa quando não é ajax