<?php

if(!isset($fileuploader['singleFile'])){
	$fileuploader['singleFile'] = false;
}

if(!isset($fileuploader['input_params']['show_preview'])){
	$fileuploader['input_params']['show_preview'] = true;
}

if(isset($fileuploader['input_params']['show_preview'])){
	if(!empty($fileuploader['input_params']['show_preview_url'])){
		$show_preview_url = $fileuploader['input_params']['show_preview_url'];
	}else{
		$show_preview_url = '/arquivos/download';
	}
	
//	$show_preview_url .= '?size='.rawurlencode($fileuploader['input_params']['show_preview']).'&src=';
	if(!preg_match('/\/$/', $show_preview_url)){
		$show_preview_url .= '/';
	}
}

if(!array_key_exists('fileLimit', $fileuploader))
{
	$fileuploader['fileLimit'] = 0;
}

if(!array_key_exists('id', $fileuploader))
{
	$fileuploader['id'] = 'fileuploader';
}


$fileuploader += array(
	'url' 		=> $this->Html->url(array('controller' => 'arquivos', 'action' => 'temporary_upload', $fileuploader['model'])),
	'extensions'=> array('jpg', 'jpeg', 'png', 'gif', 'pdf',),
	'multiple'	=> true,
	'showMessage'	=> "
		$('#multiple_upload_block_".$fileuploader['id']."')
			.removeBlockMessages()
			.blockMessage(message, {type: 'error'})
		;
		return true;
	",
	'onSubmit'	=> "
		\$multiple_upload_block = $('#multiple_upload_block_".$fileuploader['id']."');
		if(\$multiple_upload_block.attr('sending') == undefined){
			\$multiple_upload_block
				.attr('sending', true)
				.removeBlockMessages()
				.blockMessage('Aguarde! Enviando arquivos' , {type: 'warning'})
				.parents('form')
					.find('input[type=submit]')
						.addClass('disabled')
						.attr('disabled', 'disabled')
			;
		}
		".(			$fileuploader['fileLimit'] == 0 ?
			
				""
				:
				"\$multiple_upload_block.find('div.qq-upload-button').hide();"
		).
		"
		return true;
	",

	'onCancel' => "
		if($('#".$fileuploader['id']." ul.qq-upload-list a.qq-upload-cancel').length == 0){
			$('#multiple_upload_block_".$fileuploader['id']."')
				.removeAttr('sending')
				.removeBlockMessages()
				.parents('form')
					.find('input[type=submit]')
						.removeClass('disabled')
						.removeAttr('disabled')
			;			
		}
	",
	'onComplete'=> "
		if(!$('#".$fileuploader['id']." ul.qq-upload-list li[qqFileId=' + id + ']').hasClass('qq-upload-fail')){
		
			\$multiple_upload_block = $('#multiple_upload_block_".$fileuploader['id']."');

			\$arquivo_list = $('#arquivo_list_".$fileuploader['id']."');
			\$arquivo_list_itens = $('#arquivo_list_".$fileuploader['id']." li');
			var current_index = (\$arquivo_list_itens.length == 0 ? 0 : \$arquivo_list_itens.length);
			
			".(
				$fileuploader['singleFile'] ?
				"$('#arquivo_list_".$fileuploader['id']." li').remove();
				"
				:
				""
			)."

			$('#arquivo_list_".$fileuploader['id']."').append('<li>\
				<input type=\"hidden\" name=\"data[".$fileuploader['fieldname']."]".($fileuploader['singleFile'] ? "" : "[' + current_index + ']")."[id]\" value=\"' + responseJSON.id + '\" />\
				<input type=\"hidden\" name=\"data[".$fileuploader['fieldname']."]".($fileuploader['singleFile'] ? "" : "[' + current_index + ']")."[arquivo_bck]\" value=\"' + responseJSON.arquivo.arquivo + '\" />\
				<div class=\"inline-small-label required\"><label for=\"".$fileuploader['fieldname'].($fileuploader['singleFile'] ? "" : "' + current_index + '")."Arquivo\">".$fileuploader['input_params']['label'].($fileuploader['singleFile'] ? "" : " ' + (current_index + 1) + '")."</label>\
				<input type=\"file\" id=\"".$fileuploader['fieldname'].($fileuploader['singleFile'] ? "" : "' + current_index + '")."Arquivo\" value=\"\" name=\"data[".$fileuploader['fieldname']."]".($fileuploader['singleFile'] ? "" : "[' + current_index + ']")."[arquivo]\">\
				".(!isset($fileuploader['descricao']) || $fileuploader['descricao'] == true ? 
					"<div style=\"padding-left: 0em;margin: -25px 0 0 420px;\" class=\"input text display-inline-block no-margin-bottom\"><label for=\"".$fileuploader['fieldname'].($fileuploader['singleFile'] ? "" : "' + current_index + '")."Descricao\">Descrição</label><input type=\"text\" name=\"data[".$fileuploader['fieldname']."]".($fileuploader['singleFile'] ? "" : "[' + current_index + ']")."[descricao]\" /></div>"
					:
					""
				)."\
				".(!empty($fileuploader['input_params']['show_remove']) 
					? 
					"<br class=\"clear\"/><div class=\"no-padding no-margin-bottom file_remove\"><input type=\"hidden\" value=\"0\" id=\"".$fileuploader['fieldname'].($fileuploader['singleFile'] ? "" : "' + current_index + '")."ArquivoRemove_\" name=\"data[".$fileuploader['fieldname']."]".($fileuploader['singleFile'] ? "" : "[' + current_index + ']")."[arquivo][remove]\"><input type=\"checkbox\" id=\"".$fileuploader['fieldname'].($fileuploader['singleFile'] ? "" : "' + current_index + '")."ArquivoRemove\" value=\"1\" name=\"data[".$fileuploader['fieldname']."]".($fileuploader['singleFile'] ? "" : "[' + current_index + ']")."[arquivo][remove]\"><label for=\"".$fileuploader['fieldname'].($fileuploader['singleFile'] ? "" : "' + current_index + '")."ArquivoRemove\">Remover arquivo - (' + responseJSON.arquivo.arquivo.replace(/^.*\//, '') + ')</label>"
					:
					""
				)."\
				".(isset($fileuploader['input_params']['show_preview'])
					?
					" <a href=\"".$this->Html->url($show_preview_url)."' + responseJSON.id + '/' + responseJSON.arquivo.arquivo.replace(/^.*\//, '') + '\" class=\"fancy-live\">Download</a>"
					:
					""
				)."\
			</li>');

			$('#".$fileuploader['id']." ul.qq-upload-list li[qqFileId=' + id + ']').fadeOut('normal', function(){\$(this).remove()});
		}
		
		//Erro
		else{
			$('#".$fileuploader['id']." ul.qq-upload-list li[qqFileId=' + id + ']').append('\
				<a href=\"javascript://Remover arquivo\" class=\"qq-upload-delete\">Remover da lista</a>\
			');
		}
		
		
		if($('#".$fileuploader['id']." ul.qq-upload-list li a.qq-upload-cancel').length == 0){
			
			\$multiple_upload_block
				.removeAttr('sending')
				.removeBlockMessages()
				.parents('form')
					.find('input[type=submit]')
						.removeClass('disabled')
						.removeAttr('disabled')
			;

			if($('#".$fileuploader['id']." ul.qq-upload-list li.qq-upload-fail').length != 0 ){
				\$multiple_upload_block
					.blockMessage('Envio de arquivos finalizado!' , {type: 'warning'})
					.blockMessage('Um ou mais arquivos falharam no envio!' , {type: 'error'})
				;
			}
		}
		
		".(
			$fileuploader['fileLimit'] == 0 ?
			""
			:
			"if($('#arquivo_list_".$fileuploader['id']." li').size() >= ".$fileuploader['fileLimit']."){
				\$multiple_upload_block.remove();
			}else{
				\$multiple_upload_block.find('div.qq-upload-button').show();
			}
			"
		)."
	",
);


