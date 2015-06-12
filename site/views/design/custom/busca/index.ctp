<?php
//$paginator->options(array('url' => $this->passedArgs));
if(empty($isAjax)):
?>
<div class="container">
	<div class="lista blog">
	<h2>Resultados encontrados em Roteiros</h2>
	<?php
	#echo '<pre>';
	#print_r($resultado_busca);
	#die();
	foreach ($resultado_busca AS $key => $buscad):
		?>
		<article class="row">
			<a class="link-overlay" title="<?php echo $buscad['Roteiro']['nome']; ?>" href="<?php echo $this->Html->url('/destinos/'.$buscad['Roteiro']['fullpath'].'/roteiros/'.$buscad['Roteiro']['friendly_url']); ?>">
			</a>
			<div class="span5 image">
			<?php
				echo $this->Image->thumbImage(
					array(
						'src' 	=> $buscad['Roteiro']['imagem_lista'],
						'size'	=> '480*280',
						'crop'	=> '480*280',
					),
					array("alt" => 'Foto: ' . $buscad['Roteiro']['nome'],)
				);
			?>
			</div>
			<div class="span7 description">
				<div class="roteiro-item-header">
					<div class="roteiro-nome"><?php echo $buscad['Roteiro']['nome']; ?></div>
					<?php if(!empty($buscad['Roteiro']['qtd_dias'])):?><div class="roteiro-duracao"><?php echo $buscad['Roteiro']['qtd_dias']; ?></div><?php endif; ?>
					<?php if(!empty($buscad['Roteiro']['onde_comeca']) || !empty($buscad['Roteiro']['onde_termina'])):?>
						<div class="onde-comeca-termina">
							<span>Começa em: <?php 
								if(!empty($buscad['Roteiro']['onde_comeca'])) {
									echo $buscad['Roteiro']['onde_comeca'];
								} else {
									echo '--';
								}
							?> </span>
							&nbsp;&nbsp;
							<span>Termina em: <?php
								if(!empty($buscad['Roteiro']['onde_termina'])) {
									echo $buscad['Roteiro']['onde_termina'];
								}else{
									echo '--';
								} 
							?> </span>
						</div>
					<?php endif; ?>
					<div class="roteiro-descricao"><?php echo $buscad['Roteiro']['resumo'];?></div>
				</div>
				<div class="valor-a-partir"><?php if(!empty($buscad['Roteiro']['preco_a_partir'])):?>a partir de <span class="price"><?php echo $buscad['Roteiro']['preco_a_partir'];?></span><?php endif;?></div>
				<span class="btn-saiba-mais">saiba mais</span>
			</div>
		</article>
		<hr />
	<?php endforeach; ?>

	<h2>Resultados encontrados em Destinos</h2>
	<?php
	foreach ($resultado_busca_destinos AS $key => $busca_destino):
	?>
		<article class="row">
			<a class="link-overlay" title="<?php echo $busca_destino['Destino']['nome']; ?>" href="<?php echo $this->Html->url('/destinos/'.$busca_destino['Destino']['fullpath']);?>">
			</a>
			<div class="span5 image">
			<?php
				echo $this->Image->thumbImage(
					array(
						'src' 	=> $busca_destino['Destino']['imagem_capa'],
						'size'	=> '480*280',
						'crop'	=> '480*280',
					),
					array("alt" => 'Foto: ' . $busca_destino['Destino']['nome'],)
				);
			?>
			</div>
			<div class="span7 description">
				<div class="roteiro-item-header">
					<div class="roteiro-nome"><?php echo $busca_destino['Destino']['nome']; ?></div>
					<div class="roteiro-descricao"><?php echo $busca_destino['Destino']['resumo'];?></div>
				</div>
				<span class="btn-saiba-mais">saiba mais</span>
			</div>
		</article>
		<hr />
	<?php endforeach; ?>
	</div>
	<?php /*if(!empty($busca)): ?>
	<br /><br />
	<div class="text-align-center"><?php echo $this->Element('paginacao/paginacao'); ?></div>
	<br /><br />
	<?php endif; */?>

</div>

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
endif; //Só executa quando não é ajax