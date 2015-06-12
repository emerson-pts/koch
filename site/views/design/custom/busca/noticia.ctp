<?php echo $this->Element('abas-next-prev'); ?>
<div class="container">
	<div class="lista blog-interna">
		<div class="sprite date-interna">
			<span><?php echo $noticia['Noticia']['data_noticia_dia']; ?></span> <?php echo $noticia['Noticia']['data_noticia_mes']; ?>
		</div>
		<h2 class="bgnone"><?php echo $noticia['Noticia']['titulo']; ?></h2>
		<div class"clear"></div>
		<div class="autor"><span>por:</span> nome da pessoa</div>

		<div class="conteudo">
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
			<?php echo $noticia['Noticia']['conteudo']; ?>
		</div>
		<div class="clear"></div>
		<hr />
	</div>	
</div>