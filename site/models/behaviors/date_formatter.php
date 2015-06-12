<?php
/**
 * Prevent deletion if child record found
 *
 * @author  Nik Chankov
 * @url http://nik.chankov.net
 * @see http://nik.chankov.net/2007/12/20/using-different-date-format-in-cakephp-12/
 */
class DateFormatterBehavior extends ModelBehavior {
   
    /**
     * Class Vars
     * All these variables can be set from Configure class
     */
    //Data format for humans
    var $dateFormat = 'dd/mm/yyyy';
    //Dataformat for database
    var $databaseFormat = 'yyyy-mm-dd';
    //delimeted for humans
    var $delimiterDateFormat = '/';
    //delimiter for database
    var $delimiterDatabaseFormat = '-';
    //delimiter between date and time
    var $delimiterDateTimeFormat = ' ';
	//Remove seconds from time on human format
	var $removeSecondsFromTime = true;
	
	//Convert timezone
	var $userTimezone = false;
	var $databaseTimezone = false;

    /**
     * Empty Setup Function
    */
    function setup(&$model) {
        //Getting user defined vars
        $dateFormat = Configure::read('DateBehaviour.dateFormat');
        if($dateFormat != null){
            $this->dateFormat = $dateFormat;
        }
        $databaseFormat = Configure::read('DateBehaviour.databaseFormat');
        if($databaseFormat != null){
            $this->databaseFormat = $databaseFormat;
        }
        $delimiterDateFormat = Configure::read('DateBehaviour.delimiterDateFormat');
        if($delimiterDateFormat != null){
            $this->delimiterDateFormat = $delimiterDateFormat;
        }
        $delimiterDatabaseFormat = Configure::read('DateBehaviour.delimiterDatabaseFormat');
        if($delimiterDatabaseFormat != null){
            $this->delimiterDatabaseFormat = $delimiterDatabaseFormat;
        }
        $delimiterDateTimeFormat = Configure::read('DateBehaviour.delimiterDateTimeFormat');
        if($delimiterDateTimeFormat != null){
            $this->delimiterDateTimeFormat = $delimiterDateTimeFormat;
        }
        $removeSecondsFromTime = Configure::read('DateBehaviour.removeSecondsFromTime');
        if($removeSecondsFromTime != null){
            $this->removeSecondsFromTime = $removeSecondsFromTime;
        }
        
        //Getting user defined vars
        $this->userTimezone = Configure::read('DateBehaviour.userTimezone');
        $this->databaseTimezone = Configure::read('DateBehaviour.databaseTimezone');
        
		if(!empty($this->userTimezone)){
			$this->userTimezoneObj = new DateTimeZone($this->userTimezone);
		}

		if(!empty($this->databaseTimezone)){
			$this->databaseTimezoneObj = new DateTimeZone($this->databaseTimezone);
		}
    
    	$this->model = $model;
    }
   
    /**
     * Function which convert one date from format1 to format2
     * basically this function play with those three elements of the date - dd, mm, yyyy
     * with delimiter you define which one of the elements is where
     *
     * @param string $date date string formated with format1
     * @param string $format1 format in which is formatted the $date variable by if it's comming from database is yyyy-mm-dd
     * @param string $format2 new format for the date.
     * @param char $delimiter separater between different elements of the date string /i.e. dash (-), dot(.), space ( ), etc/
     * @return string date formated with $format2
     * @access restricted
     */
    function _convertDate($date, $format1, $format2, $delimiterDateFormat, $delimiterDatabaseFormat){
        if($date == null OR $date == ''){
            return '';
        }
        
		if (!preg_match('/^'.preg_replace('/(d|m|y)/i','[0-9]',preg_quote($format1,'/')).'/',$date)){
			return $date;
		}
		
        //Split date and time
        $date = explode($this->delimiterDateTimeFormat, $date);
        $date_array = explode($delimiterDateFormat, $date[0]);
		
		$format1_array = explode($delimiterDateFormat, $format1);
        $format2_array = explode($delimiterDatabaseFormat, $format2);
       
        $current_array = array_combine($format1_array, $date_array);
        $new_array = array_combine($format2_array, $date_array);
        foreach($new_array as $key=>$value){
            $new_array[$key] = $current_array[$key];
        }
		
		
		//If is converting to human format, then convert time
		if($this->databaseFormat == $format1 && $this->removeSecondsFromTime == true && isset($data[1])){
			$date[1] = substr($date[1],0,-3);
		}
		
		
        if(isset($date[1])){
            //merge date and time again
            return implode($delimiterDatabaseFormat, $new_array).$this->delimiterDateTimeFormat.$date[1];
        }else{
            return implode($delimiterDatabaseFormat, $new_array);
        }
    }
   
