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

		<?php
		$destinos_loop = (
			//Se tem o índice children (está em algum destino)
			!empty($destino['children']) ?
				$destino['children']
				:
				$destino
		);
		$destinos_loop_count = count($destinos_loop);
		
		foreach( $destinos_loop	AS $key => $r ):
		<div class="btn-group">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="<?php echo $this->Html->url('/'.implode('/', $this->params['originalArgs']['passedArgs']).'/'.$r['Destino']['friendly_url']);?>"><span class="float-left">Destinos </span><span class="caret"></span></a>
			<ul class="dropdown-menu">
				<?php 
				foreach($r['children'] AS $child_key => $child_value): ?>
				<li><a href="<?php echo $this->Html->url('/'.implode('/', $this->params['originalArgs']['passedArgs']).'/'.$r['Destino']['friendly_url'].'/'.$child_value['Destino']['friendly_url']);?>"><?php echo $child_value['Destino']['nome'];?></a></li>
				<?php endforeach; ?>
			</ul> 
		</div>
		<?php endforeach; ?>
	</div>
</div>
