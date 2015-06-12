<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
class AppModel extends Model {
	var $actsAs = array('Lockable', 'DateFormatter','Containable','EnumSet',
		'Logable' =>  array(
			'userModel' => 'Usuario', 
			'userKey' => 'usuario_id', 
			'change' => 'full', // options are 'list' or 'full'
			'description_ids' => TRUE, // options are TRUE or FALSE
			'ignore' => array('data_cadastro','senha',),
			'skip' => 'add',
			'disable_behavior' => array('DateFormatter', 'Xml',),
			'ignore_models'	=> array('Aro', 'Sitemap', 'Galeria', 'Destino', /* 'Aco', 'ArosAco'*/),
		)
	);

	function beforeSave(){
		foreach($columns = $this->getColumnTypes() AS $field=>$type){
			if (preg_match('/^data_(cadastro|alteracao)$/',$field) && preg_match('/^(date|datetime)$/',$type) && !isset($this->data[$this->alias][$field]))
				$this->data[$this->alias][$field] = date('Y-m-d'.($type == 'datetime' ? ' H:i:s' : ''));
		}
		
		//Meio Upload - limpa caminho completo do campo dir
		if(isset($this->actsAs['MeioUpload'])){
			foreach($this->actsAs['MeioUpload'] AS $upload_field=>$upload_conf){
				if(!empty($this->data[$this->alias][$upload_field])){
					$this->data[$this->alias][$upload_field] = preg_replace('/^'.preg_quote(SITE_DIR, '/').'(webroot\/)?/', '', $upload_conf['dir']).$this->data[$this->alias][$upload_field];
				}
			}
		}
		
		return true;
	}
	
	function afterSave(){
		$this->clearCache();
	}

	function afterDelete(){
		$this->clearCache();
	}
	
	function clearCache(){
		if($files = array_merge(
			glob(preg_replace('/\.admin/', '', CACHE).'views/*.*'), 
			glob(preg_replace('/\.admin/', '', CACHE).'*.*'),
			glob(preg_replace('/\.admin/', '', CACHE).'cake_*'),
			glob(CACHE.'views/*.*'), 
			glob(CACHE.'*.*'),
			glob(CACHE.'cake_*')
		)){
			foreach($files as $v)unlink($v);
		}
		return true;
	}
	
	function paginateCount($conditions = null, $recursive = 0, $extra = array()) {
		$parameters = compact('conditions', 'recursive');
		if (isset($extra['group'])) {
			$parameters['fields'] = $extra['group'];
			if (is_string($parameters['fields'])) {
				// pagination with single GROUP BY field
				if (substr($parameters['fields'], 0, 9) != 'DISTINCT ') {
					$parameters['fields'] = 'DISTINCT ' . $parameters['fields'];
				}
				unset($extra['group']);
				$count = $this->find('count', array_merge($parameters, $extra));
			} else {
				// resort to inefficient method for multiple GROUP BY fields
				$count = $this->find('count', array_merge($parameters, $extra));
				$count = $this->getAffectedRows();
			}
		} else {
			// regular pagination
			$count = $this->find('count', array_merge($parameters, $extra));
		}
		return $count;
	}

	// just pulled out of thin air (i.e. untested)
	function validateAtLeastOne($data) {
		$args = func_get_args();  // will contain $data, 'myField2', 'myField3', ...
	
		foreach ($args as $name) {
			if (is_array($name)) {
				$name = current(array_keys($name));
			}
			if (!empty($this->data[$this->alias][$name])) {
				return true;
			}
		}
	
		return false;
	}
	
    //identifica se o que foi digitado é cpf ou cnpj
	function _cnpj_cpf($cnpj_cpf){
		//Ajusta pontuação
		$key = key($cnpj_cpf);
		$value = current($cnpj_cpf);
		
		$value = preg_replace(
			array(
				'/^([0-9]{3})([0-9]{3})([0-9]{3})([0-9]{2})$/',
				'/^([0-9]{2})([0-9]{3})([0-9]{3})([0-9]{4})([0-9]{2})$/',
			),
			array(
				'\1.\2.\3-\4',
				'\1.\2.\3/\4-\5',
			),
			$value
		);

		$this->data[$this->alias][$key] = $value;
				
		//Preenchido com 14 zeros
		if(preg_match('/^0{14}$/',$value)){
			return true;
		}
		//Internacional (inicia com 3 letras maiúsculas ou é válido
		else if(
			$this->_is_cpf($value) || 
			$this->_is_cnpj($value)
		){
			return true;
		}else{
			return false;
		}
	}

