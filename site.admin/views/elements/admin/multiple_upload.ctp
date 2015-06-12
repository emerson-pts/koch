<?php
if(!isset($setup['topLinkLeft']))$setup['topLinkLeft'] = array();
$setup['topLinkLeft'][$this->Html->image('icons/fugue/navigation-180.png').' Voltar'] = array('url' => $this->params['named'] + array('action' => 'index'), 'htmlAttributes' => array('escape' => false));
$this->set('setup', $setup);

if(!isset($upload_config)){$upload_config = array();}
$upload_config += array(
	'multiple_title' => 'Envio de arquivos',
	'extensions'	=> array('jpg', 'jpeg', 'png', 'gif',),
	'params' => array(),
);
?>
<section class="grid_12" id="multiple_upload_block">
	<div class="block-border"><div class="block-content disable-selection">
		<h1><?php echo $upload_config['multiple_title'];?></h1>
		<div class="with-padding no-padding-top">
			<?php
			echo $this->Element('fileuploader/fileuploader', array(
				'fileuploader' => array(
			//		'id'		=> 'fileuploader',
//					'url' 		=> $this->Html->url(array('action' => 'add', 'multiple')),
					'params'     => $upload_config['params'],
					'extensions'=> $upload_config['extensions'],
					'showMessage'	=> "
						$('#multiple_upload_block')
//							.removeBlockMessages()
							.blockMessage(message, {type: 'error'})
						;
						return true;
					",
					'onSubmit'	=> "
						$('#multiple_upload_block')
							.removeBlockMessages()
						;
						return true;
					",
					'onComplete'=> "
						if($('#fileuploader ul.qq-upload-list li').length == $('#fileuploader ul.qq-upload-list li.qq-upload-success').length ){
							$('#multiple_upload_block')
//								.removeBlockMessages()
								.blockMessage('Envio de arquivos completado com sucesso!' , {type: 'success'})
							;
						}else if($('#fileuploader ul.qq-upload-list li').length == ($('#fileuploader ul.qq-upload-list li.qq-upload-success').length + $('#fileuploader ul.qq-upload-list li.qq-upload-fail').length) ){
							$('#multiple_upload_block')
//								.removeBlockMessages()
								.blockMessage('Envio de arquivos finalizado!' , {type: 'warning'})
								.blockMessage('Um ou mais arquivos falharam no envio!' , {type: 'error'})
							;
						}
						
					",
/*
	
		onProgress: function(id, fileName, loaded, total){<?php echo $fileuploader['onProgress'];?>},
		onCancel: function(id, fileName){<?php echo $fileuploader['onCancel'];?>}
*/
				),
			));
			?>
		</div>
	</div></div>
</section>
