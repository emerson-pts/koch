<?php
$form_url = $this->params['named'];
unset($form_url['status']);

echo $this->Form->create(false,array('url' => $form_url, 'class'=>'form small', 'id' => 'filtroTipo', ));
echo $this->Form->input('filter.filter_tipo',array(
	'label'=> __('Tipo', true),
	'type' => 'select', 
	'selected' => $this->Session->read('filter.filter_tipo'),
	'options'=> array('*' => __('-Todos-', true)) + $setup['options']['tipo'], 
	'div' => 'inline-mini-label input float-left',
));

echo $this->Form->end();

?>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#filterFilterTipo')
		.change(function(event){
			document.location.href = "<?php echo preg_replace(array('/filter_tipo\:[^\/]*\/?/', '/\/+$/',), '', $this->Html->url('/' . $this->params['url']['url']));?>/" + jQuery(this).attr('name').replace(/^.*\[([^\]]+)\]$/, '$1') + ':' + jQuery(this).val();
		})
		.keydown(function(event){
			if (event.keyCode === 13) {
				jQuery(this).trigger('change');
			}
		})

	;
}); 
</script>