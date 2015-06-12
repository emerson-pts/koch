<!doctype html>
<!--[if lt IE 8 ]><html lang="en" class="no-js ie ie7"><![endif]-->
<!--[if IE 8 ]><html lang="en" class="no-js ie"><![endif]-->
<!--[if (gt IE 8)|!(IE)]><!--><html lang="en" class="no-js"><!--<![endif]-->
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
			
			'common', 'form', 'standard', // Estilos globais
			'960.gs.fluid', //Alterne entre estes dois estilos para layout fixo ou líquido 960.gs
			'simple-lists', 'block-lists', 'planning', 'table', 'calendars', 'wizard', 'gallery', // CSS customizados 

			'jquery.fancybox-1.3.4', 'jquery.blockUI',

			'sql_debug','webjump.default', 'webjump.template', 'webjump.custom',
			
		));

		echo $html->css(array('style.print', 'webjump.custom.print'), 'stylesheet', array('media' => 'print'));
	
		//Modernizr for support detection, all javascript libs are moved right above </body> for better performance 
		echo $this->Html->script(array('libs/modernizr.custom.min.js', 'libs/jquery-1.6.3.min.js', 'jquery.miniMenu',));
		//
		//SE ATUALIZAR O JQUERY PARA VERSÃO MAIS NOVA O UPLOAD NÃO CONSEGUE TIRAR O ITEM DA LISTA
		//
		
		//Arquivos com script/css inline=false
		echo $scripts_for_layout;
	?>	
</head>
<body>
	<!-- Header -->
	<header><?php echo $this->Element('blocks/header');?></header>
	<?php echo $this->Element('blocks/nav_main');?>
	<?php echo $this->Element('blocks/nav_sub');?>
	<?php echo $this->Element('blocks/status_bar');?>
	<div id="header-shadow"></div>
	<!-- End header -->
	<?php 
	//Se tem link superior na esquerda ou direita...
	if(!empty($setup['topLink']) || !empty($setup['topLinkLeft'])): 
	?>
	<!-- Always visible control bar -->
	<div id="control-bar" class="grey-bg static clearfix"><div class="container_12 control-bar-default">
	<?php 
	//Se os links superiores foram definidos
		foreach(array('topLinkLeft' => 'float-left', 'topLink' => 'float-right') AS $setup_key => $block_class):
			if(isset($setup[$setup_key])):
				$links = array();
				
				//Se não é array, converte em array
				if(!is_array($setup[$setup_key]))$setup[$setup_key] = array($setup['topLink']);
				
				//Parse nos links
				foreach($setup[$setup_key] AS $key=>$value):
					//Se não é uma array, então o valor é a url 
					if(!is_array($value['url']))$value = array('url' => $value);
					
					//Se deve incluir os parametros atuais na url do link
					if(!empty($value['include_params_in_url'])){
						$value['url'] += $this->params['named'];
					}
					
					//Checa permissão
					if(!empty($acl) 
						&& method_exists($acl, 'check') 
						&& !$acl->check('controllers/'.(!is_array($value['url']) ? $value['url'] : (isset($value['url']['controller']) ? $value['url']['controller'] : $this->params['controller']).(isset($value['url']['action']) ? '/'.$value['url']['action'] : ''))))
						continue;
					
					//Se não tem atributos de html
					if(!isset($value['htmlAttributes']))$value['htmlAttributes'] = array();
					
					//Se não tem classe definida, seta a padrão
					if(!isset($value['htmlAttributes']['class']))$value['htmlAttributes']['class'] = 'big-button';
	
					//Inclui link na array
					$links[] = $this->Html->link($key, $value['url'], $value['htmlAttributes']);
	
				endforeach;
				
				//Se tem links
				if(!empty($links)):
					//Exibe links
				?>
				<div id="<?php echo $setup_key;?>" class="<?php echo $block_class;?>"> 
					<?php
					foreach($links AS $link):
						echo $link.' ';
					endforeach;
					?>
				</div>
				<?php
				endif;
			endif;
		endforeach;
	?>			
	</div></div>
	<!-- End control bar -->
	<?php endif; ?>
	<!-- Content -->
	<div class="clear"></div>
	<article class="container_12">
	<?php 
	//Verifica se tem mensagem a ser exibida
	if($this->Session->read('Message.flash')):
	?>
		<section class="grid_12 with-margin">
			<?php echo $this->Session->flash();?>
		</section>
	<?php 
	endif;

	if(($flash_msgs = $this->Session->read('Message.flash_msgs'))):
	?>
		<section class="grid_12 with-margin">
			<?php 
			foreach($flash_msgs AS $key=>$value):
				echo $this->Session->flash('flash_msgs.'.$key);
			endforeach;
			?>
		</section>
	<?php 
	endif;
	?>
	<div class="controller-<?php echo $this->name;?>">
		<?php echo $content_for_layout;	?>
	</div>
	<div class="clear"></div>
	<?php if(!empty($log) && $this->Acl->check('controllers/Logs')){
		echo $this->element('log.ajax', $log);
	}?>
	</article>
	<!-- End content -->
	<footer>
		<div class="float-right">
			<?php 
			if(isset($footerLink)){
				if(!is_array($footerLink)){
					echo $footerLink;
				}else{
					echo implode('', $footerLink);
				}
			}
			?>
			<a href="#top" class="button"><span class="picto navigation-up"></span> <?php __('Topo');?></a>
		</div>
		
	</footer>
	
	<!--
	
	Updated as v1.5:
	Libs are moved here to improve performance
	
	-->
	<?php
		echo $this->Html->script(array('old-browsers', 'libs/jquery.hashchange',)); // Generic libs 
		echo $this->Html->script(array('jquery.accessibleList', /*'searchField',*/ 'common', 'standard',)); // Template libs 
		echo $this->Html->script(array('jquery.form',)); //Webjump custom
	?>
	<!--[if lte IE 8]><?php echo $this->Html->script('standard.ie.js');?><![endif]-->
	<?php
		echo $this->Html->script(array('jquery.tip', 'jquery.contextMenu', 'jquery.modal', ));
		echo $this->Html->script(array('list', )); //Custom styles lib
		echo $this->Html->script(array('libs/jquery.dataTables.min', 'libs/jquery.datepick/jquery.datepick.min', 'libs/jquery.datepick/jquery.datepick-pt-BR' )); //Plugins
		
