<div class="barra-cinza"><h2>Notícias</h2></div>
	<div class="cont-box-noticias">
		<?php if(!empty($noticias_recentes)){  
			 foreach($noticias_recentes as $noticias){
		?>
		<div class="loop-box-not">
	 		<div class="img-box-not"><?php echo $this->Html->image(array('controller'=>'thumbs','?'=>array('src'=>$noticias["Noticia"]["image"],'size'=>'207*140', 'crop' => '207x140', "border" => "0")),array('escape'=>false)); ?></div>
			<div class="title-box-not"><?php echo $noticias['Noticia']['titulo']; ?></div>
			<div class="resumo-box-not"><?php echo $noticias['Noticia']['conteudo_preview']; ?></div>
			<?php echo $this->Html->link("(Veja mais)", $noticias['Noticia']['link'],array('class'=>'link-box-not'));?>
			<!--<div class="link-box-not">(Veja mais)</div>-->
			</div><!-- loop-box-prod -->
			
		<?php }// foreach
		}//if ?>
			
		
		
		
		
	
		<br clear="all" />
	</div><!-- cont-box-noticias -->

	
