<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
//Yii::setPathOfAlias('yiibooster', dirname(__FILE__).'/../extensions/yiibooster');
Yii::setPathOfAlias('booster', dirname(__FILE__) . DIRECTORY_SEPARATOR . '../extensions/yiibooster');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	#'theme'=>'classic',
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Web Application',
	'defaultController'=>'note',

	// preloading 'log' component
	'preload'=>array(
		'log',
		'booster',
		),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		///*
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'pass',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		//*/
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'loginUrl'=>array('note/login'),
		),
		// uncomment the following to enable URLs in path-format
		///*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
			'showScriptName'=>false,
			'caseSensitive'=>false,
		),
		//*/

		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		// uncomment the following to use a MySQL database
		//*///*
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=notes',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'pass',
			'charset' => 'utf8',
		),
		/*/
		'db' => array(
			'connectionString' => 'pgsql:host=localhost;port=5432;dbname=isin',
			'username' => 'postgres',
			'password' => 'pass',
			'charset' => 'utf8',
		),
		//*/
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'note/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning, info',
					'except'=>'user.*',
				),
				array(
					'class'=>'system.logging.CFileLogRoute',
					'categories'=>'user.*',
					'logFile'=>'user.log',
					'maxLogFiles'=>100000,
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				//*/
			),
		),
		'cache'=>array(
			'class'=>'system.caching.CFileCache',
		),
		'booster' => array(
			'class' => 'application.extensions.yiibooster.components.Booster',
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@exaxample.com',
	),
	
	'timeZone'=>'Europe/Kiev',

	'sourceLanguage'=>'en',
	'language'=>'en',


);