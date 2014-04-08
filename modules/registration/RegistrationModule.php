<?php
Yii::setPathOfAlias('registration' , dirname(__FILE__));

class RegistrationModule extends CWebModule {
  // why enableRegistration ? - in case you only want a recovery !
  public $layout = 'user.views.layouts.yum';
  public $enableRegistration = true;
  public $enableRecovery = true;

  public $recoveryUrl     = array('//registration/registration/recovery');
  public $activationUrl   = array('//registration/registration/activation');
  public $registrationUrl = array('//registration/registration/registration');

  public $activationSuccessView = '/registration/activation_success';
  public $activationFailureView = '/registration/activation_failure';

  // Whether to confirm the activation of an user by email
  public $enableActivationConfirmation = true;

  public $registrationEmail='register@website.com';
  public $recoveryEmail='restore@website.com';

  // If set to true, no username is needed on registration.
  // The user only needs to give his email address.
  // The 'username' is set to given email automatically.
  public $registration_by_email = false;

  // Which roles should be assigned automatically to a fresh registered user?
  // Use role id, for example array(1,4,5)
  public $defaultRoles = array();
  public $defaultHybridAuthRoles = array();

  public $registrationView    = '/registration/registration';
  public $changePasswordView  = 'user.views.user.changepassword';
  public $recoverPasswordView = 'registration.views.registration.recovery';

  /**
   * Whether to use captcha in registration process
   * @var boolean
   */
  public $enableCaptcha = true;

  public $loginAfterSuccessfulRecovery   = false;
  public $loginAfterSuccessfulActivation = false;

  public $controllerMap=array(
    'registration'=>array(
      'class'=>'registration.controllers.YumRegistrationController'),
  );

}
