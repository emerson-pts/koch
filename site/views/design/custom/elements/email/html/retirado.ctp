<div style="width:600px; height:749px;">
	<?php echo $this->Html->image(Configure::read('site.full_url').'/img/topo_email2.jpg'); ?>	
	<div style="height:173px;">
	<div style="margin: 25px; text-align:center;">
 		<?php echo $this->Html->image(Configure::read('site.full_url').'/img/icon-green.png', array('style' => 'float:left;')); ?>	
		<span style="font-size:15px; color:#f99511; font-weight:bold; margin-top:10px;">
			Produto <?php echo $cliente['Produto']['nome'];?> já foi retirado. obrigado.
		</span>
	</div>
	</div>
	<a href="<?php echo Configure::read('site.full_url').'/servicos/cliente'; ?>">
		<?php echo $this->Html->image(Configure::read('site.full_url').'/img/minha_conta_email.jpg', array('style' => 'float:left;')); ?>	
	</a>
	<a href="<?php echo Configure::read('site.full_url'); ?>">
		<?php echo $this->Html->image(Configure::read('site.full_url').'/img/site_email.jpg', array('style' => 'float:right;')); ?>
	</a>
	<a href="<?php echo Configure::read('site.facebook'); ?>">	
		<?php echo $this->Html->image(Configure::read('site.full_url').'/img/face_email.jpg', array('style' => 'margin-left:130px;')); ?>	
	</a>
	<?php echo $this->Html->image(Configure::read('site.full_url').'/img/footer_email.jpg'); ?>	
</div>