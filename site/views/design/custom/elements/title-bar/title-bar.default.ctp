<?php
$customTitleBarFile = 'title-bar.'.strtolower(Inflector::slug($this->name, '-'));
if(file_exists(dirname(__FILE__).DS.$customTitleBarFile.'.ctp')){
	echo $this->Element('title-bar'.DS.$customTitleBarFile);
	return;
}

if($this->name == 'Home' || $this->name == 'Busca' || $this->name == 'CakeError') {
	return;
}
?>
<div id="title-bar">
	<div class="container">
		<h1><?php echo $menu_ativo[0]['Sitemap']['label']; ?></h1>
		<?php if(!empty($submenu)): ?>
		<ul>
			<?php foreach($submenu AS $key => $value): ?>
				<li <?php if(!empty($this->params['originalArgs']['passedArgs'][1]) && $this->params['originalArgs']['passedArgs'][1] == $value['Sitemap']['friendly_url']):?>class="active"<?php endif;?>>
					<?php echo $this->Html->link(
						$value['Sitemap']['label'],
						'/'.$menu_ativo[0]['Sitemap']['friendly_url'].'/'.$value['Sitemap']['friendly_url']
					);?>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
	</div>
</div>
