<!-- Sub nav -->
<div id="sub-nav"><div class="container_12">
	<?php
//	<a href="#" title="Help" class="nav-button"><b><?php __('Ajuda');? ></b></a>
	
	if(isset($setup['searchFields']) && $this->params['action'] == 'index'){
		echo $this->Element('admin/form/search_box');
	}
	?>
</div></div>
<!-- End sub nav -->
