<div class="container">
	<article>
		<?php echo $pagina_depoimentos['Pagina']['conteudo']; ?>
	</article>

	<?php 
	$depoimentos_loop_count = count($depoimentos);
	foreach($depoimentos as $key => $r): 
	?>
		<article class="row">
			<div class="span5 image">
			<?php
				echo $this->Image->thumbImage(
					array(
						'src' 	=> $r['FormDepoimento']['imagem'],
						'size'	=> '480*280',
						'crop'	=> '480*280',
					),
					array("alt" => 'Foto: Depoimento destino ' . $r['FormDepoimento']['destino'],)
				);
			?>
			</div>
			<div class="span7 description">
				<div class="destino"><?php echo $r['FormDepoimento']['destino']; ?></div>
				<blockquote><p><?php echo $r['FormDepoimento']['depoimento']; ?></p></blockquote>
				<cite><?php echo $r['FormDepoimento']['nome']; ?></cite>
				<div class="cidade"><?php echo $r['FormDepoimento']['cidade']; ?></div>
			</div>
		</article>
		<?php if($key+1 < $depoimentos_loop_count): ?>
			<hr />
		<?php endif; ?>
	<?php endforeach; ?>
	<?php if(!empty($depoimentos)): ?>
	<div class="text-align-center"><?php echo $this->element('paginacao'); ?></div>
	<br /><br />
	<?php endif; ?>
	<?php 
	echo $this->Form->create('FormDepoimento', array('url' => '/'.implode('/', $this->params['originalArgs']['params']['pass']), 'id' => 'form_depoimento', 'enctype' => 'multipart/form-data',)); ?>
	<div class="row-fluid">
		<div class="span12"><p class="lead no-margin-bottom">Preencha o formulário e envie seu depoimento</p>
			<!-- <span class="ff-lobster">o depoimento será enviado para aprovação<br /> -->
			seu e-mail não será divulgado no site</span>
			<br /><br/>
		</div>
	</div>
	<cake:nocache>
	<?php if($session->check('Message.flash')): ?>
		<div class="row-fluid">
		<div class="offset2 span8"><?php echo $this->Session->flash('form'); ?></div>
	</div>
	<?php endif; ?>
	</cake:nocache>
	<div class="row-fluid">
		<div class="span6">
			<?php echo $this->Form->input("nome",array(
				"maxlength" => "100",
				'type' 	=> 'text',
				'autocomplete'=> false,
				'label' => false,
				'placeholder' => 'nome',
			));
			?>
		</div>
		<div class="span6">
			<?php echo $this->Form->input("email",array(
				"maxlength" => "100",
				'type' 	=> 'text',
				'autocomplete'=> false,
				'label' => false,
				'placeholder' => 'e-mail',
			));
			?>
		</div>
	</div>			
	<div class="row-fluid">
		<div class="span6">
			<?php echo $this->Form->input("cidade",array(
				"maxlength" => "100",
				'div' => 'input text control-group',
				'type' 	=> 'text',
				'label' => false,
				'autocomplete'=> false,
				'placeholder' => 'cidade',
			));
			?>
		</div>
		<div class="span6">
			<?php echo $this->Form->input("destino",array(
				"maxlength" => "100",
				'type' 	=> 'text',
				'label' => false,
				'autocomplete'=> false,
				'placeholder' => 'destino',
			));
			?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span12">
			<?php echo $this->Form->input("depoimento",array(
				// "maxlength" => "100",
				'type' 	=> 'textarea',
				'autocomplete'=> false,
				'label' => false,
				'placeholder' => 'seu depoimento',
				'class'=>'depoimento limit',
				'data-maxsize'=>'200',
				'data-output'=>'status'
			));
			?>
			<span id="status"></span>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span12">
			<?php echo $this->Form->input("imagem",array(
				'type' 	=> 'file',
				'label' => false,
				'select' => 'Selecione uma foto de sua viagem',
				'selected' => 'Foto selecionada',
			));
			?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span12">
			<?php echo $this->Form->submit('enviar',array(
				'class' => 'ff-lobster',
			));
			?>
		</div>
	</div>
	<?php echo $form->end(); ?>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<?php
echo $this->Html->script(
	array(
		'maxlength'
	)
);
?>
<script type="text/javascript">
jQuery(document).ready(function() {
	if(window.location.hash) {
		$('html, body').animate({
			scrollTop: $("#form_depoimento").offset().top-170
		}, 1000);
	}	
});
</script>