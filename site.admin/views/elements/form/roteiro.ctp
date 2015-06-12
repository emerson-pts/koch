<?php
if(!empty($dados_originais)){
	if(!isset($setup['topLink']))$setup['topLink'] = array();
	$setup['topLink']['Destino: <i>'.preg_replace('/^_+/', '', $setup['options']['destino_id'][$dados_originais['Roteiro']['destino_id']]).'</i> '.$this->Html->image('icons/fugue/navigation.png')] = array('url' => array('controller' => 'destinos', 'action' => 'edit', $dados_originais['Roteiro']['destino_id']), 'htmlAttributes' => array('escape' => false));
	$this->set('setup', $setup);
}
?>
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
	<li><a href="#tab-capa">Imagem de Capa</a></li> 
	<li><a href="#tab-tipo_viagem">Tipo de Viagem</a></li> 
	<li><a href="#tab-descricao">Descrição</a></li> 
	<li><a href="#tab-roteiro">Roteiro</a></li> 
	<li><a href="#tab-servicos">Serviços</a></li> 
	<li><a href="#tab-documentos">Documentos</a></li> 
	<li><a href="#tab-observacoes">Observações</a></li> 
	<li><a href="#tab-precos">Preço</a></li> 
</ul>
<div class="tabs-content no-padding">
	<div id="tab-lista" class="fieldset no-border">
		<?php 
			foreach(array(
				'imagem_lista'	=> array('label' => 'Lista', 'div' => 'input inline-medium-label', 'type' => 'file', 'show_remove' => true, 'show_preview' => '640x480', 'show_preview_url' => '/../'.str_replace('.admin', '', APP_DIR).'/thumbs/'),
				'resumo'=> array('label' => 'Resumo', 'div' => 'input inline-medium-label', 'cols' => 50, 'rows' => 5, 'style' => 'width: 580px; height: 120px;', ),
			) AS $key => $params){
				echo $this->Element('admin/form/default_form_input', array( 'key' => $key, 'params' => $params,));
			}
		?>
	</div>
	<div id="tab-capa" class="fieldset no-border">
		<?php 
			App::Import('Vendor', 'WebjumpUtilities');
			$color_options = WebjumpUtilities::str2associative_array(Configure::read('Options.color'));
			foreach($color_options AS $key=>$value){
				$color_example[] = '<span class="keyword '.$key.'-keyword">'.$value.'</span>';
			}			
			
			foreach(array(
				'imagem_capa'	=> array('label' => 'Capa', 'div' => 'input inline-medium-label', 'after' => '<small>(Tamanho sugerido 1600 x 940 pixels)</small>', 'type' => 'file', 'show_remove' => true, 'show_preview' => '640x480', 'show_preview_url' => '/../'.str_replace('.admin', '', APP_DIR).'/thumbs/'),
				'imagem_capa_align'	=> array('label' => 'Alinhamento', 'div' => 'input inline-medium-label', 'default' => 'center', 'options' => array('center' => 'Centralizar', 'top' => 'Superior', 'bottom' => 'Inferior',)),
				'imagem_capa_txt' => array('label' => 'Texto da imagem de capa', 'div' => 'input inline-medium-label ckeditor', 'class' => 'ckeditor', 'cols' => 50, 'rows' => 15,
					'after' => '
						<script type="text/javascript">
							jQuery(document).ready(function(){
								CKEDITOR.replace( "RoteiroImagemCapaTxt", {
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
	<div id="tab-tipo_viagem" class="fieldset no-border">
		<?php
			$i = 0;
			
			$roteiros_viagem_tipo = Set::Combine($this->data, 'ViagemTipo.{n}.id', 'ViagemTipo.{n}.RoteirosViagemTipo.id');
			foreach($setup['options']['viagem_tipo_id'] AS $key => $value){
				echo $this->Element('admin/form/default_form_input', $params = array( 
					'key' => 'RoteirosViagemTipo.'.$i.'.id',
					'params' => array(
						'type' => 'hidden',
						'value' => (isset($roteiros_viagem_tipo[$key]) ? $roteiros_viagem_tipo[$key] : ''),
					),
				));
				echo $this->Element('admin/form/default_form_input', $params = array( 
					'key' => 'RoteirosViagemTipo.'.$i.'.roteiro_id',
					'params' => array(
						'type' => 'hidden',
						'value' => (isset($roteiros_viagem_tipo[$key]) ? $key : ''),
					),
				));
				echo $this->Element('admin/form/default_form_input', $params = array( 
					'key' => 'RoteirosViagemTipo.'.$i.'.viagem_tipo_id',
					'params' => array(
						'label' => $value, 
						'div' => 'input inline-medium-label', 
						'type' => 'checkbox', 
						'class'=>'switch',
						'default' => (isset($roteiros_viagem_tipo[$key]) ? $key : '0'),
						'value' => $key,
					),
				));
				$i++;
			}
		?>
	</div>
	<div id="tab-descricao" class="fieldset no-border">
		<?php 
			foreach(array(
				'onde_comeca' => array('label' => 'Onde começa', 'div' => 'input inline-medium-label', 'maxlength' => 32,),
				'onde_termina' => array('label' => 'Onde termina', 'div' => 'input inline-medium-label', 'maxlength' => 32,),
				'olho'		=> array('label' => 'Olho', 'div' => 'input inline-medium-label', 'cols' => 100, 'rows' => 5, 'style' => 'width: 100%;',),
				'imagem_descricao'	=> array('label' => 'Imagem', 'div' => 'input inline-medium-label', 'type' => 'file', 'show_remove' => true, 'show_preview' => '640x480', 'show_preview_url' => '/../'.str_replace('.admin', '', APP_DIR).'/thumbs/'),
				'descricao'	=> array('label' => 'Descrição', 'div' => 'input inline-medium-label ckeditor', 'class' => 'ckeditor', 'cols' => 50, 'rows' => 15,
					'style' => 'height: 550px;',
					'after' => '
						<script type="text/javascript">
							jQuery(document).ready(function(){
								CKEDITOR.replace( "RoteiroDescricao", {
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
	<div id="tab-roteiro" class="fieldset no-border">
		<?php 
			foreach(array(
				'qtd_dias' => array('label' => 'Quantidade de Dias', 'div' => 'input inline-medium-label', 'maxlength' => 16,),
				'roteiro'	=> array('label' => false, 'div' => 'input inline-medium-label no-padding ckeditor', 'class' => 'ckeditor', 'cols' => 50, 'rows' => 15,
					'style' => 'height: 550px;',
					'after' => '
						<script type="text/javascript">
							jQuery(document).ready(function(){
								CKEDITOR.replace( "RoteiroRoteiro", {
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
	<div id="tab-servicos" class="fieldset no-border">
		<?php 
			foreach(array(
				'servicos'	=> array('label' => false, 'div' => 'input inline-medium-label no-padding ckeditor', 'class' => 'ckeditor', 'cols' => 50, 'rows' => 15,
					'style' => 'height: 550px;',
					'after' => '
						<script type="text/javascript">
							jQuery(document).ready(function(){
								CKEDITOR.replace( "RoteiroServicos", {
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
	<div id="tab-documentos" class="fieldset no-border">
		<?php 
			foreach(array(
				'documentos'	=> array('label' => false, 'div' => 'input inline-medium-label no-padding ckeditor', 'class' => 'ckeditor', 'cols' => 50, 'rows' => 15,
					'style' => 'height: 550px;',
					'after' => '
						<script type="text/javascript">
							jQuery(document).ready(function(){
								CKEDITOR.replace( "RoteiroDocumentos", {
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
	<div id="tab-observacoes" class="fieldset no-border">
		<?php 
			foreach(array(
				'observacoes'=> array('label' => false, 'div' => 'input inline-medium-label no-padding ckeditor', 'class' => 'ckeditor', 'cols' => 50, 'rows' => 15,
					'style' => 'height: 550px;',
					'after' => '
						<script type="text/javascript">
							jQuery(document).ready(function(){
								CKEDITOR.replace( "RoteiroObservacoes", {
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
	<div id="tab-precos" class="fieldset no-border content-roteiro-precos">
		<?php
			App::import('Helper', 'BoomViagens');
			foreach(array(
				'preco_a_partir' => array('label' => 'A partir de', 'div' => 'input inline-medium-label', 'maxlength' => 16,),
				'precos'	=> array('label' => false, 'div' => 'input inline-medium-label no-padding', 'cols' => 100, 'rows' => 5, 'style' => 'float: left; width: 350px; height: 700px; margin-right: 10px;', 'wrap' => 'off',
					'after' => '<small style="text-transform: none;">Utilize [[Título]] para exibir destacar um grupo de valores.<br />
Digite cada tabela de preços no formato: <br />
[Double]<br />
2 estrelas=US$ 2348,00<br />
3 estrelas=US$ 2348,00</small><br /><iframe id="precos_preview" name="precos_preview" width="680" height="650" style="border: 2px solid #f00"></iframe><div class="clear"></div>',
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
<?php if( $this->action == 'edit' ):?>
<form id="precos_render_update" style="display: none" action="<?php echo $this->Html->url(array('action' => 'render_preco'));?>" method="post" target="precos_preview">
	<textarea name="data[precos]"></textarea>
</form>
<script>
	jQuery(document).ready(function(){
		var timerRefreshPrecos = 0;
		jQuery('#RoteiroPrecos')
			.keydown(function(){
				clearTimeout(timerRefreshPrecos);
			})
			.keyup(function(){
				timerRefreshPrecos = setTimeout(function(){
					//do what you need to in 1 second
					jQuery('#precos_render_update')
						.trigger('submit')
					;
				}, 1000)
			;
		});
		jQuery('#precos_render_update')
			.submit(function(){
				jQuery(this)
					.find('textarea')
					.val(jQuery('#RoteiroPrecos').val())
				;
			})
			.trigger('submit')
		;
	});
</script>
<?php endif;