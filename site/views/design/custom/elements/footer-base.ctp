<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
window.jQuery || document.write('<sc' + 'ript src="<?php echo $this->Html->url("/js/jquery-1.10.2.min.js");?>"><\/sc' + 'ript>');
</script>
<script>
function maxHeight(element){
	var maxHeight = Math.max.apply(null, element.map(function ()
	{
    	return $(this).outerHeight();
	}).get());
	return maxHeight
}
</script>
<?php
echo $this->Html->script(
	array(
		'bootstrap.min',
		'jquery.maskedinput-1.3.1.min',
		'jquery.carouFredSel-6.2.1',
		'jquery.mousewheel.min',
		'jquery.touchSwipe.min',
		'timeline.min',
		'jquery.fancybox',
	)
);
?>
<script>

//Placeholder fallback
var SITE = SITE || {};
 
SITE.fileInputs = function() {
  var $this = $(this),
      $val = $this.val(),
      valArray = $val.split('\\'),
      newVal = valArray[valArray.length-1],
      $button = $this.siblings('.button'),
      $fakeFile = $this.siblings('.file-holder');
  if(newVal !== '') {
	buttonSelected = jQuery(this).attr('selected') || 'Arquivo selecionado';
    $button.text(buttonSelected);
    if($fakeFile.length === 0) {
      $button.after('<span class="file-holder">' + newVal + '</span>');
    } else {
      $fakeFile.text(newVal);
    }
  }
};

