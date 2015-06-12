<?php echo $this->Html->charset(); ?>  
<title><?php
	//SEO - título
	if(empty($title_for_layout)){
		if(!empty($this->params['seo'])){
			$titles = array_filter(Set::extract('/Seo/title', $this->params['seo']));
			if(!empty($titles)){
				$title_for_layout = end($titles);
			}else{
				$title_for_layout = '';
			}
		}else{
			$title_for_layout = '';
		}
	}

	if(!empty($title_for_layout)){
		$title_for_layout .= Configure::read('site.title_separator');
	}
	
	$siteTitle = __(Configure::read('site.title'), true);
	//Se o título completo ultrapassa o limite de caracteres, oculta o trecho entre chaves do título do site
	//Caso contrário remove as chaves de marcação
	$siteTitle = preg_replace('/\{(.*?)\}/', (strlen($title_for_layout.$siteTitle) > Configure::read('Seo.titleLimit') ? '' : '\1'), $siteTitle);

	echo $title_for_layout . $siteTitle;
?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php 
	echo $this->Html->meta('icon');
	
	//SEO
	if(!empty($this->params['seo'])){
		foreach(array('keywords', 'description') AS $meta){
			$var = array_filter(Set::extract('/Seo/'.$meta, $this->params['seo']));
			if(!empty($var)){
				$var = end($var);
				if(!empty($var)){
					echo $this->Html->meta($meta, $var, array('type' => $meta), false);
				}
			}
		}
	}
	//Se está na home
	else if(empty($this->params['originalArgs'])){
		//Exibe keyword e description padrão
		foreach(array('keywords', 'description') AS $meta){
			$var = Configure::read('site.'.$meta);

			if(!empty($var) && $var != '%install%'){
				echo $this->Html->meta($meta, $var, array('type' => $meta), false);
			}
		}
	}

	if($this->params['controller'] == 'modalidades' || $this->params['controller'] == 'cases' || $this->params['controller'] == 'eventos'):
		echo $this->Html->css('style.galeria');
	endif;

	echo $this->Html->css(
		array(
			'bootstrap.min',
			'webjump.default',
			'style',
			'style.responsive',
			'timeline',
			'timeline_light',
			'jquery.fancybox',
		),
		null,
		array(
			'media' => 'screen',
		)
	);

	if(Configure::read('debug') >= 2)echo $this->Html->css(array('sql_debug'));
?>
<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<?php
	echo $this->Html->script(
		array(
			'fontdetect',
		)
	);
?>
<script>
//Função para não disparar o resize durante o redimensionamento
function debouncer( func , timeout ) {
   var timeoutID , timeout = timeout || 200;
   return function () {
	  var scope = this , args = arguments;
	  clearTimeout( timeoutID );
	  timeoutID = setTimeout( function () {
		  func.apply( scope , Array.prototype.slice.call( args ) );
	  } , timeout );
   }
}		

// Usage
window.onload = function() {
    var detective = new Detector();
    //Identifica se o navegador tem capacidade para testar a fonte
    var testFont = detective.detect('abcdef');
    var lobster = detective.detect('Lobster');
    var century = detective.detect('Century Gothic') || detective.detect('CenturyGothic') || detective.detect('AppleGothic');
    if(testFont || !lobster || !century){
		WebFontConfig = {
			google: { families: new Array() }
		};
		
		if(testFont || !lobster){
			WebFontConfig.google.families[0] = 'Lobster::latin';
		}

		if(testFont || !century){
			WebFontConfig.google.families[1] = 'Muli::latin';
		}
		
		(function() {
			var wf = document.createElement('script');
			wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
			'://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
			wf.type = 'text/javascript';
			wf.async = 'true';
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(wf, s);
		})(); 
  	}
};
</script>
