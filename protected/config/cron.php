<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'cron',

	// preloading 'log' component
	'preload'=>array('log'),

        'import'=>array(
            'application.components.*',
            'application.models.*',
        ),

	// application components
	'components'=>array(
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=nk2I6F',
			'emulatePrepare' => true,
			'username' => 'u_nk2I6F',
			'password' => 'uscdFYBI',
			'charset' => 'utf8',
		),
		
		'log'=>array(
                    'class'=>'CLogRouter',
                    'routes'=>array(
                        array(
                            'class'=>'CFileLogRoute',
                            'logFile'=>'cron.log',
                            'levels'=>'error, warning',
                        ),
                        array(
                            'class'=>'CFileLogRoute',
                            'logFile'=>'cron_trace.log',
                            'levels'=>'trace',
                        ),
                    ),
                ),
	),
);