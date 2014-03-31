<?php
/**
 * RegistrationForm class.
 * RegistrationForm is the data structure for keeping
 * user registration form data. It is used by the 'registration' action of 
 * 'YumRegistrationController'.
 * @package Yum.models
 */
class YumRegistrationForm extends YumUser {
  public $email;
  public $terms;
  public $newsletter;
  public $username;
  public $password;
  public $street;
  public $city;
  public $telephone;
  public $verifyPassword;
  public $verifyCode; // Captcha

  public function rules() 
  {
    $rules = parent::rules();

    if(!(Yum::hasModule('registration') && Yum::module('registration')->registration_by_email))
      $rules[] = array('username', 'required');

    $rules[] = array('newsletter, terms', 'safe');
    // password requirement is already checked in YumUser model, its sufficient
    // to check for verifyPassword here
    $rules[] = array('verifyPassword', 'required');
    $rules[] = array('password', 'compare',
      'compareAttribute'=>'verifyPassword',
      'message' => Yum::t("Retype password is incorrect."));

    if(Yum::module('registration')->enableCaptcha && !Yum::module()->debug)
      $rules[] = array('verifyCode', 'captcha',
        'allowEmpty'=>CCaptcha::checkRequirements()); 

    return $rules;
  }

  public static function genRandomString($length = 10)
  {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $string ='';    
    for ($p = 0; $p < $length; $p++)
    {
      $string .= $characters[mt_rand(0, strlen($characters)-1)];
    }
    return $string;
  }
}
