<div id="title-bar">
	<div class="container">
		<h1>
		<?php
		//Não abriu nenhum destino
		if(empty($destino['Destino'])):
			echo $menu_ativo[0]['Sitemap']['label'];

		//Destino com subníveis
		elseif(empty($destino['Destino']['parent_id'])):
			echo $menu_ativo[0]['Sitemap']['label'] . ' ' . $destino['Destino']['nome'];
		
		//Destino com roteiro
		else:
			//Se está com roteiro aberto
			if(!empty($roteiro)):
			?> Roteiro <span>&raquo; <?php echo $menu_ativo[0]['Sitemap']['label'] . ' '. implode(' / ', Set::extract($destinoPath, '{n}.Destino.nome'));?></span>
			<?php
			else:
			?><?php echo current(Set::extract(array_slice($destinoPath, -1), '{n}.Destino.nome'));?> <span>&raquo; <?php echo $menu_ativo[0]['Sitemap']['label'] . ' '. implode(' / ', Set::extract(array_slice($destinoPath, 0, -1), '{n}.Destino.nome'));?></span>
			<?php endif; ?>
		<?php endif; ?>
		</h1>
		<ul>
			<li>
				<?php echo $this->Html->link(
					'Voltar',
					'/'.implode('/', array_slice($this->params['originalArgs']['passedArgs'], 0, -1))
				);?>
			</li>
		</ul>
	</div>
</div>
