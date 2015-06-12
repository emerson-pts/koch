<section class="grid_12">
	<div class="block-border"><div class="block-content">
		<?php
			echo $this->element('admin/form/default_form', array(
				'form_title' => $form_title, 
				'form_submit_label' => $form_submit_label,
				'no_form_end' => true,
			));
			?>
<?php if( $this->action == 'edit' ):?>
<ul class="tabs js-tabs">
	<li><a href="#tab-lista">Lista</a></li> 
	<li class="destino-flag_roteiros-1"><a href="#tab-capa">Imagem de Capa</a></li> 
	<li class="destino-flag_roteiros-1"><a href="#tab-geral">Geral</a></li> 
	<li class="destino-flag_roteiros-1"><a href="#tab-galeria">Galeria</a></li> 
	<li class="destino-flag_roteiros-1"><a href="#tab-brochura">Brochura</a></li> 
	<li class="destino-flag_roteiros-1"><a href="#tab-infos">Infos Adicionais</a></li> 
</ul>
<div class="tabs-content no-padding">
	<div id="tab-lista" class="fieldset no-border">
		<?php 
			foreach(array(
				'imagem_lista'	=> array('label' => 'Lista', 'div' => 'input inline-medium-label', 'type' => 'file', 'show_remove' => true, 'show_preview' => '640x480', 'show_preview_url' => '/../'.str_replace('.admin', '', APP_DIR).'/thumbs/'),
				'resumo'=> array('label' => 'Resumo', 'div' => 'input inline-medium-label', 'cols' => 50, 'rows' => 5, 'style' => 'width: 780px;',),
			) AS $key => $params){
				echo $this->Element('admin/form/default_form_input', array( 'key' => $key, 'params' => $params,));
			}
		?>
	</div>
	<div id="tab-capa" class="fieldset no-border">
		<?php 
			foreach(array(
				'imagem_capa'	=> array('label' => 'Capa', 'div' => 'input inline-medium-label', 'after' => '<small>(Tamanho sugerido 1600 x 940 pixels)</small>', 'type' => 'file', 'show_remove' => true, 'show_preview' => '640x480', 'show_preview_url' => '/../'.str_replace('.admin', '', APP_DIR).'/thumbs/'),
				'imagem_capa_align'	=> array('label' => 'Alinhamento', 'div' => 'input inline-medium-label', 'default' => 'center', 'options' => array('center' => 'Centralizar', 'top' => 'Superior', 'bottom' => 'Inferior',)),
				'imagem_capa_txt' => array('label' => 'Texto da imagem de capa', 'div' => 'input inline-medium-label ckeditor', 'class' => 'ckeditor', 'cols' => 50, 'rows' => 15,
					'after' => '
						<script type="text/javascript">
							jQuery(document).ready(function(){
								CKEDITOR.replace( "DestinoImagemCapaTxt", {
									width: "100%",
									height: "300px",
									enterMode: CKEDITOR.ENTER_BR,
									bodyClass: "chromakey destinos img-capa",
										toolbar: [
											['.(Configure::read('Admin.editor.styles_set') ? '"Styles", ' : '').' "FontSize" ],
											["Bold","Italic","Underline","StrikeThrough","-","Subscript","Superscript"],
											["JustifyLeft","JustifyCenter","JustifyRight","JustifyBlock"],
											["TextColor","BGColor"],
											["Cut","Copy","PasteText"],
											["Undo","Redo","RemoveFormat"],
											["About"], ["Source"]
										]
								});
							});
						</script>
					'
				),
			) AS $key => $params){
				echo $this->Element('admin/form/default_form_input', array( 'key' => $key, 'params' => $params,));
			}
		?>
	</div>
	<div id="tab-geral" class="fieldset no-border">
		<?php 
			foreach(array(
				'olho'		=> array('label' => 'Olho', 'div' => 'input inline-medium-label', 'cols' => 100, 'rows' => 5, 'limit' => 255, 'style' => 'width: 100%;',),
				'descricao'	=> array('label' => 'Descrição', 'div' => 'input inline-medium-label ckeditor', 'class' => 'ckeditor', 'cols' => 50, 'rows' => 15,
					'style' => 'height: 550px;',
					'after' => '
						<script type="text/javascript">
							jQuery(document).ready(function(){
								CKEDITOR.replace( "DestinoDescricao", {
									width: "100%",
									height: "400px"
								});
							});
						</script>
					'
				),
				'video'		=> array('label' => 'Vídeo', 'div' => 'input inline-medium-label', 'cols' => 100, 'rows' => 5, 'style' => 'width: 640px;', 'between' => '<small>Informe a url do víveo no Youtube</small><br />',),
				'highlights'=> array('label' => 'Highlights', 'div' => 'input inline-medium-label', 'cols' => 100, 'rows' => 10, 'between' => '<small>Digite um destaque por linha</small><br />', 'style' => 'width: 640px;',),
			) AS $key => $params){
				echo $this->Element('admin/form/default_form_input', array( 'key' => $key, 'params' => $params,));
			}
		?>
	</div>
	<div id="tab-galeria" class="fieldset no-border">
		<?php echo $this->Html->link('Gerenciar fotos da galeria', array('controller' => 'destino_fotos', 'action' => 'index', 'filter[DestinoFoto.destino_id]:'.$dados_originais['Destino']['id']), array('class' => 'big-button grey'));?>
