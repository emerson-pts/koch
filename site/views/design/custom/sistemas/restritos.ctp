<div id="title-bar" class="area-restrita">
	<div class="container">
		<div class="row-fluid">
			<div class="span6">
				<h1>Área</h1>
				<strong>Restrita</strong>
			</div>
			<div class="span6">
				<div class="div"></div>
				<p>
					<?php echo Configure::read('texto.pagina.area.restrita'); ?>
				</p>
			</div>
		</div>
	</div>
</div>

<div class="container sistem">

	<br />

	<div class="row-fluid botoes">
		<div class="span6">
			<a class="<? if(empty($this->params['pass'])) echo 'active'; ?>" href="<?php echo $this->Html->url('/sistema/'); ?>">Aquivos comuns</a>
		</div>

		<div class="span6">
			<a class="<? if(!empty($this->params['pass'])) { if($this->params['pass'][0] == 'arquivos-restritos') echo 'active'; } ?>" href="<?php echo $this->Html->url('/sistema/arquivos-restritos'); ?>">Arquivos restritos</a>
		</div>
	</div>

	<br />

	<div class="row-fluid bem-vindo">
		<div class="span12">
			<h2>Bem vindo, <span><?php echo $nome_usuario; ?></span>. Você está acessando a área restrita da Koch Tavares. Para fazer upload de um arquivo, <a href="<?php echo $this->Html->url('/sistema/arquivos'); ?>"><span>clique aqui</span></a> </h2>
		</div>
	</div>

	<br />

	<div class="row-fluid bem-vindo">
		<div class="span12">
			<?php
			if(!empty($restritos)):
			?>
			<ul class="arquivos">
				<?php
				foreach($restritos AS $key=> $arquivos):
					$pasta =  $key;
				?>
				<li><a href="javascript:;" class="categoria"><?php echo str_replace('-', ' ', $key); ?></a></li>
					<?php
					foreach($arquivos AS $key=> $arquivo):
						$ext = pathinfo($arquivo, PATHINFO_EXTENSION);
						$nomeArquivo = pathinfo($arquivo, PATHINFO_FILENAME);
					?>
					<li class="sub">
						<div class="sep-arq"></div>
						<ul>
							<li>
								<a href=" <?php echo $this->Html->url('/sistema/arquivos-restritos/download/'.$pasta.'/'.$arquivo); ?>"><?php echo $nomeArquivo; ?></a>
								<span><strong>[.<?php echo $ext; ?>]</strong><!-- lorem ipsum dolor --></span>
							</li>
						</ul>
					</li>
					<? endforeach; ?>

				<? endforeach; ?>
			</ul>

			<? endif; ?>

		</div>
	</div>

	<div class="row-fluid bem-vindo">
		<div class="span12">
			<hr />
		</div>
	</div>

</div>

<div class="clear"></div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery('li.sub').hide();
	jQuery('.categoria').on('click',function(){		
		jQuery(this).parent().next().slideToggle();
	});
});
</script>