	//Valida CPF
	function _is_cpf($cpf) {
		if(is_array($cpf)){
			$cpf = current($cpf);
		}
	   if (strlen($cpf)<11 OR preg_match("/[^0-9\.\-]/",$cpf)){
		  return 0;
	   }
	   $nulos = array("12345678909","11111111111","22222222222","33333333333",
					  "44444444444","55555555555","66666666666","77777777777",
					  "88888888888","99999999999","00000000000");
	   /* Retira todos os caracteres que nao sejam 0-9 */
	   $aux="";
	   for ($i=1; $i<=strlen($cpf); $i++){
		 $ch=substr($cpf,$i-1,1);
		 if (ord($ch)>=48 && ord($ch)<=57){
		   $aux=$aux.$ch;
		 }
	   }
	   $cpf = $aux;
	   /* Retorna falso se o cpf for nulo */
	   foreach ( $nulos as $nulo ) {
		 if($cpf == $nulo){
		   return 0;
		 }
	   }
	   /*Calcula o penúltimo dígito verificador*/
	   $acum=0;
	   for($i=0; $i<9; $i++) {
		 $acum+= $cpf[$i]*(10-$i);
	   }

	   $x=$acum % 11;
	   $acum = ($x>1) ? (11 - $x) : 0;
	   /* Retorna falso se o digito calculado eh diferente do passado na string */
	   if ($acum != $cpf[9]){
		 return 0;
	   }
	   /*Calcula o último dígito verificador*/
	   $acum=0;
	   for ($i=0; $i<10; $i++){
		 $acum+= $cpf[$i]*(11-$i);
	   }

	   $x=$acum % 11;
	   $acum = ($x > 1) ? (11-$x) : 0;
	   /* Retorna falso se o digito calculado eh diferente do passado na string */
	   if ( $acum != $cpf[10]){
		 return 0;
	   }
	   /* Retorna verdadeiro se o cpf eh valido */
	   return 1;
	}
	/**
	 * Verifica CNPJ
	 *
	 * @author Alejandro Fernandez Moraga <moraga86@gmail.com>
	 * @link http://www.moraga.com.br
	 * @param string $str CNPJ
	 * @return string|false
	 */

	function _is_cnpj($str) {
		if(is_array($str)){
			$str = current($str);
		}

		if (!preg_match('|^(\d{2,3})\.?(\d{3})\.?(\d{3})\/?(\d{4})\-?(\d{2})$|', $str, $matches))
			return false;

		array_shift($matches);
		$str = implode('', $matches);

		if (strlen($str) > 14)
			$str = substr($str, 1);

		$sum1 = 0;
		$sum2 = 0;
		$sum3 = 0;
		$calc1 = 5;
		$calc2 = 6;

		for ($i=0; $i <= 12; $i++) {
			$calc1 = ($calc1 < 2) ? 9 : $calc1;
			$calc2 = ($calc2 < 2) ? 9 : $calc2;

			if ($i <= 11)
				$sum1 += $str[$i] * $calc1;

			$sum2 += $str[$i] * $calc2;
			$sum3 += $str[$i];
			$calc1--;
			$calc2--;
		}

		$sum1 %= 11;
		$sum2 %= 11;

		return ($sum3 && $str[12] == ($sum1 < 2 ? 0 : 11 - $sum1) && $str[13] == ($sum2 < 2 ? 0 : 11 - $sum2)) ? /*$str*/ true : false;
	}
	
	function friendly_url_validate($field, $options = array(), $validate_options = null){
		$defaults = array('field' => null, 'key_to_return' => 'friendly_url');
		$options = Set::merge($defaults, $options);

		//Se enviou a url, ignora verificação - neste caso, acrescente a validação unique no campo friendly_url
		if(!empty($this->data[$this->alias][$options['key_to_return']])){
			$this->data[$this->alias][$options['key_to_return']] = strtolower(Inflector::slug($this->data[$this->alias][$options['key_to_return']],'-'));
			return true;
		}
		
		if(empty($options['field'])){
			$value = current($field);
		}else{
			foreach($options['field'] AS $key => $field){
				$options['field'][$key] = Set::extract($field, $this->data);
			}
			$value = implode(' ', $options['field']);
		}

		if(!$friendly_url = $this->friendly_url($value)){
			return false;
		}
	
		$this->data[$this->alias][$options['key_to_return']] = $friendly_url;
		return true;
	}
	
	function friendly_url($value, $id = null){
		if(empty($id))$id = $this->id;
		//Troca acentos, caracteres especiais por hifen
 		$friendly_url = strtolower(Inflector::slug($value,'-'));
		$sufix = 0;
		
		if(empty($friendly_url)){
			$friendly_url = __('sem-titulo', true);
		}
		
		$friendly_url_valid = $friendly_url.(empty($sufix) ? '' : '-'.$sufix);
		
		while($sufix < 9999 && 0 != ($count = $this->find('count', array('contain' => array(), 'conditions' => array('friendly_url' => $friendly_url_valid) + (!empty($id) ? array('id !=' => $id) : array()))))){
			$sufix++;
			$friendly_url_valid = $friendly_url.(empty($sufix) ? '' : '-'.$sufix);
		}
		
		if($sufix == 9999 && !empty($count)){
			return false;
		}
		
		return $friendly_url_valid;
	}
	
