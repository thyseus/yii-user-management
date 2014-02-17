<?php

class YumUserIdentity extends CUserIdentity {
	private $id;
	public $user;
	const ERROR_EMAIL_INVALID=3;
	const ERROR_STATUS_INACTIVE=4;
	const ERROR_STATUS_BANNED=5;
	const ERROR_STATUS_REMOVED=6;
	const ERROR_STATUS_USER_DOES_NOT_EXIST=7;

	// Authenticate the user. When without_password is set to true, the user
	// gets authenticated without providing a password. This is used for
	// the option 'loginAfterSuccessfulActivation'
	public function authenticate($without_password = false) {
		$user = YumUser::model()->find('username = :username', array(
					':username' => $this->username));

		// try to authenticate via email
		if(Yum::hasModule('profile') 
				&& Yum::module()->loginType & UserModule::LOGIN_BY_EMAIL
				&& !$user) {
			if($profile = YumProfile::model()->find('email = :email', array(
							':email' => $this->username)))
				if($profile->user)
					$user = $profile->user;
		}

		if(!$user)
			return self::ERROR_STATUS_USER_DOES_NOT_EXIST;

		if($user->status == YumUser::STATUS_INACTIVE)
			$this->errorCode=self::ERROR_STATUS_INACTIVE;
		else if($user->status == YumUser::STATUS_BANNED)
			$this->errorCode=self::ERROR_STATUS_BANNED;
		else if($user->status == YumUser::STATUS_REMOVED)
			$this->errorCode=self::ERROR_STATUS_REMOVED;
		else if($without_password)
			$this->credentialsConfirmed($user);
		else if(!CPasswordHelper::verifyPassword($this->password, $user->password))
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
			$this->credentialsConfirmed($user);
		return !$this->errorCode;
	}

	function credentialsConfirmed($user) {
		$this->id = $user->id;
		$this->setState('id', $user->id);
		$this->username = $user->username;
		$this->errorCode=self::ERROR_NONE;
	}

	/**
	 * @return integer the ID of the user record
	 */
	public function getId()
	{
		return $this->id;
	}

	public function getRoles()
	{
		return $this->Role;
	}

}
