<?php
$form_url = $this->params['named'];
unset($form_url['centro_id']);
unset($form_url['categoria_id']);
$options_categoria 	= $setup['options']['categoria_global_id'];
$options_centro 	= $setup['options']['centro_id'];
unset($options_categoria['']);
unset($options_centro['']);

echo $this->Form->create(false,array('url' => $form_url, 'class'=>'form small', 'id' => 'filtroCentroCategoria', ));
echo $this->Form->input('filter.categoria_id',array(
	'label'=> array('style' => 'width: 6.4em', 'text' => __('Categoria', true)), 
	'between' => $this->Form->text('filter.categoria_search', array('class' => 'selectSearch', 'value' => '', 'field' => 'categoria', 'style' => 'width: 30px;')).' ',
	'type' => 'select', 
	'selected' => $filtro_centro_categoria['categoria_atual'],
	'options'=> array('*' => __('-Todos-', true)) + array('NULL' => '-Não informado-') + $options_categoria, 
	'div' => 'inline-mini-label input float-left',
	'style' => 'width: 310px;',
));

echo $this->Form->input('filter.centro_id',array(
	'label'=> array('style' => 'width: 5em', 'text' => __('Centro', true)), 
	'between' => $this->Form->text('filter.centro_search', array('class' => 'selectSearch', 'value' => '', 'field' => 'centro', 'style' => 'width: 30px;')).' ',
	'type' 	=> 'select', 
	'value' => $filtro_centro_categoria['centro_atual'],
	'options'=> array('*' => __('-Todos-', true)) + array('NULL' => '-Não informado-') + $options_centro, 
	'div' 	=> array('class' => 'inline-mini-label input float-left', 'style' => 'margin-left: 10px;',),
	'style' => 'width: 310px;',
));

//echo $this->Form->submit('Filtrar',array('style' => 'margin: 1px 0 0 3px;', 'class' => 'button float-left', 'div'=>false));

echo $this->Form->end();

?>
<script type="text/javascript">
<?php
foreach(array('centro' => 'centro', 'categoria_global' => 'categoria') AS $field_search => $field){
	$search = array();
	
	echo 'var '.$field.'_search = new Array();';
	
	foreach($setup['options'][$field_search.'_search'] AS $id=>$codigo){
		echo $field.'_search['.$codigo.'] = '.$id.';';
	}
}
?>
jQuery(document).ready(function(){
	jQuery('#filterCentroId, #filterCategoriaId')
		.change(function(event){
			document.location.href = "<?php echo preg_replace(array('/(centro|categoria)_id\:[^\/]*\/?/', '/\/+$/',), '', $this->Html->url('/' . $this->params['url']['url']));?>/" + jQuery(this).attr('name').replace(/^.*\[([^\]]+)\]$/, '$1') + ':' + jQuery(this).val();
		})
		.keydown(function(event){
			if (event.keyCode === 13) {
				jQuery(this).trigger('change');
			}
		})

	;
	
	jQuery('.selectSearch')
		.keyup(function(event){
			if(jQuery(this).attr('field') == 'categoria'){
				search = categoria_search;
			}else{
				search = centro_search;
			}
			
			if(search[jQuery(this).val()] != undefined){
				jQuery('#' + jQuery(this).attr('id').replace(/Search$/, 'Id')).val(search[jQuery(this).val()]);
			}else{
				jQuery('#' + jQuery(this).attr('id').replace(/Search$/, 'Id')).val('');
			}
		})
		.blur(function(event){
			jQuery(this).val('');
		})
	;
}); 
</script>