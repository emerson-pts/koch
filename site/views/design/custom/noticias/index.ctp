<?php
//Faz com que os endereços de página e ordenação gerados pelo paginator incluam as variáveis submetidas na url
$paginator->options(array('url' => $this->passedArgs));

//Só executa quando não é ajax
if(empty($isAjax)): ?>
	<div id="title-bar" class="nopadding">
		<div class="container">
			<div class="row-fluid">

				<div class="span12">
					<div class="img-modalidade" style="height: 270px; overflow:hidden; ">
						<?php
							echo $this->Image->thumbImage(
								array(
									'src' 	=> $pagina_noticia['Pagina']['image'],
									'size'	=> '1180*270',
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

	<br />

	<div class="container noticias">

		<div class="row-fluid">
			<div class="span6">

				<div class="styled-select eventos">
					<select name="select_evento">
						<option value="">Busque pelo evento</option>
						<? foreach ($categorias AS $key => $categoria): ?>
							<option value="<?php echo $categoria['Categoria']['friendly_url']?>">
								<?php echo $categoria['Categoria']['nome']?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>

			</div>
			<div class="span6">
			<?php
			echo ' <form method="get" action="'.$this->Html->url('/noticias').'">';

				echo $this->Form->input("busca",array(
					"maxlength" => "100",
					"placeholder" => "Realize sua busca por palavra chave",
					"label" => false,
					'name' => 'busca'
				));

			echo ' </form>';

			?>
			</div>
		</div><!-- .row-fluid -->

		<div class="row-fluid">
			<?php
			//chama o filtro de noticias
			echo $this->Element('noticias/filtro_ultimas');
			?>
		</div>

		<?php
 
	//Se não tem notícias
	if(empty($noticias)):
		echo $this->Html->div('message_error',__('Nenhum conteúdo foi encontrado.', true));
		$noticias_lista = $noticias;
	else:
		//Destaques
		//$noticia_destaque = array_slice($noticias, 0, 1);
		//$noticias_lista = array_slice($noticias, 1);
		#print_r($this->params['originalArgs']['passedArgs']);
		#if(empty($this->params['originalArgs']['passedArgs'])) {
		?>
		<div class="row-fluid">
			<?php
			foreach ($noticias_destaque AS $key => $noticia) { //Link na imagem ?>

			<div class="span12">

				<?php
					//DATA
					echo $this->Html->tag('span', $noticia['Noticia']['data_noticia_dia'].'/'.$noticia['Noticia']['data_noticia_mes'].'/'.$noticia['Noticia']['data_noticia_ano']);

					echo $this->Image->thumbImage(
						array(
							'src' 	=> $noticia['Noticia']['image_chamada'],
							'size'=>'1180x269',
							'crop'	=> '1180x269',
						),
						array('class' => 'img-noticia', 'alt'=>$noticia['Noticia']['titulo'],'url'=>$noticia['Noticia']['link'], )
					);
					//echo $this->Html->tag('br','');
					
					//TITULO
					
					echo $this->Html->tag('strong', $noticia['Noticia']['titulo']);

					//PREVIEW
					echo $this->Html->tag('p',$noticia['Noticia']['conteudo_preview']);

				?>
			</div>
				<?php
				
			}
		?>
		</div> <!-- .row-fluid -->
	<?php
		#}
		
	endif;
else:
	//Se é ajax..
	$noticias_lista = $noticias;
	
endif;//fim Só executa quando não é ajax

//Se não é ajax, monta cabeçalho
if(empty($isAjax)) { ?>

	<div class="row noticias">
		<div class="noticia-outras">
		<?php
	}
		$i=1;
		foreach ($noticias AS $key => $noticia) { ?>

			<div class="span4">

				<span><?php echo $noticia['Noticia']['data_noticia_data']; ?></span>
				<?php
				echo $this->Image->thumbImage(
						array(
							'src' 	=> $noticia['Noticia']['image'],
							'size'	=> '389*228',
							'crop'	=> '389*228',
						),
						array('class' => 'img-noticia', 'alt'=>$noticia['Noticia']['titulo'],'url'=>$noticia['Noticia']['link'], )
					);
				?>
				<br />
				<div class="title"><strong><?php echo $noticia['Noticia']['titulo']; ?></strong></div>
				<p>
				<?php
				if(!empty($noticia['Noticia']['conteudo_preview'])):
					echo substr($noticia['Noticia']['conteudo_preview'],0,100).'...';
				endif;
				?>
				</p>

			</div>
			<a class="noticia_count"></a>

			<?php
			$i++;
		}

//NÃO É AJAX
if(empty($isAjax)) { ?>

	</div> <!-- .noticias-outras -->

	</div> <!-- .row-fluid -->

	<?php ?>
	<div class="paging_footer"><?php echo $this->Element('paginacao');?></div>

	<div class="container">
		<div class="row-fluid">
			<hr />
		</div>
	</div>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function(event){
		if($('span.paging_current').html() != $('span.paging_total').html()){
			$('div.paging_counter').prepend('<a href="#maisNoticias" class="mais-noticias" current_page="1"></a>');
			$('a.mais-noticias')
				.click(function(event){
					$(this).blur();
					//$(this).addClass('active');
					var offset = $(this).offset();
					setTimeout(function(){$('html, body').animate({scrollTop:(parseInt(offset.top) - 100)});}, 400);
					var current_page = parseInt($(this).attr('current_page')) + 1;
					$('div.noticia-outras').append('<div class="loading">&nbsp;</div>');
					$(this).attr('current_page', current_page);
					$.ajax({
						method: 'get',
						cache: false,
						url : window.location.pathname.replace(/\/page:[0-9]+/, '') + '/page:' + current_page,
						context: $(this),
						dataType : 'text',
						success: function (data) { 
							$('div.noticia-outras div.loading').replaceWith(data);
							//$(this).removeClass('active');
//							$('span.paging_current').html($('div.noticias-outras a.noticia_count').size()+6);
							$('span.paging_current').html($('a.noticia_count').size());
							if($('span.paging_current').html() == $('span.paging_total').html()){
								$(this).fadeOut();
							}
						},
						error: function(){
							alert('<?php echo __('Não foi possível atualizar a lista');?>');
						}
					 });
					 event.stopPropagation();
					 event.preventDefault();
					 return false;
				})
			;
		}

		$('div.paging_header, span.paging_showing, div.paging').remove();

		$('select[name="select_evento"]').change(function(){
			location.href = "<?php echo $this->Html->url('/noticias/categoria/'); ?>"+$(this).val();

			// location.href='<?php echo $this->Html->url(array('controller'=>!empty($menu_ativo[0]['Sitemap']['friendly_url'])?$menu_ativo[0]['Sitemap']['friendly_url']:$this->params['controller']));?>/'+$(this).val();
		});

	});
	</script>	
	</div>
	<?php //.container.noticias
}//NÃO É AJAX
?>