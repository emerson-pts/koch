<div class="container filtro">
	<div class="row-fluid">
		<div class="filtro">
			<div class="span2">
				<?php
				echo '<div class="styled-select">';
					//echo '<span></span>';
					echo '<select name="ano" class="anos">';
					foreach($filtro_anos AS $ano){
						$url = array('controller' => !empty($menu_ativo[0]['Sitemap']['friendly_url'])?$menu_ativo[0]['Sitemap']['friendly_url']:$this->params['controller'], 'action' => $ano,) + $this->params['named'];
						$options = array(
							'class' => (!empty($filtro_ano) && $ano == $filtro_ano ? 'active' : false),
						);	
						echo '<option value="'.$ano.'"'.(!empty($filtro_ano) && $ano == $filtro_ano ?' selected':'').'>'.$ano.'</option>';
					}
					echo '</select>';
				echo '</div>';
				
				?>
			</div>
			<div class="span10">
				<ul class="meses">
				<?php	
					if(empty($filtro_ano))$filtro_ano = date('Y');
					//Faz links da barra
					foreach($this->Formatacao->meses AS $key=>$mes) {
						$key++;
						if($key < 10)$key = '0'.$key;
						$url = array('controller' => !empty($menu_ativo[0]['Sitemap']['friendly_url'])?$menu_ativo[0]['Sitemap']['friendly_url']:$this->params['controller'], 'action' => $filtro_ano, $key) + $this->params['named'];
						
						?>
						<div class="span1">
							<li <?php if(!empty($filtro_mes) && $key == (int)$filtro_mes)echo 'class="active"';?>>
							<?php 
							
								if($filtro_ano.'-'.$key > date('Y-m')) {
									echo $this->Html->link(substr($mes, 0, 3),'#', array('class' => 'nolink'));
								} else {
									echo $this->Html->link(substr($mes, 0, 3), $url);
								}
							?>
							</div>
						</li>
					<?php
					}
				?>
				</ul>
			</div>
		</div>
	</div>

</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() {

	$('div.select select').change(function(){
 		$(this).prev().text($(this).val());

 		location.href='<?php echo $this->Html->url(array('controller'=>!empty($menu_ativo[0]['Sitemap']['friendly_url'])?$menu_ativo[0]['Sitemap']['friendly_url']:$this->params['controller']));?>/'+$(this).val();
 	});

	$('div.select select').each(function() {
		$(this).prev().text($(this).val());
	
	});

});
</script>