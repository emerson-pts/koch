<?php
//Lockable Behavior
/*$GLOBALS['LockableBehavior'] = array();

function shutdown_lock(){
	foreach($GLOBALS['LockableBehavior'] AS $lock=>$lock_value){
		unlink($lock);
		echo $lock.PHP_EOL;
	}
	echo 'unlock shutdown';
}

register_shutdown_function('shutdown_lock');
*/

class LockableBehavior extends ModelBehavior {
	
	function beforeSave(&$model){
		if(!empty($model->autoLock) && !$this->lock($model))return false;
	}
	
	function afterSave(&$model){
		if(!empty($model->autoLock))$this->unlock($model);
	}

	function _defaultLockName($model){
		return 'CakePHP'.$model->alias.'Lock';
	}

	function lock(&$model, $lockname = null, $timeout = 5){
		if(empty($lockname))$lockname = $this->_defaultLockName($model);
		
/*		$time = time();

		while(time() - $time < $timeout){
			if(!file_exists(TMP.'LockableBehavior.'.$lockname.'.lock')){
				$GLOBALS['LockableBehavior'][TMP.'LockableBehavior.'.$lockname.'.lock'] = true;
				touch(TMP.'LockableBehavior.'.$lockname.'.lock', true);
				return true;
			}
		}
		debug("Cannot get lock ".$lockname);
		return false;		
*/

//		var_dump($model->query("SELECT IS_FREE_LOCK('{$lockname}')"));
		$result = $model->query("SELECT GET_LOCK('{$lockname}', ".$timeout.")");
		if (current($result[0][0]) == 0){
			debug("Cannot get lock ".$lockname);
			return false;
		}elseif (!$result){
			debug("Server died away or something");
			return false;
		}else{
			return true;
		}

	}

	function unlock(&$model, $lockname = null){
		if(empty($lockname))$lockname = $this->_defaultLockName($model);
/*		
		if(file_exists(TMP.'LockableBehavior.'.$lockname.'.lock')){
			unlink(TMP.'LockableBehavior.'.$lockname.'.lock');
			unset($GLOBALS['LockableBehavior'][TMP.'LockableBehavior.'.$lockname.'.lock']);

			return true;
		}else{
			debug("Lock ".$lockname." does not exists");
			return false;
		}
*/		
		$result = $model->query("SELECT RELEASE_LOCK('{$lockname}')");
		if (current($result[0][0]) == 0){
			debug("Cannot release lock ".$lockname);
			return false;
		}elseif (!$result){
			debug("Server died away or something");
			return false;
		}else{
			return true;
		}
	}
}
