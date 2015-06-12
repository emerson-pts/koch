(function($) {
	//Mini menu em formato plugin
	$.fn.miniMenu = function()
	{
		//MENU SEM ANIMAÇÃO
		this.css({opacity:0}).parent().hover(function()
		{
			$(this).children('.mini-menu').css({opacity:1});
			
		}, function()
		{
			$(this).children('.mini-menu').css('display', '').css({opacity:0});
		});
	};
})( jQuery );