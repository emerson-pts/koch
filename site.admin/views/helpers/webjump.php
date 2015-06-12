<?php
class WebjumpHelper extends Helper {
	
	function extract($r, $extract){
		//Se o índice da array é numérico
		if(is_numeric(key($r))){
			//Então executa a função em cada índice
			$return = array();
			foreach($r AS $key=>$value){
				$return[$key] = self::extract($value, $extract);
			}
			return $return;
		}

		$return = $extract;
		preg_match_all('/\{(.*?)\}/m', $extract, $matches,PREG_SET_ORDER);
		foreach($matches AS $key=>$match){
			if(!$extract_value = Set::extract($match[1], $r)){
				$extract_value = false;
			}
			else{
				if(is_array($extract_value)){
					$extract_value = implode('|',$extract_value);
				}
			}
			$return = preg_replace('/'.preg_quote($match[0], '/').'/m', $extract_value, $return);
		}
		return $return;
	}
	
	function return_bytes($val) {
		$val = trim($val);
		$last = strtolower($val[strlen($val)-1]);
		switch($last) {
			// The 'G' modifier is available since PHP 5.1.0
			case 'g':
				$val *= 1024;
			case 'm':
				$val *= 1024;
			case 'k':
				$val *= 1024;
		}
	
		return $val;
	}

	//Formata tag de keyword
	function keyword( $value, $conf = array()){
		$conf += array(
			'label' 	=> 'nome', 
			'color' 	=> 'color', 
			'tag_open' 	=> '<span class="keyword %s-keyword">', 
			'tag_close'	=> '</span>',
			'empty'		=> '<small>-Não informado-</small>',
		);
		if(empty($value) 
			|| !is_array($value) 
			|| !array_key_exists($conf['color'], $value) 
			|| !array_key_exists($conf['label'], $value)
			|| is_null($value[$conf['label']])
		){
			return $conf['empty'];
		}
		return sprintf($conf['tag_open'], $value[$conf['color']]) . $value[$conf['label']] . $conf['tag_close'];
	}
	
	function keywords( $values, $conf = array()){
		$conf += array(
			'empty'		=> '<small>-Não informado-</small>',
		);
		
		$return = array();
		foreach($values AS $key=>$value){
			if(empty($value)){
				$return[$key] = $conf['empty'];
			}else{
				$return[$key] = self::keyword($value, $conf);
			}
		}
		$return = implode(' ', array_unique($return));
		if(empty($return)){
			return $conf['empty'];
		}else{
			return $return;
		}
	}
}