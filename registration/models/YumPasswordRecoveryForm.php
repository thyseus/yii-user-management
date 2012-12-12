<?php

/**
 * PasswordRecoveryForm class.
 * PasswordRecoveryForm is the data structure for keeping the
 * password recovery form data. It is used by the 'recovery' action 
 * of the Registration Module
 */
class YumPasswordRecoveryForm extends YumFormModel {
	public $login_or_email;

	// $user will be poupulated with the user instance, if found
	public $user;
	
	public function rules()
	{
		$rules = array(
				// username and password are required
				array('login_or_email', 'required'),
				array('login_or_email', 'checkexists'),
				array('login_or_email', 'email'),
				);

		return $rules;
	}

	public function attributeLabels()
	{
		return array(
			'login_or_email'=>Yum::t('Email'),
		);
	}
	
	public function checkexists($attribute, $params) {
		$user = null;

		// we only want to authenticate when there are no input errors so far
		if(!$this->hasErrors()) {
			if (strpos($this->login_or_email,"@")) {
				$profile = YumProfile::model()->findByAttributes(array(
							'email'=>$this->login_or_email));
				$this->user = $profile 
					&& $profile->user 
					&& $profile->user instanceof YumUser ? $profile->user : null;
			} else 
				$this->user = YumUser::model()->findByAttributes(array(
							'username'=>$this->login_or_email));

		}
	}
}
