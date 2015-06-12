<br />
<br />
<fieldset class="grey-bg collapse">
	<legend><a href="#">Search Engine Optimization</a></legend>
	<?php
		foreach(array(
			'Seo.id'		=> array('type' => 'hidden',),
			'Seo.model'		=> array('type' => 'hidden', 'value' => $model),
			'Seo.title'		=> array('label' => 'Título', 'style' => 'width: 780px;', 'limit' => Configure::read('Seo.titleLimit') - strlen(Configure::read('site.title')),
				'after' => '<br />O título deve descrever a página em poucas palavras. Ele aparece no navegador, nos resultados da busca e também em sites externos.<br />
É o elemento mais importante da página, depois do conteúdo total. Este texto será adicionado ao título padrão do site <small>'.Configure::read('site.title').'</small>.',
			),
			'Seo.description'	=> array('label' => 'Descrição', 'div' => 'input inline-medium-label', 'cols' => 50, 'rows' => 5, 'style' => 'width: 780px;', 'limit' => Configure::read('Seo.descriptionLimit'),
				'after' => '<br />A descrição tem uma função de publicidade. Em geral, ela é usada nos sites de busca para descrever os resultados para seu site. <br />
A elaboração de uma descrição legível e atraente, usando palavras-chave importantes podem melhorar a audiência da página.<br />
O Google e outros motores de busca, deixam a palavra-chave pesquisada em negrito na descrição dos resultados.'
			),
			'Seo.keywords'	=> array('label' => 'Palavras-chave', 'div' => 'input inline-medium-label', 'cols' => 50, 'rows' => 5, 'style' => 'width: 780px;', 'limit' => Configure::read('Seo.keywordsLimit'),
				'before' => '<br /><div class="display-inline-block message warning">Não recomendamos o uso de palavras-chave no site. Também conhecidas como keywords, foram tão exploradas há tempos atrás que<br />
muitos sites de busca, como o Google não as utilizam no processo de pesquisa dos resultados. <a href="http://www.youtube.com/watch?v=jK7IPbnmvVU">Veja este vídeo</a>.<br />
Há ainda ressalvas em utilizar este recurso por dar dicas a seus concorrentes sobre quais palavras-chave você está tentando atingir.</div>'
			),
		) AS $key => $params){
			echo $this->Element('admin/form/default_form_input', array( 'key' => $key, 'params' => $params,));
		}
	?>
</fieldset>