<?php
/*	
		<div class="block-content no-border" id="multiple_upload_block">
			<?php
			echo $this->Element('fileuploader/fileuploader', array(
				'fileuploader' => array(
			//		'id'		=> 'fileuploader',
					'url' 		=> $this->Html->url(array('controller' => 'destino_fotos', 'action' => 'add', 'multiple')),
					'params' 	=> array('destino_id' => $dados_originais['Destino']['id'],),
					'extensions'=> array('jpg', 'jpeg', 'png', 'gif',),
					'showMessage'	=> "
						$('#multiple_upload_block')
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
								.blockMessage('Envio de arquivos completado com sucesso!' , {type: 'success'})
							;
						}else if($('#fileuploader ul.qq-upload-list li').length == ($('#fileuploader ul.qq-upload-list li.qq-upload-success').length + $('#fileuploader ul.qq-upload-list li.qq-upload-fail').length) ){
							$('#multiple_upload_block')
								.blockMessage('Envio de arquivos finalizado!' , {type: 'warning'})
								.blockMessage('Um ou mais arquivos falharam no envio!' , {type: 'error'})
							;
						}
						
					",
				),
			));
		?></div>
*/
?>
	</div>
	<div id="tab-brochura" class="fieldset no-border">
		<?php 
			foreach(array(
				'brochura'		=> array('label' => 'Brochura', 'div' => 'input inline-medium-label', 'cols' => 100, 'rows' => 5, 'limit' => 255, 'style' => 'width: 640px;', 'between' => '<small>Ao copiar o código de embed do ISSUU, marcar a opção <i>Use on Tumblr, Wordpress or similar</i></small><br />',),
			) AS $key => $params){
				echo $this->Element('admin/form/default_form_input', array( 'key' => $key, 'params' => $params,));
			}
		?>
	</div>
	<div id="tab-infos" class="fieldset no-border">
		<?php 
			foreach(array(
				'info_adicional'=> array('label' => 'Info Adicional', 'div' => 'input inline-medium-label ckeditor', 'class' => 'ckeditor', 'cols' => 50, 'rows' => 15,
					'style' => 'height: 550px;',
					'after' => '
						<script type="text/javascript">
							jQuery(document).ready(function(){
								CKEDITOR.replace( "DestinoInfoAdicional", {
									width: "100%",
									height: "400px"
								});
							});
						</script>
					'
				),
			) AS $key => $params){
				echo $this->Element('admin/form/default_form_input', array( 'key' => $key, 'params' => $params,));
			}
		?>
	</div>
</div>
<?php endif; ?>
<?php echo $this->Form->end();?>

	</div></div>
</section>