//Admin
		echo $this->Html->script(array(
			'javascript_next_field',
			'ckeditor/ckeditor',
			'jquery.blockUI.js',
			'jquery.blockUI.functions.js',
			'jquery.maskMoney',
			'jquery.maskedinput-1.3.min',
			'jquery.fancybox-1.3.4.pack.js',
			'jquery.textlimit.r2.1.js',
			'jquery.hotkeys',
			'jquery.ajaxValidate.js',
			'validate2',
			'phpjs',
			'putCursorAtEnd',
		));
	?>
	<script type="text/javascript">
	var ajaxValidatorUrl = "<?php echo $this->Html->url('/ajax_validators/index/');?>";
	var agent=navigator.userAgent.toLowerCase();
	var is_iphone = (agent.indexOf('iphone')!=-1 ? true : false);
	var is_ipad = (agent.indexOf('ipad')!=-1 ? true : false);
	var is_android = (agent.indexOf('android')!=-1 ? true : false);
	var is_chrome = (agent.indexOf('chrome')!=-1 ? true : false);
	
	jQuery(document).ready(function(){

		//HIDE EDIT
		<?php if($this->name == 'Sistemas') { ?>
			$('.table-actions .edit').hide();
		<? } ?>

		/* SHOW HIDE MODALIDADES/CASES - TEXTOS */
		$('label[for="TextoCase"]').hide();
		$('#TextoCase').hide();

		$('label[for="TextoEvento"]').hide();
		$('#TextoEvento').hide();

		$('#TextoTipo').change(function(){

			if($(this).val() == 'modalidade') {
				$('label[for="TextoCase"]').hide();
				$('#TextoCase').hide();

				$('label[for="TextoEvento"]').hide();
				$('#TextoEvento').hide();

				$('label[for="TextoArea"]').hide();
				$('#TextoArea').hide();

				$('label[for="TextoModalidade"]').show();
				$('#TextoModalidade').show();			
			}

			if($(this).val() == 'case') {
				$('label[for="TextoModalidade"]').hide();
				$('#TextoModalidade').hide();

				$('label[for="TextoEvento"]').hide();
				$('#TextoEvento').hide();

				$('label[for="TextoArea"]').hide();
				$('#TextoArea').hide();

				$('label[for="TextoCase"]').show();
				$('#TextoCase').show();
			}

			if($(this).val() == 'evento') {
				$('label[for="TextoModalidade"]').hide();
				$('#TextoModalidade').hide();

				$('label[for="TextoCase"]').hide();
				$('#TextoCase').hide();

				$('label[for="TextoArea"]').hide();
				$('#TextoArea').hide();

				$('label[for="TextoEvento"]').show();
				$('#TextoEvento').show();
			}

			if($(this).val() == 'area') {

				$('label[for="TextoCase"]').hide();
				$('#TextoCase').hide();

				$('label[for="TextoModalidade"]').hide();
				$('#TextoModalidade').hide();

				$('label[for="TextoEvento"]').hide();
				$('#TextoEvento').hide();

				$('label[for="TextoArea"]').show();
				$('#TextoArea').show();
			}

		});

		/* SHOW HIDE MODALIDADES/CASES - GALERIAS */

		$('label[for="GaleriaCase"]').hide();
		$('#GaleriaCase').hide();
		$('label[for="GaleriaEvento"]').hide();
		$('#GaleriaEvento').hide();

		$('#GaleriaTipo').change(function(){

			if($(this).val() == 'modalidade') {
				$('label[for="GaleriaCase"]').hide();
				$('#GaleriaCase').hide();

				$('label[for="GaleriaEvento"]').hide();
				$('#GaleriaEvento').hide();

				$('label[for="GaleriaModalidade"]').show();
				$('#GaleriaModalidade').show();
			}

			if($(this).val() == 'case') {
				$('label[for="GaleriaModalidade"]').hide();
				$('#GaleriaModalidade').hide();

				$('label[for="GaleriaEvento"]').hide();
				$('#GaleriaEvento').hide();

				$('label[for="GaleriaCase"]').show();
				$('#GaleriaCase').show();
			}

			if($(this).val() == 'evento') {
				$('label[for="GaleriaModalidade"]').hide();
				$('#GaleriaModalidade').hide();

				$('label[for="GaleriaCase"]').hide();
				$('#GaleriaCase').hide();

				$('label[for="GaleriaEvento"]').show();
				$('#GaleriaEvento').show();
			}
		});

		/* SHOW HIDE MODALIDADES/CASES - VIDEOS */

		$('label[for="VideoCase"]').hide();
		$('#VideoCase').hide();
		$('label[for="VideoEvento"]').hide();
		$('#VideoEvento').hide();

		$('#VideoTipo').change(function(){

			if($(this).val() == 'modalidade') {
				$('label[for="VideoCase"]').hide();
				$('#VideoCase').hide();
				$('label[for="VideoEvento"]').hide();
				$('#VideoEvento').hide();

				$('label[for="VideoModalidade"]').show();
				$('#VideoModalidade').show();
			}

			if($(this).val() == 'case') {
				$('label[for="VideoModalidade"]').hide();
				$('#VideoModalidade').hide();

				$('label[for="VideoEvento"]').hide();
				$('#VideoEvento').hide();

				$('label[for="VideoCase"]').show();
				$('#VideoCase').show();
			}

			if($(this).val() == 'evento') {
				$('label[for="VideoModalidade"]').hide();
				$('#VideoModalidade').hide();

				$('label[for="VideoCase"]').hide();
				$('#VideoCase').hide();

				$('label[for="VideoEvento"]').show();
				$('#VideoEvento').show();
			}
		});

		/* SHOW HIDE MODALIDADES/CASES - WALLPAPERS */

		$('label[for="WallpaperCase"]').hide();
		$('#WallpaperCase').hide();
		$('label[for="WallpaperEvento"]').hide();
		$('#WallpaperEvento').hide();

		$('#WallpaperCategoria').change(function(){

			if($(this).val() == 'modalidade') {				

				$('label[for="WallpaperCase"]').hide();
				$('#WallpaperCase').hide();

				$('label[for="WallpaperEvento"]').hide();
				$('#WallpaperEvento').hide();

				$('label[for="WallpaperModalidade"]').show();
				$('#WallpaperModalidade').show();
			}

			if($(this).val() == 'case') {
				$('label[for="WallpaperModalidade"]').hide();
				$('#WallpaperModalidade').hide();

				$('label[for="WallpaperEvento"]').hide();
				$('#WallpaperEvento').hide();

				$('label[for="WallpaperCase"]').show();
				$('#WallpaperCase').show();
			}

			if($(this).val() == 'evento') {
				$('label[for="WallpaperModalidade"]').hide();
				$('#WallpaperModalidade').hide();

				$('label[for="WallpaperCase"]').hide();
				$('#WallpaperCase').hide();

				$('label[for="WallpaperEvento"]').show();
				$('#WallpaperEvento').show();
			}
		});

		/* SHOW HIDE AREAS */
		$('label[for="TextoArea"]').hide();
		$('#TextoArea').hide();

		/***
		COMEÇO SHOW/HIDE QDO ESTA EDITANDO
		***/
		if($('#TextoTipo').val() == 'modalidade') {			

			$('label[for="TextoCase"]').hide();
			$('#TextoCase').hide();

			$('label[for="TextoEvento"]').hide();
			$('#TextoEvento').hide();

			$('label[for="TextoArea"]').hide();
			$('#TextoArea').hide();

			$('label[for="TextoModalidade"]').show();
			$('#TextoModalidade').show();			

			$('#TextoModalidade').val($('#TextoParentId').val()).attr("selected","selected");
		}

		if($('#TextoTipo').val() == 'case') {
			$('label[for="TextoModalidade"]').hide();
			$('#TextoModalidade').hide();

			$('label[for="TextoEvento"]').hide();
			$('#TextoEvento').hide();

			$('label[for="TextoArea"]').hide();
			$('#TextoArea').hide();

			$('label[for="TextoCase"]').show();
			$('#TextoCase').show();

			$('#TextoCase').val($('#TextoParentId').val()).attr("selected","selected");
		}

		if($('#TextoTipo').val() == 'evento') {
			$('label[for="TextoModalidade"]').hide();
			$('#TextoModalidade').hide();

			$('label[for="TextoCase"]').hide();
			$('#TextoCase').hide();

			$('label[for="TextoArea"]').hide();
			$('#TextoArea').hide();

			$('label[for="TextoEvento"]').show();
			$('#TextoEvento').show();

			$('#TextoEvento').val($('#TextoParentId').val()).attr("selected","selected");
		}

		if($('#TextoTipo').val() == 'area') {

			$('label[for="TextoCase"]').hide();
			$('#TextoCase').hide();

			$('label[for="TextoModalidade"]').hide();
			$('#TextoModalidade').hide();

			$('label[for="TextoEvento"]').hide();
			$('#TextoEvento').hide();

			$('label[for="TextoArea"]').show();
			$('#TextoArea').show();

			$('#TextoArea').val($('#TextoParentId').val()).attr("selected","selected");
		}

		/** FIM texto **/

		if($('#VideoTipo').val() == 'case') {
			$('label[for="TextoModalidade"]').hide();
			$('#TextoModalidade').hide();

			$('label[for="TextoEvento"]').hide();
			$('#TextoEvento').hide();

			$('label[for="TextoArea"]').hide();
			$('#TextoArea').hide();

			$('label[for="TextoCase"]').show();
			$('#TextoCase').show();

			$('#TextoCase').val($('#VideoParentId').val()).attr("selected","selected");
		}

		if($('#VideoTipo').val() == 'evento') {
			$('label[for="TextoModalidade"]').hide();
			$('#TextoModalidade').hide();

			$('label[for="TextoCase"]').hide();
			$('#TextoCase').hide();

			$('label[for="TextoArea"]').hide();
			$('#TextoArea').hide();

			$('label[for="TextoEvento"]').show();
			$('#TextoEvento').show();

			$('#TextoEvento').val($('#VideoParentId').val()).attr("selected","selected");
		}

		if($('#VideoTipo').val() == 'modalidade') {

			$('label[for="VideoCase"]').hide();
			$('#VideoCase').hide();

			$('label[for="VideoArea"]').hide();
			$('#VideoArea').hide();

			$('label[for="VideoEvento"]').hide();
			$('#VideoEvento').hide();

			$('label[for="VideoModalidade"]').show();
			$('#VideoModalidade').show();

			$('#VideoModalidade').val($('#VideoParentId').val()).attr("selected","selected");
		}

		/** FIM video **/

		if($('#GaleriaTipo').val() == 'modalidade') {
			$('label[for="GaleriaCase"]').hide();
			$('#GaleriaCase').hide();

			$('label[for="GaleriaEvento"]').hide();
			$('#GaleriaEvento').hide();

			$('label[for="GaleriaModalidade"]').show();
			$('#GaleriaModalidade').show();

			$('#GaleriaModalidade').val($('#GaleriaRelatedId').val()).attr("selected","selected");
		}

		if($('#GaleriaTipo').val() == 'case') {
			$('label[for="GaleriaModalidade"]').hide();
			$('#GaleriaModalidade').hide();

			$('label[for="GaleriaEvento"]').hide();
			$('#GaleriaEvento').hide();

			$('label[for="GaleriaCase"]').show();
			$('#GaleriaCase').show();

			$('#GaleriaCase').val($('#GaleriaRelatedId').val()).attr("selected","selected");
		}

		if($('#GaleriaTipo').val() == 'evento') {
			$('label[for="GaleriaModalidade"]').hide();
			$('#GaleriaModalidade').hide();

			$('label[for="GaleriaCase"]').hide();
			$('#GaleriaCase').hide();

			$('label[for="GaleriaEvento"]').show();
			$('#GaleriaEvento').show();

			$('#GaleriaEvento').val($('#GaleriaRelatedId').val()).attr("selected","selected");
		}

		/** FIM galeria **/

		if($('#WallpaperCategoria').val() == 'modalidade') {
			$('label[for="WallpaperCase"]').hide();
			$('#WallpaperCase').hide();

			$('label[for="WallpaperModalidade"]').show();
			$('#WallpaperModalidade').show();

			$('#WallpaperModalidade').val($('#WallpaperParentId').val()).attr("selected","selected");
		}

		if($('#WallpaperCategoria').val() == 'case') {
			$('label[for="WallpaperModalidade"]').hide();
			$('#WallpaperModalidade').hide();

			$('label[for="WallpaperCase"]').show();
			$('#WallpaperCase').show();

			$('#WallpaperCase').val($('#WallpaperParentId').val()).attr("selected","selected");
		}

		if($('#WallpaperCategoria').val() == 'evento') {
			$('label[for="WallpaperModalidade"]').hide();
			$('#WallpaperModalidade').hide();

			$('label[for="WallpaperCase"]').hide();
			$('#WallpaperCase').hide();

			$('label[for="WallpaperEvento"]').show();
			$('#WallpaperEvento').show();

			$('#WallpaperEvento').val($('#WallpaperParentId').val()).attr("selected","selected");
		}

		/** FIM wallpaper **/

		/***
		FIM SHOW HIDE
		***/

		$('input.confirm').click(function(event){
			fraseConfirmacao = $(this).attr('confirm');
			if(!window.confirm((fraseConfirmacao == undefined ? 'Você confirma esta solicitação' : fraseConfirmacao))){
				event.stopPropagation();
                event.preventDefault();
				return false;
			}
		});

		$('a.external').click(function(){
	        window.open(this.href);
	        return false;
		});

		/* This is basic - uses default settings */
		$("a.fancy").fancybox({
			hideOnContentClick: true,
			centerOnScroll	: true
		});

		$.mask.definitions['*']='[a-zA-Z0-9 .,\(\)]';
  		$('input.cepMask').mask('99999-999');
  		$('input.cpfMask').mask('999.999.999-99');
  		$('input.cnpjMask').mask('99.999.999/9999-99');
    	$('input.cnpjcpfMask')
    		.keypress(function(){
    			mascaraMutuario(this,cpfCnpj);
    		})
    		.blur(function(){
    			clearTimeout()
    		})
    	;

    	$('input.telMask')
    		.live('focusout', function(event) {
				var target, phone9, element;
				target = (event.currentTarget) ? event.currentTarget : event.srcElement;
				phone9 = target.value.match(/(\-[0-9]{5}|\([0-9]{2}\) [0-9]{5}\-[0-9]{4})/g);
				element = $(target);
				element.unmask();
				if(phone9) {
					element.mask("(99) 99999-999?***********");
				} else {
					element.mask("(99) 9999-9999?***********");
				}
			})
			.trigger('focusout')
		;

        $('input.dateMaskDiaHora').mask('99/99/9999 99:99');
    	$('input.dateMask').mask('99/99/9999');
		$('input.dateMaskMesAno').mask('99/9999');
        $('input.percentMask').mask('99,99');

		$('input.currency')
			.maskMoney({symbol:"",decimal:",",thousands:"."})
			.focus(function(){
				putCursorAtEnd(this);
			})
		;

		$('input.onlyNumberDecimal').keyup(function(){
			extractNumber(this, 2, false);
		});
		$('input.onlyNumber').keyup(function(){
			this.value = this.value.replace(/[^0-9]/g,'');
		});

		$('textarea[max-line]').each(function(){
			$(this)
				.keydown(function(event){
					newLines = $(this).val().split("\n").length;
			
					if(event.keyCode == 13 && newLines >= $(this).attr("max-line")) {
						return false;
					}
				})
			;
		});


		//Faz as ações padrões do Alt + teclas especiais
		$.hotkeys.add('Alt+return',function () {
			$('#filtroSubmit,.alt-return').click();
		});

		$.hotkeys.add('Alt+s',function () {
			$('form.form-submit').submit();
		});

		//Se tem algum form com alt-s
		if($('form.form-submit').size() != 0){
			//Faz as ações padrões do Alt + teclas especiais
			$.hotkeys.add('Alt+1',function () {$('.datepicker').datepick('hide');$('form.form-submit fieldset:eq(0)').find('select:visible,input:visible').filter(':first').trigger('focus');});
			$.hotkeys.add('Alt+2',function () {$('.datepicker').datepick('hide');$('form.form-submit fieldset:eq(1)').find('select:visible,input:visible').filter(':first').trigger('focus');});
			$.hotkeys.add('Alt+3',function () {$('.datepicker').datepick('hide');$('form.form-submit fieldset:eq(2)').find('select:visible,input:visible').filter(':first').trigger('focus');});
			$.hotkeys.add('Alt+4',function () {$('.datepicker').datepick('hide');$('form.form-submit fieldset:eq(3)').find('select:visible,input:visible').filter(':first').trigger('focus');});
			$.hotkeys.add('Alt+5',function () {$('.datepicker').datepick('hide');$('form.form-submit fieldset:eq(4)').find('select:visible,input:visible').filter(':first').trigger('focus');});
			$.hotkeys.add('Alt+6',function () {$('.datepicker').datepick('hide');$('form.form-submit fieldset:eq(5)').find('select:visible,input:visible').filter(':first').trigger('focus');});
			$.hotkeys.add('Alt+7',function () {$('.datepicker').datepick('hide');$('form.form-submit fieldset:eq(6)').find('select:visible,input:visible').filter(':first').trigger('focus');});
			$.hotkeys.add('Alt+8',function () {$('.datepicker').datepick('hide');$('form.form-submit fieldset:eq(7)').find('select:visible,input:visible').filter(':first').trigger('focus');});
			$.hotkeys.add('Alt+9',function () {$('.datepicker').datepick('hide');$('form.form-submit fieldset:eq(8)').find('select:visible,input:visible').filter(':first').trigger('focus');});
		}
		
		$.hotkeys.add('Alt+q',function () {
			window.location.href = '<?php echo $this->base;?>/agendamentos/add/tipo:pagamento';
		});
		$.hotkeys.add('Alt+w',function () {
			window.location.href = '<?php echo $this->base;?>/agendamentos/add/tipo:recebimento';
		});

		//Ícone no datepicker		
		jQuery('input.datepicker').after('<span class="datepicker-icon"></span>');
		jQuery('span.datepicker-icon')
			.click(function(event){
				element_input = jQuery(this).prev();
				if(!element_input.attr('disabled')){
					element_input.trigger('focus');
				}
			})
		;

		//Form error
		jQuery('input.form-error')
			.wrap('<span class="relative"></span>')
			.after('<span class="check-error"></span>')
	//		.focus(function(event){
	//			jQuery(this).parent().find('span.check-error').foldAndRemove();
	//		})
		;

		//Ajusta mensagens
		jQuery('div.message_error').addClass('message error').prepend('<span class="close-bt"></span>');
		jQuery('div.message_warning,div.message_alert').addClass('message warning').prepend('<span class="close-bt"></span>');
		jQuery('div.message_info').addClass('message').prepend('<span class="close-bt"></span>');
		jQuery('div.message_success').addClass('message success').prepend('<span class="close-bt"></span>');

		//Alerta sair da página sem salvar
		var isDirty = false;
		var msg = 'Suas alterações não foram salvas.';
		
		jQuery(':input').change(function(){
			if(!isDirty){
				isDirty = true;
			}
		});
		
		jQuery('form').submit(function() {
			isDirty = false;
		});
		
		window.onbeforeunload = function(){
			if(isDirty) {
				return msg;
			}
		};
		
		CKEDITOR.config.language = 'pt-br';
		CKEDITOR.config.filebrowserBrowseUrl = '<?php echo $this->base;?>/kcfinder/browse.php?type=files';
		CKEDITOR.config.filebrowserImageBrowseUrl = '<?php echo $this->base;?>/kcfinder/browse.php?type=images';
		CKEDITOR.config.filebrowserFlashBrowseUrl = '<?php echo $this->base;?>/kcfinder/browse.php?type=flash';
		CKEDITOR.config.filebrowserUploadUrl = '<?php echo $this->base;?>/kcfinder/upload.php?type=files';
		CKEDITOR.config.filebrowserImageUploadUrl = '<?php echo $this->base;?>/kcfinder/upload.php?type=images';
		CKEDITOR.config.filebrowserFlashUploadUrl = '<?php echo $this->base;?>/kcfinder/upload.php?type=flash';
		
		CKEDITOR.config.width = <?php 
			if($default_width = Configure::read('Admin.editor.default_width')){
				echo $default_width;
			}
			else{
				echo 900;
			}
			?>;
		CKEDITOR.config.height = <?php 
			if($default_height = Configure::read('Admin.editor.default_height')){
				echo $default_height;
			}
			else{
				echo 300;
			}
			?>;
		CKEDITOR.config.enterMode = CKEDITOR.ENTER_P;
		CKEDITOR.config.resize_dir = 'both';
		
		CKEDITOR.config.fontSize_sizes = '16/16px;24/24px;36/36px;48/48px;72/72px;108/108px;216/216px';

		<?php if($editorContentCss = Configure::read('Admin.editor.content_css')):
			$editorContentCss = explode(PHP_EOL, $editorContentCss );
			array_walk($editorContentCss, function(&$value, $key){ $value = trim($value);});
			$editorContentCss = array_filter($editorContentCss);
		?>
		CKEDITOR.config.contentsCss = ['<?php echo implode("', '", $editorContentCss);?>'];
		<?php endif; ?>

		<?php if($editorStylesSet = Configure::read('Admin.editor.styles_set')):?>
		CKEDITOR.config.stylesSet = <?php echo $editorStylesSet;?>;
		<?php endif; ?>

		<?php if($colorButton_colors = Configure::read('Admin.editor.color_button_colors')):?>
		CKEDITOR.config.colorButton_colors = '<?php echo $colorButton_colors;?>';
		<?php endif; ?>

  		CKEDITOR.config.toolbar = [
			{ name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'PasteText', '-', 'Undo', 'Redo' ] },
			{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Scayt' ] },
			{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
			{ name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule', 'SpecialChar' ] },
			{ name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'Preview' ] },
			{ name: 'about', items: [ 'About' ] },
			{ name: 'tools', items: [ 'Maximize' ] },
			{ name: 'others', items: [ '-' ] },
			'/',
			{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Strike', '-', 'RemoveFormat' ] },
			{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
			{ name: 'styles', items: [ <?php if(!empty($editorStylesSet)){echo "'Styles', ";}?> 'Format', 'FontSize' ] },
			{ name: 'color', items: ['TextColor','BGColor'] }
		];

	});

	</script>
	<?php
/*	
	<!-- Charts library -->
	<!--Load the AJAX API-->
	<script src="http://www.google.com/jsapi"></script>
	<script>
		
		//
		// This script is dedicated to building and refreshing the demo chart
		// Remove if not needed
		//
		
		// Load the Visualization API and the piechart package.
		google.load('visualization', '1', {'packages':['corechart']});
		
		// Add listener for tab
		jQuery('#tab-stats').onTabShow(function() { drawVisitorsChart(); }, true);
		
		// Handle viewport resizing
		var previousWidth = jQuery(window).width();
		jQuery(window).resize(function()
		{
			if (previousWidth != jQuery(window).width())
			{
				drawVisitorsChart();
				previousWidth = jQuery(window).width();
			}
		});
		
		// Demo chart
		function drawVisitorsChart() {

			// Create our data table.
			var data = new google.visualization.DataTable();
			var raw_data = [['Website', 50, 73, 104, 129, 146, 176, 139, 149, 218, 194, 96, 53],
							['Shop', 82, 77, 98, 94, 105, 81, 104, 104, 92, 83, 107, 91],
							['Forum', 50, 39, 39, 41, 47, 49, 59, 59, 52, 64, 59, 51],
							['Others', 45, 35, 35, 39, 53, 76, 56, 59, 48, 40, 48, 21]];
			
			var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
			
			data.addColumn('string', 'Month');
			for (var i = 0; i < raw_data.length; ++i)
			{
				data.addColumn('number', raw_data[i][0]);	
			}
			
			data.addRows(months.length);
			
			for (var j = 0; j < months.length; ++j)
			{	
				data.setValue(j, 0, months[j]);	
			}
			for (var i = 0; i < raw_data.length; ++i)
			{
				for (var j = 1; j < raw_data[i].length; ++j)
				{
					data.setValue(j-1, i+1, raw_data[i][j]);	
				}
			}
			
			// Create and draw the visualization.
			var div = jQuery('#chart_div');
			new google.visualization.ColumnChart(div.get(0)).draw(data, {
				title: 'Monthly unique visitors count',
				width: div.width(),
				height: 330,
				legend: 'right',
				yAxis: {title: '(thousands)'}
			});
			
			// Message
			notify('Chart updated');
		};
	</script>
*/		
	?>	
	<script>
		
		/*
		 * This script shows how to setup the various template plugins and functions
		 */
		
		jQuery(document).ready(function()
		{
			<?php
			/*
			 * Example context menu
			 */
			/*
			// Context menu for all favorites
			jQuery('.favorites li').bind('contextMenu', function(event, list)
			{
				var li = jQuery(this);
				
				// Add links to the menu
				if (li.prev().length > 0)
				{
					list.push({ text: 'Move up', link:'#', icon:'up' });
				}
				if (li.next().length > 0)
				{
					list.push({ text: 'Move down', link:'#', icon:'down' });
				}
				list.push(false);	// Separator
				list.push({ text: 'Delete', link:'#', icon:'delete' });
				list.push({ text: 'Edit', link:'#', icon:'edit' });
			});
			
			// Extra options for the first one
			jQuery('.favorites li:first').bind('contextMenu', function(event, list)
			{
				list.push(false);	// Separator
				list.push({ text: 'Settings', icon:'terminal', link:'#', subs:[
					{ text: 'General settings', link: '#', icon: 'blog' },
					{ text: 'System settings', link: '#', icon: 'server' },
					{ text: 'Website settings', link: '#', icon: 'network' }
				] });
			});
			*/
		?>
			/*
			 * Dynamic tab content loading
			 */
			
			jQuery('#tab-comments').onTabShow(function()
			{
				jQuery(this).loadWithEffect('ajax-tab.html', function()
				{
					notify('Content loaded via ajax');
				});
			}, true);
			
			/*
			 * Table sorting
			 */
			
			// A small classes setup...
			jQuery.fn.dataTableExt.oStdClasses.sWrapper = 'no-margin last-child';
			jQuery.fn.dataTableExt.oStdClasses.sInfo = 'message no-margin';
			jQuery.fn.dataTableExt.oStdClasses.sLength = 'float-left';
			jQuery.fn.dataTableExt.oStdClasses.sFilter = 'float-right';
			jQuery.fn.dataTableExt.oStdClasses.sPaging = 'sub-hover paging_';
			jQuery.fn.dataTableExt.oStdClasses.sPagePrevEnabled = 'control-prev';
			jQuery.fn.dataTableExt.oStdClasses.sPagePrevDisabled = 'control-prev disabled';
			jQuery.fn.dataTableExt.oStdClasses.sPageNextEnabled = 'control-next';
			jQuery.fn.dataTableExt.oStdClasses.sPageNextDisabled = 'control-next disabled';
			jQuery.fn.dataTableExt.oStdClasses.sPageFirst = 'control-first';
			jQuery.fn.dataTableExt.oStdClasses.sPagePrevious = 'control-prev';
			jQuery.fn.dataTableExt.oStdClasses.sPageNext = 'control-next';
			jQuery.fn.dataTableExt.oStdClasses.sPageLast = 'control-last';
			
			// Apply to table
			jQuery('.sortable').each(function(i)
			{
				// DataTable config
				var table = jQuery(this),
					oTable = table.dataTable({
						/*
						 * We set specific options for each columns here. Some columns contain raw data to enable correct sorting, so we convert it for display
						 * @url http://www.datatables.net/usage/columns
						 */
						aoColumns: [
							{ bSortable: false },	// No sorting for this columns, as it only contains checkboxes
							{ sType: 'string' },
							{ bSortable: false },
							{ sType: 'numeric', bUseRendered: false, fnRender: function(obj) // Append unit and add icon
								{
									return '<small><img src="images/icons/fugue/image.png" width="16" height="16" class="picto"> '+obj.aData[obj.iDataColumn]+' Ko</small>';
								}
							},
							{ sType: 'date' },
							{ sType: 'numeric', bUseRendered: false, fnRender: function(obj) // Size is given as float for sorting, convert to format 000 x 000
								{
									return obj.aData[obj.iDataColumn].split('.').join(' x ');
								}
							},
							{ bSortable: false }	// No sorting for actions column
						],
						
						/*
						 * Set DOM structure for table controls
						 * @url http://www.datatables.net/examples/basic_init/dom.html
						 */
						sDom: '<"block-controls"<"controls-buttons"p>>rti<"block-footer clearfix"lf>',
						
						/*
						 * Callback to apply template setup
						 */
						fnDrawCallback: function()
						{
							this.parent().applyTemplateSetup();
						},
						fnInitComplete: function()
						{
							this.parent().applyTemplateSetup();
						}
					});
				
				// Sorting arrows behaviour
				table.find('thead .sort-up').click(function(event)
				{
					// Stop link behaviour
					event.preventDefault();
					
					// Find column index
					var column = jQuery(this).closest('th'),
						columnIndex = column.parent().children().index(column.get(0));
					
					// Send command
					oTable.fnSort([[columnIndex, 'asc']]);
					
					// Prevent bubbling
					return false;
				});
				table.find('thead .sort-down').click(function(event)
				{
					// Stop link behaviour
					event.preventDefault();
					
					// Find column index
					var column = jQuery(this).closest('th'),
						columnIndex = column.parent().children().index(column.get(0));
					
					// Send command
					oTable.fnSort([[columnIndex, 'desc']]);
					
					// Prevent bubbling
					return false;
				});
			});
			
			/*
			 * Datepicker
			 * Thanks to sbkyle! http://themeforest.net/user/sbkyle
			 */
			 
			var datepicker_setup = {
				alignment: 'bottom',
				showOtherMonths: true,
				selectOtherMonths: true,
				renderer: {
					picker: '<div class="datepick block-border clearfix form"><div class="mini-calendar clearfix">' +
							'{months}</div></div>',
					monthRow: '{months}', 
					month: '<div class="calendar-controls" style="white-space: nowrap">' +
								'{monthHeader:M yyyy}' +
							'</div>' +
							'<table cellspacing="0">' +
								'<thead>{weekHeader}</thead>' +
								'<tbody>{weeks}</tbody></table>', 
					weekHeader: '<tr>{days}</tr>', 
					dayHeader: '<th>{day}</th>', 
					week: '<tr>{days}</tr>', 
					day: '<td>{day}</td>', 
					monthSelector: '.month', 
					daySelector: 'td', 
					rtlClass: 'rtl', 
					multiClass: 'multi', 
					defaultClass: 'default', 
					selectedClass: 'selected', 
					highlightedClass: 'highlight', 
					todayClass: 'today', 
					otherMonthClass: 'other-month', 
					weekendClass: 'week-end', 
					commandClass: 'calendar', 
					commandLinkClass: 'button',
					disabledClass: 'unavailable'
				}
			};
			jQuery.datepick.setDefaults(datepicker_setup);
			jQuery('.datepicker').datepick();
		});
		
		// Demo modal
		function openModal()
		{
			jQuery.modal({
				content: '<p>This is an example of modal window. You can open several at the same time (click button below!), move them and resize them.</p>'+
						  '<p>The plugin provides several other functions to control them, try below:</p>'+
						  '<ul class="simple-list with-icon">'+
						  '    <li><a href="javascript:void(0)" onclick="jQuery(this).getModalWindow().setModalTitle(\'\')">Remove title</a></li>'+
						  '    <li><a href="javascript:void(0)" onclick="jQuery(this).getModalWindow().setModalTitle(\'New title\')">Change title</a></li>'+
						  '    <li><a href="javascript:void(0)" onclick="jQuery(this).getModalWindow().loadModalContent(\'ajax-modal.html\')">Load Ajax content</a></li>'+
						  '</ul>',
				title: 'Example modal window',
				maxWidth: 500,
				buttons: {
					'Open new modal': function(win) { openModal(); },
					'Close': function(win) { win.closeModal(); }
				}
			});
		}


	//Sobrescreve função definida no jquery.ajaxValidate.js
	function formErrorRemove(e_this){
		//se mandou string, então seleciona o elemento jquery
		if (isString(e_this) == false)var e_this = $(e_this);

		
		$(e_this)
			.parent()
			.find('span.check-error')
			.foldAndRemove()
		;
	
		$(e_this)
			.removeClass('form-error')
			.closest('div')
			.removeClass('error')
			.find('div.error-message')
			
			.slideUp('normal',function(){
				$(this).remove();
			})
		;
	}
	
	</script>
<?php echo $this->element('sql_dump'); ?>
<?php echo $this->Js->writeBuffer(); ?>
</body>
</html>
