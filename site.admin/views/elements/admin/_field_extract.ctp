<?php
$value = Set::extract($field, $r);
if(is_array($field_setup)):
	$intersect_configs = array_intersect_key($field_setup, array('field_format' => true, 'field_printf' => true, 'field_evaluate' => true));
	if(!empty($intersect_configs)):
		foreach(array_keys($intersect_configs) AS $key):
			switch($key):
				case 'field_format':
					//Se tem o índice field_format ...
					//Se não é array
					if(empty($field_setup['field_format'])):
						continue;
					elseif(!is_array($field_setup['field_format'])):
						//Então aplica valor como função
						$value = ${$field_setup['field_format']}($value);
					else:
						//Se não é array o índice 0 - tem somente uma ação a ser executada 
						if(!is_array($field_setup['field_format'][0])){
							//Transforma em uma array para executar o looping
							$setup['listFields'][$field]['field_format'] = $field_setup['field_format'] = array($field_setup['field_format']);
						}
						
						//Looping em todas formatações a serem executadas
						foreach($field_setup['field_format'] AS $field_format_key => $field_format):
							switch($field_format[0]){
								case 'function':
									switch(count($field_format)):
										case 2:
											$value = $field_format[1]($value);
											break;
										case 3:
											$value = $field_format[1]($value, $field_format[2]);
											break;
										case 4:
											$value = $field_format[1]($value, $field_format[2], $field_format[3]);
											break;
										case 5:
											$value = $field_format[1]($value, $field_format[2], $field_format[3], $field_format[4]);
											break;
										case 6:
											$value = $field_format[1]($value, $field_format[2], $field_format[3], $field_format[4], $field_format[5]);
											break;
										case 7:
											$value = $field_format[1]($value, $field_format[2], $field_format[3], $field_format[4], $field_format[5], $field_format[6]);
											break;
										default:
											debug(sprintf(__('Erro no parâmetro field_format do campo <i>%s</i>. <pre>%s</pre>', true), $field, var_export($field_format, true)));
											$this->cakeError('error500');
											break;
									endswitch;
									break;
									
								case 'object':
									switch(count($field_format)):
										case 3:
											$value = ${$field_format[1]}->$field_format[2]($value);
											break;
										case 4:
											$value = ${$field_format[1]}->$field_format[2]($value, $field_format[3]);
											break;
										case 5:
											$value = ${$field_format[1]}->$field_format[2]($value, $field_format[3], $field_format[4]);
											break;
										case 6:
											$value = ${$field_format[1]}->$field_format[2]($value, $field_format[3], $field_format[4], $field_format[5]);
											break;
										case 7:
											$value = ${$field_format[1]}->$field_format[2]($value, $field_format[3], $field_format[4], $field_format[5], $field_format[6]);
											break;
										default:
											debug(sprintf(__('Erro no parâmetro field_format do campo <i>%s</i>. <pre>%s</pre>', true), $field, var_export($field_format, true)));
											$this->cakeError('error500');
											break;
									endswitch;
									break;
									
								case 'class':
									$class = new $field_format[1];
									switch(count($field_format)):
										case 3:
											$value = $class->$field_format[2]($value);
											break;
										case 4:
											$value = $class->$field_format[2]($value, $field_format[3]);
											break;
										case 5:
											$value = $class->$field_format[2]($value, $field_format[3], $field_format[4]);
											break;
										case 6:
											$value = $class->$field_format[2]($value, $field_format[3], $field_format[4], $field_format[5]);
											break;
										case 7:
											$value = $class->$field_format[2]($value, $field_format[3], $field_format[4], $field_format[5], $field_format[6]);
											break;
										default:
											debug(sprintf(__('Erro no parâmetro field_format do campo <i>%s</i>. <pre>%s</pre>', true), $field, var_export($field_format, true)));
											$this->cakeError('error500');
											break;
									endswitch;
									break;
									
								default:
									debug(sprintf(__('Erro no parâmetro field_format do campo <i>%s</i>. O tipo de formatação não pode ser reconhecida (valores aceitos function, object e class). Informado: %s', true), $field, $field_format[0]));
									$this->cakeError('error500');
									break;
							}
							
						endforeach;
					endif;
				
					break;
				
				case 'field_printf':
					//Formata o valor do campo com o texto
					$value = sprintf($field_setup['field_printf'], $value, $value, $value, $value, $value);
					break;
		
				case 'field_evaluate':
					//Executa as instruções php no campo
					$value = eval($field_setup['field_evaluate']);
					
					break;
					
			endswitch;
			
		endforeach;
	
	endif;

endif;
if(trim($value) == ''){
	echo '&nbsp;';
}else{
	echo $value;
}