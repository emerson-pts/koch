<a id="archor"></a>
<div id="title-bar" class="no-padding">
	<div class="container modalidade">
		<div class="row-fluid">
			<div class="span12">
				<div class="img-modalidade" style="height: 270px; overflow:hidden; ">
					<?php
						echo $this->Image->thumbImage(
							array(
								'src' 	=> $area['Area']['image'],
								'size'	=> '1180*634',
								//'crop'	=> '1160*200',
								//'crop_pos' => 'center top',
							)
						);

						if(!empty($area['Area']['image'])):
					?>
					<a href="javascript:;" class="down" title="Clique para abrir a imagem completa"></a>
					<a href="javascript:;" class="up" title="Clique para fechar a imagem"></a>
					<? endif; ?>
				</div>				
			</div>
		</div>
	</div>
</div>

<div class="container area">

		<div class="row-fluid">

			<div class="span12">
				<h2 class="subtitulo"><?php echo $area['Area']['conteudo']; ?></h2>
			</div>

		</div>

		<div class="row-fluid area-texto">
			<?php
			foreach ($textos AS $key => $texto): ?>

			<?php if(count($textos) == 1) {
				?>
			<div class="span12">

				<a href="<?php echo $this->Html->url('/textos/'.$texto['Texto']['friendly_url']);?>">
					<?php
						echo $this->Image->thumbImage(
							array(
								'src' 	=> $texto['Texto']['image'],
								'size'=>'1180x269'
								//'crop'	=> '1160*200',
								//'crop_pos' => 'center top',
							)
						);
					?>
				</a>

			<? } // span12
			if(count($textos) == 2) { ?>
			<div class="span6">

				<a href="<?php echo $this->Html->url('/textos/'.$texto['Texto']['friendly_url']);?>">
					<?php
						echo $this->Image->thumbImage(
							array(
								'src' 	=> $texto['Texto']['image'],
								'size'	=> '580*330',
								//'crop'	=> '1160*200',
								//'crop_pos' => 'center top',
							)
						);
					?>
				</a>

			<? } //span6

			if(count($textos) == 3) { ?>
			<div class="span4">

				<a href="<?php echo $this->Html->url('/textos/'.$texto['Texto']['friendly_url']);?>">
					<?php
						echo $this->Image->thumbImage(
							array(
								'src' 	=> $texto['Texto']['image'],
								'size'	=> '389*228',
								//'crop'	=> '1160*200',
								//'crop_pos' => 'center top',
							)
						);
					?>
				</a>

			<? } // span4 ?>

				<br />

				<div class="title"><strong><?php echo $texto['Texto']['titulo'];?></strong></div>
				<p><?php echo $texto['Texto']['descricao_preview'];?></p>
			</div>

			<? endforeach; ?>

		</div>

		<? if(count($eventos)>0): ?>
			<div class="row-fluid area">
				<div class="span12">
					<h2>Principais eventos</h2>
				</div>
			</div>
		<? endif; ?>

		<?php
			foreach ($eventos AS $key => $evento): ?>
			<div class="row-fluid area-texto">

				<div class="span4 img">
					<?php
						echo $this->Image->thumbImage(
							array(
								'src' 	=> $evento['Evento']['image_chamada'],
								'size'	=> '389*228',
								//'crop'	=> '1160*200',
								//'crop_pos' => 'center top',
							)
						);
					?>
					<?php
					#if(!empty($evento['Evento']['link'])):
						if($evento['Evento']['tipo'] == 'evento') { //se é evento ou é evento proprietario
					?>
						<a target="_blank" href="<?php echo $evento['Evento']['link']; ?>">
							<div class="btn-evento">
								<span class="btn-custom">+</span>
								<span class="link">acesse o site do evento</span>
							</div>
						</a>
					<? }
					if($evento['Evento']['tipo'] == 'proprietario') { ?>
						<a target="_blank" href="<?php echo $this->Html->url('/eventos/'.$evento['Evento']['friendly_url']); ?>">
							<div class="btn-evento">
								<span class="btn-custom">+</span>
								<span class="link">acesse à página do evento</span>
							</div>
						</a>
					<? }

					if($evento['Case']['id']>0):
					?>
						<a target="_blank" href="<?php echo $this->Html->url('/cases/'.$evento['Case']['friendly_url']); ?>">
							<div class="btn-evento">
								<span class="btn-custom">+</span>
								<span class="link">conferir o case</span>
							</div>
						</a>
					<? endif; ?>
				</div>

				<div class="span8">
					<strong><?php echo $evento['Evento']['titulo'];?></strong>
					<p><?php echo $evento['Evento']['conteudo'];?></p>
				</div>
			</div>

			<br />

		<? endforeach; ?>

		<? if(count($atletas)>0): ?>
			<div class="row-fluid area">
				<div class="span12">
					<h2>Atletas</h2>
				</div>
			</div>
		<? endif; ?>

		<?php
			foreach ($atletas AS $key => $evento): ?>
			<div class="row-fluid area-texto">

				<div class="span4">
					<?php
						echo $this->Image->thumbImage(
							array(
								'src' 	=> $evento['Evento']['image'],
								'size'	=> '389*228',
								//'crop'	=> '1160*200',
								//'crop_pos' => 'center top',
							)
						);
					?>
					<a target="_blank" href="<?php echo $evento['Evento']['link']; ?>">
						<div class="btn-evento">
							<span class="btn-custom">+</span>
							<span class="link">acesse o site do atleta</span>
						</div>
					</a>
				</div>

				<div class="span8">
					<strong><?php echo $evento['Evento']['titulo'];?></strong>
					<p><?php echo $evento['Evento']['conteudo'];?></p>

				</div>
			</div>

			<br />

		<? endforeach; ?>

	</div>

