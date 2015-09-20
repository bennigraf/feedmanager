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
* iTu-Sitemanager-specific routing:
*/

// use /assets/guid.ending to stream/playback podcasts:
Router::connect('/assets/:asset',
	array(
		'controller' => 'assets',
		'action' => 'view'),
	array(
		'pass' => array('asset'),
		// matches i.e. C84DE0C0-2787-4081-A8A3-6DE8B60513AC.m4v
		'asset' => '[0-9A-Z]{8}-[0-9A-Z]{4}-[0-9A-Z]{4}-[0-9A-Z]{4}-[0-9A-Z]{12}\.[0-9a-z]{3,4}$'
	));

// needed because feeds/xyz is being replaced later
Router::connect('/feeds/index', array('controller' => 'feeds', 'action' => 'index'));
Router::connect('/feeds/add', array('controller' => 'feeds', 'action' => 'add'));
Router::connect('/feeds/edit/*', array('controller' => 'feeds', 'action' => 'edit'));
Router::connect('/feeds/order/*', array('controller' => 'feeds', 'action' => 'order'));
Router::connect('/feeds/delete/*', array('controller' => 'feeds', 'action' => 'delete'));
Router::connect('/feeds/deleteimg/*', array('controller' => 'feeds', 'action' => 'deleteimg'));
Router::connect('/feeds/images/*', array('controller' => 'feeds', 'action' => 'images'));

// use /itunesu/feeds/[feedtitle].rss to access feeds directly
Router::connect('/feeds/:feedtitle',
	array(
		'controller' => 'feeds',
		'action' => 'view'
	),
	array(
		'pass' => array('feedtitle')
	)
	);
// give format if possible...
Router::connect(
	'/feeds/:format/:feedtitle',
	array('controller' => 'feeds', 'action' => 'view'),
	array(
		'pass' => array('feedtitle'),
		'format' => 'hd|sd|audio'
	)
	);


/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	// Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
	Router::connect('/', array('controller' => 'feeds', 'action' => 'index'));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

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
	
	Router::parseExtensions('rss');
	
	