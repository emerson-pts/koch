<? /*?><p class="lead">Em breve você irá conferir artigos sobre os mais variados destinos</p><? */?>

<div class="container">
	<div class="lista blog">
	<?php
	$noticias_destaque = array_slice($noticias, 0, 2);
	$noticias_lista = array_slice($noticias, 2);

	foreach ($noticias_destaque AS $key => $noticia):

		$mes = $noticia['Noticia']['data_noticia_mes'];

		switch ($mes) { 
			case 1: $mes = "jan"; break;
			case 2: $mes = "fev"; break;
			case 3: $mes = "mar"; break;
			case 4: $mes = "abr"; break;
			case 5: $mes = "mai"; break;
			case 6: $mes = "jun"; break;
			case 7: $mes = "jul"; break;
			case 8: $mes = "ago"; break;
			case 9: $mes = "set"; break;
			case 10: $mes = "out"; break;
			case 11: $mes = "nov"; break;
			case 12: $mes = "dez"; break;
		}
		?>
		<article class="row">
			<a class="link-overlay" href="<?php echo $this->Html->url('/blog/'.$noticia['Noticia']['data_noticia_ano'].'/'.$noticia['Noticia']['data_noticia_mes'].'/'.$noticia['Noticia']['friendly_url']);?>"></a>
			<div class="sprite date">
				<span><?php echo $noticia['Noticia']['data_noticia_dia']; ?></span> <?php echo $mes; ?>
			</div>
			<div class="span5 image">
			<?php
				echo $this->Image->thumbImage(
					array(
						'src' 	=> $noticia['Noticia']['image'],
						'size'	=> '480*280',
						'crop'	=> '480*280',
					),
					array("alt" => 'Foto: ' . $noticia['Noticia']['titulo'],)
				);
			?>
			</div>
			<div class="span7 description">
				<div><h2 class="bgnone"><?php echo $noticia['Noticia']['titulo']; ?></div>
				<div class="resume"><?php echo $noticia['Noticia']['conteudo_preview']; ?></div>
				<a href="<?php echo $this->Html->url('/blog/'.$noticia['Noticia']['data_noticia_ano'].'/'.$noticia['Noticia']['data_noticia_mes'].'/'.$noticia['Noticia']['friendly_url']);?>">Leia o post completo</a>
			</div>
		</article>
		<hr />
	<?php endforeach; ?>
	</div>
</div>
