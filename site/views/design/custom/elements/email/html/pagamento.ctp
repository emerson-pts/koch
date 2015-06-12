<div style="width:600px; height:749px;">
	<?php echo $this->Html->image(Configure::read('site.full_url').'/img/topo_pagamento.jpg'); ?>	
	<div style="height:173px;  font-family:'arial';">
	<div style="margin: 25px;">
		<span style="color:#ee6f22; font-size:12px; text-transform:uppercase; font-weight:100;">
			<br />
			<span style="color:#ee6f22; font-size:12px; text-transform:uppercase; font-weight:100;">
				<?php echo 'Prezado Sr.(a) <span style="font-weight:bold;">'.$pedido['Pedido']['Cliente']['ClienteProfile']['nome'].'</span>';?>
			</span>
			<br />
			Parabéns, seu pagamento do item :  <span style="font-weight:bold;"><?php echo $pedido['Pedido']['Produto']['nome'];?></span>
			<br />
			foi identificado com sucesso,
			<br />
			A equipe do DESCEPRECO agradece, e espera contar com você em muitas outras compras.
			<br />
			Atenciosamente,
			<br />
			<a href="http://www.descepreco.com.br/site/">WWW.DESCEPRECO.COM.BR</a>
			<br />
			<br />
			TEL: 2063-1456
			<br />
			FAX: 2914-6435
			<br />
			Rua Hipólito soares, 158 – Ipiranga - São Paulo - SP
			<br />
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