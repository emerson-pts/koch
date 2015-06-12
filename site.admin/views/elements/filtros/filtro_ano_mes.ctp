<div class="filtro_ano_mes">
	<!-- Note the required class: menu-opener -->
	<div class="float-left button blue menu-opener">
		<!-- v1.5: you can now use the button as a working link -->
		<a href="javascript://"><?php echo $filtro_ano_mes['anos'][$filtro_ano_mes['ano_atual']];?></a>
		 
		<!-- This is the arrow down image -->
		<div class="menu-arrow"><?php echo $this->Html->image('menu-open-arrow.png');?></div>
		 
		<!-- Menu content -->
		<div class="menu">
			<ul>
				<?php foreach($filtro_ano_mes['anos'] AS $key=>$value): ?><li class="icon_calendar <?php 
					if(strcmp($filtro_ano_mes['ano_atual'], $key) == 0){
						echo 'active';
					}
				?>"><?php 
					echo $this->Html->link(
						$value, 
						array('ano' => $key) + $this->params['named']
					);
				?></li>
				<?php endforeach; ?>
			</ul>
		</div>
		<!-- End  of menu content -->
	</div>
	<div class="float-left" style="margin: 2px 5px 0 5px;">
		<div class="meses">
			<?php foreach($this->Formatacao->meses AS $key=>$value){
				$key = str_pad($key+1, 2, "0", STR_PAD_LEFT);
				echo $this->Html->link(
					substr($value, 0, 3),
					array('mes' => $key) + $this->params['named'],
					array('class' => 'keyword '. (strcmp($filtro_ano_mes['mes_atual'], $key) == 0 ? ' blue-keyword' : 'gray-light-keyword '))
				).' ';
				
			}
			?>
		</div>
		<?php
		echo $this->Html->link(
			'Todos',
			array('mes' => '*') + $this->params['named'],
			array('class' => 'keyword '. (strcmp($filtro_ano_mes['mes_atual'], '*') == 0 ? ' blue-keyword' : 'gray-light-keyword '))
		).' ';
	?>
	</div>
	<?php
	//Se não está exibindo todos os meses e tem filtro de dia definido	
	if(!isset($filtro_ano_mes['show_days']) || !empty($filtro_ano_mes['show_days'])):
		if(strcmp($filtro_ano_mes['ano_atual'], '*') == 0 || strcmp($filtro_ano_mes['mes_atual'], '*') == 0){
			$dias_mes_atual = 31;
		}else{
			$dias_mes_atual = cal_days_in_month(CAL_GREGORIAN, $filtro_ano_mes['mes_atual'], $filtro_ano_mes['ano_atual']);
		}
		$dias = range(1, $dias_mes_atual);
		array_walk($dias, create_function('&$val', '$val = str_pad($val, 2, "0", STR_PAD_LEFT);'));
		
		$filtro_ano_mes['dias'] = array('*' => 'Todos') + array_combine($dias, $dias);
	?>
	<div class="button blue menu-opener">
		<a href="javascript://"><?php echo $filtro_ano_mes['dias'][$filtro_ano_mes['dia_atual']];?></a>
		<!-- This is the arrow down image -->
		<div class="menu-arrow"><?php echo $this->Html->image('menu-open-arrow.png');?></div>
		<!-- Menu content -->
		<div class="menu">
			<ul style="height: 215px; overflow: auto;">
				<?php foreach($filtro_ano_mes['dias'] AS $key=>$value): ?><li class="icon_calendar <?php 
					if(strcmp($filtro_ano_mes['dia_atual'], $key) == 0){
						echo 'active';
					}
				?>"><?php 
					echo $this->Html->link(
						$value, 
						array('dia' => $key) + $this->params['named']
					);
				?></li>
				<?php endforeach; ?>
			</ul>
		</div>
		<!-- End  of menu content -->
	</div>
	<?php echo $this->Html->link(__('Hoje', true), array('ano' => date('Y'), 'mes' => date('m'), 'dia' => date('d')) + $this->params['named'], array('escape' => false, 'title' => 'Hoje', 'class' => 'with-tip today'));?>
	<?php endif; ?>
</div>
