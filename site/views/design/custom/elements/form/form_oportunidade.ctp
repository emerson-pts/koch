<div class="container">

	<cake:nocache><?php echo $this->Session->flash('form'); ?></cake:nocache>

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

	<div class="clear"></div><br />

	<div class="row-fluid oportunidades">

		<div class="span6">
			<?php echo $this->Form->create('FormOportunidade', array('name'=>'FormOportunidade', 'type' => 'file', 'url' => (isset($this->params['originalArgs']['params']['url']['url']) ? '/'.$this->params['originalArgs']['params']['url']['url'] : null))); ?>

			<h2>Preencha os dados</h2>

			<div class="row-fluid">
				<div class="span12">
					<?php echo $this->Form->input("nome",array(
						"maxlength" => "100",
						"placeholder" => "Nome Completo",
						"label" => false,
					)); ?>
				</div>
			</div>

			<div class="row-fluid">
				<div class="span12">
					<?php echo $this->Form->input("email",array(
						"maxlength" => "100",
						"placeholder" => "Email",
						"label" => false,
					)); ?>
				</div>
			</div>

			<div class="row-fluid">
				<div class="span12">
					<?php echo $this->Form->input("telefone",array(
						"maxlength" => "100",
						'class'=>'telMask',
						"placeholder" => "Telefone",
						"label" => false,
					)); ?>
				</div>
			</div>			

			<div class="row-fluid">
				<div class="span12">
					<div class="styled-select">

						<?php

							$options_assuntos = explode(PHP_EOL,Configure::read('assuntos.form.oportunidade'));
							foreach($options_assuntos as $key => $options_assunto):
								$options_assuntos[$key] = trim($options_assunto);
								if(empty($options_assuntos[$key])):
									unset($options_assuntos[$key]);
								endif;
							endforeach;
							$options_assuntos = array_combine($options_assuntos, $options_assuntos);

							echo $this->Form->input('assunto', array('type' => 'select', 'class' => 'selectpicker', 'options' => $options_assuntos, 'empty' => 'Assunto', 'div' => false, 'label' => false));
						?>
					</div>
				</div>
			</div>

			<div class="row-fluid">
				<div class="span12">
					<?php echo $this->Form->input("mensagem",array(
						"maxlength" => "500",
						'class'=>'input-mensagem-consulte',
						'type' => 'textarea',
						"placeholder" => "Mensagem",
						"label" => false,
					)); ?>
				</div>
			</div>

			<div class="row-fluid">
				<div class="span12">
					<?php echo $this->Form->input("arquivo",array(
						'type' 	=> 'file',
						'label' => false,
						'select' => 'faça o upload do seu curriculum',
						'selected' => 'Arquivo selecionado',
					));
					?>
				</div>
			</div>

			<div class="row-fluid">
				<div class="span12">
					<div class="btn-oportunidades">
					<span class="btn-custom">+</span>
						<?php echo $this->Form->submit('enviar',array(
							'class' => '',
						));
						?>
					</div>
				</div>
			</div>

			<?php echo $this->Form->end(); ?>

		</div>

		<hr class="visible-phone" />

		<div class="span6 titulo">

			<h2 style="float:left; margin-right:10px;">Oportunidades</h2>

			<div class="arrows" style="float:left !important;">

				<a id="prev_op" class="prev" href="javascript:;">
					<span></span>
				</a>
				<a id="next_op" class="next" href="javascript:;">
					<span></span>
				</a>
			</div>

			<div class="clear"></div>

			<div class="list_carousel home responsive">
				<ul id="slide_oportunidades">
					<?php
					foreach ($oportunidades AS $key => $oportunidade): ?>
					<li>
						<div class="slide">
							<strong><?php echo $oportunidade['Oportunidade']['titulo'];?></strong>
							<p><?php echo $oportunidade['Oportunidade']['descricao'];?></p>
						</div>
					</li>
					<? endforeach; ?>
				</ul>
			</div>

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

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() {

	jQuery('#slide_oportunidades').carouFredSel({
		responsive: true,
		//visibleItems:3,
		width: 580,
		height: 280,
		scroll: 2,
		prev: '#prev_op',
		next: '#next_op',
		auto: false,
		items: {
			width: 580,
			height: 130,
			visible: {
				min: 2,
				max: 4
			}
		},
		mousewheel: true,
		swipe: {
			onMouse: true,
			onTouch: true
		}
	});									

});
</script>