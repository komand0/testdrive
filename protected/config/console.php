<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',

	// preloading 'log' component
	'preload'=>array('log'),

	// application components
	'components'=>array(
		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),//*/
		// uncomment the following to use a MySQL database
		/**/
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
			'emulatePrepare' => true,
		),//*/
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
			),
		),
		'authManager'=>array(
			'class'=>'application.components.DbAuthManager',
			'connectionID'=>'db',
			'defaultRoles' => array('guest'),
		),
	),
);