	function afterFind($results, $primary = true){
		//Primary é false quando a array do resultado é enviada no formato 
		//	array('campo1' => 'valor1', 'campo2' => 'valor2')
		//	ou array(0 => array('Model' => array('campo1' => 'valor1', 'campo2' => 'valor2')), 1 => array('Model' => array('campo1' => 'valor1', 'campo2' => 'valor2')))
		if(/*!$primary ||*/ !is_array(current($results))){

			$results = $this->afterFindExecute($results);
		}
		//Se foi enviada no formato array('Model' => array('campo1' => 'valor1', 'campo2' => 'valor2'))
		else if (array_key_exists($this->alias, $results)){
			$results[$this->alias] = $this->afterFindExecute($results[$this->alias]);
			$results = $this->afterFindAssociates($results);
		}
		//Caso contrário está no formato array(0 => array('Model' ...)=> array('campo1' => 'valor1', 'campo2' => 'valor2')))
		else{
			foreach ($results as $key => $val) {
				if(isset($val[$this->alias])){
					$results[$key][$this->alias] = $this->afterFindExecute($val[$this->alias]);
				}else{
					if(is_array($val)){
						$results[$key] = $this->afterFindExecute($val);
					}
	//				$results[$key] = $this->afterFindAssociates($results[$key]);
				}
			}
		}
		//Se está setada a variável $this->afterFindGetfullpath...
		if(!empty($this->afterFindGetfullpath)){
			//Faz backup da configuração
			$configGetfullpath = $this->afterFindGetfullpath;

			//reseta a variável 
			$this->afterFindGetfullpath = false;
			
			//Se está no formato array('id' => 1, 'nome' => ...);
			if(array_key_exists('id', $results)){
				if(is_array($configGetfullpath)){
					foreach($configGetfullpath AS $label){
						$results['fullpath_'.$label] = $this->getfullpath($results['id'], $separator = '/', $label);
						if($label == $this->displayField){
							$results['fullpath'] = $results['fullpath_'.$label];
						}
						
					}
				}else{
					$results['fullpath'] = $this->getfullpath($results['id']);
				}
				
			}
			//Caso contrário, está no formato (array(0 => array('id'  =>  1, 'nome' => ...), 1 => array('id'  =>  1, 'nome' => ...), 2...)
			else{
				foreach($results AS $key=>$value){			
					if(!isset($value[$this->alias]['id']))break;
					
					if(is_array($configGetfullpath)){
						foreach($configGetfullpath AS $label){
							$results[$key][$this->alias]['fullpath_'.$label] = $this->getfullpath($value[$this->alias]['id'], $separator = '/', $label);
							if($label == $this->displayField){
								$results[$key][$this->alias]['fullpath'] = $results[$key][$this->alias]['fullpath_'.$label];
							}
						}
					}else{
						$results[$key][$this->alias]['fullpath'] = $this->getfullpath($value[$this->alias]['id']);
					}
				}
			}
			$this->afterFindGetfullpath = $configGetfullpath;
		}
		return $results;
	}
	
	//Correção para executar o after find dos modelos associados
	function afterFindAssociates($result){
	return $result;
		//Associações
		$associatedModels = array_merge(
			array_keys($this->belongsTo),
			array_keys($this->hasOne),
			array_keys($this->hasMany),
			array_keys($this->hasAndBelongsToMany)
							
		);
		foreach($associatedModels AS $associatedModel){
			if (array_key_exists($associatedModel, $result)){
//		var_dump($result);exit;
				$result[$associatedModel] = $this->$associatedModel->afterFind($result[$associatedModel]);
			}
		}
		return $result;
	}
	
	//Funções padrão de afterFind
	function afterFindExecute($result){
		return $result;
	}

	//Função para checar a data minima	
	function validateDateMin($value, $data){
		$value = current($value);
		$value = preg_replace('/^(..)\/(..)\/(....)$/', '\3-\2-\1',$value);
		if($value >= $data){
			return true;
		}else{
			return false;
		}
	}
	
	/** 
	* checks is the field value is unqiue in the table 
	* note: we are overriding the default cakephp isUnique test as the 
	original appears to be broken 
	* 
	* @param string $data Unused ($this->data is used instead) 
	* @param mnixed $fields field name (or array of field names) to 
	validate 
	* @return boolean true if combination of fields is unique 
	*/ 
	function checkUnique($data, $fields) { 
		$tmp = array();
		
		if (!is_array($fields)) { 
			$fields = array($fields); 
		}
		foreach($fields as $key) { 
			if(!empty($this->data[$this->name][$key])){
				$tmp[$key] = $this->data[$this->name][$key]; 
			}
		} 
		if (!empty($this->data[$this->name][$this->primaryKey]) && empty($this->id)) { 
			$tmp[$this->primaryKey.' !='] = $this->data[$this->name][$this->primaryKey]; 
		} 
		return $this->isUnique($tmp, false); 
	}
	
	//Lista de Estados
	function estados(){
	   $return = array(
		  ''=>'-Selecione-',
		  "AC"=>"Acre",
		  "AL"=>"Alagoas",
		  "AP"=>"Amapá",
		  "AM"=>"Amazonas",
		  "BA"=>"Bahia",
		  "CE"=>"Ceará",
		  "DF"=>"Distrito Federal",
		  "ES"=>"Espírito Santo",
		  "GO"=>"Goiás",
		  "MA"=>"Maranhão",
		  "MT"=>"Mato Grosso",
		  "MS"=>"Mato Grosso do Sul",
		  "MG"=>"Minas Gerais",
		  "PA"=>"Pará",
		  "PB"=>"Paraíba",
		  "PR"=>"Paraná",
		  "PE"=>"Pernambuco",
		  "PI"=>"Piauí",
		  "RJ"=>"Rio de Janeiro",
		  "RN"=>"Rio Grande do Norte",
		  "RS"=>"Rio Grande do Sul",
		  "RO"=>"Rondônia",
		  "RR"=>"Roraima",
		  "SP"=>"São Paulo",
		  "SC"=>"Santa Catarina",
		  "SE"=>"Sergipe",
		  "TO"=>"Tocantins",
		);
		return $return;
	}
	 
