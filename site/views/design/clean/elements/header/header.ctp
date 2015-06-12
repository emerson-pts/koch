<!--
<div class="menu">
	<ul>
		<?php /* Código puro menu
			<li><a href="#">empresa</a></li>
			<li><a href="#">serviços</a></li>
			<li><a href="#">clientes</a></li>
			<li><a href="#">responsabilidade social</a></li>
			<li><a href="#">links úteis</a></li>
			<li><a href="#">notícias</a></li>
			<li><a href="#">galeria</a></li>
			<li><a href="#">orçamento</a></li>
			<li><a href="#" class="no-margin">contato</a></li> 
			*/ 
		?>
		<?php
		/*if($this->params['controller'] == 'home'){
			echo '<li class="current"><a href="'.$this->Html->url('/home').'" >home</a></li>';
		}else{
			echo '<li><a href="'.$this->Html->url('/home').'">home</a></li>';
		} */
		$i = 0;
		foreach($menu AS $item){	
			$i++;
			$class = array();
			//if($i == 1)$class[] = 'first';
			if(count($menu) == $i)$class[] = 'no-margin';
			
			if((!empty($menu_ativo) && $menu_ativo[0]['Sitemap']['friendly_url'] == $item['Sitemap']['friendly_url'])
			
				||
				
				($this->params['controller'] == 'noticias' && $item['Sitemap']['friendly_url'] == 'noticias')
					
			)$class[] = 'current';
			echo '<li><a href="'.$this->Html->url('/'.$item['Sitemap']['friendly_url']).'" class="'.implode(' ', $class).'">'.$item['Sitemap']['label'].'</a>'."\r\n";
		
			echo '</li>'."\r\n";
		}//foreach
		
		?>
	</ul>
</div><!-- menu -->