//Smooth scroll to hash
function filterPath(string) {
	return string
		.replace(/^\//,'')
		.replace(/(index|default).[a-zA-Z]{3,4}$/,'')
		.replace(/\/$/,'')
	;
}

// use the first element that is "scrollable"
function scrollableElement(els) {
	for (var i = 0, argLength = arguments.length; i <argLength; i++) {
		var el = arguments[i],
			$scrollElement = $(el);
		if ($scrollElement.scrollTop()> 0) {
			return el;
		}
		else {
			$scrollElement.scrollTop(1);
			var isScrollable = $scrollElement.scrollTop()> 0;
			$scrollElement.scrollTop(0);
			if (isScrollable) {
				return el;
			}
		}
	}
	return [];
}

jQuery.fn.liScroll = function(settings) {
	settings = jQuery.extend({
	travelocity: 0.07
	}, settings);		
	return this.each(function(){
		var $strip = jQuery(this);
		$strip.addClass("newsticker")
		var stripWidth = 3;
		$strip.find("li").each(function(i){
			stripWidth += jQuery(this, i).outerWidth(true);
		});
		var $mask = $strip.wrap("<div class='mask'></div>");
		var $tickercontainer = $strip.parent().wrap("<div class='tickercontainer'></div>");								
		var containerWidth = $strip.parent().parent().width();	
		$strip.width(stripWidth);			
		var totalTravel = stripWidth+containerWidth;
		var defTiming = totalTravel/settings.travelocity;
		function scrollnews(spazio, tempo){
			$strip.animate({left: '-='+ spazio}, tempo, "linear", function(){$strip.css("left", containerWidth); scrollnews(totalTravel, defTiming);});
		}
		scrollnews(totalTravel, defTiming);				
		$strip.hover(function(){
			jQuery(this).stop();
		},
		function(){
			var offset = jQuery(this).offset();
			var residualSpace = offset.left + stripWidth;
			var residualTime = residualSpace/settings.travelocity;
			scrollnews(residualSpace, residualTime);
		});
	});	
};

jQuery(document).ready(function() {
	jQuery('.scrollup').trigger('click');
	jQuery(window).scroll(function(){
		if (jQuery(this).scrollTop() > 100) {
			jQuery('.scrollup').fadeIn();
		} else {
			jQuery('.scrollup').fadeOut();
		}
	});

	jQuery('.scrollup').click(function(){
		jQuery("html, body").animate({ scrollTop: 0 }, 600);
		return false;
	});

	// jQuery('input.login').on('click',function(e){
	// 	e.preventDefault();

	// 	window.location.href = '/koch/site/sistema/';

	// });

	$("ul#ticker01").liScroll();

	/* CAROUSEL HOME */
	jQuery('#slide1').carouFredSel({
		responsive: true,
		width: 700,
		scroll: 1,
		prev: '#prev1',
		next: '#next1',
		auto: false,
		items: {
			width: 260,
			visible: {
				min: 1,
				max: 3
			}
		},
		mousewheel: true,
		swipe: {
			onMouse: true,
			onTouch: true
		}
	});

	jQuery('#slide2').carouFredSel({
		responsive: true,
		width: 700,
		scroll: 1,
		prev: '#prev2',
		next: '#next2',
		auto: false,
		items: {
			width: 260,
			visible: {
				min: 1,
				max: 3
			}
		},
		mousewheel: true,
		swipe: {
			onMouse: true,
			onTouch: true
		}
	});

	jQuery('.telMask').mask('(99) 9999-9999?***********')
	jQuery('.dateMask').mask('99/99/9999');

	var locationPath = filterPath(location.pathname);
	var scrollElem = scrollableElement('html', 'body');

	jQuery('a.smooth-scroll[href*=#]').each(function() {
		var thisPath = filterPath(this.pathname) || locationPath;
		if (  locationPath == thisPath
			&& (location.hostname == this.hostname || !this.hostname)
			&& this.hash.replace(/#/,'') 
		) {
			var $target = jQuery(this.hash), target = this.hash;
			if (target && $target.offset()) {
				var targetOffset = $target.offset().top - 50 - parseInt(jQuery('body').css('margin-top'));
				jQuery(this).on('click', function(event) {
					event.preventDefault();
					jQuery(scrollElem).animate({scrollTop: targetOffset}, 400, function() {
						location.hash = target;
					});
				});
			}
		}
	});


});

jQuery(document).ready(function() {

	setTimeout(function(){
		jQuery(".carousel").trigger('click');
		jQuery('.carousel').carousel();
		//jQuery(".carousel-control.right").trigger('click');
	},5000);

	jQuery('.carousel').each(function(i){

		var id = $(this).find('.active').index();

		jQuery('.ultimas-noticias-home').addClass('active-index1');
		jQuery('.ultimas-noticias-home').removeClass('active-index2');
		jQuery('.ultimas-noticias-home').removeClass('active-index3');

		jQuery('.highlights').addClass('active-index1');
		jQuery('.highlights').removeClass('active-index2');
		jQuery('.highlights').removeClass('active-index3');
	});

	//vitrine
	jQuery('.carousel').on('slide',function(e){

		var id = $(this).find('.active').index();

		if(id == '0') {
			jQuery('.ultimas-noticias-home').addClass('active-index2');
			jQuery('.ultimas-noticias-home').removeClass('active-index1');
			jQuery('.ultimas-noticias-home').removeClass('active-index3');

			jQuery('.highlights').addClass('active-index2');
			jQuery('.highlights').removeClass('active-index1');
			jQuery('.highlights').removeClass('active-index3');

			
			// jQuery('.ultimas-noticias-home').addClass('active-index1');
			// jQuery('.ultimas-noticias-home').removeClass('active-index2');
			// jQuery('.ultimas-noticias-home').removeClass('active-index3');

			// jQuery('.highlights').addClass('active-index1');
			// jQuery('.highlights').removeClass('active-index2');
			// jQuery('.highlights').removeClass('active-index3');

			// jQuery('.ultimas-noticias-home').removeClass('active-index3');
		}

		if(id == '1') {
			jQuery('.ultimas-noticias-home').addClass('active-index3');
			jQuery('.ultimas-noticias-home').removeClass('active-index1');
			jQuery('.ultimas-noticias-home').removeClass('active-index2');

			jQuery('.highlights').addClass('active-index3');
			jQuery('.highlights').removeClass('active-index1');
			jQuery('.highlights').removeClass('active-index2');
		}

		if(id == '2') {

			jQuery('.ultimas-noticias-home').removeClass('active-index1');
			jQuery('.ultimas-noticias-home').removeClass('active-index2');
			jQuery('.ultimas-noticias-home').removeClass('active-index3');

			jQuery('.highlights').removeClass('active-index1');
			jQuery('.highlights').removeClass('active-index2');
			jQuery('.highlights').removeClass('active-index3');
		}

	});

    if ( !("placeholder" in document.createElement("input")) ) {
        jQuery("input[placeholder], textarea[placeholder]").each(function() {
            var val = jQuery(this).attr("placeholder");
            if ( this.value == "" ) {
                this.value = val;
            }
            jQuery(this).focus(function() {
                if ( this.value == val ) {
                    this.value = "";
                }
            }).blur(function() {
                if ( jQuery.trim(this.value) == "" ) {
                    this.value = val;
                }
            })
        });
 
        // Clear default placeholder values on form submit
        jQuery('form').submit(function() {
            jQuery(this).find("input[placeholder], textarea[placeholder]").each(function() {
                if ( this.value == jQuery(this).attr("placeholder") ) {
                    this.value = "";
                }
            });
        });
    }

	jQuery('div.input.file input[type=file]').each(function(){
		buttonSelect = jQuery(this).attr('select') || 'Selecione o arquivo';
		jQuery(this)
			.after('<span class="button">' + buttonSelect + '</span>')
			.bind('change focus click', SITE.fileInputs)
		;
	});

});

jQuery(document).ready(function(){

	/* RESIZE */
	//jQuery('.caroufredsel_wrapper').height(jQuery('.caroufredsel_wrapper li:first').height());

	jQuery('li.dropdown>a, li.dropdown-submenu>a').on('focus', function(){
		jQuery(this).parent().addClass('open');
	});

	jQuery('ul.nav>li:not(.dropdown)>a,ul.nav>li li:not(.dropdown-submenu)>a').on('focus', function(){
		jQuery(this).parent().parent().find('li.dropdown.open, li.dropdown-submenu.open').removeClass('open');
	});

	//Abrir links externos em nova janela, sem follow
	jQuery('a[href^=http]').each(function(){
		if(this.href.indexOf('webjump.com.br') == -1 && this.href.indexOf(location.hostname) == -1){
			jQuery(this)
				.attr('target', '_blank')
			;
		}
	});

    if (window.location.hash !== ''){
    	jQuery('a[href="' + window.location.hash + '"]').tab('show');
    }
	
	jQuery('a[data-toggle="tab"]').on('shown', function(e) {
		var scrollmem = jQuery('body').scrollTop();
		window.location.hash = e.target.hash;
		jQuery('html,body').scrollTop(scrollmem)
    });
    
    jQuery('.alert.with-close-button').prepend('<button type="button" class="close" data-dismiss="alert">&times;</button>');

//	jQuery('.h3,h3').wrap('<div class="text-align-center"></div>');

});

//Reseta zoom até que o próprio usuário amplie
//if (navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i)) {
    var viewportmeta = document.querySelector('meta[name="viewport"]');
    if (viewportmeta) {
        viewportmeta.content = 'width=device-width, minimum-scale=1.0, maximum-scale=1.0, initial-scale=1.0';
        document.body.addEventListener('gesturestart', function () {
            viewportmeta.content = 'width=device-width, minimum-scale=0.25, maximum-scale=1.6';
        }, false);
    }
//}

</script>
<?php
if(!empty($this->viewVars['scripts_for_layout_footer'])){
	echo $this->viewVars['scripts_for_layout_footer'];
}
?>