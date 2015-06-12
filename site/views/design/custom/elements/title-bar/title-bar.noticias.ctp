<div id="title-bar">
	<div class="container">
		<h1>
		<?php
		//Não abriu nenhum destino
		if(empty($destino['Destino'])):
			echo $menu_ativo[0]['Sitemap']['label'];

		//Destino com subníveis
		elseif(empty($destino['Destino']['parent_id'])):
			echo $menu_ativo[0]['Sitemap']['label'] . ' ' . $destino['Destino']['nome'];

		//Destino com roteiro
		else:
			//Se está com roteiro aberto
			if(!empty($roteiro)):
			?> Roteiro <span>&raquo; <?php echo $menu_ativo[0]['Sitemap']['label'] . ' '. implode(' / ', Set::extract($destinoPath, '{n}.Destino.nome'));?></span>
			<?php
			else:
			?><?php echo current(Set::extract(array_slice($destinoPath, -1), '{n}.Destino.nome'));?> <span>&raquo; <?php echo $menu_ativo[0]['Sitemap']['label'] . ' '. implode(' / ', Set::extract(array_slice($destinoPath, 0, -1), '{n}.Destino.nome'));?></span>
			<?php endif; ?>
		<?php endif; ?>
		</h1>

		<div class="navbar">
			<div class="nav-inner">
				<div class="container">
					<div class="nav-collapse">
						<ul class="nav titlebar">
							<?php
							$i = 0;
							foreach($menu AS $item) {
								//echo $item['Sitemap']['label'];
								if( $item['Sitemap']['label'] == 'Destinos') {
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

								if(!empty($item['submenu']) || $item['Sitemap']['route'] == 'template_destinos'){
									$class[] = 'dropdown';
								}

								echo '<li class="'.implode(' ', $class).' nohover">
									<a '.(!empty($item['submenu']) || $item['Sitemap']['route'] == 'template_destinos' ? 'xdata-toggle="dropdown"' : '').' href="'.$this->Html->url('/'.$item['Sitemap']['friendly_url']).'">
										<div>escolha seu destino <b class="caret-down"></b></div>
									</a>'.PHP_EOL;
								if(!empty($item['submenu'])):
									echo '<ul class="dropdown-menu">';
									foreach($item['submenu'] AS $subitem) {
										echo '<li '.(!empty($subitem['submenu']) ? 'class="dropdown-submenu "' : '').'>
											<a '.(!empty($subitem['submenu']) ? 'xdata-toggle="dropdown"' : '').' href="'.$this->Html->url('/'.'/'.$subitem['Sitemap']['friendly_url']).'">'.$subitem['Sitemap']['label'] . '</a>'.PHP_EOL;
										if(!empty($subitem['submenu'])) {
											echo '<ul class="dropdown-menu">'.PHP_EOL;
											foreach($subitem['submenu'] AS $subitem2){
												echo '<li><a href="destino:'.$this->Html->url('/'.$item['Sitemap']['friendly_url'].'/'.$subitem['Sitemap']['friendly_url']).'/'.$subitem2['Sitemap']['friendly_url'].'">'.$subitem2['Sitemap']['label'].'</a></li>'.PHP_EOL;
											}
											echo '</ul>'.PHP_EOL;
										}
										echo '</li>'.PHP_EOL;
									}
									echo '</ul>'.PHP_EOL;

								elseif($item['Sitemap']['route'] == 'template_destinos'):
									echo '<ul class="dropdown-menu">';
									foreach($destinos_load AS $subitem) {
										echo '<li '.(!empty($subitem['submenu']) ? 'class="dropdown-submenu pull-left"' : '').'>
												<a '.(!empty($subitem['submenu']) ? 'xdata-toggle="dropdown"' : '').' href="'.$this->Html->url('/blog/destino:'.$subitem['Destino']['friendly_url']).'">'.$subitem['Destino']['nome'] . '</a>'.PHP_EOL;
										if(!empty($subitem['submenu'])){
											echo '<ul class="dropdown-menu">'.PHP_EOL;
											foreach($subitem['submenu'] AS $subitem2){
												echo '<li>
												<a href="'.$this->Html->url('/blog/destino:	').$subitem2['Destino']['friendly_url'].'">'.$subitem2['Destino']['nome'].'</a></li>'.PHP_EOL;
											}
											echo '</ul>'.PHP_EOL;
										}
										echo '</li>'.PHP_EOL;
									}
									echo '</ul>'.PHP_EOL;

								endif;
								
								echo '</li>'.PHP_EOL;
							}//foreach
						}
							?>
						</ul>
					</div><!-- /.nav-collapse -->
				</div><!-- /.container -->
			</div><!-- /.navbar-inner -->
		</div><!-- /.navbar -->
	</div>
</div>
