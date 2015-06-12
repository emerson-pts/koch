<?php
$recoverpass_url = $this->Html->url('/usuarios/recoverpass_confirm/' . $uid, true);

?>Olá <?php echo $usuario['Usuario']['nome'];?>,<br />
<br />
Por favor, clique no link a seguir para cadastrar sua senha de acesso ao nosso sitema.<br />
<br />
<a style="color: #8e8d9d;text-decoration: none;" href="<?php echo $recoverpass_url;?>"><?php echo $recoverpass_url;?></a><br />
<br />
