<?php
Yii::setPathOfAlias('YumModule' , dirname(__FILE__));
Yii::setPathOfAlias('YumComponents' , dirname(__FILE__) . '/components/');
Yii::setPathOfAlias('YumAssets' , dirname(__FILE__) . '/assets/');

Yii::import('YumModule.models.*');
Yii::import('YumModule.controllers.YumController');

class UserModule extends CWebModule {
	public $version = '0.9-git-wip';
	public $debug = false;

	//layout related control vars
	public $baseLayout = 'application.views.layouts.main';
	public $layout = 'application.modules.user.views.layouts.yum';
	public $loginLayout = 'application.modules.user.views.layouts.login';
	public $adminLayout = 'application.modules.user.views.layouts.yum';
	public $enableBootstrap = true;

	public $enableLogging = true;
	public $enableOnlineStatus = true;

	// Cost for Password generation. See CPasswordHelper::hashPassword() for
	// details. 
	public $passwordHashCost = 13;

	// enable pStrength jquery widget
	public $enablepStrength = true;
	public $displayPasswordStrength = true;

	public $passwordGeneratorOptions = array(
			'length' => 8,
			'capitals' => 1,
			'numerals' => 1,
			'symbols' => 1,
			);

	// Show an Captcha after how many unsuccessful logins? Set to 0 to 
	// always display an captcha, set to false to disable this function
	public $captchaAfterUnsuccessfulLogins = 3;

	// After how much seconds without an action does a user gets indicated as
	// offline? Note that, of course, clicking the Logout button will indicate
	// him as offline instantly anyway.
	public $offlineIndicationTime = 300; // 5 Minutes

	// set to false to enable case insensitive users.
  // for example, demo and Demo would be the same user then
	public $caseSensitiveUsers = true;

	// set this to true if you do want to access data through a REST api. 
	// Disabled by default for security reasons.
	public $enableRESTapi = false;

	// Default cookie Duration is 3600*24*30 (30 days)
	public $cookieDuration = 2592000;

	// Set this to true to enable RESTful login over the same password as
	// the admin account. This is set to false, so the password does not
	// get over the network in cleartext. Use the md5 password to authenticate.
	public $RESTfulCleartextPasswords = false;

	public $password_expiration_time = 30; // days
	public $activationPasswordSet = false;
	public $autoLogin = false;

	// set to swift to active emailing by swiftMailer or 
	// PHPMailer to use PHPMailer as emailing lib.
	public $mailer = 'yum'; 
	public $phpmailer = null; // PHPMailer array options.
	public $adminEmail = 'admin@example.com';

	public $pageSize = 10;

	// if you want the users to be able to edit their profile TEXTAREAs with an
	// rich text Editor like CKEditor or tinymce, set that here
  public $rtepath = false; // Don't use an Rich text Editor
  public $rteadapter = false; // Don't use an Adapter

	public $customCsvExportCriteria = '1';
	
	// valid callback function that executes after user login
	public $afterLogin = false;

	// Set this to true to really remove users instead of setting the status
	// to -2 (YumUser::REMOVED)	
	// Handle with care. User and Profile will get removed physically from the db.
	public $trulyDelete = false;

	// set avoidSql to true if you intent do use yii-user-management on a non
	// mysql database. All places where a SQL query would be used for performance
	// reason are overwritten with a ActiveRecord implementation. This should
	// make it more compatible with other rdbms. Experimental of course.
	public $avoidSql = false;

	// When the auditTrail extension
	// (http://www.yiiframework.com/extension/audittrail)
	// is installed, use it. It simply appends the LoggableBehavior to
	// all Yum-classes, so they get logged.
	public $enableAuditTrail = false;

	public static $dateFormat = "m-d-Y";  //"d.m.Y H:i:s"
	public $dateTimeFormat = 'm-d-Y G:i:s';  //"d.m.Y H:i:s"

	private $_urls=array(
			'login'=>array('//user/user'),
			'return'=>array('//user/user/index'),
			'firstVisit'=>array('//user/privacy/update'),
			'delete'=>array('//user/user/delete'),
			// Page to go after admin logs in
			'returnAdmin'=>false,
			// Page to go to after logout
			'returnLogout'=>array('//user/user/login'));

