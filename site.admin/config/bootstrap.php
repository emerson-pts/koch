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
    'models' =>  array(SITE_DIR . 'models' . DS),
    'behaviors' =>  array(SITE_DIR . 'models/behaviors' . DS),
    'vendors' =>  array(SITE_DIR . 'vendors' . DS),
    'helpers' =>  array(SITE_DIR . 'views/helpers' . DS),
));

Inflector::rules('singular', array('irregular' => array('vendors' => 'vendor', 'banners' => 'banner','locais'=>'local', 'duvidas' => 'duvida','produto_categorias'=>'produto_categoria', ), 'rules' => array('/^(.*)coes$/i' => '\1cao', '/^(.*)ses$/i' => '\1s', '/^(.*)ns$/i' => '\1m', '/^(.*)ias$/i' => '\1ia', ),));
Inflector::rules('plural', array('irregular' => array('vendor' => 'vendors', 'banner' => 'banners','local'=>'locais', 'duvida' => 'duvidas', 'produto_categoria'=>'produto_categorias', ), 'rules' => array('/^(.*)cao$/i' => '\1coes', '/^(.*)s$/i' => '\1ses', '/^(.*)m$/i' => '\1ns',  '/^(.*)ia$/i' => '\1ias', ),));

Configure::write('Config.language', 'pt_br');

//Nome humanizado dos controllers
Configure::write('controllerTraduzido', array(
	'Acl'				=> 'Permissões	',
	'Usuarios'	 		=> 'Usuários',
	'Sitemaps'	 		=> 'Mapa do Site',
	'Noticias'	 		=> 'Notícias',
	'Paginas'	 		=> 'Páginas',
	'GaleriaArquivos'	=> 'Arquivos da Galeria',
	'Configurations'	=> 'Configurações',
	'Logs'				=> 'Logs - Registro de alterações',
	'Pages'				=> 'Páginas Estáticas',
	'FormaPagamentos'	=> 'Formas de Pagamento',
	'Calendarios'		=> 'Calendários',
	'Promocoes'			=> 'Promoções',
	'DownloadArquivo'	=> 'Downloads',
	'Relatorios'		=> 'Relatórios',
	'edit_status'		=> 'Edição de status',

	'controllers'		=>'Sistema',

	'index'				=> 'Listar',
	'add'				=> 'Novo',
	'add_multiple'		=> 'Novo (múltiplo)',
	'edit'				=> 'Editar',
	'edit_parcial'		=> 'Edição parcial',
	'edit_completo'		=> 'Edição completa',
	'delete'			=> 'Apagar',
	'del'				=> 'Apagar',
	'view'				=> 'Visualizar',
	'preview' 			=> 'Pré-visualizar',
	'display'			=> 'Exibir',
	'movedown'			=> 'Mover para baixo',
	'moveup'			=> 'Mover para cima',
	'update_parent'		=> 'Alterar pai',
	
	'build_acl'			=> 'Recriar lista de permissões disponíveis',
	'set_permission'	=> 'Alterar permissão',
	
	'AjaxValidators'	=> 'Validação durante preenchimento',
	'change_pass' 		=> 'Alterar senha',
	
	'DestinoFotos'		=> 'Fotos do Destino',
));

//Monta menu
//	* no início do submenu é a ação padrão do menu. Para o menu funcionar, ao menos um submeno deve ter essa opcao
Configure::write('Admin.menu', array(
	'Home'	=> array(
/*		'Dashboard' => '/dashboard/index',
		'Banners' => '/banners/index',
*/
	),

	'Conteúdo' => array(
		//Crie itens com índice numérico para linkar o menu ao acessar o endereço, sem exibir o item no menu
		'Páginas' => '/paginas/index',
			'/paginas/add',
			'/paginas/edit',
			'/paginas/delete',
		'Vitrine' => '/vitrines/index',
			'/vitrines/add',
			'/vitrines/edit',
			'/vitrines/delete',
		'Banners'	=> '/banners/index',
			'/banners/add',
			'/banners/edit',
		'Cases' 	=> '/cases/index',
			'/cases/add',
			'/cases/edit',
			'/cases/delete',
		'Timeline' 	=> '/historias/index',
			'/historias/add',
			'/historias/edit',
			'/historias/delete',
		'Clientes' 	=> '/clientes/index',
			'/clientes/add',
			'/clientes/edit',
			'/clientes/delete',
		'Parceiros' 	=> '/parceiros/index',
			'/parceiros/add',
			'/parceiros/edit',
			'/parceiros/delete',
		'Area de atuação' 	=> '/areas/index',
			'/areas/add',
			'/areas/edit',
			'/areas/delete',
	),

	'Modalidades' => array(
		'Modalidades' 	=> '/modalidades/index',
			'/modalidades/add',
			'/modalidades/edit',
			'/modalidades/delete',
	),

	'Notícias' => array(
		'Categorias'=> '/categorias/index',
		'Notícias'=> '/noticias/index',
		'Calendário'=> '/calendarios/index',
		'Eventos'=> '/eventos/index',
	),

	'Galeria multimídia' => array(
		'*Fotos'	=> '/galerias/index',
			'/galerias/add',
			'/galerias/edit',
			'/galerias/delete',
			'/galeria_arquivos/index',
			'/galeria_arquivos/add',
			'/galeria_arquivos/edit',
			'/galeria_arquivos/delete',

		'Vídeos'	=> '/videos/index',
		'Textos'	=> '/textos/index',
		'Wallpaper'	=> '/wallpapers/index',
		'Arquivos FTP'	=> '/Sistemas/index',
	),

	'Oportunidades' => array(
		'Oportunidades' 	=> '/oportunidades/index',
			'/oportunidades/add',
			'/oportunidades/edit',
			'/oportunidades/delete',
	),

	'Setup' => array(
		'/acl/index',

		'Configurações'		=> '/configurations/index',
			'/configurations/add',
			'/configurations/edit',
			'/configurations/delete',

		'Usuários'			=> '/usuarios/index',
			'/usuarios/add',
			'/usuarios/edit',
			'/usuarios/delete',

		'Grupos'			=> '/grupos/index',
			'/grupos/add',
			'/grupos/edit',
			'/grupos/delete',

		'Mapa do Site'	=> '/sitemaps/index',
			'/sitemaps/add',
			'/sitemaps/edit',

	),
));

