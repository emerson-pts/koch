<div class="header-contact">
	<div>
		<ul>
			<?php foreach(WebjumpUtilities::str2associative_array( Configure::read('site.contact') ) AS $key => $value):
				$value = $this->Text->autoLink( $value );
			?>
				<li><b><?php echo $key; ?></b> <?php
					if( preg_match( '/^[\+\(\) 0-9\-\.]+$/', $value ) ){
						echo '<a href="tel:' . $value . '">' . $value . '</a>';
					}
					else{
						echo $value;
					}
				?></li>
			<?php endforeach; ?>
		</ul>					
	</div>
</div>