	private $_views = array(
			'login' => '/user/login',
			'menu' => '/user/menu',
			'registration' => '/registration/registration',
			'activate' => '/user/resend_activation',
			'message' => '/user/message',
			'passwordForm' => '/user/_activation_passwordform',
			'changePassword' => 'changepassword',
			'messageCompose' =>'application.modules.message.views.message.compose');

	// LoginType :
	// If you want to activate many types of login just sum up the values below 
	// and assign them to 'loginType' in the user module configuration. For 
	// example, to allow login by username, email and hybridauth, set this 
	// value to 7. Defaults to only allow login by username (value set to 1)
	const LOGIN_BY_USERNAME	= 1;
	const LOGIN_BY_EMAIL = 2;
	const LOGIN_BY_HYBRIDAUTH	= 4;
	public $loginType = 1;

	public $hybridAuthConfigFile =  'protected/config/hybridauth.php';

	// see user/vendors/hybridauth/Hybrid/Providers for supported providers.
	// example: array('facebook', 'twitter')
	public $hybridAuthProviders = array();

	/**
	 * Defines all Controllers of the User Management Module and maps them to
	 * shorter terms for using in the url
	 * @var array
	 */
	public $controllerMap=array(
		'default'=>array('class'=>'YumModule.controllers.YumDefaultController'),
		'rest'=>array('class'=>'YumModule.controllers.YumRestController'),
		'csv'=>array('class'=>'YumModule.controllers.YumCsvController'),
		'auth'=>array('class'=>'YumModule.controllers.YumAuthController'),
		'install'=>array('class'=>'YumModule.controllers.YumInstallController'),
		'statistics'=>array('class'=>'YumModule.controllers.YumStatisticsController'),
		'translation'=>array('class'=>'YumModule.controllers.YumTranslationController'),
		'user'=>array('class'=>'YumModule.controllers.YumUserController'),
		// workaround to allow the url application/user/login:
		'login'=>array('class'=>'YumModule.controllers.YumUserController')
	);

	public $userTable = '{{user}}';
	public $translationTable = '{{translation}}';

	public $usernameRequirements=array(
		'minLen'=>3,
		'maxLen'=>30,
		'match' => '/^[A-Za-z0-9_-]+$/u',
		'dontMatchMessage' => 'Incorrect symbol\'s. (A-z0-9)',
	);

	public $passwordRequirements = array(
			'minLen' => 6,
			'maxLen' => 128,
			'minLowerCase' => 0,
			'minUpperCase'=>0,
			'minDigits' => 0,
			'maxRepetition' => 3,
			);


	/**
	 * Implements support for getting URLs and Views
	 * @param string $name
	 */
	public function __get($name) {
		if(substr($name, -3) === 'Url')
			if(isset($this->_urls[substr($name, 0, -3)]))
				return $this->_urls[substr($name, 0, -3)];

		if(substr($name, -4) === 'View')
			if(isset($this->_views[substr($name, 0, -4)]))
				return $this->_views[substr($name, 0, -4)];

		return parent::__get($name);
	}

	/**
	 * Implements support for setting URLs and Views
	 * @param string $name
	 * @param mixed $value
	 */
	public function __set($name,$value) {
		if(substr($name,-3)==='Url') {
			if(isset($this->_urls[substr($name,0,-3)]))
				$this->_urls[substr($name,0,-3)]=$value;
		}
		if(substr($name,-4)==='View') {
			if(isset($this->_views[substr($name,0,-4)]))
				$this->_views[substr($name,0,-4)]=$value;
		}

		//parent::__set($name,$value);
	}

	public function init() {
		$this->setImport(array(
			'YumModule.controllers.*',
			'YumModule.models.*',
			'YumModule.components.*',
			'YumModule.core.*',
		));
	}

	public function beforeControllerAction($controller, $action) {
		// Do not enable Debug mode when in Production Mode
		if(!defined('YII_DEBUG'))
			$this->debug = false;

		if(method_exists(Yii::app()->user, 'isAdmin') && Yii::app()->user->isAdmin())
			$controller->layout = Yum::module()->adminLayout;

		return parent::beforeControllerAction($controller, $action);
	}
}
