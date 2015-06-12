<?php
if(isset($setup['box_filter'])):
	foreach($setup['box_filter'] AS $filter=>$filter_setup){
		echo '
	<div class="block-border with-margin"><div class="block-content">
		<div class="h1">'.$filter_setup['title'].'</div>
			<ul class="paginator-order">';
		//Exibe opções
		foreach($filter_setup['options'] AS $id=>$label){
			echo '<li class="'.(
				(strcmp($id, '*') == 0 && !isset($this->params['named']['filter['.$filter.']'])) ||
				(isset($this->params['named']['filter['.$filter.']']) && strcmp($this->params['named']['filter['.$filter.']'], $id) == 0)
					? 'active' : '').'">'.$this->Html->link($label, preg_replace('/\/?filter\['.$filter.'\]:[^\/]+/', '', '/'.preg_replace('/^\//','',$this->params['url']['url'])).'/filter['.$filter.']:'.$id, array('escape' => false)).'</li>';
		}
		echo '</ul>
	</div></div>
		';
	}
endif;
