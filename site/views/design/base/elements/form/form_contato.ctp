<cake:nocache><?php echo $this->Session->flash('form'); ?></cake:nocache>
<?php echo $this->Form->create('FormContato', array('name'=>'contato','url' => (isset($this->params['originalArgs']['params']['url']['url']) ? '/'.$this->params['originalArgs']['params']['url']['url'] : null))); ?>
<!-- Nome -->
<?php echo $this->Form->input("nome",array(
			"maxlength" => "100",
				//'class'=>'input-contato campos',
				'type' => 'text',
				'label' => false,
				'value' => 'Nome',
				'class' => 'text form_focus nome nome_email gray2 f28 impact uppercase'
				)); 
?>
<!-- Nome -->
<!-- Email -->
<?php echo $this->Form->input("email",array(
			"maxlength" => "100",
				//'class'=>'input-contato campos',
				'type' => 'text',
				'label' => false,
				'value' => 'Email',
				'class' => 'text form_focus email nome_email gray2 f28 impact uppercase'
				)); 
?>
<!-- Email -->
<!-- Telefone -->
<?php echo $this->Form->input("telefone",array(
			"maxlength" => "100",
				'type' => 'text',
				'label' => false,
				'value' => 'Telefone',
				'class' => ' text form_focus telefone gray2 f28 impact uppercase'
				)); 
?>
<!-- Telefone -->
<!-- Mensagem -->
<?php echo $this->Form->input("mensagem",array(
			"maxlength" => "1200",
				//'class'=>'input-contato campos',
				'type' => 'textarea',
				'label' => false,
				'value' => 'Mensagem',
				'class' => 'text mensagem gray2 f28 impact uppercase'
				)); 
?>
<!-- Mensagem -->
<!-- Botão -->
<?php 
	echo $form->submit('enviar', array(
	'type'=>'submit',
	'class'=>'submit impact f25 blue3',
	'label' => 'enviar'
	));
?>
<!-- Botão -->
<?php echo $form->end(); ?>	

<script type="text/javascript">
	$(document).ready(function(){		
		$('input.form_focus')
			.focus(function(){
				if($(this).val() == 'Nome'){
					$(this).val('');
				}
				if($(this).val() == 'Telefone'){
					$(this).val('');
				}
				if($(this).val() == 'Email'){
					$(this).val('');
				}
			})
			.blur(function(){
				if($.trim($('input.form_focus.nome').val()) == ''){
					$('input.form_focus.nome').val('Nome');
				}
				if($.trim($('input.form_focus.telefone').val()) == ''){
					$('input.form_focus.telefone').val('Telefone');
				}
				if($.trim($('input.form_focus.email').val()) == ''){
					$(this).val('Email');
				}
			})
		;
		$('textarea.mensagem')
			.focus(function(){
				if($(this).val() == 'Mensagem'){
					$(this).val('');
				}
			})
			.blur(function(){
				if($.trim($(this).val()) == ''){
					$(this).val('Mensagem');
				}
			})
		;
	});
</script>