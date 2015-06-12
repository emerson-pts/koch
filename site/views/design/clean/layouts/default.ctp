<?php
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.view.templates.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */ 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>  
	<title><?php echo __(Configure::read('site.title')) . (empty($title_for_layout) ? '' : ': '.$title_for_layout); ?></title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css(array('style', 'reset', 'prettyPhoto','style_galeria','messages','vitrine.default','vitrine_texto','galeria.default','style.fonts'));   // codigo que chama o css, que esta em  site\webroot\css
		echo $this->Html->script(array('http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js' , 'jquery.prettyPhoto', 'jquery.bxSlider.min', 'jquery.maskMoney' ,'jquery.maskedinput-1.3.min'));             
		if(Configure::read('debug') >= 2)echo $this->Html->css(array('sql_debug'));

		echo $scripts_for_layout;

		echo $this->Html->meta('keywords', (!empty($meta['keyword']) ? $meta['keyword'] : Configure::read('meta.keyword')), array('type' => 'keywords'), false);
		echo $this->Html->meta('description', (!empty($meta['description']) ? $meta['description'] : Configure::read('meta.description')), array('type' => 'description'), false); 
	?>
	<script type="text/javascript">var switchTo5x=true;</script>
	<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
	<script type="text/javascript">stLight.options({publisher: "78e1fcca-b568-4e1b-878f-709a7614a208"}); </script>
	<!-- SCRIPT PARA APAGAR VALUE QUANDO CLICADO NO CAMPO -->
	<script type="text/javascript">
		$(document).ready(function(){
			$('input.campos, textarea.campos').each(function(){
				$(this)
					.attr('original_value', $(this).val())
					.focus(function(){
						if($(this).val() == $(this).attr('original_value')){
							$(this).val('');
						}
					})
					.blur(function(){
						if($.trim($(this).val()) == ''){
							$(this).val($(this).attr('original_value'));
						}
					})
				;
			})
		});
	</script>
	<!-- SCRIPT DO PLUGIN MASK -->
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery("a[rel^='prettyPhoto'], a.prettyphoto, a.lightbox, a.prettyPhoto").prettyPhoto({show_title: false});
			$.mask.definitions['*']='[a-zA-Z0-9 .,\(\)]';
			$('input.cepMask').mask('99999-999');
  			$('input.cpfMask').mask('999.999.999-99');
			$('input.currency').maskMoney({symbol:"",decimal:",",thousands:"."});
			$('input.dateMaskDiaHora').mask('99/99/9999 99:99');
			$('input.dateMask').mask('99/99/9999');
			$('input.dateMaskMesAno').mask('99/9999');
			$('input.telMask')
				.live('focusout', function(event) {
					var target, phone9, element;
					target = (event.currentTarget) ? event.currentTarget : event.srcElement;
					phone9 = target.value.match(/(\-[0-9]{5}|\([0-9]{2}\) [0-9]{5}\-[0-9]{4})/g, '');
					element = $(target);
					element.unmask();
					if(phone9) {
						element.mask("(99) 99999-999?***********");
					} else {
						element.mask("(99) 9999-9999?***********");
					}			
				})
				.trigger('focusout')
			;
		});
	</script>
	<!-- SCRIPT DO PLUGIN MASK -->
	<!-- SCRIPT PARA APAGAR VALUE QUANDO CLICADO NO CAMPO -->
	<!-- PRETTY fOTO -->
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery("a[rel^='prettyPhoto']").prettyPhoto({show_title: false,theme:'light_rounded',overlay_gallery:false});
			jQuery('a[href^=http]').each(function(){
				if(this.href.indexOf(location.hostname) == -1)jQuery(this).attr('target', '_blank');
			});
			//Ordena Verticalmente os logos dos parceiros
			jQuery("div.img img").each(function(index){
				//$(this).find('img').css('marginTop',($(this).height()/2)-($(this).children('img')/2));
			});
		});
	</script>
	<script type="text/javascript">var switchTo5x=true;</script>
	<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
	<script type="text/javascript">stLight.options({publisher: "ur-1db6eb65-7c8c-6af-dad0-daadc318a8e"});</script>
	<!-- PRETTY fOTO -->
</head>
<body>
<?php echo $this->element('header/header'); ?>
<cake:nocache><?php echo $this->Session->flash(); ?></cake:nocache>
<?php echo $content_for_layout; ?>
<?php echo $this->element('footer/footer'); ?>
<?php
echo $this->element('sql_dump');
echo $this->Js->writeBuffer();
?>
<!-- views/design/clean/layouts -->
</body>
</html>