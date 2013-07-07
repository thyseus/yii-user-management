<?php
/**
 * UserChangePassword class.
 * UserChangePassword is the data structure for keeping
 * user change password form data. It is used by the 'changepassword' action
 * of 'UserController'.
 */

class YumUserChangePassword extends YumFormModel 
{
//	private $_errors;
	public $password;
	public $verifyPassword;
	public $currentPassword;

	public function addError($attribute, $error) {
		parent::addError($attribute, Yum::t($error));
	}

	public function rules() {
		$passwordRequirements = Yum::module()->passwordRequirements;
		$passwordrule = array_merge(array(
					'password', 'YumPasswordValidator'), $passwordRequirements);
		$rules[] = $passwordrule;
		$rules[] = array('currentPassword', 'safe');
		$rules[] = array('currentPassword', 'required', 'on' => 'user_request');
		$rules[] = array('password, verifyPassword', 'required');
		$rules[] = array('password', 'compare', 'compareAttribute' =>'verifyPassword', 'message' => Yum::t('Retyped password is incorrect'));

		return $rules;
	}

	public function attributeLabels() {
		return array(
			'password'=>Yum::t('New password'),
			'verifyPassword'=>Yum::t('Retype your new password'),
			'currentPassword'=>Yum::t('Your current password'),
		);
	}

}
