<!-- <div id="title-bar">
	<div class="container modalidade">
		<div class="row-fluid">
			<div class="span12">
				<div class="img-modalidade" style="height: 200px; overflow:hidden; ">
					<?php
						echo $this->Html->link(
							$this->Html->image('custom/topo_noticias.jpg', array( 'alt' => '')),
							'/',
							array('escape' => false, 'class' => '')
						);
					?>
				</div>
			</div>
		</div>
	</div>
</div> -->

<div id="title-bar">
	<div class="container">
		<div class="row-fluid">
			<div class="span6">
				<h1>Notícias</h1>
				<strong><span>koch</span>tavares</strong>
			</div>
			<div class="span5">
				<p>
					<?php echo Configure::read('texto.pagina.noticias'); ?>
				</p>
			</div>
		</div>
	</div>
</div>

<br />

<?php
//Faz com que os endereços de página e ordenação gerados pelo paginator incluam as variáveis submetidas na url
$paginator->options(array('url' => $this->passedArgs));

//Só executa quando não é ajax
//if(empty($isAjax)): ?>
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
		echo ' <form method="get" action="'.$this->Html->url(isset($this->params['originalArgs']['params']['url']['url']) ? '/'.$this->params['originalArgs']['params']['url']['url'] : null).'">';
		//echo $this->Form->create('FormNoticia', array('method'=>'get', 'name'=>'noticia','url' => (isset($this->params['originalArgs']['params']['url']['url']) ? '/'.$this->params['originalArgs']['params']['url']['url'] : null)));

			echo $this->Form->input("busca",array(
				"maxlength" => "100",
				"placeholder" => "Realize sua busca por palavra chave",
				"label" => false,
				'name' => 'busca'
			));

		echo ' </form>';


		?>
		</div>
	</div>

	<div class="row-fluid">
		<?php
		//chama o filtro de noticias
		echo $this->Element('noticias/filtro_ultimas');
		?>
	</div>

	<div class="row-fluid">

    	<?php
		//Se não tem notícias
		if(empty($noticias)): ?>
		<?php
			echo $this->Html->div('message_error',__('Nenhum conteúdo foi encontrado.', true));
			$noticias_lista = $noticias;
		else: ?>

		<div class="span12">

			<?php
			//Destaques
			$noticias_destaque = array_slice($noticias, 0, 1);
			$noticias_lista = array_slice($noticias, 1, 3);

			//DESTAQUE 1
			foreach ($noticias_destaque AS $key => $noticia): ?>

				<?php
					echo $this->Image->thumbImage(
						array(
							'src' 	=> $noticia['Noticia']['image'],
							'size'=>'1180x269'
							//'crop'	=> '100*182',
						),
						array('class' => 'img-noticia', 'alt'=>$noticia['Noticia']['titulo'],'url'=>$noticia['Noticia']['link'], )
					);
				?>
				<br />
				<strong><?php echo $noticia['Noticia']['titulo']; ?></strong>
				<p>
				<?php
					echo $noticia['Noticia']['conteudo_preview'];
				?>
				</p>
			<?php endforeach; 
		endif; ?>
		</div>

	</div>

	<br />

	<div class="row-fluid">
		<?php
		if(!empty($noticias_lista)):

			foreach ($noticias_lista AS $key => $noticia): ?>

				<div class="span4">

					<span><?php echo $noticia['Noticia']['data_noticia_data']; ?></span>
					<?php
					echo $this->Image->thumbImage(
							array(
								'src' 	=> $noticia['Noticia']['image_chamada'],
								'size'	=> '389*228',
								//'crop'	=> '389*228',
							),
							array('class' => 'img-noticia', 'alt'=>$noticia['Noticia']['titulo'],'url'=>$noticia['Noticia']['link'], )
						);
					?>
					<br />
					<strong><?php echo $noticia['Noticia']['titulo']; ?></strong>
					<p>
					<?php
						echo $noticia['Noticia']['conteudo_preview'];
					?>
					</p>

				</div>

			<?php
			endforeach;

		endif;

		/*
			endif;
		else:
			//Se é ajax..
			$noticias_lista = $noticias;
		endif;//fim Só executa quando não é ajax

		//Se não é ajax, monta cabeçalho
		if(empty($isAjax)) {
			echo $this->Html->div('clear',false);
			?>

			<div class="not-ultimas">

			<?php
		}

			if(!empty($noticias_lista)) {

				foreach ($noticias_lista AS $key => $noticia) {

					echo $this->Html->div('divisor',false);

					//TITULO
					echo $this->Html->tag('h3',$noticia['Noticia']['titulo']); 

					//Preview
					echo $this->Html->link(
						$this->Text->truncate(
							(!empty($noticia['Noticia']['conteudo_preview']) ? $noticia['Noticia']['conteudo_preview'] : $noticia['Noticia']['conteudo']),
							438,
							array('ending' => '...','exact' => false,'html'=>false)
						).
						$this->Html->tag('span',
							' (Veja mais)',
							array('escape'=>false,'class'=>'mais')
						),
						$noticia['Noticia']['link'],
						array('style'=>'margin-top:5px;display:block','class'=>'noticia_count txt_padrao','escape'=>false)
					);
				}
			} */
		?>

	</div>

</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function() {

		$('select[name="select_evento"]').change(function(){
			location.href = "<?php echo $this->Html->url('/noticias/categoria/'); ?>"+$(this).val();

			// location.href='<?php echo $this->Html->url(array('controller'=>!empty($menu_ativo[0]['Sitemap']['friendly_url'])?$menu_ativo[0]['Sitemap']['friendly_url']:$this->params['controller']));?>/'+$(this).val();
		});

	});
</script>

<?php
/*
//NÃO É AJAX
if(empty($isAjax)){

	?></div><?php //.not-ultimas
	
	?><div class="paging_footer"><?php echo $this->Element('paginacao');?></div>
	<script type="text/javascript">
	$(document).ready(function(event){
		if($('span.paging_current').html() != $('span.paging_total').html()){
			//insere o botão de mais noticias
			$('div.paging_counter').prepend('<a href="#maisNoticias" class="mais-noticias" current_page="1">Veja mais not&iacute;cias <big>&raquo;</big> </a>');
			$('a.mais-noticias')
				.click(function(event){
					$(this).blur();
					//$(this).addClass('active');
					var offset = $(this).offset();
					setTimeout(function(){$('html, body').animate({scrollTop:(parseInt(offset.top) - 100)});}, 400);
					var current_page = parseInt($(this).attr('current_page')) + 1;
					$('div.not-ultimas').append('<div class="loading">&nbsp;</div>');
					$(this).attr('current_page', current_page);
					$.ajax({
						method: 'get',
						cache: false,
						url : window.location.pathname.replace(/\/page:[0-9]+/, '') + '/page:' + current_page,
						context: $(this),
						dataType : 'text',
						success: function (data) { 
							$('div.not-ultimas div.loading').replaceWith(data);
							//$(this).removeClass('active');
							$('span.paging_current').html($('a.noticia_count').size());
							if($('span.paging_current').html() >= $('span.paging_total').html()){
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
		
		
		/*$( "#search" ).autocomplete({
			source: "search.php",
			minLength: 2,
			select: function( event, ui ) {
				log( ui.item ?
					"Selected: " + ui.item.value + " aka " + ui.item.id :
					"Nothing selected, input was " + this.value );
			}
		});
		
		
			
	});
	</script>
<?php
	
}//NÃO É AJAX */
?>
