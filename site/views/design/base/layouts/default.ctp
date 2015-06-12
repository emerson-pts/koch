<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>  
	<title><?php 
		echo $title_for_layout;
		if(!empty($title_for_layout)){
			echo Configure::read('site.title_separator');
		}
		echo __(Configure::read('site.title'));
	?></title>
	<?php
		echo $this->Html->meta('icon');
	
		echo $this->Html->css(array('style', 'reset','style.base','style.fonts','style.galeria','style.vitrine','vitrine_texto','messages', 'prettyPhoto'));
		echo $this->Html->script(array('http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js' , 'jquery.prettyPhoto', 'jquery.bxSlider.min',));
		if(Configure::read('debug') >= 2)echo $this->Html->css(array('sql_debug'));

		echo $scripts_for_layout;

		echo $this->Html->meta('keywords', (!empty($meta['keyword']) ? $meta['keyword'] : Configure::read('meta.keyword')), array('type' => 'keywords'), false);
		echo $this->Html->meta('description', (!empty($meta['description']) ? $meta['description'] : Configure::read('meta.description')), array('type' => 'description'), false); 
	?>
</head>
<body>
<?php 
	echo $this->element('header/header'); 
	echo $this->element('menu/menu'); 
?>
<cake:nocache><?php echo $this->Session->flash(); ?></cake:nocache>
<?php 
	echo $content_for_layout;
	echo $this->element('footer/footer'); 
?>
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery("a[rel^='prettyPhoto']").prettyPhoto({show_title: false,theme:'light_rounded',overlay_gallery:false});
		//Abrir links externos em nova janela, sem follow
		jQuery('a[href^=http]').each(function(){
			if(this.href.indexOf('webjump.com.br') == -1 && this.href.indexOf(location.hostname) == -1){
				jQuery(this)
					.attr('target', '_blank')
				;
			}
		});

		jQuery('input.campos, textarea.campos').each(function(){
			jQuery(this)
				.attr('original_value', $(this).val())
				.focus(function(){
					if(jQuery(this).val() == $(this).attr('original_value')){
						jQuery(this).val('');
					}
				})
				.blur(function(){
					if(jQuery.trim(jQuery(this).val()) == ''){
						jQuery(this).val($(this).attr('original_value'));
					}
				})
			;
		})
	});
</script>
<?php
	echo $this->Js->writeBuffer();
	echo $this->element('sql_dump');
?>
<!-- views/design/base/layouts -->
</body>
</html>