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

	<div class="row-fluid bem-vindo">
		<div class="span12">
	        <section id="tables">
				<div class="page-header">
					<h2>Preencha seus dados para entrar na área restrita</h1>
				</div>
	        </section>
		</div>
	</div>

	<?php if($this->Session->read('Message.auth.message')): ?>

	<div class="row-fluid bem-vindo">
		<div class="span12">
			<div class="alert alert-error with-close-button">
				<?php echo $this->Session->read('Message.auth.message'); ?>
			</div>
		</div>
	</div>

	<? endif; ?>

	<?php echo $this->Form->create('Usuario' , array('name'=> 'Login', 'action' => 'login',)); ?>

	<div class="row-fluid bem-vindo">
		<div class="span12">
			<div class="span6">
				<?php echo $this->Form->input("email",array(
					"maxlength" => "100",
					"placeholder" => "Email",
					"label" => false,
					'required' => true
				)); ?>
			</div>
			<div class="span6">
				<?php echo $this->Form->input("senha",array(
					"maxlength" => "100",
					"placeholder" => "Senha",
					'autocomplete' => 'off',
					'type' => 'password',
					"label" => false,
					'required' => true
				)); ?>
			</div>
		</div>
	</div>

	<br />

	<div class="row-fluid bem-vindo">
		<div class="span12">
			<?php echo $this->Form->submit('efetuar login',array(
				'class' => 'submit-login',
			));
			?>
		</div>
	</div>

	<?php echo $this->Form->end(); ?>

	<br />

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