	//Valida estado
	function validateEstado($key){
		$estados = $this->estados();
		if (!isset($estados[current($key)])){
			return false;
		}else{
			return true;
		}
	}

		
	function paises(){
	   $return = array(
		  "BR"=>"BRASIL",
		  "AF"=>"AFGHANISTAN",
		  "AX"=>"ÅLAND ISLANDS",
		  "AL"=>"ALBANIA",
		  "DZ"=>"ALGERIA",
		  "AS"=>"AMERICAN SAMOA",
		  "AD"=>"ANDORRA",
		  "AO"=>"ANGOLA",
		  "AI"=>"ANGUILLA",
		  "AQ"=>"ANTARCTICA",
		  "AG"=>"ANTIGUA AND BARBUDA",
		  "AR"=>"ARGENTINA",
		  "AM"=>"ARMENIA",
		  "AW"=>"ARUBA",
		  "AU"=>"AUSTRALIA",
		  "AT"=>"AUSTRIA",
		  "AZ"=>"AZERBAIJAN",
		  "BS"=>"BAHAMAS",
		  "BH"=>"BAHRAIN",
		  "BD"=>"BANGLADESH",
		  "BB"=>"BARBADOS",
		  "BY"=>"BELARUS",
		  "BE"=>"BELGIUM",
		  "BZ"=>"BELIZE",
		  "BJ"=>"BENIN",
		  "BM"=>"BERMUDA",
		  "BT"=>"BHUTAN",
		  "BO"=>"BOLIVIA",
		  "BA"=>"BOSNIA AND HERZEGOVINA",
		  "BW"=>"BOTSWANA",
		  "BV"=>"BOUVET ISLAND",
		  "IO"=>"BRITISH INDIAN OCEAN TERRITORY",
		  "BN"=>"BRUNEI DARUSSALAM",
		  "BG"=>"BULGARIA",
		  "BF"=>"BURKINA FASO",
		  "BI"=>"BURUNDI",
		  "KH"=>"CAMBODIA",
		  "CM"=>"CAMEROON",
		  "CA"=>"CANADA",
		  "CV"=>"CAPE VERDE",
		  "KY"=>"CAYMAN ISLANDS",
		  "CF"=>"CENTRAL AFRICAN REPUBLIC",
		  "TD"=>"CHAD",
		  "CL"=>"CHILE",
		  "CN"=>"CHINA",
		  "CX"=>"CHRISTMAS ISLAND",
		  "CC"=>"COCOS (KEELING) ISLANDS",
		  "CO"=>"COLOMBIA",
		  "KM"=>"COMOROS",
		  "CG"=>"CONGO",
		  "CD"=>"CONGO, THE DEMOCRATIC REPUBLIC OF THE",
		  "CK"=>"COOK ISLANDS",
		  "CR"=>"COSTA RICA",
		  "CI"=>"COTE D'IVOIRE",
		  "HR"=>"CROATIA",
		  "CU"=>"CUBA",
		  "CY"=>"CYPRUS",
		  "CZ"=>"CZECH REPUBLIC",
		  "DK"=>"DENMARK",
		  "DJ"=>"DJIBOUTI",
		  "DM"=>"DOMINICA",
		  "DO"=>"DOMINICAN REPUBLIC",
		  "EC"=>"ECUADOR",
		  "EG"=>"EGYPT",
		  "SV"=>"EL SALVADOR",
		  "GQ"=>"EQUATORIAL GUINEA",
		  "ER"=>"ERITREA",
		  "EE"=>"ESTONIA",
		  "ET"=>"ETHIOPIA",
		  "FK"=>"FALKLAND ISLANDS (MALVINAS)",
		  "FO"=>"FAROE ISLANDS",
		  "FJ"=>"FIJI",
		  "FI"=>"FINLAND",
		  "FR"=>"FRANCE",
		  "GF"=>"FRENCH GUIANA",
		  "PF"=>"FRENCH POLYNESIA",
		  "TF"=>"FRENCH SOUTHERN TERRITORIES",
		  "GA"=>"GABON",
		  "GM"=>"GAMBIA",
		  "GE"=>"GEORGIA",
		  "DE"=>"GERMANY",
		  "GH"=>"GHANA",
		  "GI"=>"GIBRALTAR",
		  "GR"=>"GREECE",
		  "GL"=>"GREENLAND",
		  "GD"=>"GRENADA",
		  "GP"=>"GUADELOUPE",
		  "GU"=>"GUAM",
		  "GT"=>"GUATEMALA",
		  "GN"=>"GUINEA",
		  "GW"=>"GUINEA-BISSAU",
		  "GY"=>"GUYANA",
		  "HT"=>"HAITI",
		  "HM"=>"HEARD ISLAND AND MCDONALD ISLANDS",
		  "VA"=>"HOLY SEE (VATICAN CITY STATE)",
		  "HN"=>"HONDURAS",
		  "HK"=>"HONG KONG",
		  "HU"=>"HUNGARY",
		  "IS"=>"ICELAND",
		  "IN"=>"INDIA",
		  "ID"=>"INDONESIA",
		  "IR"=>"IRAN, ISLAMIC REPUBLIC OF",
		  "IQ"=>"IRAQ",
		  "IE"=>"IRELAND",
		  "IL"=>"ISRAEL",
		  "IT"=>"ITALY",
		  "JM"=>"JAMAICA",
		  "JP"=>"JAPAN",
		  "JO"=>"JORDAN",
		  "KZ"=>"KAZAKHSTAN",
		  "KE"=>"KENYA",
		  "KI"=>"KIRIBATI",
		  "KP"=>"KOREA, DEMOCRATIC PEOPLE'S REPUBLIC OF",
		  "KR"=>"KOREA, REPUBLIC OF",
		  "KW"=>"KUWAIT",
		  "KG"=>"KYRGYZSTAN",
		  "LA"=>"LAO PEOPLE'S DEMOCRATIC REPUBLIC",
		  "LV"=>"LATVIA",
		  "LB"=>"LEBANON",
		  "LS"=>"LESOTHO",
		  "LR"=>"LIBERIA",
		  "LY"=>"LIBYAN ARAB JAMAHIRIYA",
		  "LI"=>"LIECHTENSTEIN",
		  "LT"=>"LITHUANIA",
		  "LU"=>"LUXEMBOURG",
		  "MO"=>"MACAO",
		  "MK"=>"MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF",
		  "MG"=>"MADAGASCAR",
		  "MW"=>"MALAWI",
		  "MY"=>"MALAYSIA",
		  "MV"=>"MALDIVES",
		  "ML"=>"MALI",
		  "MT"=>"MALTA",
		  "MH"=>"MARSHALL ISLANDS",
		  "MQ"=>"MARTINIQUE",
		  "MR"=>"MAURITANIA",
		  "MU"=>"MAURITIUS",
		  "YT"=>"MAYOTTE",
		  "MX"=>"MEXICO",
		  "FM"=>"MICRONESIA, FEDERATED STATES OF",
		  "MD"=>"MOLDOVA, REPUBLIC OF",
		  "MC"=>"MONACO",
		  "MN"=>"MONGOLIA",
		  "MS"=>"MONTSERRAT",
		  "MA"=>"MOROCCO",
		  "MZ"=>"MOZAMBIQUE",
		  "MM"=>"MYANMAR",
		  "NA"=>"NAMIBIA",
		  "NR"=>"NAURU",
		  "NP"=>"NEPAL",
		  "NL"=>"NETHERLANDS",
		  "AN"=>"NETHERLANDS ANTILLES",
		  "NC"=>"NEW CALEDONIA",
		  "NZ"=>"NEW ZEALAND",
		  "NI"=>"NICARAGUA",
		  "NE"=>"NIGER",
		  "NG"=>"NIGERIA",
		  "NU"=>"NIUE",
		  "NF"=>"NORFOLK ISLAND",
		  "MP"=>"NORTHERN MARIANA ISLANDS",
		  "NO"=>"NORWAY",
		  "OM"=>"OMAN",
		  "PK"=>"PAKISTAN",
		  "PW"=>"PALAU",
		  "PS"=>"PALESTINIAN TERRITORY, OCCUPIED",
		  "PA"=>"PANAMA",
		  "PG"=>"PAPUA NEW GUINEA",
		  "PY"=>"PARAGUAY",
		  "PE"=>"PERU",
		  "PH"=>"PHILIPPINES",
		  "PN"=>"PITCAIRN",
		  "PL"=>"POLAND",
		  "PT"=>"PORTUGAL",
		  "PR"=>"PUERTO RICO",
		  "QA"=>"QATAR",
		  "RE"=>"REUNION",
		  "RO"=>"ROMANIA",
		  "RU"=>"RUSSIAN FEDERATION",
		  "RW"=>"RWANDA",
		  "SH"=>"SAINT HELENA",
		  "KN"=>"SAINT KITTS AND NEVIS",
		  "LC"=>"SAINT LUCIA",
		  "PM"=>"SAINT PIERRE AND MIQUELON",
		  "VC"=>"SAINT VINCENT AND THE GRENADINES",
		  "WS"=>"SAMOA",
		  "SM"=>"SAN MARINO",
		  "ST"=>"SAO TOME AND PRINCIPE",
		  "SA"=>"SAUDI ARABIA",
		  "SN"=>"SENEGAL",
		  "CS"=>"SERBIA AND MONTENEGRO",
		  "SC"=>"SEYCHELLES",
		  "SL"=>"SIERRA LEONE",
		  "SG"=>"SINGAPORE",
		  "SK"=>"SLOVAKIA",
		  "SI"=>"SLOVENIA",
		  "SB"=>"SOLOMON ISLANDS",
		  "SO"=>"SOMALIA",
		  "ZA"=>"SOUTH AFRICA",
		  "GS"=>"SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS",
		  "ES"=>"SPAIN",
		  "LK"=>"SRI LANKA",
		  "SD"=>"SUDAN",
		  "SR"=>"SURINAME",
		  "SJ"=>"SVALBARD AND JAN MAYEN",
		  "SZ"=>"SWAZILAND",
		  "SE"=>"SWEDEN",
		  "CH"=>"SWITZERLAND",
		  "SY"=>"SYRIAN ARAB REPUBLIC",
		  "TW"=>"TAIWAN, PROVINCE OF CHINA",
		  "TJ"=>"TAJIKISTAN",
		  "TZ"=>"TANZANIA, UNITED REPUBLIC OF",
		  "TH"=>"THAILAND",
		  "TL"=>"TIMOR-LESTE",
		  "TG"=>"TOGO",
		  "TK"=>"TOKELAU",
		  "TO"=>"TONGA",
		  "TT"=>"TRINIDAD AND TOBAGO",
		  "TN"=>"TUNISIA",
		  "TR"=>"TURKEY",
		  "™"=>"TURKMENISTAN",
		  "TC"=>"TURKS AND CAICOS ISLANDS",
		  "TV"=>"TUVALU",
		  "UG"=>"UGANDA",
		  "UA"=>"UKRAINE",
		  "AE"=>"UNITED ARAB EMIRATES",
		  "GB"=>"UNITED KINGDOM",
		  "US"=>"UNITED STATES",
		  "UM"=>"UNITED STATES MINOR OUTLYING ISLANDS",
		  "UY"=>"URUGUAY",
		  "UZ"=>"UZBEKISTAN",
		  "VU"=>"VANUATU",
		  "VE"=>"VENEZUELA",
		  "VN"=>"VIET NAM",
		  "VG"=>"VIRGIN ISLANDS, BRITISH",
		  "VI"=>"VIRGIN ISLANDS, U.S.",
		  "WF"=>"WALLIS AND FUTUNA",
		  "EH"=>"WESTERN SAHARA",
		  "YE"=>"YEMEN",
		  "ZM"=>"ZAMBIA",
		  "ZW"=>"ZIMBABWE");
		return $return;
	}

