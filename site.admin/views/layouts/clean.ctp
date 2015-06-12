<!doctype html>
<html lang="en" class="no-js">
<head>
	<?php echo $this->Html->charset(); ?>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	
	<title>
		<?php echo Configure::read('site.title') . (empty($title_for_layout) ? '' : ': '.$title_for_layout); ?>
	</title>

	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->meta(array('robots' => 'noindex,nofollow'));
	
		//Global stylesheets
		echo $this->Html->css(array(
			'reset', 

			'sql_debug','webjump.default', 'webjump.template', 'webjump.custom', 

			'webjump.custom.europa_boleto',
		));

		echo $html->css(array('style.print', 'webjump.custom.print'), 'stylesheet', array('media' => 'print'));
	
		//Arquivos com script/css inline=false
		echo $scripts_for_layout;
	?>	
</head>
<body style="margin: 15px;">
	<?php 
	//Verifica se tem mensagem a ser exibida
	if($this->Session->read('Message.flash')):
	?>
		<p><?php echo $this->Session->flash();?></p>
	<?php 
	endif;

	if(($flash_msgs = $this->Session->read('Message.flash_msgs'))):
	?>
		<p>
			<?php 
			foreach($flash_msgs AS $key=>$value):
				echo $this->Session->flash('flash_msgs.'.$key);
			endforeach;
			?>
		</p>
	<?php 
	endif;
	?>
	<?php echo $content_for_layout;	?>

<?php echo $this->element('sql_dump'); ?>
<?php echo $this->Js->writeBuffer(); ?>
</body>
</html>