<div id="title-bar">
	<div class="container">
		<div class="row-fluid">
			<div class="span6">
				<h1 class="calendario"><?php echo Configure::read('titulo.pagina.calendario'); ?></h1>
				<strong><span>koch</span>tavares</strong>
			</div>
			<div class="span6">
				<div class="div"></div>
				<p>
					<?php echo Configure::read('texto.pagina.calendario'); ?>
				</p>
			</div>
		</div>
	</div>
</div>

<!-- <br /> -->

<div class="container calendarios">

	<br />

	<div class="row-fluid botoes">
		<div class="span6">
			<a class="<? if($this->params['originalArgs']['params']['pass'][1] == 'anteriores') echo 'active'; ?>" href="<?php echo $this->Html->url('/calendario/anteriores');?>">Eventos Anteriores</a>
		</div>

		<div class="span6">
			<a class="<? if($this->params['originalArgs']['params']['pass'][1] == 'proximos' || $this->params['originalArgs']['params']['pass'][1] == '') echo 'active'; ?>" href="<?php echo $this->Html->url('/calendario/proximos');?>">Próximos Eventos</a>
		</div>
	</div>

	<br />

	<div class="row-fluid">
		<?php
		if(!empty($calendarios)) {
			$i=0;
			foreach($calendarios AS $key=> $calendario):
			$color = $i % 2 ? 'color' : '';

			if(!$mobile) {
				if($i == '0' || $i == '2' || $i == '5' || $i == '7' || $i == '8' || $i == '10' || $i == '13' || $i == '15' || $i == '16' || $i == '18' || $i == '21' || $i == '23' || $i == '26' || $i == '28' || $i == '31') { ?>
					<div class="span3 color">
				<? } else { ?>
					<div class="span3">
				<? }
			} else { ?>			
					<div class="span3 <?php echo $color; ?>">
			<? } ?>
				<div class="calendario">
					<a target="_blank" href="<?php echo $this->Html->url($calendario['Calendario']['link']); ?>">
						<span class="link-overlay-text">
							<? /*?><div>saiba mais</div><? */?>
						</span>
						<h3>
							<br />
							<?php
							if(!$calendario['Calendario']['data_fim']): ?>

								<div class="min-height">
									<span class="data">
										<?php echo $calendario['Calendario']['data_dia']; ?>
									</span>
									<br />
									<span class="ext-mes"><?php echo $calendario['Calendario']['data_mes_ex']; ?></span><span class="ext-ano"><?php echo $calendario['Calendario']['data_ano']; ?></span>

									<?php if(!empty($calendario['Calendario']['hora'])): ?>
										<span class="hora"><?php echo $calendario['Calendario']['hora']; ?></span>
									<? endif; ?>

								</div>

								<?php echo nl2br($calendario['Calendario']['titulo']); ?>

							<?php endif; ?>

							<?php
							if(!empty($calendario['Calendario']['data_fim'])): 

								if($calendario['Calendario']['data'] != $calendario['Calendario']['data_fim']):
									if($calendario['Calendario']['data_mes'] == $calendario['Calendario']['data_fim_mes']) { ?>

										<div class="mes_igual">

											<div class="min-height">
												<span class="data"><?php echo $calendario['Calendario']['data_dia'] ?></span>
												<span class="interval">A</span>

												<span class="data"><?php echo $calendario['Calendario']['data_fim_dia']; ?></span>
												<span class="ext-mes"><?php echo substr($calendario['Calendario']['data_fim_mes_ex'],0,3); ?></span><span class="ext-ano"><?php echo $calendario['Calendario']['data_fim_ano']; ?></span>
											</div>											

											<?php echo nl2br($calendario['Calendario']['titulo']); ?>
										</div>

									<? } else { //if mes inicial for diferente do mes final ?>

										<div class="mes_diferente">

											<div class="min-height">

												<span class="data<?php if(!empty($calendario['Calendario']['data_fim'])) { echo ' width-auto'; } ?>"><?php echo $calendario['Calendario']['data_dia'] ?></span>
												<span class="ext-mes"><?php echo substr($calendario['Calendario']['data_mes_ex'],0,3)?></span><span class="ext-ano"><?php echo $calendario['Calendario']['data_ano'] ?></span>

												<span class="interval">A</span><br />

												<span class="data"><?php echo $calendario['Calendario']['data_fim_dia']; ?></span>
												<span class="ext-mes"><?php echo substr($calendario['Calendario']['data_fim_mes_ex'],0,3); ?></span><span class="ext-ano"><?php echo $calendario['Calendario']['data_fim_ano']; ?></span>
											</div>

											<?php echo nl2br($calendario['Calendario']['titulo']); ?>

										</div>

									<? } ?>

								<? endif; //if data inicial for diferente da data final ?>
							<? endif; //if tem data final ?>
							
						</h3>
					</a> 
				</div>

			</div>

			<?
			$i++;
			endforeach; 
		} else {
			echo '<br /><div class="span12"><h2>Não foi encontrado eventos</h2></div>';
		}
		?>

	</div>

