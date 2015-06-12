<div class="container">
	<div class="lista">
	<?php
	$viagem_tipo_loop_count = count($viagem_tipos);
	foreach( $viagem_tipos	AS $key => $r ):
	?>
		<article class="row">
			<div class="span5 image">
			<?php
				echo $this->Image->thumbImage(
					array(
						'src' 	=> $r['ViagemTipo']['imagem_lista'],
						'size'	=> '480*280',
						'crop'	=> '480*280',
					),
					array("alt" => 'Foto: Roteiro ' . $r['ViagemTipo']['nome'],)
				);
			?>
			</div>
			<div class="span7 description">
				<div><h2><?php echo $r['ViagemTipo']['nome']; ?></h2></div>
				<div class="resume"><?php echo $r['ViagemTipo']['descricao']; ?></div>
				<div class="btn-group">
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="javascript://Destinos" title="Destinos <?php echo $r['ViagemTipo']['nome'];?>"><span class="float-left">Destinos </span><span class="caret"></span></a>
					<ul class="dropdown-menu">
						<?php 
						foreach($r['Destino'] AS $child_key => $child_value): ?>
						<li><a href="<?php echo $this->Html->url('/destinos/'.$child_value['fullpath']);?>"><?php echo $child_value['nome'];?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
				<span>&nbsp;&nbsp;</span>
				<div class="btn-group">
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="javascript://Roteiros" title="Roteiros <?php echo $r['ViagemTipo']['nome'];?>"><span class="float-left">Roteiros </span><span class="caret"></span></a>
					<ul class="dropdown-menu">
						<?php 
						foreach($r['Roteiro'] AS $child_key => $child_value): ?>
						<li><a href="<?php echo $this->Html->url('/destinos/'.$child_value['fullpath']);?>"><?php echo $child_value['nome'];?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</article>
		<?php if($key+1 < $viagem_tipo_loop_count): ?>
			<hr />
		<?php endif; ?>
	<?php endforeach; ?>
	</div>
</div>