<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'YumUserController'.
 */
class YumUserLogin extends YumFormModel {
	public $username;
	public $password;
	public $rememberMe;
	public $verifyCode; // captcha 

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules() {
		if(!isset($this->scenario))
			$this->scenario = 'login';

		$rules = array(
				array('username, password', 'required', 'on' => 'login'),
				array('rememberMe', 'boolean'),
				);

		if(Yum::module()->captchaAfterUnsuccessfulLogins !== false) {
			$rules[] = array( 'verifyCode', 'captcha', 'on' => 'captcha',
					'allowEmpty' => !CCaptcha::checkRequirements(),
					);
			$rules[] = array('username, password', 'required', 'on' => 'captcha');
		}

		return $rules;
	}

	public function attributeLabels() {
		return array(
				'username'=>Yum::t('Name'),
				'password'=>Yum::t("Password"),
				'rememberMe'=>Yum::t("Remember me next time"),
				'verifyCode'=>Yum::t("Verification code"),
				);
	}
}
