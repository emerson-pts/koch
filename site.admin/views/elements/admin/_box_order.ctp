<?php
if(isset($setup['box_order'])):
	echo '
		<div class="block-border with-margin"><div class="block-content">
		<div class="h1">Ordenação</div>
			<ul class="paginator-order">
	';
	//Exibe opções de ordenação
	foreach($setup['box_order'] AS $field => $label){
		echo '<li class="'.($field == $this->Paginator->sortKey() ? $this->Paginator->sortDir() : '').'">'.$this->Paginator->sort($label, $field).'</li>'."\r\n";
	}
	echo '
			</ul>
	</div></div>
	';
endif;
