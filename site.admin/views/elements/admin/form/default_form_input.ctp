<?php
if(!isset($i)){$i = 1;}

if(!array_key_exists('div', $params))$params['div'] = 'input';
if($i % 2 == 0)$params['div'] .= ' even';

if(!empty($params['type']) && $params['type'] == 'checkbox' && !isset($this->data[$model][$key]) && isset($params['default']) && isset($params['value']) && $params['default'] == $params['value']){
	$params['checked'] = true;
}

if(!empty($params['type']) && $params['type'] == 'file'){
	if(!isset($params['after']))$params['after'] = '';
	
	if(strstr($key, '.') && !empty($dados_originais)){
		$value = Set::Extract($key, $dados_originais);
		$dados_model = Set::Extract(preg_replace('/\..*$/', '', $key), $dados_originais);
	}else if (!empty($dados_originais[$model][$key])){
		$value = $dados_originais[$model][$key];
		$dados_model = $dados_originais[$model];
	}else{
		$value = $dados_model = null;
	}
	
	if(!empty($value)){
		if(isset($params['show_remove'])){
			$params['after'] .= ' '.$this->Form->input($key.'.remove', array('error' => false, 'label' => (is_string($params['show_remove']) ? $params['show_remove'] : 'Remover arquivo atual - ('.basename($value).')'), 'div' => 'file_remove no-padding', 'value' => '', 'type' => 'checkbox'));
		}else{
			$params['after'] .= ' Arquivo atual - ('.basename($value).')';
		}
	}
		
	if(isset($params['show_preview']) && !empty($value)){
		$params['after'] .= ' '.$this->Html->link((!empty($params['show_preview_label']) ? $params['show_preview_label'] : 'Preview'), (
			!empty($params['show_preview_url']) ? 
				$params['show_preview_url'].'?src='.rawurlencode($value).'&size='.rawurlencode($params['show_preview'])
				:
				'/arquivos/download/'.$dados_model['id'].'/'.basename($dados_model[$key.'_bck'])
			),
			array(
				'class' => (preg_match('/\.(jpe?g|png|gif)$/i', $dados_model[$key.'_bck']) ? 'fancy' : ''),
			)
		);
	}
}

echo $this->Form->input($key,$params);
