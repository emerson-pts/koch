<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php if(preg_match('/(ipod|iphone|ipad)/i', $_SERVER['HTTP_USER_AGENT'])){echo 'class="ios"';}?>>
<head>
<?php
	echo $this->Element('header-base');
	echo $scripts_for_layout;
?>
</head>

<body class="<?php echo strtolower(Inflector::slug($this->name, '-'));?> <?php if($mobile):?>mobile<?php else: ?>desktop<?php endif;?>">

<?php
/*if($this->name == 'Home'): ?>
	<!-- Facebook -->
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
	<!-- Facebook -->
<? endif; */ ?>

<? /*?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<? */ ?>

<header><?php echo $this->Element('menu/menu');?></header>
<?php
	#echo $this->Element('title-bar/title-bar.default');
?>
<cake:nocache>
	<?php if($session->check('Message.flash')): ?><div class="container"><?php echo $this->Session->flash(); ?></div><?php endif; ?>
</cake:nocache>
<section>
	<?php echo $content_for_layout; ?>
</section>
<?php /*if($this->name != 'Home'): ?>
	<br />
	<div class="container text-align-center">
		<span class='st_facebook_large' displayText='Facebook'></span>
		<span class='st_twitter_large' displayText='Tweet'></span>
		<span class='st_googleplus_large' displayText='Google +'></span>
		<span class='st_pinterest_large' displayText='Pinterest'></span>
		<span class='st_linkedin_large' displayText='LinkedIn'></span>
		<span class='st_delicious_large' displayText='Delicious'></span>
		<span class='st_email_large' displayText='Email'></span>
		<span class='st_sharethis_large' displayText='ShareThis'></span>
	</div>
<?php endif; */ ?>
<div class="container">
	<?php #echo $this->Element('box-newsletter'); ?>
	<?php #echo $this->Element('box-socialmedia'); ?>
</div>
<a class="scrollup" href="#"></a>
<?php echo $this->Element('footer/footer'); ?>
<?php echo $this->Element('footer-base'); ?>

<?php
	echo $this->Js->writeBuffer();
	echo $this->element('sql_dump');
?>

<?php

/*if($this->params['controller'] == 'modalidades' || $this->params['controller'] == 'cases'): ?>

<script src="<?php echo $this->Html->url('/'); ?>js/bootstrap/bootstrap-transition.js"></script>
<script src="<?php echo $this->Html->url('/'); ?>js/bootstrap/bootstrap-modal.js"></script>
<script src="<?php echo $this->Html->url('/'); ?>js/bootstrap/bootstrap-collapse.js"></script><? */?>
<script src="<?php echo $this->Html->url('/'); ?>js/jquery.bxSlider.min.js"></script>
<? /*?><script src="<?php echo $this->Html->url('/'); ?>js/bootstrap/bootstrap-carousel.js"></script>

<? endif; */ ?>
<!-- views/design/custom/layouts -->
</body>
</html>