<div class="container">
	<div class="lista">
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
	?>
		<article class="row">
			<?php
			//Se o destino contém roteiros...
			if($r['Destino']['flag_roteiros']):
			?>
			<a class="link-overlay" href="<?php echo $this->Html->url('/'.implode('/', $this->params['originalArgs']['passedArgs']).'/'.$r['Destino']['friendly_url']);?>"></a>
			<?php endif; ?>
			<div class="span5 image">
				<?php
				//Se o destino não contém roteiros...
				if(!$r['Destino']['flag_roteiros']):
				?><a href="<?php echo $this->Html->url('/'.implode('/', $this->params['originalArgs']['passedArgs']).'/'.$r['Destino']['friendly_url']);?>">
				<?php endif; ?>
			<?php
				echo $this->Image->thumbImage(
					array(
						'src' 	=> $r['Destino']['imagem_lista'],
						'size'	=> '480*280',
						'crop'	=> '480*280',
					),
					array("alt" => 'Foto: ' . $r['Destino']['nome'],)
				);
			?>
				<?php if(!$r['Destino']['flag_roteiros']):?></a><?php endif; ?>
			</div>
			<div class="span7 description">
				<div><h2><?php echo $r['Destino']['nome']; ?></h2></div>
				<div class="resume"><?php echo $r['Destino']['resumo']; ?></div>
				<?php
				//Se o destino contém roteiros...
				if($r['Destino']['flag_roteiros']):
				?>
				<a class="btn" href="<?php echo $this->Html->url('/'.implode('/', $this->params['originalArgs']['passedArgs']).'/'.$r['Destino']['friendly_url']);?>">Acessar este destino</a>
				<?php
				//Caso contrário
				else:
				
				//Exibe combo de sub destinos
				?>
				<div class="btn-group">
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="<?php echo $this->Html->url('/'.implode('/', $this->params['originalArgs']['passedArgs']).'/'.$r['Destino']['friendly_url']);?>"><span class="float-left">Destinos </span><span class="caret"></span></a>
					<ul class="dropdown-menu">
						<?php 
						foreach($r['children'] AS $child_key => $child_value): ?>
						<li><a href="<?php echo $this->Html->url('/'.implode('/', $this->params['originalArgs']['passedArgs']).'/'.$r['Destino']['friendly_url'].'/'.$child_value['Destino']['friendly_url']);?>"><?php echo $child_value['Destino']['nome'];?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
				<?php
				endif;
				?>
			</div>
		</article>
		<?php if($key+1 < $destinos_loop_count): ?>
			<hr />
		<?php endif; ?>
	<?php endforeach; ?>
	</div>
</div>