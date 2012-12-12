<?php
Yii::setPathOfAlias('RegistrationModule' , dirname(__FILE__));
Yii::setPathOfAlias('YumModulesRoot' , dirname(dirname(__FILE__)));

class RegistrationModule extends CWebModule {
	// why enableRegistration ? - in case you only want a recovery !
	public $layout = 'YumModulesRoot.users.views.layouts.yum';
	public $enableRegistration = true;
	public $enableRecovery = true;

	public $registrationUrl = array('//registration/registration/registration');
	public $activationUrl = array('//registration/registration/activation');
	public $recoveryUrl = array('//registration/registration/recovery');

	public $activationSuccessView = '/registration/activation_success';
	public $activationFailureView = '/registration/activation_failure';

	// Whether to confirm the activation of an user by email
	public $enableActivationConfirmation = true;

	public $validEmailPattern = '/^[A-Za-z0-9@.\s,]+$/u';

	public $registrationEmail='register@website.com';
	public $recoveryEmail='restore@website.com';

	public $registrationView = '/registration/registration';
	public $changePasswordView =
		'YumModulesRoot.user.views.user.changepassword';
	public $recoverPasswordView =
		'RegistrationModule.views.registration.recovery';

	/**
	 * Whether to use captcha in registration process
	 * @var boolean
	 */
	public $enableCaptcha = true;

	public $loginAfterSuccessfulActivation = false;

	public $controllerMap=array(
			'registration'=>array(
				'class'=>'RegistrationModule.controllers.YumRegistrationController'),
			);

}
