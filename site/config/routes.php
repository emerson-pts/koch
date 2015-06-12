<?php
/**
 * Routes Configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
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
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
 */
    Router::parseExtensions('rss');

    Router::connect('/', array('controller' => 'home', 'action' => 'index'));

    //...and connect the rest of 'Pages' controller's urls.

	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

	Router::connect('/paginas/index/*', array('controller' => 'paginas', 'action' => 'index'));
	Router::connect('/paginas/*', array('controller' => 'paginas', 'action' => 'index'));

	Router::connect('/busca/*', array('controller' => 'busca', 'action' => 'index'));
	Router::connect('/template_noticias/*', array('controller' => 'noticias', 'action' => 'index'));
	Router::connect('/textos/*', array('controller' => 'textos', 'action' => 'index'));

	Router::connect('/template_galerias/*', array('controller' => 'galerias', 'action' => 'index'));
	Router::connect('/fotos/*', array('controller' => 'galerias', 'action' => 'fotos'));
	Router::connect('/videos/*', array('controller' => 'videos', 'action' => 'index'));

	Router::connect('/modalidades/*', array('controller' => 'modalidades', 'action' => 'index'));
	Router::connect('/calendarios/*', array('controller' => 'calendarios', 'action' => 'index'));

	Router::connect('/historia', array('controller' => 'historias', 'action' => 'index'));
	Router::connect('/historia/:action/*', array('controller' => 'historias', 'action' => 'index'));

	Router::connect('/form_contatos', array('controller' => 'form_contatos', 'action' => 'index'));
	Router::connect('/form_contatos/:action/*', array('controller' => 'form_contatos', 'action' => 'index'));

	Router::connect('/form_oportunidades', array('controller' => 'form_oportunidades', 'action' => 'index'));
	Router::connect('/form_oportunidades/:action/*', array('controller' => 'form_oportunidades', 'action' => 'index'));

	Router::connect('/template_historia', array('controller' => 'form_contatos', 'action' => 'index'));
	Router::connect('/template_historia/:action/*', array('controller' => 'form_contatos', 'action' => 'index'));

	Router::connect('/areas', array('controller' => 'areas', 'action' => 'index'));

	Router::connect('/cases/*', array('controller' => 'cases', 'action' => 'index'));
	Router::connect('/eventos', array('controller' => 'eventos', 'action' => 'index'));
	Router::connect('/eventos/*', array('controller' => 'eventos', 'action' => 'index'));

	Router::connect('/clientes', array('controller' => 'clientes', 'action' => 'index'));
	Router::connect('/parceiros', array('controller' => 'parceiros', 'action' => 'index'));
	Router::connect('/sistema/*', array('controller' => 'sistemas', 'action' => 'index'));
	Router::connect('/sistemas/*', array('controller' => 'sistemas', 'action' => 'login'));
	Router::connect('/usuarios/*', array('controller' => 'sistemas', 'action' => 'login'));

	Router::connect('/thumbs/*', array('controller' => 'thumbs', 'action' => 'index'));

	//Faz com que qualquer endereço seja direcionado para o siportalp para redirecionar a rota correta
	Router::connect('/*', array('controller' => 'sitemaps', 'action' => 'index'));