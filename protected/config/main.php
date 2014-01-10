<?php
	
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

require_once(dirname(__FILE__).'/../includes/localization.php');


return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Squid Pacific',
	'sourceLanguage'=>'tr_TR',
	'language'=>'en_US',
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*', 
		'application.components.*',
		'application.utilities.*',
		'application.utilities.epub3.*'
		
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool

		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'ln14@KlMrsqd', 
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>false,
		),
		'yiiadmin' =>array(
            'password'=>'ln14@KlMrsqd',
            'registerModels'=>array(
                //add the models you want to manage
                'application.models.User',
            ),
        ),

	),

	// application components
	'components'=>array(
		
		/*'coreMessages'=>array(
	    	'basePath'=>'/var/www/squid-pacific/egemen/protected/messages',
			)	,*/
		
		 'messages' => array(
		 			'language'=>'en_US',
                    'class' => 'CGettextMessageSource',
                    'basePath'=>'/var/www/squid-pacific/egemen/protected/locale/messages',
                    'useMoFile' => TRUE,
            ),
		 
		/*
		'messages' => array(
						
                        'class' => 'CGettextMessageSource',
                        'useMoFile' => FALSE,
                ),
		*/
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			//'caseSensitive'=>false,     
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\w+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>/<id:\w+>/<id2:\w+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		), 
		

		// uncomment the following to use a MySQL database

		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=squid_pacific',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '12548442',
			'charset' => 'utf8',
		),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                 array(
                    'class' => 'application.extension.SquidLogRoute',
                    'levels'=> 'trace,error,info,profile,warning',
                 //   'categories'=>'Squid'
                ),
            ),
        ),
		'Smtpmail'=>array(
            'class'=>'application.extension.smtpmail.PHPMailer',
            'Host'=>"tls://smtp.gmail.com",
            'Username'=>'edubox@linden-tech.com',
            'Password'=>'12548442',
            'Mailer'=>'smtp',
            'Port'=>465,
            'SMTPAuth'=>true, 
            //'ssl'=>'tls'
        ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
     	'epubtopdf'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'../../'.'bin/epubtopdf/epubtopdf ',
     	'availableLanguages' => array(
     		'tr_TR' => 'Türkçe',
     		'en_US' => 'English'
     		)
	)

);
