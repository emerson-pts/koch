<?php if(!empty($destino['Destino']['olho'])): ?><div class="text-align-center lead"><?php echo $destino['Destino']['olho']; ?></div><?php endif; ?>
<?php echo $destino['Destino']['descricao']; ?>
<br />
<div class="text-align-center">
	<h3>vídeo</h3><br />
	<section class="row video">
		<div class="span8 float-none margin-auto">
			<div class="flex-video widescreen"><?php 
			
				$fragment = $this->Youtube->getVideoEmbed($destino['Destino']['video'], array('width' => '100%', 'height' => 'auto',)); 
				$tidy = new tidy();
				$tidy->parseString($fragment,array('show-body-only'=>true),'utf8');
				$tidy->cleanRepair();
				echo $tidy;
				?></div>
		</div>
	</section>
</div>
<br />
<div class="sprite cross"></div>
<div class="text-align-center">
	<h3>highlights</h3><br />
	<br />
	<ul class="highlights clearfix"><?php 
		foreach(array_filter(explode("\n", $destino['Destino']['highlights'])) AS $i => $highlight):
		?>
			<li class="<?php if($i % 2 == 0){echo 'even';}else{echo 'odd';} ?>"><?php echo $highlight;?></li>
		<?php endforeach; ?>
	</ul>
</div>

<br />
<div class="sprite cross"></div>
<div class="text-align-center">
	<h3>roteiros</h3><br />
</div>
<?php echo $this->Element('destinos/_roteiros'); ?>