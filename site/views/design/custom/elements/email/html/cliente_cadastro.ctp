<div style="width:600px; height:749px;">
	<?php echo $this->Html->image(Configure::read('site.full_url').'/img/topo_email.jpg', array('alt' => 'Parabéns você foi cadastrado')); ?>	
	<div style="height:173px; width:510px; margin-left:60px;  font-family:'arial';">
 		<center><span style="color:#ee6f22; font-size:16px; text-transform:uppercase; font-weight:bold;">Parabéns,  seu cadastro foi efetuado com sucesso!</span></center>
		<br />
		<span style="color:#ee6f22; font-size:12px; text-transform:uppercase; font-weight:100;">
		<!--
		Segue abaixo suas informações de acesso:
		<br />
		LOGUIN: nbnbnbnbn
		<br />
		SENHA: fmfmfmfmfmf
		-->
		<br />
		AVISO IMPORTANTE:  Para participar de nosso site online fazendo ofertas de compra, é necessário 
		fazer sua habilitação em todos os itens que tiver interesse. 
	    Para isso acesse o Lote e escolha o item de sua preferência em nosso site, e faça sua habilitação.
	    Quem não se habilitar não poderá participar das ofertas de compra.   
		<br />
		OBS : Verifique se seu computador possui os requisitos técnicos mínimos necessário para participar de nossas ofertas de compras online.
		<br />
		<br />
		<a href="http://www.speedtest.net/" target="_blank">CLIQUE AQUI E FAÇA O TESTE DE CONEXÃO.</a>
		<br />
		<br />
		<a href="http://www.descepreco.com.br/site/">WWW.DESCEPRECO.COM.BR</a>
		<br />
		<br />
		TEL: 2063-1456
		<br />
		FAX: 2914-6435
		<br />
		Rua Hipólito soares, 158 – Ipiranga - São Paulo - SP
		</span>
		<br />
		<br />
	</div>
	<a href="<?php echo Configure::read('site.full_url').'/servicos/cliente'; ?>">
		<?php echo $this->Html->image(Configure::read('site.full_url').'/img/minha_conta_email.jpg', array('alt' => 'Parabéns você foi cadastrado','style' => 'float:left;')); ?>	
	</a>
	<a href="<?php echo Configure::read('site.full_url'); ?>">
		<?php echo $this->Html->image(Configure::read('site.full_url').'/img/site_email.jpg', array('alt' => 'Parabéns você foi cadastrado','style' => 'float:right;')); ?>
	</a>
	<a href="<?php echo Configure::read('site.facebook'); ?>">	
		<?php echo $this->Html->image(Configure::read('site.full_url').'/img/face_email.jpg', array('alt' => 'Parabéns você foi cadastrado','style' => 'margin-left:130px;')); ?>	
	</a>
	<?php echo $this->Html->image(Configure::read('site.full_url').'/img/footer_email.jpg', array('alt' => 'Parabéns você foi cadastrado')); ?>	
</div>

