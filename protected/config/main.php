<?php

require dirname(__FILE__).DIRECTORY_SEPARATOR.'..' . "/vendors/autoload.php";

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Homeless Partners',

	'defaultController' => 'home', 

	// preloading 'log' component
	'preload'=>array('log', 'input'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.components.Email',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'hpdev',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
	),

	// application components
	'components'=>array(

		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'loginUrl' => array('login/index'),
		),

		'authManager'=>array(
            'class'=>'AuthManager',
        ),

		'input'=>array(   
            'class'         => 'CmsInput',  
            'cleanPost'     => false,  
            'cleanGet'      => false,   
        ),
      
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName' => false,
			'rules'=>array(
				//'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				//'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'' => 'home/index',
				'about' => 'home/about',
				'howItWorks' => 'home/howItWorks',
				'faq' => 'home/faq',
				'contact' => 'home/contact',
				'privacy' => 'home/privacy',
				'terms' => 'home/terms',
                'pledge-day-2014' => 'home/pledgeDay',
                'spread-the-word' => 'home/spreadTheWord',
                'search' => 'search/index',

				'team' => 'home/team',
				'technology' => 'home/technology',
				'sponsors' => 'home/sponsors',
				'media' => 'home/media',

				'volunteer' => 'home/volunteer',
				'donate' => 'home/donate',
				'login' => 'login/index',
				'register' => 'login/register',

				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		
		'db'=>array(
			'connectionString' => 'mysql:host=<host>;dbname=<dbname>',
			'emulatePrepare' => true,
			'username' => '',
			'password' => '',
			'charset' => 'utf8',
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'home/index',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'MAILGUN_API_KEY'=>'key-0-btbu-qb7trplmbftn96me4mhi0jak8',
		'HP_SENDER_EMAIL_ADDRESS' => 'Homeless Partners <pledges@homelesspartners.com>',
		'HP_SENDER_NO_REPLY_EMAIL_ADDRESS' => 'noreply@homelesspartners.com'
	),
);