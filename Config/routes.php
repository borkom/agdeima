<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	Router::parseExtensions('rss', 'xml');
    //Router::parseExtensions('xml');
    Router::connect('/feed', array('controller' => 'posts','action' => 'index', 'ext' => 'rss'));
    Router::connect('/sitemap', array('controller' => 'posts','action' => 'sitemap', 'ext' => 'xml'));	
	Router::connect('/', array('controller' => 'posts', 'action' => 'index'));
	Router::connect(
    '/:year/:month/:permalink-:id',
    array('controller' => 'posts', 'action' => 'view'),
    array(
        'pass' => array('year', 'month', 'permalink', 'id'),    
        'year' => '[12][0-9]{3}',
        'month' => '0[1-9]|1[012]',
        'id' => '[0-9]+'
    )
);

	Router::connect(
    '/kategorija/:permalink-:id',
    array('controller' => 'posts', 'action' => 'categorized'),
    array(
        'pass' => array('permalink', 'id'),
        'id' => '[0-9]+'
    )
);

	Router::connect(
    '/strana/:permalink-:id',
    array('controller' => 'pages', 'action' => 'view'),
    array(
        'pass' => array('permalink', 'id'),
        'id' => '[0-9]+'
    )
);

	Router::connect('/novi-post', array('controller' => 'posts', 'action' => 'add'));
	Router::connect('/pretraga', array('controller' => 'posts', 'action' => 'search'));
	Router::connect('/kontakt', array('controller' => 'users', 'action' => 'contact'));			
	Router::connect('/admin', array('controller' => 'posts', 'action' => 'index', 'admin' => true));

/**
 * Load all plugin routes.  See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
