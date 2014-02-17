<?php

return array(
  'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
  'name'=>'Yii User Management Demo Application',
  'import'=>array(
    'application.models.*',
    'application.components.*',
    'application.modules.user.components.*',
    'application.modules.user.models.*',
  ),
  'modules'=>array(
    'user' => array(
      'debug' => true,
      'loginType' => 7, // username, email and hybridauth
      'hybridAuthProviders' => array('Facebook', 'Twitter'),
    ),
  ),
  'components'=>array(
    'cache' => array('class' => 'system.caching.CFileCache'),
    'user'=>array(
      'class' => 'application.modules.user.components.YumWebUser',
      'allowAutoLogin'=>true,
    ),
    'urlManager'=>array(
      'urlFormat'=>'path',
      'rules'=>array(
        '<controller:\w+>/<id:\d+>'=>'<controller>/view',
        '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
        '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
      ),
    ),
    'db'=>array(
      'connectionString' => 'mysql:host=localhost;dbname=yii_user_management_demo',
      'emulatePrepare' => true,
      'tablePrefix' => '',
      'username' => 'root',
      'password' => '',
      'charset' => 'utf8',
    ),
    'errorHandler'=>array(
      'errorAction'=>'site/error',
    ),
  ),
);
