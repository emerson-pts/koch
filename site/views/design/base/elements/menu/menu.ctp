<div class="container">
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<?php echo $this->Element('site-contact-box'); ?>
				<a class="btn btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<?php
					echo $this->Html->link(
						$this->Html->image('custom/logo.png', array( 'alt' => Configure::read('site.title'))),
						'/',
						array('escape' => false, 'class' => 'brand')
					);
				?>
				<div class="nav-collapse">
					<ul class="nav">
						<?php
						$i = 0;
						if($home_label = Configure::read('Menu.home_label')):
							$i++;
						?>
							<li class="first-child <?php if($this->params['controller'] == 'home'){echo 'active';}?>"><a href="<?php echo $this->Html->url('/');?>"><?php echo $home_label;?></a></li>
						<?php
						endif;
						
						foreach($menu AS $item){
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
							
							echo '<li class="'.implode(' ', $class).'"><a '.(!empty($item['submenu']) ? 'data-toggle="dropdown"' : '').' href="'.$this->Html->url('/'.$item['Sitemap']['friendly_url']).'"><span>'.$item['Sitemap']['label'].(!empty($item['submenu']) ? '<b class="caret"></b>' : '') .'</span></a>'.PHP_EOL;
							if(!empty($item['submenu'])){
								echo '<ul class="dropdown-menu">';
								foreach($item['submenu'] AS $subitem){
									echo '<li '.(!empty($subitem['submenu']) ? 'class="dropdown-submenu"' : '').'><a '.(!empty($subitem['submenu']) ? 'data-toggle="dropdown"' : '').' href="'.$this->Html->url('/'.$item['Sitemap']['friendly_url'].'/'.$subitem['Sitemap']['friendly_url']).'">'.$subitem['Sitemap']['label'] . '</a>'.PHP_EOL;
									if(!empty($subitem['submenu'])){
										echo '<ul class="dropdown-menu">'.PHP_EOL;
										foreach($subitem['submenu'] AS $subitem2){
											echo '<li><a href="'.$this->Html->url('/'.$item['Sitemap']['friendly_url'].'/'.$subitem['Sitemap']['friendly_url']).'/'.$subitem2['Sitemap']['friendly_url'].'">'.$subitem2['Sitemap']['label'].'</a></li>'.PHP_EOL;
										}
										echo '</ul>'.PHP_EOL;
									}
									echo '</li>'.PHP_EOL;
								}
								echo '</ul>'.PHP_EOL;
							}
							echo '</li>'.PHP_EOL;
						}//foreach
						?>
					</ul>
				</div><!-- /.nav-collapse -->
			</div><!-- /.container -->
		</div><!-- /.navbar-inner -->
	</div><!-- /.navbar -->
</div>
