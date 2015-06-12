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
			<h2>Bem vindo, <span><?php echo $nome_usuario; ?></span>. Você está acessando a área restrita da Koch Tavares.</h2>
		</div>
	</div>

	<br />

	<div class="row-fluid bem-vindo">
		<div class="span12">
	        <section id="tables">
				<div class="page-header">
					<h1>Enviar Arquivos</h1>
				</div>
	        </section>
		</div>

		<div class="row-fluid oportunidades">

		<div class="span6">
			<?php echo $this->Form->create('Sistema', array('name'=>'Arquivo', 'type' => 'file')); ?>

			<div class="row-fluid">
				<div class="span12">
					<?php
						echo $this->Form->input("usuario_id",array(
							"label" => false,
							'required' => true,
							"type" => "hidden",
							'value' => $id_usuario,
						));
					?>
					<?php echo $this->Form->input("titulo",array(
						"maxlength" => "100",
						"placeholder" => "Título",
						"label" => false,
						'required' => true
					)); ?>
				</div>
			</div>

			<div class="row-fluid">
				<div class="span12">
					<?php echo $this->Form->input("arquivo",array(
						'type' 	=> 'file',
						'label' => false,
						'select' => 'faça o upload do arquivo',
						'selected' => 'Arquivo selecionado',
						'required' => true
					));
					?>
				</div>
			</div>

			<br />

			<div class="row-fluid">
				<div class="span12">					
					<?php echo $this->Form->submit('enviar',array(
						'class' => 'submit-login',
					));
					?>
				</div>
			</div>

			<?php echo $this->Form->end(); ?>

		</div>

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
});
</script>