	//Valida pais
	function validatePais($key){
		$paises = $this->paises();
		if (!isset($paises[current($key)]))
			return false;
		else
			return true;
	}

	//Tipos de logradouro
	function tipos_logradouro(){
		$return = array(
			''=>'OUTROS',
			'RUA'=>'RUA',
			'AVENIDA'=>'AVENIDA',
			'TRAVESSA'=>'TRAVESSA',
			'PRACA'=>'PRACA',
			'ALAMEDA'=>'ALAMEDA',
			'VILA'=>'VILA',
			'CAIXA POSTAL'=>'CAIXA POSTAL',
			'ESTRADA'=>'ESTRADA',
			'BECO'=>'BECO',
			'PASSAGEM'=>'PASSAGEM',
			'VIELA'=>'VIELA',
			'QUADRA'=>'QUADRA',
			'SERVIDAO'=>'SERVIDAO',
			'CAMINHO'=>'CAMINHO',
			'1A TRAVESSA'=>'1A TRAVESSA',
			'2A TRAVESSA'=>'2A TRAVESSA',
			'RODOVIA'=>'RODOVIA',
			'CONJUNTO'=>'CONJUNTO',
			'3A TRAVESSA'=>'3A TRAVESSA',
			'ACESSO'=>'ACESSO',
			'LOTEAMENTO'=>'LOTEAMENTO',
			'LARGO'=>'LARGO',
			'VIA'=>'VIA',
			'4A TRAVESSA'=>'4A TRAVESSA',
			'ESCADARIA'=>'ESCADARIA',
			'10A RUA'=>'10A RUA',
			'10A TRAVESSA'=>'10A TRAVESSA',
			'11A RUA'=>'11A RUA',
			'11A TRAVESSA'=>'11A TRAVESSA',
			'12A RUA'=>'12A RUA',
			'12A TRAVESSA'=>'12A TRAVESSA',
			'13A TRAVESSA'=>'13A TRAVESSA',
			'14A TRAVESSA'=>'14A TRAVESSA',
			'15A TRAVESSA'=>'15A TRAVESSA',
			'16A TRAVESSA'=>'16A TRAVESSA',
			'18A TRAVESSA'=>'18A TRAVESSA',
			'19A TRAVESSA'=>'19A TRAVESSA',
			'1A AVENIDA'=>'1A AVENIDA',
			'1A PARALELA'=>'1A PARALELA',
			'1A RUA'=>'1A RUA',
			'1A SUBIDA'=>'1A SUBIDA',
			'1A VILA'=>'1A VILA',
			'1O ALTO'=>'1O ALTO',
			'1O BECO'=>'1O BECO',
			'1O PARQUE'=>'1O PARQUE',
			'2A AVENIDA'=>'2A AVENIDA',
			'2A PARALELA'=>'2A PARALELA',
			'2A RUA'=>'2A RUA',
			'2A SUBIDA'=>'2A SUBIDA',
			'2A VILA'=>'2A VILA',
			'2O ALTO'=>'2O ALTO',
			'2O BECO'=>'2O BECO',
			'2O PARQUE'=>'2O PARQUE',
			'3A AVENIDA'=>'3A AVENIDA',
			'3A PARALELA'=>'3A PARALELA',
			'3A RUA'=>'3A RUA',
			'3A SUBIDA'=>'3A SUBIDA',
			'3A VILA'=>'3A VILA',
			'3O ALTO'=>'3O ALTO',
			'3O BECO'=>'3O BECO',
			'3O PARQUE'=>'3O PARQUE',
			'4A AVENIDA'=>'4A AVENIDA',
			'4A PARALELA'=>'4A PARALELA',
			'4A RUA'=>'4A RUA',
			'4A SUBIDA'=>'4A SUBIDA',
			'4A VILA'=>'4A VILA',
			'4O ALTO'=>'4O ALTO',
			'4O BECO'=>'4O BECO',
			'5A AVENIDA'=>'5A AVENIDA',
			'5A PARALELA'=>'5A PARALELA',
			'5A RUA'=>'5A RUA',
			'5A SUBIDA'=>'5A SUBIDA',
			'5A TRAVESSA'=>'5A TRAVESSA',
			'5A VILA'=>'5A VILA',
			'5O ALTO'=>'5O ALTO',
			'5O BECO'=>'5O BECO',
			'6A AVENIDA'=>'6A AVENIDA',
			'6A RUA'=>'6A RUA',
			'6A SUBIDA'=>'6A SUBIDA',
			'6A TRAVESSA'=>'6A TRAVESSA',
			'7A RUA'=>'7A RUA',
			'7A TRAVESSA'=>'7A TRAVESSA',
			'8A RUA'=>'8A RUA',
			'8A TRAVESSA'=>'8A TRAVESSA',
			'9A RUA'=>'9A RUA',
			'9A TRAVESSA'=>'9A TRAVESSA',
			'ACAMPAMENTO'=>'ACAMPAMENTO',
			'ACESSO LOCAL'=>'ACESSO LOCAL',
			'ADRO'=>'ADRO',
			'AEROPORTO'=>'AEROPORTO',
			'ALTO'=>'ALTO',
			'ANTIGA ESTRADA'=>'ANTIGA ESTRADA',
			'AREA'=>'AREA',
			'AREA ESPECIAL'=>'AREA ESPECIAL',
			'ARTERIA'=>'ARTERIA',
			'ATALHO'=>'ATALHO',
			'AVENIDA CONTORNO'=>'AVENIDA CONTORNO',
			'AVENIDA MARGINAL'=>'AVENIDA MARGINAL',
			'AVENIDA MARGINAL DIREITA'=>'AVENIDA MARGINAL DIREITA',
			'AVENIDA MARGINAL ESQUERDA'=>'AVENIDA MARGINAL ESQUERDA',
			'AVENIDA VELHA'=>'AVENIDA VELHA',
			'BAIXA'=>'BAIXA',
			'BALAO'=>'BALAO',
			'BALNEARIO'=>'BALNEARIO',
			'BELVEDERE'=>'BELVEDERE',
			'BLOCO'=>'BLOCO',
			'BLOCOS'=>'BLOCOS',
			'BOSQUE'=>'BOSQUE',
			'BOULEVARD'=>'BOULEVARD',
			'BULEVAR'=>'BULEVAR',
			'BURACO'=>'BURACO',
			'CAIS'=>'CAIS',
			'CALCADA'=>'CALCADA',
			'CAMPO'=>'CAMPO',
			'CANAL'=>'CANAL',
			'CHACARA'=>'CHACARA',
			'CHAPADAO'=>'CHAPADAO',
			'CICLOVIA'=>'CICLOVIA',
			'CIRCULAR'=>'CIRCULAR',
			'COLONIA'=>'COLONIA',
			'COMPLEXO VIARIO'=>'COMPLEXO VIARIO',
			'CONDOMINIO'=>'CONDOMINIO',
			'CONJUNTO MUTIRAO'=>'CONJUNTO MUTIRAO',
			'CONTORNO'=>'CONTORNO',
			'CORREDOR'=>'CORREDOR',
			'CORREGO'=>'CORREGO',
			'DESCIDA'=>'DESCIDA',
			'DESVIO'=>'DESVIO',
			'DISTRITO'=>'DISTRITO',
			'ELEVADA'=>'ELEVADA',
			'ENSEADA'=>'ENSEADA',
			'ENTRADA PARTICULAR'=>'ENTRADA PARTICULAR',
			'ENTRE BLOCO'=>'ENTRE BLOCO',
			'ENTRE QUADRA'=>'ENTRE QUADRA',
			'ESCADA'=>'ESCADA',
			'ESPLANADA'=>'ESPLANADA',
			'ESTACAO'=>'ESTACAO',
			'ESTACIONAMENTO'=>'ESTACIONAMENTO',
			'ESTADIO'=>'ESTADIO',
			'ESTANCIA'=>'ESTANCIA',
			'ESTRADA ANTIGA'=>'ESTRADA ANTIGA',
			'ESTRADA DE LIGACAO'=>'ESTRADA DE LIGACAO',
			'ESTRADA ESTADUAL'=>'ESTRADA ESTADUAL',
			'ESTRADA MUNICIPAL'=>'ESTRADA MUNICIPAL',
			'ESTRADA PARTICULAR'=>'ESTRADA PARTICULAR',
			'ESTRADA VELHA'=>'ESTRADA VELHA',
			'ESTRADA VICINAL'=>'ESTRADA VICINAL',
			'FAVELA'=>'FAVELA',
			'FAZENDA'=>'FAZENDA',
			'FEIRA'=>'FEIRA',
			'FERROVIA'=>'FERROVIA',
			'FONTE'=>'FONTE',
			'FORTE'=>'FORTE',
			'GALERIA'=>'GALERIA',
			'GRANJA'=>'GRANJA',
			'HABITACIONAL'=>'HABITACIONAL',
			'ILHA'=>'ILHA',
			'ILHOTA'=>'ILHOTA',
			'JARDIM'=>'JARDIM',
			'JARDINETE'=>'JARDINETE',
			'LADEIRA'=>'LADEIRA',
			'LAGO'=>'LAGO',
			'LAGOA'=>'LAGOA',
			'MARINA'=>'MARINA',
			'MODULO'=>'MODULO',
			'MONTE'=>'MONTE',
			'MORRO'=>'MORRO',
			'NUCLEO'=>'NUCLEO',
			'PARADA'=>'PARADA',
			'PARADOURO'=>'PARADOURO',
			'PARALELA'=>'PARALELA',
			'PARQUE'=>'PARQUE',
			'PARQUE MUNICIPAL'=>'PARQUE MUNICIPAL',
			'PARQUE RESIDENCIAL'=>'PARQUE RESIDENCIAL',
			'PASSAGEM DE PEDESTRES'=>'PASSAGEM DE PEDESTRES',
			'PASSAGEM SUBTERRANEA'=>'PASSAGEM SUBTERRANEA',
			'PASSARELA'=>'PASSARELA',
			'PASSEIO'=>'PASSEIO',
			'PASSEIO PUBLICO'=>'PASSEIO PUBLICO',
			'PATIO'=>'PATIO',
			'PONTA'=>'PONTA',
			'PONTE'=>'PONTE',
			'PORTO'=>'PORTO',
			'PRACA DE ESPORTES'=>'PRACA DE ESPORTES',
			'PRAIA'=>'PRAIA',
			'PRIMEIRA LADEIRA'=>'PRIMEIRA LADEIRA',
			'PROLONGAMENTO'=>'PROLONGAMENTO',
			'QUARTA LADEIRA'=>'QUARTA LADEIRA',
			'QUINTA'=>'QUINTA',
			'QUINTA LADEIRA'=>'QUINTA LADEIRA',
			'QUINTAS'=>'QUINTAS',
			'RAMAL'=>'RAMAL',
			'RAMPA'=>'RAMPA',
			'RECANTO'=>'RECANTO',
			'RECREIO'=>'RECREIO',
			'RESIDENCIAL'=>'RESIDENCIAL',
			'RETA'=>'RETA',
			'RETIRO'=>'RETIRO',
			'RETORNO'=>'RETORNO',
			'RODO ANEL'=>'RODO ANEL',
			'ROTATORIA'=>'ROTATORIA',
			'ROTULA'=>'ROTULA',
			'RUA DE LIGACAO'=>'RUA DE LIGACAO',
			'RUA DE PEDESTRE'=>'RUA DE PEDESTRE',
			'RUA INTEGRACAO'=>'RUA INTEGRACAO',
			'RUA PARTICULAR'=>'RUA PARTICULAR',
			'RUA PRINCIPAL'=>'RUA PRINCIPAL',
			'RUA PROJETADA'=>'RUA PROJETADA',
			'RUA VELHA'=>'RUA VELHA',
			'SEGUNDA AVENIDA'=>'SEGUNDA AVENIDA',
			'SEGUNDA LADEIRA'=>'SEGUNDA LADEIRA',
			'SETOR'=>'SETOR',
			'SITIO'=>'SITIO',
			'SUBIDA'=>'SUBIDA',
			'TERCEIRA AVENIDA'=>'TERCEIRA AVENIDA',
			'TERCEIRA LADEIRA'=>'TERCEIRA LADEIRA',
			'TERMINAL'=>'TERMINAL',
			'TRAVESSA PARTICULAR'=>'TRAVESSA PARTICULAR',
			'TRAVESSA VELHA'=>'TRAVESSA VELHA',
			'TRECHO'=>'TRECHO',
			'TREVO'=>'TREVO',
			'TRINCHEIRA'=>'TRINCHEIRA',
			'TUNEL'=>'TUNEL',
			'UNIDADE'=>'UNIDADE',
			'VALA'=>'VALA',
			'VALE'=>'VALE',
			'VARIANTE'=>'VARIANTE',
			'VEREDA'=>'VEREDA',
			'VIA COLETORA'=>'VIA COLETORA',
			'VIA DE ACESSO'=>'VIA DE ACESSO',
			'VIA DE PEDESTRE'=>'VIA DE PEDESTRE',
			'VIA DE PEDESTRES'=>'VIA DE PEDESTRES',
			'VIA ELEVADO'=>'VIA ELEVADO',
			'VIA EXPRESSA'=>'VIA EXPRESSA',
			'VIA LITORANEA'=>'VIA LITORANEA',
			'VIA LOCAL'=>'VIA LOCAL',
			'VIADUTO'=>'VIADUTO',
			'ZIGUE-ZAGUE'=>'ZIGUE-ZAGUE',);
		return $return;
	}
	
	function toggleField($field, $id=null) {
		if(empty($id)) {
			$id = $this->id;
		}
	
		$field = $this->escapeField($field);
		return $this->updateAll(
			array($field => '1 -' . $field),
			array($this->escapeField() => $id)
		);
	}

	function updateField($field, $value, $id=null) {
		if(empty($id)) {
			$id = $this->id;
		}

		$field = $this->escapeField($field);
		return $this->updateAll(
			array($field => $value),
			array($this->escapeField() => $id)
		);
	}
}
