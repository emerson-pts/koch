<?php	//Validacao de Next e Prev 
if($prev_next_noticia['prev'] == '') {
	echo ''; 
} else {
?>
<!-- btn prev --> 
<a href="<?php echo $this->Html->url('/'.dirname(dirname(dirname($this->params['originalArgs']['params']['url']['url']))).$prev_next_noticia['prev']['Noticia']['link']); ?>">
	<div class="aba-volta-noticia">
		<div class="seta-volta-conto"></div>
		<div class="txt-aba">
			<div class="limita-txt-aba">
				<span class="date">
					<?php echo $prev_next_noticia['prev']['Noticia']['data_noticia_dia'].' de '.$noticia['Noticia']['data_noticia_mes']; ?>
				</span>
				<h3><?php echo $prev_next_noticia['prev']['Noticia']['titulo']; ?></h3>
			</div><!-- limita-txt-aba -->
		</div>
	</div>
</a>
<!-- btn prev -->
<?php } 
//Fim Validacao prev 
if($prev_next_noticia['next'] == '') {
	echo '';
} else {
?>
<!-- btn next --> 
<a href="<?php echo $this->Html->url('/'.dirname(dirname(dirname($this->params['originalArgs']['params']['url']['url']))).$prev_next_noticia['next']['Noticia']['link']); ?>">
	<div class="aba-ir-noticia">
		<div class="seta-ir-conto"></div>
		<div class="txt-aba-ir">
			<div class="limita-txt-aba-ir">
				<span class="date">
					<?php echo $prev_next_noticia['prev']['Noticia']['data_noticia_dia'].' de '.$noticia['Noticia']['data_noticia_mes']; ?>
				</span>
				<h3><?php echo $prev_next_noticia['next']['Noticia']['titulo']; ?></h3>
			</div><!-- limita-txt-aba -->
		</div>
	</div>
</a>
<!-- btn next -->
<?php } 
//Fim Validacao Next ?>