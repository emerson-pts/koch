<?php
class BoomViagensHelper extends Helper {
	function roteiroPreco($txt = ''){
	
		//Adiciona script para igualar as alturas dos preços			
		$view =& ClassRegistry::getObject('view');
	
		if(!isset($view->viewVars['scripts_for_layout_footer'])){
			$view->viewVars['scripts_for_layout_footer'] = '';
		}
		
		$view->viewVars['scripts_for_layout_footer'] .= '<script>
			jQuery(document).ready(function(){
				if(jQuery(\'.destino-tabs\').size() == 0 || jQuery(\'#precos.active\').size() != 0){
					dl_prices = jQuery("dl.prices>dd>dl>dd>dl>dd");
					jQuery(dl_prices).height(maxHeight(dl_prices));
				}
				else{
					jQuery(\'.destino-tabs a[data-toggle="tab"]\').on(\'shown.pricesHeight\', function (e) {
						//Se ativou preço
						if(jQuery(e.target).attr("href").indexOf("#precos") != -1){
							dl_prices = jQuery("dl.prices>dd>dl>dd>dl>dd");
							jQuery(dl_prices).height(maxHeight(dl_prices));
							jQuery(\'a[data-toggle="tab"]\').unbind(\'shown.pricesHeight\');
						}
					});
				}									
			});
			</script>'
		;
		
		$return = '';
		$table_open = $group_open = $prices_open = false;

		//Looping em cada linha do texto
		$txt = explode(PHP_EOL, $txt);
		foreach($txt AS $key=>$value){
			$value = trim($value);
			//Se a linha estiver vazia...
			if(empty($value)){
				//Se a tabela está aberta...
				if($table_open){
					$return .= 
						'</ul></dd></dl></dd>'.PHP_EOL
					;
					$table_open = false;
				}
			}
			//Se a linha tem [[Texto]]
			else if(preg_match('/^\[\[/', $value)){
				//Se a tabela está aberta...
				if($table_open){
					$return .= '</ul></dd></dl></dd>';
					$table_open = false;
				}
				
				if($group_open){
					$return .= '</dl></dd>';
					$group_open = false;
				}
				
				if(!$prices_open){
					$return .= '<dl class="prices">';
					$prices_open = true;
				}
				
				$value = preg_replace(
					array(
						'/^\[\[(.*)/', 
						'/\]\](.+)$/',
						'/\]\]/',
					), 
					array(
						'<dt><span class="subtitle">\1',
						'</span><span>\1</span>',
						'</span>',
					),
					$value).
					'</dt><dd><dl>'
				;
				$return .= $value.PHP_EOL;
			}
			else if(preg_match('/^\[(.*)\]$/', $value, $match)){
				//Se a tabela está aberta...
				if($table_open){
					$return .= '</ul></dd></dl></dd>';
				}

				$table_open = $group_open = true;
				$return .= '<dd><dl>'.PHP_EOL.
					'<dt>'.$match[1].'</dt><dd><ul>'.PHP_EOL
				;
								
			}
			else if($table_open){
				$return .= '<li>'.preg_replace('/^(.*)=(.*)$/', '<b>\1 </b>\2', $value).'</li>'.PHP_EOL;
			}
			else{
				if($table_open){
					$return .= '</ul></dd></dl></dd>';
					$table_open = false;
				}
	
				if($group_open){
					$return .= '</dl></dd>';
					$group_open = false;
				}
				
				if($prices_open){
					$return .= '</dl><div class="clear"></div>';
					$prices_open = false;
				}

				$return .= $value.'<br />'.PHP_EOL;
			}
		}

		if($table_open){
			$return .= 
				'</ul></dd></dl></dd>'.PHP_EOL
			;
			$table_open = false;
		}

		if($group_open){
			$return .= '</dl></dd>';
			$group_open = false;
		}
		
		if($prices_open){
			$retun .= '</dl><div class="clear"></div>';
			$prices_open = false;
		}
		
		$return = preg_replace('/([a-z]+\$) +([0-9\.]+)([0-9,]+)/i', '<span class="currency">\1</span> <span class="price">\2</span><span class="price price-cents">\3</span>', $return);
	
		return $return;
	}
}