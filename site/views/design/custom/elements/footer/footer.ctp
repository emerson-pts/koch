<footer>
	<div class="container">
		<div class="row-fluid">
			<div class="span12">
				<?php
				echo $this->Html->link(
					$this->Html->image('custom/logo-rodape.png', array( 'alt' => '')),
					'/',
					array('escape' => false, 'class' => 'logo-rodape')
				);
				?>
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
						?>
						<li class="<?php echo implode(' ', $class);?>"><a href="<?php echo $this->Html->url('/'.$item['Sitemap']['friendly_url']);?>"><span><?php echo $item['Sitemap']['label'];?></span></a></li>
				<?php endforeach; ?>
				</ul>
				<div class="float-right">
					<p class="pull-center">
						<a href="http://www.webjump.com.br" title="Webjump">
							<?php echo $this->Html->image('default/webjump.png', array('alt' => 'Webjump', 'class' => 'logo-webjump')); ?>
						</a>
					</p>
				</div>
			</div>
		</div>
	</div>
</footer>