?>
<ul id="arquivo_list_<?php echo $fileuploader['id'];?>">
<?php
if(is_array($fileuploader['arquivos'])):
	//Se a chave do arquivo não é numérica, então coloca o arquivo na array
	if(!is_numeric(key($fileuploader['arquivos']))){
		$fileuploader['arquivos'] = array($fileuploader['arquivos']);
	}
	foreach($fileuploader['arquivos'] AS $index=>$arquivo):
		if(empty($arquivo['id'])){
			continue;
		}
		
		if(!isset($fileuploader['input_params']['after']))$fileuploader['input_params']['after'] = '';
	
		$fileuploader['params_copy'] = $fileuploader['input_params'];
		
		if(!$fileuploader['singleFile']){
			$fileuploader['params_copy']['label'] .= ' '.($index+1);
		}
		
		$value = $arquivo['arquivo_bck'];
	
		if(!isset($fileuploader['descricao']) || $fileuploader['descricao'] == true){
			$fileuploader['params_copy']['after'] .= $this->Form->input($fileuploader['fieldname'].($fileuploader['singleFile'] ? '' : '.'.$index).'.descricao', array('label' => 'Descrição', 'div' => array('class' => 'input text display-inline-block no-margin-bottom', 'style' => ' margin: -25px 0 0 420px;'), 'type' => 'text'));
		}
	
		if(isset($fileuploader['params_copy']['show_remove']) && !empty($value)){
			$fileuploader['params_copy']['after'] .= '<br class="clear"/>'.$this->Form->input($fileuploader['fieldname'].($fileuploader['singleFile'] ? '' : '.'.$index).'.arquivo.remove', array('error' => false, 'label' => (is_string($fileuploader['params_copy']['show_remove']) ? $fileuploader['params_copy']['show_remove'] : 'Remover arquivo - ('.basename($value).')'), 'div' => 'no-padding no-margin-bottom file_remove', 'type' => 'checkbox', 'value' => (!empty($arquivo['arquivo']['remove']) ? '1' : '')));
		}
	
		if(isset($fileuploader['params_copy']['show_preview']) && !empty($value)){
			$fileuploader['params_copy']['after'] .= ' '.$this->Html->link('Download', $show_preview_url.$arquivo['id'].'/'.basename($arquivo['arquivo_bck']), array('class' => (preg_match('/\.(jpe?g|png|gif)$/i', $arquivo['arquivo_bck']) ? 'fancy' : '')));
		}
		
		?>
		<li>
			<?php 
			echo $this->Form->input($fileuploader['fieldname'].($fileuploader['singleFile'] ? '' : '.'.$index).'.id');
			echo $this->Form->hidden($fileuploader['fieldname'].($fileuploader['singleFile'] ? '' : '.'.$index).'.arquivo_bck');
			echo $this->Form->input($fileuploader['fieldname'].($fileuploader['singleFile'] ? '' : '.'.$index).'.arquivo',$fileuploader['params_copy']);
			?>
		</li>
		<?php
	endforeach;
endif;
?>
</ul>
<?php
//Se permite envio de diversos arquivos ou ainda não tem arquivos...
if(!$fileuploader['singleFile'] || (empty($fileuploader['arquivos'][0]['id']) && empty($fileuploader['arquivos']['id']))):
?>
<div class="no-padding"><div class="no-padding block-content no-border" id="multiple_upload_block_<?php echo $fileuploader['id'];?>"><?php

echo $this->Element('fileuploader/fileuploader', array(
	'fileuploader' => $fileuploader
));
?>
</div></div>

<script>
$('.qq-upload-delete').live('click', function(){
	$(this).parents('li').fadeOut('normal', function(){
		$(this).remove();
	});
});

$('div.file_remove input[type=checkbox]').live('change', function(){
	if($(this).is(':checked')){
		$(this).parents('li').find('label[for$=Arquivo],label[for$=Descricao],input[name$=\"[arquivo]\"],input[name$=\"[descricao]\"]').attr('disabled', true).addClass('disabled');
	}else{
		$(this).parents('li').find('label[for$=Arquivo],label[for$=Descricao],input[name$=\"[arquivo]\"],input[name$=\"[descricao]\"]').removeAttr('disabled').removeClass('disabled');
	}
});

</script>

<?php
endif;
?>