<?php
class ResizeImg{	
	function resize(){
		ini_set("memory_limit","128M");
		
		$setup = $default = array(
			'src' => null, 
			'size' => null,
			'no_image' => 'img/default/no-image.png',
			'crop' => null,
			'crop_pos' => 'center center',
			'crop_color' => false,
			'cache_time' => 24*60*60,//1 dia
			'output' => null, //Nulo a saida é igual a imagem original, png, jpg e gif
			'corner' => null,
			'jpg_quality' => 75,
			'force_process' => false,
		);		
	
		//Se passou somente 1 parametro 
		if(func_num_args() == 1){
			$setup_args = func_get_arg(0);
			if(!is_array($setup_args)){
				return array('error' => 'Configuração inválida');
			}
			
			foreach(func_get_arg(0) AS $key=>$value){
				if(array_key_exists($key, $setup)){
					$setup[$key] = $value;
				}
			}
		}
		else{
			$setup_keys = array_keys($setup);
			foreach(func_get_args() AS $key=>$value){
				if(!isset($setup_keys[$key])){break;}
				$setup[$setup_keys[$key]] = $value;
			}
		}

		//Filtra configurações que não estão declaradas no default
		extract($setup);

		$imgDir = WWW_ROOT;
		$cacheDir = WWW_ROOT.'img/thumb/';
		$cacheUrl = '/img/thumb/';

		if(empty($src) && empty($no_image)){
			return array('error' => 'Arquivo não informado');
		}
		if(empty($size)){
			return array('error' => 'Tamanho não informado');
		}
		
		if(!empty($crop) && !preg_match('/^([0-9]+)(x|\*)([0-9]+)$/', $crop, $match_crop)){
			return array('error' => 'Tamanho de crop inválido');
		}

		//Posição do crop aceita valores entre 0.00 e 1.00
		//Equivalencias..
		//center 					= 0.5
		//left/top					= 0
		//right/bottom				= 1
		//center-left/center-top 	= 0.25 
		//center-right/center-bottom = 0.75 

		if($crop_pos == null){$crop_pos = 'center center';}
		if(!empty($crop_pos) && !preg_match('/^(0|0\.[0-9]{1,2}|1|(?:center-)?(?:left|right)|center) (0|0\.[0-9]{1,2}|1|(?:center-)?(?:top|bottom)|center)$/', strtolower($crop_pos), $match_crop_pos)){
			return array('error' => 'Posição de crop inválida');
		}

		if(empty($src) || !$src = realpath($imgDir.$src)){
			if(!$src = realpath($imgDir.$no_image)){
				return array('error' => 'Arquivo não localizado');
			}
			else{
				$no_image_active = true;
			}
		}

		$ext_original = preg_replace('/^.*\./', '', $src);
		if(empty($output)){$output = $ext_original;}

		if(!$src || !preg_match('/^'.preg_quote($imgDir, '/').'/', $src)){
			return array('error' => 'Arquivo inválido');
		}

		switch(strtolower($ext_original)){
			case 'jpg':
			case 'jpeg':
				$header = 'Content-type: image/jpeg';
				break;
				
			case 'gif':
				$header = 'Content-type: image/gif';
				break;
			
			case 'png':
				$header = 'Content-type: image/png';
				break;
		}

		$cacheFile = $cacheDir . preg_replace('/^'.preg_quote($imgDir, '/').'/', '', $src ) . '/' . preg_replace('/\.[^\.]+$/','', basename($src)). '_' . md5(serialize($setup)).'.'.$output;

		//Usa o arquivo de cache se ele existe e ainda não expirou
		if(is_file($cacheFile) && ($cache_time === false || filemtime($cacheFile) >= time()- $cache_time)){
			return array('header' => $header, 'file' => $cacheFile, 'url' => preg_replace('/([^\/]+)/e', 'rawurlencode("\1")', $cacheUrl.preg_replace('/^'.preg_quote($cacheDir, '/').'/', '', $cacheFile)));
		}
		if(!is_dir(dirname($cacheFile)) && !mkdir ( dirname($cacheFile),  $mode = 0777, $recursive = true)){
			return array('error' => 'Erro na criação do diretório de cache da miniatura.');
		}
		
		switch(strtolower($ext_original)){
			case 'jpg':
			case 'jpeg':
				$img_func = 'imagecreatefromjpeg';
				break;
				
			case 'gif':
				$img_func = 'imagecreatefromgif';
				break;
			
			case 'png':
				$img_func = 'imagecreatefrompng';
				break;
		}
		
		//Cria um objeto com a imagem original
		if (!$im = $img_func($src)){
			return array('error' => 'Imagem inválida');
		}
		
		//Lê o tamanho da imagem original
		$im_x = imagesx($im);
		$im_y = imagesy($im);

		//Se usou o formato larguraxaltura no parametro de tamanho, então verifica qual é o máximo permitido
		if (preg_match('/^([0-9]+)(x|\*)([0-9]+)$/',$size,$matches)){
			//Se está usando a imagem de marcação e forçando o tamanho do redimensionamento...
			if(!empty($no_image_active) && $matches[2] == '*'){
				//Utiliza o menor tamanho de largura ou altura
				if($matches[1] < $matches[3]){
					$matches[3] = $matches[1];
				}
				else{
					$matches[1] = $matches[3];
				}
			}
			
			if(($matches[2] == 'x' && $matches[1]/$im_x < $matches[3]/$im_y) || ($matches[2] == '*' && $matches[1]/$im_x > $matches[3]/$im_y)){
				$size = 'w'.$matches[1];
			}else{
				$size = 'h'.$matches[3];
			}
			
		}
		

		//Define nova largura e altura
		switch (substr($size,0,1)){
			case 'w':
				$width = (int)substr($size,1);
				$im_output_x = $width;
				$im_output_y = ceil($im_y*($width/$im_x));
				break;
						
			case 'h':
				$height = (int)substr($size,1);
				$im_output_x = ceil($im_x*($height/$im_y));
				$im_output_y = $height;
				break;
		}
		
		
		//Verifica se a imagem precisa ser redimensionada
		$resize = !($im_x < $im_output_x || $im_y < $im_output_y || ($im_x == $im_output_x && $im_y == $im_output_y));
		
		//Se não precisa redimensionar e não é para dar crop, somente copia a imagem original
		if(!$resize && empty($crop) && empty($corner) && $output == $ext_original && !$force_process){
			if(copy($src, $cacheFile))
				return array('header' => $header, 'file' => $cacheFile, 'url' => $cacheUrl.preg_replace('/^'.preg_quote($cacheDir, '/').'/', '', $cacheFile));
			else
				return array('error' => 'Erro na cópia do arquivo sem redimensionamento.');

		}
		//Se a imagem deve ser redimensionada
		else if($resize || $crop){
			//Cria nova imagem
			if (!$im_output = imagecreatetruecolor($im_output_x, $im_output_y)){
				return array('error' => 'Erro na geração da miniatura');
			}
			
			if(function_exists('imageantialias'))imageantialias($im_output,1);


			setTransparency($im_output, $im);
			switch(strtolower($output)){
				case 'gif':
					$transparent_index = ImageColorTransparent($im); // gives the index of current transparent color or -1 
					if($transparent_index!=(-1)){
						$transparent_color = ImageColorsForIndex($im, $transparent_index);
					}
					
					if(!empty($transparent_color)) // simple check to find wether transparent color was set or not 
					{
						$transparent_new = ImageColorAllocate( $im_output, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue'] );
						$transparent_new_index = ImageColorTransparent( $im_output, $transparent_new );
						
						ImageFill( $im_output, 0,0, $transparent_new_index ); // don't forget to fill the new image with the transparent color
					}
					break;
					
				case 'png': 
					//Salva transparência
					imagealphablending($im_output, false);
					imagesavealpha($im_output,true);
					$transparent = imagecolorallocatealpha($im_output, 255, 255, 255, 127);

					imagefilledrectangle($im_output, 0, 0, $im_output_x, $im_output_y, $transparent);
					break;

			}

			//Copia imagem original na nova redimensionada
			if(!imagecopyresampled ($im_output, $im, 0, 0, 0, 0, $im_output_x, $im_output_y, $im_x, $im_y)){
				return array('error' => 'Erro no redimensionamento da imagem');
			}
		}
		//caso contrário, cria uma imagem de saída igual a original
		else{
			$im_output = $im;
		}

		//Se é para dar crop e o tamanho foi informado em larguraxaltura
		if(!empty($crop) && 
			(	
				($match_crop[2] == 'x' && ($im_output_x > $match_crop[1] || $im_output_y > $match_crop[3]))
				||
				$match_crop[2] == '*'
			)
			
		){
				
			//se não redimensionu
			if(!$resize){
				$im_source_x = $im_x;
				$im_source_y = $im_y;
			}
			else{
				$im_source_x = $im_output_x;
				$im_source_y = $im_output_y;
			}
		
			if($match_crop[2] == 'x'){
				if($match_crop[1] > $im_output_x)$match_crop[1] = $im_output_x;
				if($match_crop[3] > $im_output_y)$match_crop[3] = $im_output_y;
			}
			
			$im_output_crop = imagecreatetruecolor($match_crop[1], $match_crop[3]);

			//Salva transparência
			imagealphablending($im_output_crop, false);
			imagesavealpha($im_output_crop,true);

			//Se definiu uma cor de fundo para o crop
			if(!empty($crop_color)){
				$crop_color = explode(',', $crop_color);
				$transparent = ImageColorAllocate( $im_output, $crop_color[0], $crop_color[1], $crop_color[2] );
			}
			else{
				$transparent = imagecolorallocatealpha($im_output_crop, 255, 255, 255, 127);
			}
			
			imagefill($im_output_crop, 0, 0, $transparent);

			switch(@$match_crop_pos[1]){
				case 'left':
					$crop_x = 0;
					break;

				case 'right':
					$crop_x = 1;
					break;

				case 'center-left':
					$crop_x = 0.25;
					break;

				case 'center-right':
					$crop_x = 0.75;
					break;
				
				case 'center':
					$crop_x = 0.5;
					break;
				
				default:
					$crop_x = $match_crop_pos[1];
					break;
			}
			
			if($crop_x < 0){
				$crop_x = 0;
			}
			
			
			$src_x = floor(($im_source_x*$crop_x)-($match_crop[1]*$crop_x));
			if($src_x < 0){$src_x = 0;}
			
			switch(@$match_crop_pos[2]){
				case 'top':
					$crop_y = 0;
					break;

				case 'bottom':
					$crop_y = 1;
					break;

				case 'center-top':
					$crop_y = 0.25;
					break;

				case 'center-bottom':
					$crop_y = 0.75;
					break;
				
				case 'center':
					$crop_y = 0.5;
					break;
				
				default:
					$crop_y = $match_crop_pos[2];
					break;
			}
			
			if($crop_y < 0){
				$crop_y = 0;
			}

			$src_y = floor(($im_source_y*$crop_y)-($match_crop[3]*$crop_y));
			if($src_y < 0){
				$src_y = 0;
			}

			if($match_crop[1] > $im_source_x){
				$x = ($match_crop[1] - $im_source_x)/2;
			}else{
				$x = 0;
			}
			
			if($match_crop[3] > $im_source_y){
				$y = ($match_crop[3] - $im_source_y)/2;
			}else{
				$y = 0;
			}

//			imagecopy($im_output_crop, $im_output, 0, 0, $src_x, $src_y, $match_crop[1], $match_crop[3]);
			imagecopy($im_output_crop, $im_output, $x, $y, $src_x, $src_y, $im_source_x, $im_source_y);
			$im_output = $im_output_crop;
		}

		//Curvas
		if(!empty($corner) && class_exists('Imagick')){ 
			//Pega a imagem atual
			ob_start();
			switch(strtolower($output)){
				case 'jpg':
				case 'jpeg':
					imagejpeg($im_output, false, $jpg_quality);
					break;
					
				case 'gif':
					imagegif($im_output);
					break;
				
				case 'png':
					imagepng($im_output);
					break;
			}

			/* Create a new object and read the image */
			$im = new Imagick();
			$im->readImageBlob(ob_get_clean());
 
			/* Round the corners. (yes, this is all that is needed.) */
			$im->roundCorners( $corner, $corner );
			$im_output = imagecreatefromstring($im);
		}

/*
		//Marca d'água se a imagem tem mais de 200 pixels
		if($im_output_x > 400 || $im_output_y > 250){
			$watermark_im = imagecreatefrompng(WWW_ROOT.'img/watermark.png');
			$watermark_space_x = 200;
			$watermark_space_y = 100;
			$padding = 10;
			
			$watermark_x = imagesx($watermark_im);
			$watermark_y = imagesy($watermark_im);
			
			$start_x = $padding;
			
			//Aplica marca d'água
			for($current_y = $padding; $current_y < $im_output_y; $current_y += $watermark_y + $watermark_space_y){
				for($current_x = $start_x; $current_x < $im_output_x; $current_x += $watermark_x + $watermark_space_x){
					imagecopy($im_output, $watermark_im, $current_x, $current_y, 0, 0, $watermark_x, $watermark_y);
				}
				$start_x = ($start_x == $padding ? $watermark_x/2 + $watermark_space_x/2 + $padding : $padding);
			}
		}
*/
		
		
		//Limpa status de existência ou não dos arquivos
		clearstatcache();

		switch(strtolower($output)){
			case 'jpg':
			case 'jpeg':
				$img = imagejpeg($im_output, $cacheFile, $jpg_quality);
				break;
				
			case 'gif':
				$img = imagegif($im_output, $cacheFile);
				break;
			
			case 'png':
				$img = imagepng($im_output, $cacheFile);
				break;
		}
		
		//Cria arquivo da miniatura e verifica se ele foi realmente criado
		if (!$img || !is_file($cacheFile)){
			return array('error' => 'Erro na geração do cache da miniatura.');
		}

		//Exibe imagem
		//Corrigir url
		return array('header' => $header, 'file' => $cacheFile, 'url' => preg_replace('/([^\/]+)/e', 'rawurlencode("\1")', $cacheUrl.preg_replace('/^'.preg_quote($cacheDir, '/').'/', '', $cacheFile)));
	}
}

function setTransparency($new_image,$image_source)
    {
       
           // $transparencyIndex = imagecolortransparent($image_source);
            $transparencyColor = array('red' => 255, 'green' => 255, 'blue' => 255);
            
           /* if ($transparencyIndex >= 0) {
                $transparencyColor    = imagecolorsforindex($image_source, $transparencyIndex);   
            }
           */
           
            $transparencyIndex    = imagecolorallocate($new_image, $transparencyColor['red'], $transparencyColor['green'], $transparencyColor['blue']);
            imagefill($new_image, 0, 0, $transparencyIndex);
             imagecolortransparent($new_image, $transparencyIndex);
       
    } 
