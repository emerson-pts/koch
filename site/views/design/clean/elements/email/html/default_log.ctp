<?php
$content = explode("\n", $content);

foreach ($content as $line):
	echo '<p> ' . $line . '</p>';
endforeach;
?>
<div style="font-family: monospace; white-space: pre;">
	<?php echo $content_log;?>
</div>