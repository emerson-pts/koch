<?php 
class AclHelper extends AppHelper {      
	var $helpers = array("Session");  
	var $Acl;  
	var $user;
	var $session;
   
	function __construct(){  
		parent::__construct();
		App::import('Component', 'Acl');
		$this->Acl = new AclComponent();

		App::import('Core', 'CakeSession'); 
		$this->session = new CakeSession(); 
		if(!$this->session->started())$this->session->start();
		$this->user = $this->session->read('Auth.Usuario');	

		/*
		App::import('Component', 'Auth');
		$this->Auth = new AuthComponent();
		$this->Auth->Session = $this->Session;

		$this->user = $this->Auth->user();
		*/
	}   
   
	function check($url, $action='*', $write_cache = true){
		$aco = preg_replace('/\/([^\/]+)\//e', '"/".Inflector::camelize("\1")."/"', $url);
		if(empty($this->user)) return false;  
		
		$cacheKey = 'AclHelper_check.'.$this->user['id'].'.'.str_replace('/','_',$aco);
		
		if ($return = $this->session->read($cacheKey)) {
			return $return;
		}else{
			$return = $this->Acl->check(array('model'=> 'Usuario', 'foreign_key' => $this->user['id']), $aco, $action); 
			if($write_cache == true){
				$this->session->write($cacheKey, $return);
			}
			return $return;
		}  
	}
} 