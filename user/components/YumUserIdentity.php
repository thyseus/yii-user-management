<?php

class YumUserIdentity extends CUserIdentity {
	private $id;
	public $user;
	public $facebook_id=null;
	public $facebook_user=null;
	const ERROR_EMAIL_INVALID=3;
	const ERROR_STATUS_INACTIVE=4;
	const ERROR_STATUS_BANNED=5;
	const ERROR_STATUS_REMOVED=6;
	const ERROR_STATUS_USER_DOES_NOT_EXIST=7;

	public function authenticateFacebook() {
		$fbconfig = Yum::module()->facebookConfig;
		if (!$fbconfig || $fbconfig && !is_array($fbconfig))
			throw new Exception('actionLogout for Facebook was called, but is not activated in application configuration');

		Yii::import('application.modules.user.vendors.facebook.*');
		require_once('Facebook.php');
		$facebook = new Facebook($fbconfig);

		$fb_uid = $facebook->getUser();
		$profile = YumProfile::model()->findByAttributes(array('facebook_id'=>$fb_uid));
		$user = ($profile) ? YumUser::model()->findByPk($profile->user_id) : null;
		if ($user === null)
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		else if($user->status == YumUser::STATUS_INACTIVE)
			$this->errorCode = self::ERROR_STATUS_INACTIVE;
		else if($user->status == YumUser::STATUS_BANNED)
			$this->errorCode = self::ERROR_STATUS_BANNED;
		else
		{
			$this->id = $user->id;
			$this->username = 'facebook';
			$this->facebook_id = $fb_uid;
			//$this->facebook_user = $facebook->api('/me');
			$this->errorCode = self::ERROR_NONE;
		}
	}

	public function authenticateLdap()
	{
		if (!$settings = YumSettings::model()->find('is_active'))
			throw new ExceptionClass('No active YUM-Settings profile found');

		$ds = @ldap_connect($settings->ldap_host, $settings->ldap_port);
		ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, $settings->ldap_protocol);

		if ($settings->ldap_tls == 1)
			ldap_start_tls($ds);

		if (!@ldap_bind($ds))
			throw new Exception('OpenLDAP: Could not connect to LDAP-Server');

		if ($r = ldap_search($ds, $settings->ldap_basedn, '(uid=' . $this->username . ')'))
				{
				$result = @ldap_get_entries($ds, $r);
				if ($result[0] && @ldap_bind($ds, $result[0]['dn'], $this->password))
				{
				$user = YumUser::model()->find('username=:username', array(':username' => $this->username));
				if ($user == NULL)
				{
				if ($settings->ldap_autocreate == 1)
				{
				$user = new YumUser();
				$user->username = $this->username;
				if ($settings->ldap_transfer_pw == 1)
				$user->password = YumUser::encrypt($this->password);
				$user->lastpasswordchange = 0;
				$user->activationKey = '';
				$user->superuser = 0;
				$user->createtime = time();
				$user->status = 1;

				if ($user->save(false))
				{
					if (Yum::module()->enableProfiles)
					{
						$profile = new YumProfile();
						$profile->user_id = $user->id;
						$profile->privacy = 'protected';
						if ($settings->ldap_transfer_attr == 1)
						{
							$profile->email = $result[0]['mail'][0];
							$profile->lastname = $result[0]['sn'][0];
							$profile->firstname = $result[0]['givenname'][0];
							$profile->street = $result[0]['postaladdress'][0];
							$profile->city = $result[0]['l'][0];
						}
						$profile->save(false);
					}
				}
				else
					return!$this->errorCode = self::ERROR_PASSWORD_INVALID;
				}
				else
					return!$this->errorCode = self::ERROR_PASSWORD_INVALID;
				}

		$this->id = $user->id;
		$this->setState('id', $user->id);
		$this->username = $user->username;
		$this->user = $user;

		return!$this->errorCode = self::ERROR_NONE;
				}
				}
		return!$this->errorCode = self::ERROR_PASSWORD_INVALID;
	}

	// Authenticate the user. When without_password is set to true, the user
	// gets authenticated without providing a password. This is used for
	// the option 'loginAfterSuccessfulActivation'
	public function authenticate($without_password = false)
	{
		$user = YumUser::model()->find('username = :username', array(
					':username' => $this->username));

		// try to authenticate via email
		if(!$user && (Yum::module()->loginType & 2) && Yum::hasModule('profile')) {
			if($profile = YumProfile::model()->find('email = :email', array(
							':email' => $this->username)))
				if($profile->user)
					$user = $profile->user;
		}

		if(!$user)
			return self::ERROR_STATUS_USER_DOES_NOT_EXIST;

		if($without_password)
			$this->credentialsConfirmed($user);
		else if(YumUser::encrypt($this->password)!==$user->password)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else if($user->status == YumUser::STATUS_INACTIVE)
			$this->errorCode=self::ERROR_STATUS_INACTIVE;
		else if($user->status == YumUser::STATUS_BANNED)
			$this->errorCode=self::ERROR_STATUS_BANNED;
		else if($user->status == YumUser::STATUS_REMOVED)
			$this->errorCode=self::ERROR_STATUS_REMOVED;
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
