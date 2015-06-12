<div class="roteiros-list">
	<?php foreach($roteiros AS $r): ?>
	<div class="row">
		<a class="link-overlay" title="<?php echo $r['Roteiro']['nome']; ?>" href="<?php echo $this->Html->url('/'.preg_replace('/\/roteiros$/', '', implode('/', $this->params['originalArgs']['passedArgs'])).'/roteiros/'.$r['Roteiro']['friendly_url']);?>"><?php echo $r['Roteiro']['nome']; ?></a>
		<div class="span4"><?php
			echo $this->Image->thumbImage(
				array(
					'src' 	=> $r['Roteiro']['imagem_lista'],
					'size'	=> '380*253',
					'crop'	=> '380*253',
				),
				array("alt" => 'Roteiro ' . $r['Roteiro']['nome'],)
			);
		?></div>
		<div class="span8">
			<div class="roteiro-item-header">
				<div class="roteiro-nome"><?php echo $r['Roteiro']['nome']; ?></div>
				<?php if(!empty($r['Roteiro']['qtd_dias'])):?><div class="roteiro-duracao"><?php echo $r['Roteiro']['qtd_dias']; ?></div><?php endif; ?>
				<?php if(!empty($r['Roteiro']['onde_comeca']) || !empty($r['Roteiro']['onde_termina'])):?>
					<div class="onde-comeca-termina">
						<span>Começa em: <?php 
							if(!empty($r['Roteiro']['onde_comeca'])){
								echo $r['Roteiro']['onde_comeca'];
							}else{
								echo '--';
							} 
						?> </span>
						&nbsp;&nbsp;
						<span>Termina em: <?php
							if(!empty($r['Roteiro']['onde_termina'])){
								echo $r['Roteiro']['onde_termina'];
							}else{
								echo '--';
							} 
						?> </span>
					</div>
				<?php endif; ?>
				<div class="roteiro-descricao"><?php echo $r['Roteiro']['resumo'];?></div>
			</div>
			<div class="valor-a-partir"><?php if(!empty($r['Roteiro']['preco_a_partir'])):?>a partir de <span class="price"><?php echo $r['Roteiro']['preco_a_partir'];?></span><?php endif;?></div>
			<span class="btn-saiba-mais">saiba mais</span>
		</div>
	</div>
	<?php endforeach; ?>
</div>