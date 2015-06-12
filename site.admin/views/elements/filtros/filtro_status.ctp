<?php
$form_url = $this->params['named'];
unset($form_url['status']);

echo $this->Form->create(false,array('url' => $form_url, 'class'=>'form small', 'id' => 'filtroStatus', ));
echo $this->Form->input('filter.status',array(
	'label'=> array('style' => 'width: 6.4em', 'text' => __('Status', true)), 
	'type' => 'select', 
	'selected' => $this->Session->read('filter.status'),
	'options'=> array('*' => __('-Todos-', true), 'previsto|agendado' => __('Previsto/Agendado', true)) + $setup['options']['status'], 
	
	'div' => 'inline-mini-label input float-left',
				
	));

echo $this->Form->end();

?>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#filterStatus')
		.change(function(event){
			document.location.href = "<?php echo preg_replace(array('/status\:[^\/]*\/?/', '/\/+$/',), '', $this->Html->url('/' . $this->params['url']['url']));?>/" + jQuery(this).attr('name').replace(/^.*\[([^\]]+)\]$/, '$1') + ':' + jQuery(this).val();
		})
		.keydown(function(event){
			if (event.keyCode === 13) {
				jQuery(this).trigger('change');
			}
		})

	;
}); 
</script>