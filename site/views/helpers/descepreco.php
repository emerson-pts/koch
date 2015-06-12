<?php
class DesceprecoHelper extends Helper {
	var $helpers = array('Time', 'Number', 'Text', 'Html',);

	function moeda($valor, $opcoes = array()) {
		$padrao = array(
			'before'=> '',
			'after' => '',
			'zero' => '0,00',
			'places' => 2,
			'thousands' => '.',
			'decimals' => ',',
			'negative' => '<span class="negative">(%s)</span>',
			'escape' => true
		);
		$config = array_merge($padrao, $opcoes);
		if ($valor > -1 && $valor < 1) {
			$formatado = $this->Number->format(abs($valor), $config);
			if ($valor < 0 ) {
				$formatado = sprintf($config['negative'], $formatado);
/*				if ($config['negative'] == '()') {
					$formatado = '(' . $formatado .')';
				} else {
					$formatado = $config['negative'] . $formatado;
				}
*/
			}
			return preg_replace('/(,[0-9]+)/', '\1', $formatado);
		}
		$formatado = $this->Number->currency($valor, null, array('negative' => '') + $config);
		if($valor < 0)$formatado = sprintf($config['negative'], $formatado);
		
		return preg_replace('/(,[0-9]+)/', '\1', $formatado);
	}


}
