<footer>
	<div class="container">
		<div class="row">
			<div class="span12">
				<ul class="menu">
				<?php
					$i = 0;
					if($home_label = Configure::read('Menu.home_label')):
						$i++;
					?>
						<li class="first-child <?php if($this->params['controller'] == 'home'){echo 'active';}?>"><a href="<?php echo $this->Html->url('/');?>"><?php echo $home_label;?></a></li>
					<?php
					endif;
					
					foreach($menu AS $item):
						$i++;
						$class = array();
						if($i == 1){
							$class[] = 'first-child';
						}
						else if(count($menu) == $i){
							$class[] = 'last-child';
						}
						
						if((!empty($menu_ativo) && $menu_ativo[0]['Sitemap']['friendly_url'] == $item['Sitemap']['friendly_url'])){
							$class[] = 'active';
						}
						
						if(!empty($item['submenu'])){
							$class[] = 'dropdown';
						}
						?>
						<li class="<?php echo implode(' ', $class);?>"><a href="<?php echo $this->Html->url('/'.$item['Sitemap']['friendly_url']);?>"><span><?php echo $item['Sitemap']['label'];?></span></a>
				<?php endforeach; ?>
				</ul>
			</div>
		</div>
		<div class="row">
			<div class="span12">
				<div class="float-left">Todos os direitos reservados © <?php echo date('Y');?></div>
				<div class="float-right"><a href="http://www.webjump.com.br" title="Webjump">
					<?php echo $this->Html->image('default/webjump.png', array('alt' => 'Webjump', 'title' => 'Webjump')); ?>
				</a></div>
			</div>		
		</div>
	</div>
</footer>