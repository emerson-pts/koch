<div style="width:600px; height:749px;">
	<?php echo $this->Html->image(Configure::read('site.full_url').'/img/topo_email3.jpg'); ?>	
	<div style="height:173px; font-family:'arial';">
	<div style="margin: 25px;">
		<br />
		<span style="color:#ee6f22; font-size:12px; text-transform:uppercase; font-weight:100;">
			<?php echo 'Prezado Sr.(a) <span style="font-weight:bold;">'.$pedido['Cliente']['ClienteProfile']['nome'].'</span>';?>
		<br />
		<br />
		Parabéns 
		<br />
		<br />
		<?php echo 'Sua oferta para o Item :  <span style="font-weight:bold;">'.$pedido['Produto']['nome'].'</span>'; ?>
		<br />
		No valor de R$ <span style="font-weight:bold;"><?php echo number_format($pedido['Produto']['ProdutoPreco']['preco'], 2, ',', '.');?></span>
		<br />
		<?php echo 'código do item:  <span style="font-weight:bold;">'.$pedido['Produto']['ProdutoInfo']['codigo'].'</span> , foi a vencedora!'; ?>
		<br />
		<br />
		Agora, é só escolher a forma de pagamento no link PAGSEGURO.
		<br />
		Se você  precisar de transporte para sua compra, sugerimos entrar em contato com a transportadora  TRANSPORTAQUI, 
		<br />
		(nossa parceira nesta área),  que terá grande prazer em atende-lo nos seguintes telefones:  (11)2063-1456 e (11)2506-6448 
		<br />
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