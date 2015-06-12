<?php
class VimeoHelper extends Helper {
	
	function getVideoEmbed($url, $setup = array()){
		$setup += array(
			'width' => '560',
			'height' => '315',
			'allowfullscreen' => true,
		);
	
		if(!preg_match(
			'/vimeo\.com\/([^\/]+)/',
			$url,
			$match
		)){
			if(strstr($url, 'youtube')){
				if(!class_exists('YoutubeHelper')){
					App::import('Helper', 'Youtube');
				}
				return YoutubeHelper::getVideoEmbed($url);
				
			}
			return $url;
		}
		
		$id = $match[1];

		return '<iframe width="' . $setup['width'] . '" height="' . $setup['height'] . '" src="//player.vimeo.com/video/'.$id.'" frameborder="0" '.($setup['allowfullscreen'] ? 'webkitallowfullscreen mozallowfullscreen allowfullscreen' : '').'></iframe><br /><a href="'.$url.'">Tailândia by Boom! Viagens</a>';
	}
}