</div>

<div class="container">
	<div class="row-fluid">
		<hr />
	</div>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() {

	jQuery('#slide_modalidade').carouFredSel({
		responsive: true,
		width: 1700,
		scroll: 1,
		prev: '#prev_mod',
		next: '#next_mod',
		auto: false,
		items: {
			width: 780,
		//	height: '30%',	//	optionally resize item-height
			visible: {
				min: 1,
				max: 1
			}
		},
	});

	jQuery('#slide_modalidade_texto').carouFredSel({
		responsive: true,
		width: 325,
		scroll: 1,
		auto: false,
		prev: '#prev_mod_text',
		next: '#next_mod_text',
		items: {
			width: 325,
		//	height: '30%',	//	optionally resize item-height
			visible: {
				min: 1,
				max: 1
			}
		},
	});

	jQuery('#prev_mod').click(function(e){
		e.preventDefault();
		jQuery('#prev_mod_text').trigger('click');
	});

	jQuery('#next_mod').click(function(e){
		e.preventDefault();
		jQuery('#next_mod_text').trigger('click');
	});

	jQuery('#prev_mod, #next_mod').css('margin-top',jQuery('#slide_modalidade li:first').height()-210+'px');

	jQuery('#slide_galeria').carouFredSel({
		responsive: true,
		width: 1700,
		scroll: 1,
		prev: '#prev_mod_gal',
		next: '#next_mod_gal',
		auto: false,
		items: {
			width: 780,
		//	height: '30%',	//	optionally resize item-height
			visible: {
				min: 1,
				max: 1
			}
		},
	});

	jQuery('#slide_galeria_texto').carouFredSel({
		responsive: true,
		width: 325,
		scroll: 1,
		auto: false,
		prev: '#prev_gal_text',
		next: '#next_gal_text',
		items: {
			width: 325,
		//	height: '30%',	//	optionally resize item-height
			visible: {
				min: 1,
				max: 1
			}
		},
	});

	jQuery('#prev_gal').click(function(e){
		e.preventDefault();
		jQuery('#prev_gal_text').trigger('click');
	});

	jQuery('#next_gal').click(function(e){
		e.preventDefault();
		jQuery('#next_gal_text').trigger('click');
	});

	jQuery('#prev_gal, #next_gal').css('margin-top',jQuery('#slide_galeria li:first').height()-100+'px');

	$(".img-modalidade a.down").on('click',function(){
		$(this).hide();
		$('a.up').show();

		<? if(count($textos) == 1) { ?>
			$(".img-modalidade").css('height', '585px');
		<? } else if(count($textos) == 2) { ?>
			$(".img-modalidade").css('height', '635px');
		<? } else if(count($textos) == 3) { ?>
			$(".img-modalidade").css('height', '545px');
		<? } ?>

     	$(".img-modalidade").css('position', 'absolute');
    	$(".img-modalidade").css('z-index', '999');
	    $('#title-bar').css('height', '270px');

	    //console.log($('a#archor'));

	    $('html,body').animate({scrollTop: 180 }, 1000,'swing');

	});

	$(".img-modalidade a.up").on('click',function(){
		$(this).hide();
		$('a.down').show();

		$(".img-modalidade").css('height', '270px');

		//$(".img-modalidade a.down").css('bottom', '5px');
	});

});
</script>