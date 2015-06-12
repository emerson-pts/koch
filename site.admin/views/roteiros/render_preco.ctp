<html>
<head>
<?php
	echo str_replace('.admin/', '/', $this->Element('../../../site/views/design/custom/elements/header-base'));
?>
</head>
<body class="with-padding">
<?php
	echo $this->BoomViagens->roteiroPreco($this->data['precos']);
	echo str_replace('.admin/', '/', $this->Element('../../../site/views/design/custom/elements/footer-base'));
?>
</body></html>