<div class="container">
	<div class="navbar">
		<div class="navbar-inner">
			<div class="container">
				<?php #echo $this->Element('site-contact-box'); ?>
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
							
							if(!empty($item['submenu']) || $item['Sitemap']['route'] == 'template_destinos'){
								$class[] = 'dropdown';
							}
							
							echo '<li class="'.implode(' ', $class).'"><a '.(!empty($item['submenu']) || $item['Sitemap']['route'] == 'template_destinos' ? 'xdata-toggle="dropdown"' : '').' href="'.$this->Html->url('/'.$item['Sitemap']['friendly_url']).'"><span>'.$item['Sitemap']['label'].(!empty($item['submenu']) || $item['Sitemap']['route'] == 'template_destinos' ? '<b class="caret"></b>' : '') .'</span></a>'.PHP_EOL;
							if(!empty($item['submenu'])):

								if($item['Sitemap']['friendly_url'] == 'koch-tavares') {
									echo '<ul class="dropdown-menu koch-tavares">';
								} else {
									echo '<ul class="dropdown-menu">';	
								}								
								foreach($item['submenu'] AS $subitem){
									echo '<li '.(!empty($subitem['submenu']) ? 'class="dropdown-submenu"' : '').'><a '.(!empty($subitem['submenu']) ? 'xdata-toggle="dropdown"' : '').' href="'.$this->Html->url('/'.$item['Sitemap']['friendly_url'].'/'.$subitem['Sitemap']['friendly_url']).'">'.$subitem['Sitemap']['label'] . '</a>'.PHP_EOL;
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

							elseif($item['Sitemap']['route'] == 'template_destinos'):

								echo '<ul class="dropdown-menu">';
								foreach($destinos_load AS $subitem){

									echo '<li '.(!empty($subitem['submenu']) ? 'class="dropdown-submenu"' : '').'><a '.(!empty($subitem['submenu']) ? 'xdata-toggle="dropdown"' : '').' href="'.$this->Html->url('/'.$item['Sitemap']['friendly_url'].'/'.$subitem['Destino']['friendly_url']).'">'.$subitem['Destino']['nome'] . '</a>'.PHP_EOL;
									if(!empty($subitem['submenu'])){
										echo '<ul class="dropdown-menu">'.PHP_EOL;
										foreach($subitem['submenu'] AS $subitem2){
											echo '<li><a href="'.$this->Html->url('/'.$item['Sitemap']['friendly_url'].'/'.$subitem['Destino']['friendly_url']).'/'.$subitem2['Destino']['friendly_url'].'">'.$subitem2['Destino']['nome'].'</a></li>'.PHP_EOL;
										}
										echo '</ul>'.PHP_EOL;
									}
									echo '</li>'.PHP_EOL;
								}
								echo '</ul>'.PHP_EOL;

							endif;

							
							echo '</li>'.PHP_EOL;
						}//foreach
						?>
						<li class="dropdown login">
							<a xdata-toggle="dropdown" href="">
								<span>Login <b class="caret-drop"></b></span>
							</a>
							<ul class="dropdown-menu">
								<?php
								//se existir session auth do usuario entao mostra logout
								if(count(@$_SESSION['Auth']['Usuario'])>0) { ?>
									<li><a href="<?php echo $this->Html->url('/sistema/usuarios/logout/'); ?>">Sair</a></li>
								<? } else {
									echo $this->Form->create('Usuario' , array('name'=> 'Login', 'action' => 'login',)); ?>

										<?php echo $this->Form->input("email",array(
											"maxlength" => "100",
											"placeholder" => "Email",
											"label" => false,
										)); ?>

										<?php echo $this->Form->input("senha",array(
											"maxlength" => "100",
											"placeholder" => "Senha",
											"type" => "password",
											'autocomplete' => 'off',
											"label" => false,
										)); ?>

										<?php echo $this->Form->submit('enviar',array(
											'class' => 'login',
										));
										?>
									<?php echo $this->Form->end(); 
								} ?>
							</ul>
						</li>
					</ul>
					<ul class="flags">
						<li>
							<?php
								echo $this->Html->link(
									$this->Html->image('custom/flag-es.png', array( 'alt' => '')),
									'http://webjumpdev.com.br/koch/es/',
									array('escape' => false, 'class' => '')
								);							
							?>
						</li>
						<li>
							<?php
								echo $this->Html->link(
									$this->Html->image('custom/flag-en.png', array( 'alt' => '')),
									'http://webjumpdev.com.br/koch/en/',
									array('escape' => false, 'class' => '')
								);							
							?>							
						</li>
						<li>
							<?php
								echo $this->Html->link(
									$this->Html->image('custom/flag-br.png', array( 'alt' => '')),
									'/',
									array('escape' => false, 'class' => '')
								);							
							?>
						</li>
					</div>
				</div><!-- /.nav-collapse -->
			</div><!-- /.container -->
		</div><!-- /.navbar-inner -->
	</div><!-- /.navbar -->
</div>

