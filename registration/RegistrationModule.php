<?php
Yii::setPathOfAlias('RegistrationModule' , dirname(__FILE__));

class RegistrationModule extends CWebModule {
	// why enableRegistration ? - in case you only want a recovery ! 
	public $layout = 'application.modules.user.views.layouts.yum';
	public $enableRegistration = true;
	public $enableRecovery = true;

	public $registrationUrl = array('//registration/registration/registration');
	public $activationUrl = array('//registration/registration/activation');
	public $recoveryUrl = array('//registration/registration/recovery');

	public $activationSuccessView = '/registration/activation_success';
	public $activationFailureView = '/registration/activation_failure';

	// Whether to confirm the activation of an user by email
	public $enableActivationConfirmation = true; 

	public $registrationEmail='register@website.com';
	public $recoveryEmail='restore@website.com';

	// Which roles should be assigned automatically to a fresh registered user?
	// Use role id, for example array(1,4,5)  
	public $defaultRoles = array();
	public $defaultHybridAuthRoles = array();

	public $registrationView = '/registration/registration';
	public $changePasswordView = 
		'application.modules.user.views.user.changepassword';
	public $recoverPasswordView = 
		'application.modules.registration.views.registration.recovery';

	/**
	 * Whether to use captcha in registration process
	 * @var boolean
	 */
	public $enableCaptcha = true;

	public $loginAfterSuccessfulActivation = false;
	public $loginAfterSuccessfulRecovery = false;

	public $controllerMap=array(
			'registration'=>array(
				'class'=>'RegistrationModule.controllers.YumRegistrationController'),
			);

}
