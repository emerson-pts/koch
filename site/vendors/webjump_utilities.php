<?php
class WebjumpUtilities{
	//Converte string em uma array_associativa
	//Parametros $string = 'chave=valor
	//						chave2=valor2
	//			$separator = '='

	function str2associative_array($string, $separator = '='){
		if(!preg_match_all('/^([^'.preg_quote($separator, '/').']+)'.preg_quote($separator, '/').'(.*)\s*$/m', $string, $matches)){
			return false;
		}
		array_walk_recursive($matches, create_function('&$val, $key', '$val = trim($val);'));
		return array_combine($matches[1], $matches[2]);
	}

	//Remove acentos
	function stripAccents($string){ 
		$a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
		$b = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
		$string = utf8_decode($string);    
		$string = strtr($string, utf8_decode($a), $b);
		$string = strtolower($string);
		return utf8_encode($string);
	}

	//Transforma string XML em array
	function array2xml($array, $tab = 0, $current_node = ''){
		$return = '';

		foreach($array AS $key=>$value){
			if(is_numeric($key))$key = $current_node.'_'.$key;
			$return .= str_repeat("\t",$tab).'<'.$key.'>';
			if (!is_array($value)){
				$return .= $value;
			}else{
				$return .= "\r\n".self::array2xml($value, $tab + 1, $key).str_repeat("\t",$tab);
			}
			$return .= '</'.$key.">\r\n";
		}
		return $return;
	}

	function xml2array($data){
		if (preg_match_all('/<([^>]+)>(.*?)<\/\1>/s', $data, $matches, PREG_SET_ORDER)){
			$return = array();
			$matches_count = count($matches);
			foreach($matches AS $match){
				$xml2array = self::xml2array($match[2]);
				if (isset($return[$match[1]]))$match[1] = $match[1].'-'.md5(microtime());
				$return[$match[1]] = $xml2array;
			}
		}else
			$return = $data;
	
		return $return;
	}

	function mb_str_pad($input, $pad_length, $pad_string=' ', $pad_type=STR_PAD_RIGHT) {
		$diff = strlen($input) - mb_strlen($input);
		return str_pad($input, $pad_length+$diff, $pad_string, $pad_type);
	}
}