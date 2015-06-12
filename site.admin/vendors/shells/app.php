<?php
class AppShell extends Shell
{
	
	function _data(){
		return "\n".'['.date('d/m/Y h:i:s').'] ';
	}
	
	function _emailAreadySendMd5($email_content_log){
		//Gera chave md5 da mensagem excluindo as datas de log do conteúdo
		$email_content_log_md5 = md5(preg_replace('/^\s*\[[0-9][0-9]\/[0-9][0-9]\/[0-9][0-9][0-9][0-9] [0-9][0-9]:[0-9][0-9]:[0-9][0-9]\]/m', '', $email_content_log));
		return $email_content_log_md5;
	}
	
	//Verifica se a última mensagem enviada é igual a esta
	function _emailAlreadySentRead($cacheKey, $email_content_log){
		//Gera chave md5 da mensagem excluindo as datas de log do conteúdo
		$email_content_log_md5 = $this->_emailAreadySendMd5($email_content_log);

		//Verifica se o cache ainda é válido e se está com a mesma chave md5
		if ($return = Cache::read($cacheKey, 'chk_email')){
			if($return == $email_content_log_md5) {
				return true;
			}
		}

		return false;
	}

	//Grava cache da última mensagem enviada
	function _emailAlreadySentWrite($cacheKey, $email_content_log){
		//Gera chave md5 da mensagem excluindo as datas de log do conteúdo
		$email_content_log_md5 = $this->_emailAreadySendMd5($email_content_log);

		Cache::write($cacheKey, $email_content_log_md5, 'chk_email');
		return true;
	}

    public function getDatabaseLogs()
    {
        if (!class_exists('ConnectionManager') || Configure::read('debug') < 2) {
            return false;
        }
 
        $sources = ConnectionManager::sourceList();
        if (!isset($logs))
        {
            $logs = array();
            foreach ($sources as $source)
            {
                $db =& ConnectionManager::getDataSource($source);
                if (!$db->isInterfaceSupported('getLog'))
                {
                    continue;
                }
                $logs[$source] = $db->getLog();
            }
        }
 
        $out = array();
        $out[] = "Nr\tQuery\tError\tAffected\tNum. rows\tTook (ms)";
        foreach ($logs as $source => $logInfo)
        {
            $text = $logInfo['count'] > 1 ? 'queries' : 'query';
 
            $tmp = array();
            foreach ($logInfo['log'] as $k => $i)
            {
                $tmp[] = ($k + 1) . "\t" . h($i['query']) . "\t{$i['error']}\t{$i['affected']}\t{$i['numRows']}\t{$i['took']}";
            }
 
            $out[] = array(
                sprintf('(%s) %s %s took %s ms', $source, $logInfo['count'], $text, $logInfo['time']),
                $tmp
            );
        }
 
        return $out;
    }
    
    function sql_debug(){
    	//Para usar esta função ligue o debug no startup
    	//Configure::write('debug', 2);
		$sources = ConnectionManager::sourceList();
		
		$logs = array();
		foreach ($sources as $source):
			$db =& ConnectionManager::getDataSource($source);
			if (!$db->isInterfaceSupported('getLog')):
				continue;
			endif;
			$logs[$source] = $db->getLog();
		endforeach;
		print_R($logs);
	}
}