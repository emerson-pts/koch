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
		<?php echo $this->Element('noticias/filtro_ultimas'); ?>
	</div>

	<div class="row-fluid">
		<div class="span4">

			<?php
				echo $this->Image->thumbImage(
					array(
						'src' 	=> $noticia['Noticia']['image_chamada'],
						'size'	=> '389*228',
						//'crop'	=> '100*182',
					),
					array('class' => 'img-noticia', 'alt'=>$noticia['Noticia']['titulo'], )
				);
			?>
		</div>

		<div class="span8">

			<span><?php echo $noticia['Noticia']['data_noticia_data']; ?></span>

			<h2><?php echo $noticia['Noticia']['titulo']; ?></h2>
			<p><?php echo $noticia['Noticia']['conteudo']; ?></p>

		</div>

	</div>

</div><?php //.container ?>

<div class="clear"></div>

<div class="container">
	<div class="row-fluid">
		<hr />
	</div>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function() {

		

	});
</script>