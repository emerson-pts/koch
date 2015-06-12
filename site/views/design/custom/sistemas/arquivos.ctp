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

		<br />

		<cake:nocache><?php echo $this->Session->flash('form_msg'); ?></cake:nocache>
	</div>

	<br />

	<div class="row-fluid bem-vindo">
		<div class="span12">
			<h2>Bem vindo, <span><?php echo $nome_usuario; ?></span>. Você está acessando a área restrita da Koch Tavares.</h2>
		</div>
	</div>

	<br />

	<div class="row-fluid bem-vindo">
		<div class="span12">

	        <section id="tables">
				<div class="page-header">
					<h1>Arquivos</h1>
				</div>

				<div class="btn-arquivo">
					<span class="btn-custom">+</span>
					<a href="<?php echo $this->Html->url('/sistema/enviar-arquivos'); ?>">Novo arquivo</a>
				</div>

				<br /><br />

				<div class="bs-docs-example">
					<table class="table">
						<thead>
							<tr>
								<th>Data</th>
								<th>Arquivo</th>
								<th>Extensão</th>
								<th></th>
							</tr>
						</thead>
						<tbody>

							<?php
							foreach ($arquivos as $key => $arquivo):
								$data = substr($arquivo['Sistema']['created'], 0, 10);
								$ext = pathinfo($arquivo['Sistema']['arquivo'], PATHINFO_EXTENSION);
								$nomeArquivo = pathinfo($arquivo['Sistema']['arquivo'], PATHINFO_FILENAME);
							?>
								<tr>
									<td><?php echo $data; ?></td>
									<td><?php echo $nomeArquivo; ?></td>
									<td>.<?php echo $ext; ?></td>
									
									<td><a class="del" href="<?php echo $this->Html->url('/sistema/delete/'.$arquivo['Sistema']['id']); ?>">Excluir</a></td>
								</tr>
							<? endforeach; ?>

						</tbody>
					</table>
				</div>
	        </section>
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
	jQuery('.categoria').on('click',function(){
		//jQuery('li.sub').hide();
		jQuery(this).parent().next().slideToggle();
	});

	$('a.del').click(function(){ if (confirm('Deseja remover esta imagem ?')) return true; else return false; });
});
</script>