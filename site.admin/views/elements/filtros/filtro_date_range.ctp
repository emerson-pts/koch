<?php 
$form_url = $this->params['named'];
unset($form_url['range_from']);
unset($form_url['range_to']);
echo $this->Form->create(false,array('url' => $form_url, 'type' => 'get', 'class'=>'form small', 'id' => 'filtroDateRange', ));
echo $this->Form->input('filter.range_from',array(
	'label'=> array('style' => 'width: 6.4em', 'text' => __('Periodo', true)), 
	'value' => str_replace('-', '/', $filtro_range['from']),
	'class'	=> 'dateMask datepicker',
	'div' => 'inline-mini-label input float-left',
	'after' => __(' até ', true).$this->Form->input('filter.range_to',array(
		'label'=> false,
		'value' => str_replace('-', '/', $filtro_range['to']),
		'class'	=> 'dateMask datepicker',
		'div' => false,
	)),
));

echo $this->Form->end();
?>
<script>
jQuery(document).ready(function(event){
	jQuery('#filterRangeFrom,#filterRangeTo').datepick({
    	onSelect: customRange
    }); 
     
	function customRange(dates) { 
		if (this.id == 'filterRangeFrom') { 
			jQuery('#filterRangeTo')
				.datepick('option', 'minDate', dates[0] || null)
				.trigger('focus')
			; 
		} 
		else { 
			jQuery('#filterRangeFrom').datepick('option', 'maxDate', dates[0] || null); 
			
			document.location.href = "<?php echo preg_replace(array('/range_(from|to)\:[^\/]*\/?/', '/\/+$/',), '', $this->Html->url('/' . $this->params['url']['url']));?>/" + 
				'range_from:' + jQuery('#filterRangeFrom').val().replace(/\//g, '-') + '/'+ 
				'range_to:' + jQuery('#filterRangeTo').val().replace(/\//g, '-')
			;
		} 
	}
});
</script>