<?php
echo $this->Form->create('Usuario' , array('id' => 'UsuarioRecoverpassConfirmForm', 'class' => 'form with-margin', 'url' => '/'.$this->params['controller'].'/recoverpass_confirm/'.$uid));
echo $this->Form->input('senha', array('label'=>'<span class="big">Senha</span>', 'type' => 'password', 'class' => 'full-width', 'div' => 'inline-small-label with-margin', 'autocomplete' => 'off',));
echo $this->Form->input('senha_confirmacao', array('label'=>'<span class="big">Redigite <br />a senha</span>', 'type' => 'password', 'class' => 'full-width', 'div' => 'inline-small-label with-margin required', 'autocomplete' => 'off',));
echo $this->Form->button('Gerar nova senha', array('type' => 'submit', 'class' => 'float-right', 'autotab'=> true));
echo $form->end();
?>
<br class="clear" />
<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery('#UsuarioSenha').focus();

	// We'll catch form submission to do it in AJAX, but this works also with JS disabled
	jQuery('#UsuarioRecoverpassConfirmForm').ajaxForm({
		cache: false, 
		dataType: "json",
		beforeSubmit: function(formData, jqForm, options) { 
			// Check fields
			var senha = jQuery('#UsuarioSenha').val();
			var senha_confirmacao = jQuery('#UsuarioSenhaConfirmacao').val();
			
			if (!senha || senha.length == 0)
			{
				jQuery('#login-block').removeBlockMessages().blockMessage('<?php __('Por favor, digite a senha');?>', {type: 'warning'});
				return false;
			}
			else if (!senha_confirmacao || senha_confirmacao.length == 0)
			{
				jQuery('#login-block').removeBlockMessages().blockMessage('<?php __('Por favor, digite a confirmação da senha');?>', {type: 'warning'});
				return false;
			}
			else if (senha != senha_confirmacao)
			{
				jQuery('#login-block').removeBlockMessages().blockMessage('<?php __('As senhas estão diferentes');?>', {type: 'error'});
				return false;
			}
			else
			{
				var submitBt = jqForm.find('button[type=submit]');
				submitBt.disableBt();
				jqForm.sendTimer = new Date().getTime();

				// Message
				jQuery('#login-block').removeBlockMessages().blockMessage('<?php __('Alterando a senha...');?>', {type: 'loading'});

				return true;
			}

			return false;
		},
		
		success: function(data, statusText, xhr, jqForm){
			if (data.valid)
			{
				// Message
				jQuery('#login-block').removeBlockMessages().blockMessage(data.msg, {type: 'success'});

				// Small timer to allow the 'cheking login' message to show when server is too fast
				var receiveTimer = new Date().getTime();
				if (receiveTimer-jqForm.sendTimer < 500)
				{
					setTimeout(function()
					{
						document.location.href = data.redirect;
						
					}, 500-(receiveTimer-jqForm.sendTimer));
				}
				else
				{
					document.location.href = data.redirect;
				}
			}
			else
			{
				// Message
				jQuery('#login-block').removeBlockMessages().blockMessage(data.error || '<?php __('Aconteceu um erro inexperado. Por favor, tente novamente.');?>', {type: 'error'});
				jQuery('#UsuarioSenha, #UsuarioSenhaConfirmacao').val('');
				jQuery('#UsuarioSenha').focus();
				var submitBt = jqForm.find('button[type=submit]');
				submitBt.enableBt();
			}
		}
	
	});
});

</script>