<?php
if($_SERVER['REMOTE_ADDR'] == '::1')$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @subpackage    cake.app
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
class AppController extends Controller {
	
	var $helpers = array('Session', 'Html', 'Text', 'Form', 'Image', 'Formatacao', 'Acl', 'Js' => array('Jquery'), 'Cache',);
	var $components = array(
		'Session', 
		'RequestHandler', 
		
	);
	var	$cacheAction = "1 day";

	var $uses = array('Sitemap','Configuration','Pagina', );
		
	function beforeFilter(){

		App::import('Vendor', 'WebjumpUtilities');
		
		//Descomente a linha a seguir em sites multidiomas 
		//$this->_setLanguage();

		if(stripos(strtolower($_SERVER['HTTP_USER_AGENT']),'mobile') !== false) {
			$this->mobile = true;
		}
		else{
			$this->mobile = false;
		}

		//Carrega configurações
		if(is_object($this->Configuration)){
			$this->Configuration->load();
		}
		
		//Desativa debug quando é uma requisição ajax
		if ( $this->RequestHandler->isRss() || $this->RequestHandler->isAjax() )Configure::write('debug',0);  

		//Força a action padrão aparecer no URL quando ela não aparecer na variável url
		if(!preg_match('/^'.preg_quote($this->params['controller'], '/').'\/'.$this->params['action'].'(\/|$)/', $this->params['url']['url'])){
			$this->params['url']['url'] = preg_replace('/^('.preg_quote($this->params['controller'], '\/?/').')(\/|$)/','\1/'.$this->params['action'].'/', $this->params['url']['url']);
		}
		
		if($this->params['url']['url'] == '/')$this->params['url']['url'] = $this->params['controller'].'/'.$this->params['action'];
		
		
		//breadcrumbs
		$breadcrumbs = array();
		if(empty($this->params['sitemap'])){
			
		}else if($this->params['controller'] == 'home'){
			//Descomentar a linha abaixo para incluir a home no breadcrumb
			$breadcrumbs['/'] = 'Home';
		}else{
			$current_path = '';
			foreach($this->params['sitemapPath'] AS $bread){
				$current_path .= '/'.$bread['Sitemap']['friendly_url'];
				$breadcrumbs[$current_path] = $bread['Sitemap']['label'];
			}
		}
		$this->breadcrumbs = $breadcrumbs;
		
		//Recupera dados de formulários armazenados
		if($data = $this->Session->read('data')){
			foreach($data AS $key=>$value){
				$this->data[$key] = $value;
			}
			$this->Session->delete('data');
		}

		return true;
	}
	
	
	function beforeRender(){
		
		if ($this->RequestHandler->isAjax())$this->set('isAjax', true);
		
		$menu=$this->Sitemap->load();

		//Define o menu ativo quando acesso a notícia
		if(empty($this->params['originalArgs']['passedArgs'])
			&& $this->name == 'Noticias'
			&& $menu_find = $this->Sitemap->find('first', array('conditions' => array('route' => 'noticias')))){
				$this->params['originalArgs']['passedArgs'][0] = $menu_find['Sitemap']['friendly_url'];
		}
				
/*
		$url_galeria = Set::extract('/Sitemap[route=template_galerias]/friendly_url', $menu);
		if(!empty($url_galeria[0])){
			Configure::write('url.galeria',$url_galeria[0]);
		}else{
			Configure::write('url.galeria','template_galerias');
		}

		//Define o menu ativo quando acesso a notícia
		if(empty($this->params['originalArgs']['passedArgs'])
			&& $this->name == 'Noticias'
			&& $menu_find = $this->Sitemap->find('first', array('conditions' => array('route' => 'noticias')))){
				$this->params['originalArgs']['passedArgs'][0] = $menu_find['Sitemap']['friendly_url'];
		}
		//Define o menu ativo quando acesso a contatos
		else if(empty($this->params['originalArgs']['passedArgs'])
			&& $this->name == 'Galerias'
			&& $menu_find = $this->Sitemap->find('first', array('conditions' => array('route' => 'galerias')))){
				$this->params['originalArgs']['passedArgs'][0] = $menu_find['Sitemap']['friendly_url'];
		}
*/
	 	$title = array();
		if(!empty($this->params['originalArgs']['passedArgs'])){
			$menu_ativo = Set::extract('/Sitemap[friendly_url='.$this->params['originalArgs']['passedArgs'][0].']', $menu);
			$title[] = $menu_ativo[0]['Sitemap']['label'];
			$submenu = $this->Sitemap->children(array('id' => $menu_ativo[0]['Sitemap']['id'], 'direct' => true, 'fields' => array('id', 'label', 'friendly_url')));
			if(!empty($submenu) && !empty($this->params['originalArgs']['passedArgs'][1])){
				if(isset($this->params['originalArgs']['passedArgs'][1])){
					$submenu_ativo = Set::extract('/Sitemap[friendly_url='.$this->params['originalArgs']['passedArgs'][1].']', $submenu);
					$title[] = $submenu_ativo[0]['Sitemap']['label'];
					
				}
				
				//verifica se o submenu tem itens
				if($submenu_itens = $this->Sitemap->children(array('id' => $submenu_ativo[0]['Sitemap']['id'], 'direct' => true, 'fields' => array('id', 'label', 'friendly_url')))){
					if(isset($this->params['originalArgs']['passedArgs'][2])){
						$subsubmenu_ativo = Set::extract('/Sitemap[friendly_url='.$this->params['originalArgs']['passedArgs'][2].']', $submenu_itens);
						$title[] = $subsubmenu_ativo[0]['Sitemap']['label'];
					}
					
					//Faz os subitens serem incluidos no índice submenu do submenu ativo
					foreach($submenu AS $key=>$value){
						if($value['Sitemap']['id'] == $submenu_ativo[0]['Sitemap']['id']){
							$submenu[$key]['submenu'] = $submenu_itens;
							break;
						}
					}
				}
			}
		}

		//Se não está setado o script_for_layout_footer
		if(empty($this->viewVars['scripts_for_layout_footer'])){
			$this->set('scripts_for_layout_footer', '');
		}
		
		if(empty($this->breadcrumbs)){
			self::beforeFilter();
		}
		$this->set('breadcrumbs', $this->breadcrumbs);

		$this->set('mobile', $this->mobile);

		$this->set(compact('menu', 'menu_ativo', 'submenu', 'submenu_ativo','subsubmenu_ativo'));
	}

	function _setLanguage() {
		$default_language = Configure::read('Config.language');
		
		if ($this->Cookie->read('lang') && !$this->Session->check('Config.language')) {
			$this->Session->write('Config.language', $this->Cookie->read('lang'));
		}
		else if (!empty($default_language) && $default_language != $this->Session->read('Config.language')) {
			$this->Session->write('Config.language', $default_language);
			$this->Cookie->write('lang', $default_language, false, '20 days');
		}
		Configure::write('Config.language', $this->Session->read('Config.language'));

		$current_language = Configure::read('Config.language');
		$this->set('current_language', $current_language);
	}
	
	function _links(){
		$this->loadModel('Link');//Carrega modelo
		$links = $this->Link->find('all', array(
			'fields'=> array('Link.nome,Link.descricao'),
			'order' => array('Link.order'),
			'limit'	=> 4,
		));
		$this->set(compact('links'));
	}
}