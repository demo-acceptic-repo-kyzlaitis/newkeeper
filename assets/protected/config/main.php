<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
// set default
$lang = 'ru';
 
// lang list (path=>Yii I18N name)
$i18n = array(
	//'en'=>'en',
	'ru'=>'ru',
	//'ua'=>'uk',
);
if ($_SERVER['REQUEST_URI']) {
	$uri = explode('/',$_SERVER['REQUEST_URI']);
	if (isset($uri[1]) && isset($i18n[$uri[1]]))
		$lang = $uri[1];
}

//if(isset($_GET['lang']) && isset($i18n[$_GET['lang']])){
  //  $lang = $_GET['lang'];
    //var_dump($lang);exit();
    $curlang = $lang;
//}
//Yii::setPathOfAlias('yiiadmin', '/protected/modules/yiiadmin/');

$hoauth = require(dirname(__FILE__) . '/hoauth.php');

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
        //'uploadsPath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'News Keeper',
    'defaultController'=>'news',
	'sourceLanguage' => 'ru',
	'language' => $i18n[$lang],
    
	//'onBeginRequest'=>array('Aii', 'checkIp'),

	// preloading 'log' component
	'preload'=>array(
		'log',
		//'bootstrap',
	),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		//'application.models.admin.*',
		'application.components.*',
		'application.components.widgets.*',
		'application.components.behaviors.*',
		//'application.extensions.crontab.*',
        'application.extensions.editMe.*',
        'application.extensions.readability.*',
        'application.modules.user.*',
        'application.modules.user.models.*',
        'application.modules.user.components.*',
        'application.modules.rights.*',
        'application.modules.rights.components.*',
        'application.modules.yiiadmin.*',
        'application.helpers.*',
		'application.components.ImageHandler.CImageHandler',
		'application.modules.hybridauth.controllers.*',
		'application.extensions.hybridauth.hybridauth.Hybrid.*',
		'application.extensions.hybridauth.hybridauth.Hybrid.Providers.*',
	),
	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'12345',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			//'ipFilters'=>array('94.76.121.87'),
			'generatorPaths' => array(
		        'bootstrap.gii'
		    ),
		),
		
		'user'=>array(
			'tableUsers' => 'usr_users',
            'tableProfiles' => 'usr_profiles',
            'tableProfileFields' => 'usr_profiles_fields',
            # encrypting method (php hash function)
            'hash' => 'md5',
 
            # send activation email
            'sendActivationMail' => true,
 
            # allow access for non-activated users
            'loginNotActiv' => false,
 
            # activate user on registration (only sendActivationMail = false)
            'activeAfterRegister' => false,
 
            # automatically login from registration
            'autoLogin' => true,
 
            # registration path
            'registrationUrl' => array('/user/registration'),
 
            # recovery password path
            'recoveryUrl' => array('/user/recovery'),
 
            # login form path
            'loginUrl' => array('/user/login'),
 
            # page after login
            'returnUrl' => array('/user/profile'),
 
            # page after logout
            'returnLogoutUrl' => array('/user/login'),
        ),

        'rights'=>array(
                'install'=>false,
        ),

        'avatar',
        'yiiadmin'=>array(
            'password'=>'123123',
            'registerModels'=>array(
                'application.models.NewsAdmin',
                'application.models.CategoryAdmin',
                'application.models.BlogerAdmin',
                'application.models.UserAdmin',
                //'application.models.RightsAdmin',
                'application.models.CityAdmin',
                'application.models.WidgetCurrencyElementAdmin',
                'application.models.ContentAdmin',
                'application.models.SettingAdmin',
            ),
            //'excludeModels'=>array(),
        ),
		
	),

	// application components
	'components'=>array(
		'twitter' => array(
            'class' => 'ext.yiitwitteroauth.YiiTwitter',
            'consumer_key' => 'sqsbXffBj00eZNpWmLIOjulfq',
            'consumer_secret' => 'iYdDvipokefOYitCc9Wh1EKYg3p4S8IjqUNI1BkFca7JmD50yJ',
            'callback' => 'http://' . $_SERVER['HTTP_HOST'] . '/',
        ),
        'cache'=>array(
            'class'=>'system.caching.CFileCache',
        ),
        'settings' => array(
            'class'             => 'ext.CmsSettings',
            'cacheComponentId'  => 'cache',
            'cacheId'           => 'global_website_settings',
            'cacheTime'         => 84000,
            'tableName'         => 'settings',
            'dbComponentId'     => 'db',
            'createTable'       => true,
            'dbEngine'          => 'InnoDB',
        ),
        /*'mail' => array(
            'class' => 'ext.yii-mail.YiiMail',
            'transportType'=>'smtp',
            'transportOptions'=>array(
                    'host'=>'<hostanme>',
                    'username'=>'<username>',
                    'password'=>'<password>',
                    'port'=>'25',                       
            ),
            'viewPath' => 'application.views.mail',             
        ),*/
		'user'=>array(
			// enable cookie-based authentication
			'class' => 'RWebUser',
			'allowAutoLogin'=>true,
			'loginUrl' => array('/news'),
		),
		'ih'=>array(
		    'class'=>'CImageHandler',
		),
		'authManager'=>array(
                'class'=>'RDbAuthManager',
                'connectionID'=>'db',
                'defaultRoles'=>array('Authenticated', 'Guest'),
                //'session',
        ),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
            'class'=>'UrlManager',
			'urlFormat'=>'path',
			'showScriptName'=>false,
            'rules'=>require(dirname(__FILE__) . '/router.php'),
			/*'rules'=>array(
				'gii'=>'gii',
				'yiiadmin'=>'yiiadmin',
				'rights'=>'rights/assignment',
				'gii/<controller:\w+>'=>'gii/<controller>',
				'gii/<controller:\w+>/<action:\w+>'=>'gii/<controller>/<action>',
				$lang.'/<module>/<controller:\w+>/<id:\d+>'=>'<module>/<controller>/view',
				$lang.'/<module>/<controller:\w+>/<action:\w+>/<slug>'=>'<module>/<controller>/<action>',
				$lang.'/<module>/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<module>/<controller>/<action>',
				$lang.'/<module>/<controller:\w+>/<action:\w+>'=>'<module>/<controller>/<action>',
				$lang.'/<controller:\w+>/<id:\d+>'=>'<controller>/view',
				$lang.'/<controller:\w+>/<action:\w+>/<slug>'=>'<controller>/<action>',
				$lang.'/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				$lang.'/<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				$lang.'/<controller:\w+>'=>'<controller>/index',
				$lang.'/'=>'news/index',
				
				'<module>/<controller:\w+>/<id:\d+>'=>'<module>/<controller>/view',
				'<module>/<controller:\w+>/<action:\w+>/<slug>'=>'<module>/<controller>/<action>',
				'<module>/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<module>/<controller>/<action>',
				'<module>/<controller:\w+>/<action:\w+>'=>'<module>/<controller>/<action>',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<slug>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                '<controller:\w+>'=>'<controller>/index',
                '/user/login'=>'user/registration',
			),*/
		),
		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database

		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=nk',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'Cheburashka2015',
			'charset' => 'utf8',
			//'tablePrefix' => 'tbl_',
    		'enableProfiling'=>true,
    		'enableParamLogging'=>true,
		),		
		/*'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=nk2I6F',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
			//'tablePrefix' => 'tbl_',
            		'enableProfiling'=>true,
            		'enableParamLogging'=>true,
		),*/
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					//'class'=>'CFileLogRoute',
					//'levels'=>'error, warning',
                    //'class'=>'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
                    //'ipFilters'=>array('127.0.0.1','192.168.1.215'),
                    'class'=>'CFileLogRoute',
			        /*'levels'=>'trace,log',
			        'categories' => 'system.db.CDbCommand',
			        'logFile' => 'db.log',*/
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
		'image'=>array(
                    'class'=>'application.extensions.image.CImageComponent',
                    // GD or ImageMagick
                    'driver'=>'GD',
                    // ImageMagick setup path
                    'params'=>array('directory'=>'/opt/local/bin'),
                ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
        'languages' => $i18n,
        'lang' => $curlang,
		'adminEmail'=>'admin@nkeeper.ua',
        'defaultPageSize'=>10,
        'hoauth' => $hoauth,
	),
);