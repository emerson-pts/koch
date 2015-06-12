<?php echo $this->Element('vitrine/vitrine', array('vitrines' => $vitrines)) ?>

<div class="container home">
	<div class="row-fluid">
		<div class="somos-home">

			<div class="span4">
				<h2>SOMOS</h2>
				<span class="titulo">KOCH<span>TAVARES</span></span>

				<div class="pull-right">

					<a id="prev1" class="prev" href="#">
						<span></span>
					</a>
					<a id="next1" class="next" href="#">
						<span></span>
					</a>
				</div>
			</div>

			<div class="span8">
				<div class="list_carousel home responsive">
					<ul id="slide1">
						<?php foreach ($areas AS $key => $area): 
						$color = ($key % 2 === 0) ? '' : 'nobg';
						?>
							<li>
								<a href="<?php echo $this->Html->url('/koch-tavares/areas-de-atuacao/'.$area['Area']['friendly_url']); ?>">
								<div class="slide <?php echo $color; ?>">
									<h3><?php echo $area['Area']['titulo']; ?></h3>
									<p><?php echo $area['Area']['conteudo_preview']; ?></p>
								</div>
								</a>
							</li>
						<? endforeach; ?>
					</ul>
					<div class="clear"></div>
				</div>
			</div>

		</div>
	</div>
</div>
<div class="clear"></div>
<div class="redes-sociais-home">

	<div class="container">
		<div class="redes-sociais">

			<div class="span4">
				<h2>Redes</h2>
				<span>Sociais</span>
			</div>
		</div>
		<div class="span1">
			<a href="javascript:;" title="Curtir"></a>
			<div class="fb-like-bt">
			<iframe src="https://www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fkochtavares%3Ffref%3Dts&width=110&layout=button_count&action=like&show_faces=true&share=false&height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:110px; height:21px;" allowTransparency="true"></iframe>

			</div>
		</div>
		<div class="span1">
			<a target="_blank" href="<?php echo Configure::read('rede.social.facebook'); ?>" title="Facebook"></a>
			<p>facebook</p>
		</div>
		<div class="span1">
			<a target="_blank" href="<?php echo Configure::read('rede.social.twitter'); ?>" title="Twitter"></a>
			<p>twitter</p>
		</div>
		<div class="span1">
			<a target="_blank" href="<?php echo Configure::read('rede.social.instagram'); ?>" title="Instagram"></a>
			<p>instagram</p>
		</div>
		<div class="span1">
			<a target="_blank" href="<?php echo Configure::read('rede.social.pinterest'); ?>" title="Pinterest"></a>
			<p>pinterest</p>
		</div>
		<div class="span1">
			<a target="_blank" href="<?php echo Configure::read('rede.social.youtube'); ?>" title="Youtube"></a>
			<p>youtube</p>
		</div>
		<div class="span1">
			<a href="mailto:<?php echo Configure::read('contato.email'); ?>" title="Email"></a>
			<p>e_mail</p>
		</div>
	</div>
</div>
<div class="clear"></div>
<div class="ultimas-noticias-home active-index1">
	<div class="container">

		<div class="span4">
			<h2>últimas<span>notícias</span></h2>
		</div>

		<div class="span8">

			<ul id="ticker01">
			<?php
				foreach ($noticias AS $key => $noticia): ?>
				<li>
					<a href="<?php echo '.'.$noticia['Noticia']['link']; ?>">
						<h2><?php echo substr($noticia['Noticia']['titulo'],0,10).'...'; ?> <p><?php if(!empty($noticia['Noticia']['conteudo_preview'])) echo substr($noticia['Noticia']['conteudo_preview'],0,50).'...'; ?></p></h2>
						
					</a>
				</li>
				<? endforeach; ?>
			</ul>

		</div>

	</div>
</div>

<div class="clear"></div>

<div class="highlights">

	<div class="container">

		<div class="row-fluid">

			<div class="span4">
				<h2>HIGH</h2>
				<span class="titulo">LIGHTS</span>

				<div class="pull-right">
					<a id="prev2" class="prev" href="#">
						<span></span>
					</a>
					<a id="next2" class="next" href="#">
						<span></span>
					</a>
				</div>
			</div>

			<div class="span8">
				<div class="list_carousel home responsive">
					<ul id="slide2">
						<?php
						foreach ($banners AS $key => $banner): ?>
							<li>
								<a href="<?php echo $banner['Banner']['url']; ?>">
									<div class="slide">
										<?php
											echo $this->Image->thumbImage(
												array(
													'src' 	=> $banner['Banner']['imagem'],
													'size'	=> '264*260',
													//'crop'	=> '262*262',
												),
												array('class' => 'link-overlay-highlights', )
											);
										?>
										<div class="categoria">
											<p><?php echo $banner['Banner']['categoria']; ?></p>
										</div>
										<span class="link-overlay-text">
											<p><?php #echo $banner['Banner']['titulo']; ?></p>
										</span>
									</div>
								</a>
							</li>
						<? endforeach; ?>
					</ul>
					<div class="clear"></div>
				</div>

			</div>

		</div>

	</div>
</div>

