 <?php
	//echo '<pre>';print_r($this->params['originalArgs']['passedArgs'][0]);echo '</pre>';
	if(!empty($submenu)){ 
	 if(!empty($this->params['originalArgs']['passedArgs'][1])){
	 	 $url = $this->params['originalArgs']['passedArgs'][1];
	 }else{
	 	 $url = $this->params['sitemap']['children'][0]['Sitemap']['friendly_url'];
	 }
	//$submenu = array_reverse($submenu);
	?>
	<nav class="menu-submenu">
		<ul>
			<?php foreach($submenu as $lista_submenu): 
			//echo '<pre>';print_r($lista_submenu['Sitemap']);echo '</pre>';
			?>
				<li><a href="<?php echo $this->Html->url('/'.$this->params['originalArgs']['passedArgs'][0].'/'.$lista_submenu['Sitemap']['friendly_url']); ?>" title="<?php echo $lista_submenu['Sitemap']['label']; ?>" class="<?php echo $url == $lista_submenu['Sitemap']['friendly_url']?'active':''; ?>"><?php echo $lista_submenu['Sitemap']['label']; ?></a></li>
			<?php endforeach ?>
		<ul>
	</nav>
<?php } ?>