    /**
     *Function which handle the convertion of the data arrays from database to user defined format and up side down
     * @param array $data data array from and to database
     * @param int $direction with 2 possible values '1' determine that data is going to database, '2' determine that data is pulled from database
     * @return array converted array;
     * @access restricted
     */
    function _changeDate($data, $direction){
        //just return false if the data var is false
        if($data == false){
            return false;
        }
        //Detecting the direction
        switch($direction){
            case 1:
                $format1 = $this->dateFormat;
                $format2 = $this->databaseFormat;
                $delimiterDateFormat = $this->delimiterDateFormat;
                $delimiterDatabaseFormat = $this->delimiterDatabaseFormat;
                break;
            case 2:
                $format1 = $this->databaseFormat;
                $format2 = $this->dateFormat;
                $delimiterDateFormat = $this->delimiterDatabaseFormat;
                $delimiterDatabaseFormat = $this->delimiterDateFormat;
                break;
            default:
                return false;
        }
        
        //result model
        foreach($data as $key=>$value){
            if($direction == 2){
                foreach($value as $key1=>$value1){
                    if($this->model->alias == $key1){ //if it's current model;
                        $columns = $this->model->getColumnTypes();
                    } else {
                        //Fix for loading models on the fly
                        if(isset($this->model->{$key1})){
                            $columns = $this->model->{$key1}->getColumnTypes();
							
                        } else {
                            if($key1 != 'Parent'){
                                if(!App::import('Model', $key1))continue;
                                $model_on_the_fly = new $key1();
                                $columns = $model_on_the_fly->getColumnTypes();
                            }
                        }
                    }

					foreach($value1 as $k=>$val){
                        if(!is_array($val)){
                            if(in_array($k, array_keys($columns))){
                                if(($columns[$k] == 'date' || $columns[$k] == 'datetime')){// && ($k != 'created' && $k != 'modified')){
                                    if($val == '0000-00-00' || $val == '0000-00-00 00:00:00' || $val == ''){ //also clear the empty 0000-00-00 values
                                        $data[$key][$key1][$k] = null;

                                    } else {
										if(!empty($this->userTimezone)){
											$data[$key][$key1][$k] = $val = $this->convertTimezone($val, 'user');
										}
                                    	
                                        $data[$key][$key1][$k] = $this->_convertDate($val, $format1, $format2, $delimiterDateFormat, $delimiterDatabaseFormat);
                                    }
	                                $data[$key][$key1][$k.'_original'] = ($direction == 2 ? $val : $data[$key][$key1][$k]);
                                }
                            }
                        }else{
							foreach($val AS $v_key=>$v_val){
								if(in_array($v_key, array_keys($columns))){
									if(isset($columns[$v_key]) && (($columns[$v_key] == 'date' || $columns[$v_key] == 'datetime'))){// && ($v_key != 'created' && $v_key != 'modified'))){
										if($v_val == '0000-00-00' || $v_val == '0000-00-00 00:00:00' || $v_val == ''){ //also clear the empty 0000-00-00 values
											$data[$key][$key1][$k][$v_key] = null;
										} else {
											if(!empty($this->userTimezone)){
												$data[$key][$key1][$k][$v_key] = $v_val = $this->convertTimezone($v_val, 'user');
											}
											$data[$key][$key1][$k][$v_key] = $this->_convertDate($v_val, $format1, $format2, $delimiterDateFormat, $delimiterDatabaseFormat);
										}
		                                $data[$key][$key1][$k][$v_key.'_original'] = ($direction == 2 ? $v_val : $data[$key][$key1][$k][$v_key]);
									}
								}
							}
                        }
                    }  
                }
            } else {
                if($this->model->alias == $key){ //if it's current model;
                    $columns = $this->model->getColumnTypes();
                } else {
                    //Fix for loading models on the fly
                    if(isset($this->model->{$key})){
                        $columns = $this->model->{$key}->getColumnTypes();
                    } else {
                        if($key != 'Parent'){
                            if(!App::import('Model', $key))continue;
                            $model_on_the_fly = new $key();
                            $columns = $model_on_the_fly->getColumnTypes();
                        }
                    }
                }
                foreach($value as $k=>$val){  
                    if(!is_array($val)){
                        if(in_array($k, array_keys($columns))){
                            if(($columns[$k] == 'date' || $columns[$k] == 'datetime')){// && ($k != 'created' && $k != 'modified')){
								if($val == '0000-00-00' || $val == '0000-00-00 00:00:00' || $val == ''){ //also clear the empty 0000-00-00 values
									$data[$key][$k] = null;
								} else {
									$data[$key][$k] = $this->_convertDate($val, $format1, $format2, $delimiterDateFormat, $delimiterDatabaseFormat);
									if(!empty($this->databaseTimezone) && $k != 'created' && $k != 'modified' && $k != 'data_cadastro' && $k != 'data_alteracao'){
										$data[$key][$k] = $this->convertTimezone($data[$key][$k], 'database');
									}
								}
	                            $data[$key][$k.'_original'] = ($direction == 2 ? $val : $data[$key][$k]);
							}
                        }
                    }else{
                        foreach($val AS $v_key=>$v_val){
							if(in_array($v_key, array_keys($columns))){
								if(is_numeric($v_key))continue;
								if(($columns[$v_key] == 'date' || $columns[$v_key] == 'datetime')){// && ($v_key != 'created' && $v_key != 'modified')){
									if($v_val == '0000-00-00' || $v_val == '0000-00-00 00:00:00' || $v_val == ''){ //also clear the empty 0000-00-00 values
										$data[$key][$k][$v_key] = null;
									} else {
										$data[$key][$k][$v_key] = $this->_convertDate($v_val, $format1, $format2, $delimiterDateFormat, $delimiterDatabaseFormat);
										if(!empty($this->databaseTimezone) && $v_key != 'created' && $v_key != 'modified' && $v_key != 'data_cadastro' && $v_key != 'data_alteracao'){
											$data[$key][$k][$v_key] = $this->convertTimezone($data[$key][$k][$v_key], 'database');
										}
									}
		                            $data[$key][$k][$v_key.'_original'] = ($direction == 2 ? $v_val : $data[$key][$k][$v_key]);
								}
							}
						}
                    }
                }
            }
        }
        return $data;
    }
   
