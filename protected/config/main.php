<?php
	
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

require_once(dirname(__FILE__).'/../includes/localization.php');

$db_config_list=array(
			"baracuda"=>array(
                        			'connectionString' => 'mysql:host=pufferfish.private.services.okutus.com;port=3306;dbname=squid_pacific',
                        			'emulatePrepare' => true,
                        			'username' => 'barracuda',
                        			'password' => 'hWqG49pCYnGSsaXU',
                        			'charset' => 'utf8',
                			),
			"lindneo"=>array(
                        			'connectionString' => 'mysql:host=lindneo.com;port=3306;dbname=squid_pacific',
                        			'emulatePrepare' => true,
                        			'username' => 'db_squid_pacific',
                        			'password' => '7GqA3Pqcy38QnfPQ',
                        			'charset' => 'utf8',
                			),
			"ulgen"=>array(
                        			'connectionString' => 'mysql:host=datamaster.private.services.lindneo.com;port=3306;dbname=squid_pacific',
                        			'emulatePrepare' => true,
                        			'username' => 'db_squid_pacific',
                        			'password' => '7GqA3Pqcy38QnfPQ',
                        			'charset' => 'utf8',
                			),
);      

$catalogURL=array(
	"baracuda"=>"http://bigcat.okutus.com/site/import",
	"lindneo"=>"http://catalog.lindneo.com/site/import",
	"ulgen"=>"http://catalog.lindneo.com/site/import"
	);

$catalog=array(
	"baracuda"=>"http://bigcat.okutus.com",
	"lindneo"=>"http://catalog.lindneo.com",
	"ulgen"=>"http://catalog.lindneo.com",
	//"lindneo"=>"http://catalog.lindneo.com/site/import"
	);

$mainCloud=array(
		"lindneo"=>array(
				"host"=>"cloud.lindneo.com",
				"port"=>"2222",
			),
		"ulgen"=>array(
				"host"=>"cloud.lindneo.com",
				"port"=>"2222",
			),
		"baracuda"=>array(
				"host"=>"cloud.okutus.com",
				"port"=>"2222",
			),
	);

$host_config=array(
			"ulgen"=>array(
                				'catalog_host'=>'http://catalog.lindneo.com',
				                'kerbela_host'=>'http://kerbela.lindneo.com',
				                'panda_host'=>'http://panda.lindneo.com',
				                'koala_host'=>'http://koala.lindneo.com',
								'cloud_host'=>'http://cloud.lindneo.com',
								'reader_host'=>'http://reader.lindneo.com/ekaratas'
					),
			"tigerfish"=>array(
                                'catalog_host'=>'http://bigcat.okutus.com',
                                'kerbela_host'=>'http://kerbela.okutus.com',
                                'panda_host'=>'http://boxoffice.okutus.com',
                                'koala_host'=>'http://wow.okutus.com',
								'cloud_host'=>'http://cloud.okutus.com',
								'reader_host'=>'http://reader.okutus.com'
				)
		);

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Okutus Editör',
	'sourceLanguage'=>'tr_TR',
	'language'=>'en_US',
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*', 
		'application.controllers.*', 
		'application.components.*',
		'application.utilities.*',
		'application.utilities.epub3.*',
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
		
		/* 'messages' => array(
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
		/*
		'db'=>array(
			'connectionString' => 'mysql:host=lindneo.com;port=3306;dbname=squid_pacific',
			'emulatePrepare' => true,
			'username' => 'db_squid_pacific',
			'password' => '7GqA3Pqcy38QnfPQ',
			'charset' => 'utf8',
		),
		*/
		
		'db'=>$db_config_list[gethostname()],		


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
                    'except'=>'system.*',
                ),
            ),
        ),
		'Smtpmail'=>array(
            'class'=>'application.extension.smtpmail.PHPMailer',
            'Host'=>"tls://smtp.gmail.com",
            'Username'=>'noreply@okutus.com',
            'Password'=>'7m68FJ:J:JHoAeY',
            'Mailer'=>'smtp',
            'Port'=>465,
            'SMTPAuth'=>true, 
           	//'SMTPSecure' => 'tls',
        ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName'] 
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'pacific@linden-tech.com',
		'noreplyEmail'=>'noreply@okutus.com',
		'twilioSid'=>'AC32ab2abb469b9c87c749dbffe37d5f06',
		'twilioToken'=>'26d65a599d9f301162f13cf5ca7b696e',
		'twilioFrom'=>'+18282124403'	,

     	'epubtopdf'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'../../'.'bin/epubtopdf/epubtopdf ',
     	'pdftojpg'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'../../'.'bin/pdftojpg/pdftojpg ',
     	'tocextractor'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'../../'.'bin/jpdfbookmarks-2.5.2/jpdfbookmarks --dump ',
     	'htmltopng'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'../../'.'bin/htmltopng/htmltopng ',
     	'lindenstamp'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'../../'.'bin/lindenstamp/lindenstamp ',
     	'timestamps'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'../../'.'timestamps/',
     	'storage'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'../../'.'uploads/files/',
     	'availableLanguages' => array(
     		'tr_TR' => 'Türkçe',
     		'en_US' => 'English'
     		),
     	'catalogExportURL' => $catalogURL[gethostname()],
     	'catalog' => $catalog[gethostname()],
     	'catalog_host'=>$host_config[gethostname()]['catalog_host'],
        'kerbela_host'=>$host_config[gethostname()]['kerbela_host'],
        'panda_host'=>$host_config[gethostname()]['panda_host'],
        'koala_host'=>$host_config[gethostname()]['koala_host'],
        'cloud_host'=>$host_config[gethostname()]['cloud_host'],
        'reader_host'=>$host_config[gethostname()]['reader_host'],
        'mainCloud'=>$mainCloud[gethostname()],

	)

);
