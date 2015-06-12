<div class="box-newsletter">
	<?php echo $this->Form->create('FormNewsletter', array('url' => array('controller' => 'form_newsletters', 'action' => 'index', '#' => 'box-newsletter'),'class'=>'form_newsletter', 'id' => 'box-newsletter')); ?>
		<legend>Newsletter</legend>
		<cake:nocache><?php echo $this->Session->flash('form_newsletter'); ?></cake:nocache>
		<div class="row-fluid">
		<?php echo $this->Form->input('nome', array(
			'maxlength' => '100',	
			'type'		=> 'text',
			'label' 	=> false,
			'placeholder' => __('nome', true),
		)); 
		
		echo $this->Form->input('email', array(
			'maxlength' => '100',	
			'type'		=> 'text',
			'label' 	=> false,
			'placeholder' => __('email', true),
		)); 
		
		echo $this->Form->submit('enviar');
		
		?>
		</div>
	<?php echo $this->Form->end(); ?>
</div>