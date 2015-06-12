<div class="wrap wrap-vitrine">
	<div class="vitrine">
		<ul id="slider">
		<?php foreach($vitrines as $vitrine){?>
			<li>
				<!-- área para inserir texto -->
				<?php echo $this->element('vitrine/vitrine_texto'); ?>
				<!-- área para inserir texto -->
				<div class="vitrine-img">
					<a href="<?php echo !empty($vitrine['Vitrine']['url'])?$vitrine['Vitrine']['url']:'/';?>">
			    		<?php
							echo $this->Html->image(
								array('controller'=>'thumbs','?'=>array('src'=> '/'.$vitrine['Vitrine']['imagem'],'size'=>'853*352','crop'=>'853x352')),
								array("alt" => $vitrine['Vitrine']['titulo'],'width'=>'853','height'=>'352',)
							);	
						?>
					</a>
				</div>
			</li>
		<?php
	    	}
		?>
		</ul>
	</div>
	<p class="vitrine-prev"><a href="" id="vitrine-prev"></a></p>
	<p class="vitrine-next"><a href="" id="vitrine-next"></a></p>
</div>
<br class="clear" />

<script type="text/javascript">
jQuery(function(){
  var slider = jQuery('#slider').bxSlider({
    controls: false,
	auto: true,
	pause: 7000,
	autoHover: true,
	pager: true
  });
  jQuery('#vitrine-prev').click(function(){
    slider.goToPreviousSlide();
    return false;
  });
  jQuery('#vitrine-next').click(function(){
   slider.goToNextSlide();
    return false;
  });
});
</script>
	