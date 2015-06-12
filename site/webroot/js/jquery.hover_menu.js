// jQuery para fazer o hover nos menus tipo bandeira
jQuery(document).ready(function(){
	jQuery('a.flag_link.red').mouseenter(function(){
	 	jQuery('a.flag_link.yellow .flag_menu.yellow').addClass('bg_yellow');
	 	jQuery('a.flag_link.yellow .flag_menu.yellow div .image').addClass('img_yellow');
		
		jQuery('a.flag_link.blue .flag_menu.blue').addClass('bg_blue');
	 	jQuery('a.flag_link.blue .flag_menu.blue div .image').addClass('img_blue');
	})
	jQuery('a.flag_link.red').mouseleave(function(){
	 	jQuery('a.flag_link.yellow .flag_menu.yellow').removeClass('bg_yellow');
	 	jQuery('a.flag_link.yellow .flag_menu.yellow div .image').removeClass('img_yellow');
		
		jQuery('a.flag_link.blue .flag_menu.blue').removeClass('bg_blue');
	 	jQuery('a.flag_link.blue .flag_menu.blue div .image').removeClass('img_blue');
	})
	
	
	jQuery('a.flag_link.yellow').mouseenter(function(){
	 	jQuery('a.flag_link.red .flag_menu.red').addClass('bg_red');
	 	jQuery('a.flag_link.red .flag_menu.red div .image').addClass('img_red');
		
		jQuery('a.flag_link.blue .flag_menu.blue').addClass('bg_blue');
	 	jQuery('a.flag_link.blue .flag_menu.blue div .image').addClass('img_blue');
	})
	jQuery('a.flag_link.yellow').mouseleave(function(){
	 	jQuery('a.flag_link.red .flag_menu.red').removeClass('bg_red');
	 	jQuery('a.flag_link.red .flag_menu.red div .image').removeClass('img_red');
		
		jQuery('a.flag_link.blue .flag_menu.blue').removeClass('bg_blue');
	 	jQuery('a.flag_link.blue .flag_menu.blue div .image').removeClass('img_blue');
	})

	jQuery('a.flag_link.blue').mouseenter(function(){
	 	jQuery('a.flag_link.red .flag_menu.red').addClass('bg_red');
	 	jQuery('a.flag_link.red .flag_menu.red div .image').addClass('img_red');
		
		jQuery('a.flag_link.yellow .flag_menu.yellow').addClass('bg_yellow');
	 	jQuery('a.flag_link.yellow .flag_menu.yellow div .image').addClass('img_yellow');
	})
	jQuery('a.flag_link.blue').mouseleave(function(){
	 	jQuery('a.flag_link.red .flag_menu.red').removeClass('bg_red');
	 	jQuery('a.flag_link.red .flag_menu.red div .image').removeClass('img_red');
		
	 	jQuery('a.flag_link.yellow .flag_menu.yellow').removeClass('bg_yellow');
	 	jQuery('a.flag_link.yellow .flag_menu.yellow div .image').removeClass('img_yellow');
	})
	
})	