</div>


<? /* ?>

<div class="container">
	<div class="wrap-noticias">
    	
		<div style="margin:10px 0 0 0">
    	<?php
		
		//FILTRO
		echo $this->Element('noticias/filtro_ultimas');

	
	
	if(!empty($calendarios)){
		//DESTAQUE
		$destaque=current(Set::extract('/Calendario[destaque=1]/.[:first]',$calendarios));
		if(!empty($destaque)){
			//$destaque['titulo'];
			//$destaque['descricao'];
			//exit();
			echo '<div id="destaque">';
				?><span class="txt11">Dica do m&ecirc;s &bull; <?php echo $destaque['titulo'];?></span><?php
				?><span class="txt_padrao"><?php echo $destaque['descricao'];?></span><?php
			echo '</div>';
		
		}
		echo '<div class="clear"></div>';
		
		?><ul id="calendario"><?php 
		//Eventos do calendario
		
		$dia="";
		foreach($calendarios AS $key=>$calendario){
			$class = '';
			
			if($calendario['Calendario']['feriado'] == 1)$class = 'feriado';
				
				echo '<li'.(!empty($class)?' class="'.$class.'"':'').' id="evento_'.$calendario['Calendario']['id'].'">';
				
				
					
					//IMAGE
					if(!empty($calendario['Calendario']['image'])){
						echo $this->Html->link( 
							$this->Html->image(
								array('controller'=>'thumbs','?'=>array('src'=>'img/upload/calendarios'.$calendario['Calendario']['image'],'size'=>'248*135','crop'=>'248x135')),
								array('style'=>'float:left;margin:0px 15px 15px 0px')
							),
							'/img/upload/calendarios'.$calendario['Calendario']['image'],
							array('rel'=>'prettyPhoto','escape'=>false)
						);
							
					}
					//echo $this->base.preg_replace('/\/$/', '', preg_replace('/\/?evento:[^\/]+/', '', '/'.preg_replace('/^\//','',(!empty($this->params['originalArgs']['params']['url']['url']) ? $this->params['originalArgs']['params']['url']['url'] : $this->params['url']['url'])))).'/evento:'.$key;
					//TITULO
					?><h3>

					
					<span class="data<?php if(!empty($calendario['Calendario']['data_fim'])){ echo ' width-auto';}?>"><?php echo substr($calendario['Calendario']['data'], 0, 5).(!empty($calendario['Calendario']['data_fim']) && $calendario['Calendario']['data'] != $calendario['Calendario']['data_fim'] ? ' até '.substr($calendario['Calendario']['data_fim'],0,5) : '').'</span> <span class="bullet">-</span> '.(empty($calendario['Calendario']['hora']) ? '' : '<span class="hora">'.$calendario['Calendario']['hora'].'</span> <span class="bullet">-</span> ').$calendario['Calendario']['titulo'];?>
					</h3><?php 
					
					
					
		
					<span class="calendario-tipo"><?php echo $calendario['Calendario']['tipo_formatado'];?></span>
		
					echo '<span class="txt_padrao">'.$calendario['Calendario']['descricao'].'</span>'; 
				
					echo $this->Html->div('clear',false);
					
		}
		echo '</li>'; // Fecha o ultimo calendario

		
	?></ul><?php
	
	}else{
		echo $this->Html->div('message_error clear','Não foi encontrado eventos',array('id'=>'flashMessage'));

	}

?>
	</div>
		
		
		
	</div>
	
</div>
	
<div class="clear"></div>







<? */ ?>