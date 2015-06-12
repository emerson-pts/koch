<?php
// echo '<pre>';
//print_r($texto);

if($texto['Texto']['tipo'] == 'area') {
?>

<div id="title-bar">
	<div class="container">
		<div class="row-fluid">
			<div class="span6">
				<h1><?php echo $texto['Area']['titulo']; ?></h1>
			</div>
			<div class="span6">
				<div class="div"></div>
				<p>
					<?php echo $texto['Area']['conteudo_preview']; ?>
				</p>
			</div>
		</div>
	</div>
</div>

<? } 
else if($texto['Texto']['tipo'] == 'modalidade') { ?>

<div id="title-bar" class="modalidade no-padding">
	<div class="container">
		<div class="row-fluid">
			<div class="span6">
				<?php
					echo $this->Image->thumbImage(
						array(
							'src' 	=> $texto['Modalidade']['image_icone'],
							'size'	=> '161*161',
							//'crop'	=> '169*169',
						),
						array('class' => 'icone-modalidade',)
					);
				?>
			</div>
			<div class="span6">
				<div class="div"></div>
				<h1 class="modalidade">
					<?php echo $texto['Modalidade']['titulo']; ?>
				</h1>
			</div>
		</div>
	</div>
</div>

<? } 
else if($texto['Texto']['tipo'] == 'case') { ?>

<div id="title-bar">
	<div class="container">
		<div class="row-fluid">
			<div class="span6">
				<h1><?php echo $texto['Cas']['titulo']; ?></h1>
			</div>
			<div class="span6">
				<div class="div"></div>
				<p>
					<?php echo $texto['Cas']['conteudo_preview']; ?>
				</p>
			</div>
		</div>
	</div>
</div>

<? } 
else if($texto['Texto']['tipo'] == 'evento') { ?>

<div id="title-bar">
	<div class="container">
		<div class="row-fluid">
			<div class="span6">
				<h1><?php echo $texto['Evento']['titulo']; ?></h1>
				<strong><span>eventos</span></strong>
			</div>
			<div class="span6">
				<div class="div"></div>
				<p>
					<?php echo $texto['Evento']['conteudo_preview']; ?>
				</p>
			</div>
		</div>
	</div>
</div>

<? } ?>

<!-- <div id="title-bar">
	<div class="container">
		<div class="row-fluid">
			<div class="span6">
				<h1>TEXTOS</h1>
				<strong><span>confira</span></strong>
			</div>
			<div class="span6">
				<div class="div"></div>
				<p>
					<?php echo Configure::read('texto.pagina.textos'); ?>
				</p>
			</div>
		</div>
	</div>
</div> -->

<br />

<div class="container noticias">

	<div class="row-fluid">
		<div class="span4">
			<?php
				echo $this->Image->thumbImage(
					array(
						'src' 	=> $texto['Texto']['image'],
						'size'	=> '389*228',
						//'crop'	=> '100*182',
					),
					array('class' => 'img-noticia', 'alt'=>$texto['Texto']['titulo'])
				);
			?>
		</div>

		<div class="span8">

			<h2><?php echo $texto['Texto']['titulo']; ?></h2>
			<p><?php echo $texto['Texto']['descricao']; ?></p>

		</div>

	</div>

</div><?php //.container ?>