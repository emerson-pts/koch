<div class="container">
	<cake:nocache><?php echo $this->Session->flash('form'); ?></cake:nocache>
	<?php echo $this->Form->create('FormContato', array('name'=>'contato','url' => (isset($this->params['originalArgs']['params']['url']['url']) ? '/'.$this->params['originalArgs']['params']['url']['url'] : null))); ?>

	<div class="row-fluid">

		<div class="span12">
			<?php
				foreach($banners as $key=> $banner):
					echo $this->Image->thumbImage(
						array(
							'src'	=> $banner['Banner']['imagem'],
							'size'	=> 'w1928',
							#'crop'	=> '380x239',
						),
						array("alt" => $banner['Banner']['titulo'], "class" => 'banner')
					);
				endforeach;
			?>
		</div>

	</div>

	<div class="row-fluid texto-contato">

		<div class="span12 escritorios">
			<h2><span>•</span>Escritórios</h2><br />
			<p><?php echo Configure::read('texto.escritorios'); ?></p>
		</div>

		<div class="clear"></div>

		<div class="span12 operacoes">
			<h2><span>•</span>Operações</h2><br />
			<p><?php echo Configure::read('texto.operacoes'); ?></p>
		</div>
		
	</div>


	<div class="row-fluid">

		<div class="span12">
			<div class="maps" itemprop="location">
				<?php echo Configure::read('mapa'); ?>
			</div>
		</div>

	</div>

	<div class="clear"></div><br />

	<div class="row-fluid">

		<div class="span12">
			<p class="address"><?php echo Configure::read('Company.address.contact'); ?></p>
		</div>

	</div>

</div>

<div class="container">
	<div class="row-fluid">
		<div class="span12">
			<hr />
		</div>
	</div>
</div>