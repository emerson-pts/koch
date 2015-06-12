<?php if(!empty($roteiro['Roteiro']['olho'])):?><div class="text-align-center lead"><?php echo $roteiro['Roteiro']['olho']; ?></div><?php endif; ?>
<?php echo $roteiro['Roteiro']['descricao']; ?>
<br />
<?php if(!empty($roteiro['Roteiro']['imagem_descricao'])):
	$getimagesize = getimagesize(WWW_ROOT.$roteiro['Roteiro']['imagem_descricao']);
?>
	<div class="pagina-image image-align-center"><span class="pagina-image-caret caret-1"></span><span class="pagina-image-caret caret-2"></span><span class="pagina-image-caret caret-3"></span><span class="pagina-image-caret caret-4"></span>
		<?php 
		echo $this->Image->thumbImage(
			array(
				'src' 	=> $roteiro['Roteiro']['imagem_descricao'],
				'size'	=> 'w1180',
			),
			array("alt" => 'Foto: '.$roteiro['Roteiro']['nome'],)
		);
		?>
	</div>
<?php endif; ?>

