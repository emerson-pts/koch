<section class="grid_12">
	<div class="block-border"><div class="block-content">
		<?php
		 echo $this->Element('admin/form/default_form', 
			array(
				'form_title' => $form_title,
				'form_submit_label' => $form_submit_label,
				'no_form_end' => true,
			)
		);
		?>
		<br /><br />
		<fieldset><legend>Relacionamentos</legend>
		<?php
			echo $this->Form->input('noticia_relacionada_search',array('id' => 'NoticiaNoticiaRelacionadaSearch', 'label' => 'Notícias', 'type' => 'text', 'after' => '<ul class="relacionamentos" id="NoticiaRelacionada"><li class="hidden"><a title="Remover" class="delete_related" href="javascript://Remover"><input type="hidden" name="data[NoticiaRelacionada][NoticiaRelacionada][]" value="" /><span></span></a></li></ul>', 'value' => '', 'div' => 'input nopadding-bottom'));
				echo $this->Form->hidden('noticia_relacionada_search_label', array('id' => 'NoticiaNoticiaRelacionadaSearchLabel',));
			
/*
			//Video
			echo $this->Form->input('video_relacionado_search',array('id' => 'NoticiaVideoRelacionadoSearch', 'label' => 'Videos', 'type' => 'text', 'after' => '<ul class="relacionamentos" id="VideoRelacionado"><li class="hidden"><a title="Remover" class="delete_related" href="javascript://Remover"><input type="hidden" name="data[VideoRelacionado][VideoRelacionado][]" value="" /><span></span></a></li></ul>', 'value' => '', 'div' => 'input nopadding-bottom'));
			echo $this->Form->hidden('video_relacionado_search_label', array('id' => 'NoticiaVideoRelacionadoSearchLabel',));
			
			//Galeria
			echo $this->Form->input('galeria_relacionada_search',array('id' => 'NoticiaGaleriaRelacionadaSearch', 'label' => 'Galerias', 'type' => 'text', 'after' => '<ul class="relacionamentos" id="GaleriaRelacionada"><li class="hidden"><a title="Remover" class="delete_related" href="javascript://Remover"><input type="hidden" name="data[GaleriaRelacionada][GaleriaRelacionada][]" value="" /><span></span></a></li></ul>', 'value' => '', 'div' => 'input nopadding-bottom'));
			echo $this->Form->hidden('galeria_relacionada_search_label', array('id' => 'NoticiaGaleriaRelacionadaSearchLabel',));
*/

			//Destino
			echo $this->Form->input('destino_relacionado_search',array('id' => 'NoticiaDestinoRelacionadoSearch', 'label' => 'Detinos', 'type' => 'text', 'after' => '<ul class="relacionamentos" id="DestinoRelacionado"><li class="hidden"><a title="Remover" class="delete_related" href="javascript://Remover"><input type="hidden" name="data[DestinoRelacionado][DestinoRelacionado][]" value="" /><span></span></a></li></ul>', 'value' => '', 'div' => 'input nopadding-bottom'));
			echo $this->Form->hidden('destino_relacionado_search_label', array('id' => 'NoticiaDestinoRelacionadoSearchLabel',));

			?>
		</fieldset>
		<?php echo $this->Form->end();?>
	</div></div>
</section>
<?php
echo $jmycake->autocomplete('NoticiaNoticiaRelacionadaSearch','/noticias/autocomplete/Noticia/{Noticia.id|Noticia.titulo|Noticia.friendly_url}',array('NoticiaNoticiaRelacionadaSearchLabel'=>'itemLabel',));

//echo $jmycake->autocomplete('NoticiaVideoRelacionadoSearch','/videos/autocomplete/Video/{Video.id|Video.titulo|Video.friendly_url}',array('NoticiaVideoRelacionadoSearchLabel'=>'itemLabel',));

//echo $jmycake->autocomplete('NoticiaGaleriaRelacionadaSearch','/galerias/autocomplete/Galeria/{Galeria.id|Galeria.label|Galeria.friendly_url}',array('NoticiaGaleriaRelacionadaSearchLabel'=>'itemLabel',));

echo $jmycake->autocomplete('NoticiaDestinoRelacionadoSearch','/destinos/autocomplete/Destino/{Destino.id|Destino.nome|Destino.friendly_url}',array('NoticiaDestinoRelacionadoSearchLabel'=>'itemLabel',));
?>
<script type="text/javascript">
function NoticiaNoticiaRelacionadaSearch_onupdate(){
	relacionamento_update('NoticiaNoticiaRelacionadaSearch', 'NoticiaRelacionada', 'related_id');
}

function NoticiaVideoRelacionadoSearch_onupdate(){
	relacionamento_update('NoticiaVideoRelacionadoSearch', 'VideoRelacionado', 'video_id');
}

function NoticiaGaleriaRelacionadaSearch_onupdate(){
	relacionamento_update('NoticiaGaleriaRelacionadaSearch', 'GaleriaRelacionada', 'galeria_id');
}

function NoticiaDestinoRelacionadoSearch_onupdate(){
	relacionamento_update('NoticiaDestinoRelacionadoSearch', 'DestinoRelacionado', 'destino_id');
}


function relacionamento_update(search_field, field, related_id){
	id = $('#' + search_field).val();
	$('#' + search_field).val('');
	label = $('#' + search_field + 'Label').val();
	$('#' + search_field + 'Label').val('');
	
	if($('#' + field  + ' li input[value="' + id + '"]').size() != 0)return;
	
	var $li_clone = $('#' + field + '>li:first').clone();
	
	$li_clone
		.find('input')
			.val(id)
	;
	$li_clone
		.find('span')
			.html(label)
	;
	$li_clone
		.appendTo('#' + field)
		.fadeIn()
	;
}

$(document).ready(function(){
	$('.delete_related').live('click', function(){
		if(!window.confirm('Deseja remover este relacionamento?')){
			event.stopPropagation();
			event.preventDefault();
			return false;
		}
		$(this).parents('li').slideUp('normal', function(){
			$(this).remove();
		});
	});
	
	<?php
	foreach(array(
		'NoticiaRelacionada' => '{tipo} - {titulo} ({data_noticia} - cód. {id})',
		'VideoRelacionado' => '{titulo} ({data} - cód. {id})',
		'GaleriaRelacionada' => '{label} ({data} - cód. {id})',
		'DestinoRelacionado' => '{nome} (cód. {id})',
	) AS $key=>$value){
		echo '
			var $id = $("#Noticia'.$key.'Search");
			var $label = $("#Noticia'.$key.'SearchLabel");
		';
		if(!empty($this->data[$key])){
			foreach($this->data[$key] AS $relacionamento){
				$replaces = array();
				foreach(Set::flatten($relacionamento) AS $replace_key=>$replace_value){
					$replaces['/'.preg_quote('{'.$replace_key.'}', '/').'/']  = $replace_value;
				}
				echo '$id.val("'.$relacionamento['id'].'");';
				echo '$label.val("'.htmlentities(preg_replace(array_keys($replaces), $replaces, $value), $flags = ENT_COMPAT, $charset = 'UTF-8').'");';
				echo 'relacionamento_update("Noticia'.$key.'Search", "'.$key.'", "related_id");';
			}
		}
		echo '/* ';
		print_r(Set::flatten($relacionamento));
		echo '*/';
	}
	?>
});
</script>