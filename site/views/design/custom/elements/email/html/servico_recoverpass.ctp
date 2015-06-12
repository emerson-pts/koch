<?php
$recoverpass_url = FULL_BASE_URL .'/'. APP_DIR . '/servicos/cliente/recoverpass_confirm/' . $uid;

echo '<table border="0" cellpadding="0" cellspacing="0" width="500"><tr><td style="padding:0;margin:0;"><div style="width: 500px; color: #625F5F; border: 1px solid #26244b;background: #FFF;">'./*$this->Html->image('email_header.jpg',array('embed'=>'swift')).*/'<br />
<div style="padding: 35px 45px;border-top: 1px solid #26244b;text-align: left !important;">
<br />
<br />
Olá '.$cliente['ClienteProfile']['nome'].',<br />
<br />
Por favor, clique no link a seguir para confirmar a troca de sua senha.<br />
Caso não tenha solicitado a substituição, por favor ignore esta mensagem.<br />
<br />
<a style="color: #8e8d9d;text-decoration: none;" href="'.$recoverpass_url.'">'.$recoverpass_url.'</a><br />
<br />
Abraços,<br />
<br />
<b>Desce Preço</b><br />
<a style="color: #2e6c9d;font-weight: bold;text-decoration: none;" href="http://www.descepreco.com.br" target="_blank">www.descepreco.com.br</a>
</div></div>
</td></tr></table>';
