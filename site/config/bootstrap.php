<?php
/**
 * This file is loaded automatically by the app/webroot/index.php file after the core bootstrap.php
 *
 * This is an application wide file to load any function that is not used within a class
 * define. You can also use this to include or require any files in your application.
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
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 * This is related to Ticket #470 (https://trac.cakephp.org/ticket/470)
 *
 * App::build(array(
 *     'plugins' => array('/full/path/to/plugins/', '/next/full/path/to/plugins/'),
 *     'models' =>  array('/full/path/to/models/', '/next/full/path/to/models/'),
 *     'views' => array('/full/path/to/views/', '/next/full/path/to/views/'),
 *     'controllers' => array(/full/path/to/controllers/', '/next/full/path/to/controllers/'),
 *     'datasources' => array('/full/path/to/datasources/', '/next/full/path/to/datasources/'),
 *     'behaviors' => array('/full/path/to/behaviors/', '/next/full/path/to/behaviors/'),
 *     'components' => array('/full/path/to/components/', '/next/full/path/to/components/'),
 *     'helpers' => array('/full/path/to/helpers/', '/next/full/path/to/helpers/'),
 *     'vendors' => array('/full/path/to/vendors/', '/next/full/path/to/vendors/'),
 *     'shells' => array('/full/path/to/shells/', '/next/full/path/to/shells/'),
 *     'locales' => array('/full/path/to/locale/', '/next/full/path/to/locale/')
 * ));
 *
 */

/**
 * As of 1.3, additional rules for the inflector are added below
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */
 
 //SITE BASE DIR
define('SITE_DIR', ROOT . DS . str_replace('.admin', '', APP_DIR) . DS);

 App::build(array(
     'views' =>  array(SITE_DIR.'views'. DS. 'design'. DS. 'custom'.DS, SITE_DIR.'views'. DS. 'design'. DS. 'base'.DS,),
 ));
 
Inflector::rules('singular', array('rules' => array('/^(.*)coes$/i' => '\1cao', '/^(.*)ses$/i' => '\1s', '/^(.*)ns$/i' => '\1m', '/^(.*)ias$/i' => '\1ia',),));
Inflector::rules('plural', array('rules' => array('/^(.*)cao$/i' => '\1coes', '/^(.*)s$/i' => '\1ses', '/^(.*)m$/i' => '\1ns',  '/^(.*)ia$/i' => '\1ias', ),));

//Se postou dados, desabilita o cache
if(!empty($_POST)){
	Configure::write('Cache.check', false);
}

 //Se o acesso foi realizado através do .htaccess anterior ao da aplicação
if(
	!preg_match(
		'/^'.
		preg_quote(
			preg_replace('/^'.preg_quote($_SERVER['DOCUMENT_ROOT'], '/').'/', '', ROOT).
			DS .
			APP_DIR
		, '/').
		'/',
		$_SERVER['REQUEST_URI']
	)
){
	Configure::write('App.base', '/.');
}
