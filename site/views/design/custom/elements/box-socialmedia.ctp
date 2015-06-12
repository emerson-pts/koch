<div class="box-social-media">
	<div class="legend">Redes Sociais</div>
	<div class="social-media-icons">
		<?php foreach(Configure::read('SocialMedia') AS $key => $value):
			if(is_array($value)){
				$key = key($value);
				$value = current($value);
			}
		?>
			<a href="<?php echo $value; ?>" target="_blank" class="sprite social-media <?php echo $key;?>"><?php echo $key;?><span></span></a>
		<?php endforeach;?>
	</div>
</div>