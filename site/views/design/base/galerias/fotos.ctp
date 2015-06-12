<?php echo $title_for_layout; ?>
<div class="wrap">
	<?php
		// chama o modelo do layout da galeria
		echo $this->Element('galeria/galeria', array('galeria_atual' => $galeria_atual));
	?>
</div>




