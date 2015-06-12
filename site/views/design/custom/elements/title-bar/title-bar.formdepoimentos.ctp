<div id="title-bar">
	<div class="container">
		<h1><?php echo $menu_ativo[0]['Sitemap']['label']; ?>
		</h1>
		<ul>
			<li>
				<?php echo $this->Html->link(
					'Escreva seu depoimento',
					'/'.preg_replace('/\/sucesso$/', '', implode('/', $this->params['originalArgs']['params']['pass'])). '#form_depoimento',
					array('class' => 'smooth-scroll',)
				);?>
			</li>
		</ul>
	</div>
</div>

