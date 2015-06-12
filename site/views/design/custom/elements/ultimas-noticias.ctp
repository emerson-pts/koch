<div class="ultimas-noticias">
	<div class="barra-cinza"><h2 class="dentro-barra">Últimas noticias</h2></div>
	<?php
	//Verifica se tem notícias recentes
	if(!empty($noticias_recentes)){
		//Pega a primeira notícia
		$noticias = $noticias_recentes[0];					
		?>
			<?php echo $this->Html->div('img',
			$this->Html->image(
				array('controller'=>'thumbs','?'=>array('src'=>'/'.$noticias['Noticia']['image'],'size'=>'138*90', "crop" => "138x90",)),
				array('url'=>!empty($noticias['Noticia']['link'])?$noticias['Noticia']['link']:false, "border" => "0",  "style" => "float:left")
			)
		);?>
			<h4 style=""><?php echo $noticias['Noticia']['titulo']; ?></h4>
			<p style=""><?php echo $noticias['Noticia']['conteudo_preview']; ?>
			<!--<a href="#" style="color:#a180a0;text-decoration:none;font-weight:bold;">(Veja mais)</a>--><br />
			<?php echo $this->Html->link("(Veja mais)",$noticias['Noticia']['link'],array('style'=>'color:#a180a0;text-decoration:none;font-weight:bold;'));?>
			</p>
			<br />
			<div class="separador-noticias"></div>		
		<?php
		//Looping da segunda notícia até a última
		foreach(array_slice($noticias_recentes, 1) AS $key=>$noticias){
		?>
			<div class="cont-noticias">
				<?php echo $this->Html->div('img',
			$this->Html->image(
				array('controller'=>'thumbs','?'=>array('src'=>'/'.$noticias['Noticia']['image'],'size'=>'138*90', "crop" => "138x90",)),
				array('url'=>!empty($noticias['Noticia']['link'])?$noticias['Noticia']['link']:false, "border" => "0",  "style" => "float:left")
			)
		);?>
				<div class="title-noticia"><?php echo $noticias['Noticia']['titulo']; ?></div>
				<p style=""><?php echo $noticias['Noticia']['conteudo_preview']; ?><br />
				<?php echo $this->Html->link("(Veja mais)",$noticias['Noticia']['link'],array('style'=>'color:#a180a0;text-decoration:none;font-weight:bold;'));?>
			</div>
		<?php 
		}//foreach
		
	}//end if?>
	
	<a href="<?php echo $this->Html->url('/noticias');?>"><div class="btn-todas-noti"></div></a>
	<br clear="all" />
				
</div><!-- ultimas noticias -->	