<?php

// Yii::setPathOfAlias('local','path/to/local-folder');

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Mein Service Check',
	'language' => 'de',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.modules.user.models.*',
		'application.models.*',
		'application.components.*',
		'application.modules.cms.CmsModule',
		'application.modules.user.components.*',
		),

	'modules'=>array(
		'user' => array(
			'profileLayout' => '//layouts/main',
			'profileView' => '//profile/view',
			'avatarScaleImage' => false,
			'layout' => '//layouts/main',
			'userLayout' => '//layouts/main',
			'avatarPath' => 'images/avatar',
			'registrationEmail' => 'kontakt@mein-service-check.de',
			'debug' => true,
			'loginType' => 3,
			'registrationType' => 2,
			'loginView' => '//user/login'),
		'cms' => array(
			'rtepath' => '/ckeditor/ckeditor.js',
			'rteadapter' => '/ckeditor/adapters/jquery.js',
			'layout' => ''),
		),

	// application components
	'components'=>array(
			'user'=>array(
				'class' => 'application.modules.user.components.YumWebUser',
				'allowAutoLogin'=>true,
				'loginUrl' => array('//user/user/login')
				),
			'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName' => false,
			'rules'=>array(
		'' => 'site/index',
				'benutzerregistrierung' => 'registration/registerUser',
				'firmenregistrierung' => 'registration/registerCompany',
				'login' => 'user/auth',
				'blog' => 'post/index',
				'news' => 'news/index',
				'blog/<id:\d+>' => 'post/view',
				'blog/<title>' => 'post/view',
				'forum' => 'forum/index',
				'forum/create' => 'forum/create',
				'forum/Kategorie/<category>' => 'forum/index',
				'forum/<id:\d+>' => 'forum/view',
				'forum/<title>' => 'forum/view',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				'<page:\w+>' => 'cms/sitecontent/view',
			),
		),
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=d00f977b',
			'schemaCachingDuration' => '3600',
			'emulatePrepare' => true,
			'username' => 'd00f977b',
			'password' => 'DRtbJqqPNvvdKkuM',
			'charset' => 'utf8',
			'tablePrefix' => '',
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
//	array( 'class'=>'CFileLogRoute', 'levels'=>'error, warning',), 
//	array( 'class'=>'CWebLogRoute', 'showInFireBug' => false),
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'kontakt@mein-service-check.de',
	),
);
