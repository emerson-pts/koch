<ul id="arquivo_list_<?php echo $fileuploader['id'];?>">
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

if(empty($fileuploader['arquivos'])):
?>	
	<li>Nenhum disponível</li>
<?php
elseif(is_array($fileuploader['arquivos'])):
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
		
		$fileuploader['params_copy'] += array(
			'disabled' => true,
			'readonly' => true,
		);
		
		if(!empty($fileuploader['params_copy']['class'])){
			$fileuploader['params_copy']['class'] .= ' disabled';
		}
		else{
			$fileuploader['params_copy']['class'] = ' disabled';
		}
		
		if(!$fileuploader['singleFile']){
			$fileuploader['params_copy']['label'] .= ' '.($index+1);
		}
		
		$value = $arquivo['arquivo_bck'];
	
		if(isset($fileuploader['params_copy']['show_preview']) && !empty($value)){
			$fileuploader['params_copy']['after'] .= ' '.$this->Html->link('Download ('.basename($value).')', $show_preview_url.$arquivo['id'].'/'.basename($arquivo['arquivo_bck']), array('class' => (preg_match('/\.(jpe?g|png|gif)$/i', $arquivo['arquivo_bck']) ? 'fancy' : '')));
		}
		
		?>
		<li>
			<?php 
			if(!isset($fileuploader['descricao']) || $fileuploader['descricao'] == true){
				echo $this->Form->input($fileuploader['fieldname'].($fileuploader['singleFile'] ? '' : '.'.$index).'.descricao', $fileuploader['params_copy']);
			}
			else{
				echo trim($fileuploader['params_copy']['after']);
			}
			?>
		</li>
		<?php
	endforeach;
endif;
?>
</ul>