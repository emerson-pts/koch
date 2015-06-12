<?php
	echo '<div class="paging">'.
		$paginator->prev('<< '.__('Anterior', true), array(), null, array('class'=>'disabled')).
		'| '.$paginator->numbers().
		' |'.$paginator->next(__('Próxima', true).' >>', array(), null, array('class' => 'disabled')).'
	</div><div class="paging_counter">'.
		$paginator->counter(array(
			'format' => __('<span class="paging_current">%current%</span>/<span class="paging_total">%count%</span> registros listados. <span class="paging_showing">Exibindo de %start% a %end%. Página %page% de %pages%.</span>' , true)
		)).
	'</div>';
?>