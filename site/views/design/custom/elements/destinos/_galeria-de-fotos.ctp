<div class="h4"><?php echo $destino['Destino']['nome'];?> - confira as imagens &nbsp;&nbsp;&nbsp;<div class="fb-like" data-href="<?php echo $this->Html->url( $this->here, true );?>" data-width="450" data-layout="button_count" data-show-faces="false" data-send="false"></div></div>
<?php
echo $this->element('galeria/exibe-galeria.responsive', array(
	'result' => $destino,
	'gallery_setup' => array(
		'model_arquivos' => 'DestinoFoto',
		'indicators' => false,
	),
));