    //Function before save.
    function beforeSave($model) {
        $model->data = $this->_changeDate($model->data, 1); //direction is from interface to database
        return true;
    }
   
    function afterFind(&$model, $results){
        $results = $this->_changeDate($results, 2); //direction is from database to interface
        return $results;
    }
    
    function convertTimezone($val, $timezoneTo){
    	if($timezoneTo == 'user'){
	    	$timezoneFrom = 'databaseTimezone';
    	}else{
	    	$timezoneFrom = 'userTimezone';
    	}
    
    	$timezoneTo = $timezoneTo.'Timezone';
    	
    	if(empty($this->$timezoneTo)){
    		return $val;
    	}

		$timezoneTo_obj_name = $timezoneTo.'Obj';
    	$timezoneTo_obj = $this->$timezoneTo_obj_name;
    	
		$timezoneFrom_obj_name = $timezoneFrom.'Obj';
    	$timezoneFrom_obj = $this->$timezoneFrom_obj_name;
    	
    	
		$date = new DateTime($val, $timezoneFrom_obj);
		$date->setTimeZone($timezoneTo_obj);

		//se tem a hora
		if(strstr($val, ' ')){
			return $date->format('Y-m-d H:i:s');
		}else{
			return $date->format('Y-m-d');
		}
    }
}
