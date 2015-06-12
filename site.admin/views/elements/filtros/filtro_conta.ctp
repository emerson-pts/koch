<?php
//Define o label do filtro atual

//Se é numérico
if(empty($filtro_conta['conta_atual']) || $filtro_conta['conta_atual'] == '*'){
	$label = 'Todas contas';
}
//Filtro por tipo de conta
else if(!is_numeric($filtro_conta['conta_atual'])){
	$label =  $conta_tipos[$filtro_conta['conta_atual']].' - Todas';
}
//Filtro por conta
else if($r = Set::filter(Set::classicExtract($filtro_conta['contas'], '{s}.'.$filtro_conta['conta_atual']))){
	$r = current($r);
	$label = /*$conta_tipos[$r['conta_tipo']].' - '.*/$r['nome'];
}
else{
	$label = 'Contas';
}
?>
<!-- Note the required class: menu-opener -->
<div class="float-left button blue menu-opener">
	<!-- v1.5: you can now use the button as a working link -->
	<a href="javascript://"><?php echo $label;?></a>
	 
	<!-- This is the arrow down image -->
	<div class="menu-arrow"><?php echo $this->Html->image('menu-open-arrow.png');?></div>
	 
	<!-- Menu content -->
	<div class="menu">
		<ul>
			<?php foreach($filtro_conta['contas'] AS $tipo_conta=>$contas): ?><li class="icon_cards <?php 
				if(strcmp($filtro_conta['conta_atual'], $tipo_conta) == 0){
					echo 'active';
				}
				?>"><?php 
					echo $this->Html->link(
						$conta_tipos[$tipo_conta], 
						array('conta_id' => $tipo_conta)
					);
				?><ul>
				<li class="icon_cards <?php 
				if(strcmp($filtro_conta['conta_atual'], $tipo_conta) == 0){
					echo 'active';
				}
				?>"><?php 
					echo $this->Html->link(
						'Todas', 
						array('conta_id' => $tipo_conta)
					);
				?>
				<?php foreach($contas AS $key=>$value): ?><li class="icon_cards <?php 
					if(strcmp($filtro_conta['conta_atual'], $key) == 0){
						echo 'active';
					}
					?>"><?php 
						echo $this->Html->link(
							$value['nome'], 
							array('conta_id' => $key)
						);
					?></li>
				<?php endforeach; ?>
			</ul></li>
			<?php endforeach; ?>
		</ul>
	</div>
	<!-- End  of menu content -->
</div>
<?php
//$tipo_conta => 'Todas<span class="saldo">'.$this->Formatacao->moeda(array_sum(Set::extract($contas, '{n}.saldo_previsto'))).'</span>',
