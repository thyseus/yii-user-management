<?php

// This is the bootstrap script of the yii user management demo application.
// It is not meant for any productive 
// Change the following path to your yii installation
require_once(dirname(__FILE__).'/../yii-git/framework/yii.php');

define('YII_DEBUG',true);

Yii::createWebApplication('/protected/config/main.php')->run();