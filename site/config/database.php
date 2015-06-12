<?php
class DATABASE_CONFIG {

	var $development = array(
		'driver' => 'mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'root',
		'password' => 'dopcom',
		'database' => 'kochtava_site',
		'prefix' => 'site_',
		'encoding' => 'utf8',
	);

	var $production = array(
		'driver' => 'mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'kochtava_site',
		'password' => 'e271s22s',
		'database' => 'kochtava_site',
		'prefix' => 'site_',
		'encoding' => 'utf8',
	);

	var $default = array();
	
	function __construct(){
        $this->default = $this->development;

        //$this->default = strstr($_SERVER['SERVER_NAME'], 'localhost') || preg_match( '/^192\.168/', $_SERVER['SERVER_ADDR']) ? $this->development : $this->production;

		//Tradução database
		$this->translated = $this->default;
		$this->translated['database'] = sprintf(Configure::read('Config.language_options.database'), $this->translated['database']);
    }
	
	function DATABASE_CONFIG(){
		$this->__construct();
	}
}
