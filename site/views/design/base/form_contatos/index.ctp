<?php
	 $this->set('title_for_layout', 'Contato');
?>
<cake:nocache><?php echo $this->Session->flash('form_msg'); ?></cake:nocache>
<?php echo $this->element('form/form_contato'); ?>
	