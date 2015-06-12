<div class="container">
	<h1><?php echo $pagina['Pagina']['titulo']; ?></h1>
	<?php if(!empty($pagina['Pagina']['image'])): ?>
		<div class="pagina-image image-align-<?php echo $pagina['Pagina']['image_align'];?>"><span class="pagina-image-caret caret-1"></span><span class="pagina-image-caret caret-2"></span><span class="pagina-image-caret caret-3"></span><span class="pagina-image-caret caret-4"></span>
			<?php 
			echo $this->Image->thumbImage(
				array(
					'src' 	=> $pagina['Pagina']['image'],
					'size'	=> 'w1180',
				),
				array("alt" => $pagina['Pagina']['titulo'],)
			);
			?>
			<?php if(!empty($pagina['Pagina']['image_legenda'])): ?>
				<div class="pagina-image-legenda"><?php echo $pagina['Pagina']['image_legenda']; ?></div>
			<?php endif; ?>
		</div>
	<?php endif; ?>
	<?php
		if(!stristr($pagina['Pagina']['conteudo'], '[texto_aspas]')){
			if(empty($pagina['Pagina']['texto_aspas'])){
				$conteudo = $pagina['Pagina']['conteudo'];
			}else{
				$conteudo = $pagina['Pagina']['conteudo'].
					'<blockquote>"'.$pagina['Pagina']['texto_aspas'].'"</blockquote>';
			}
		}else{
			$conteudo = str_ireplace('[texto_aspas]', '<blockquote>"'.$pagina['Pagina']['texto_aspas'].'"</blockquote>', $pagina['Pagina']['conteudo']);
		}
		echo $this->Html->div('pagina-conteudo',$this->Formatacao->pagebreak($conteudo, array('url' => (!empty($this->params['originalArgs']) ? 'originalArgs.params.' : '').'url.url')));
	?>
</div>