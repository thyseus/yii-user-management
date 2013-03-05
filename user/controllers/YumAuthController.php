<?
class YumAuthController extends YumController {
	public $defaultAction = 'login';
	public $loginForm = null;

	public function accessRules() {
		return array(
				array('allow',
					'actions'=>array('login', 'facebook'),
					'users'=>array('*'),
					),
				array('allow',
					'actions'=>array('logout'),
					'users'=>array('@'),
					),
				array('deny',  // deny all other users
					'users'=>array('*'),
					),
				);
	}

	/**
	 * Handles user login via OpenLDAP
	 */
	public function loginByLdap()
	{
		if (!Yum::module()->loginType & UserModule::LOGIN_BY_LDAP)
			throw new Exception('login by ldap was called, but is not activated in application configuration');

		Yii::app()->user->logout();

		$identity = new YumUserIdentity($this->loginForm->username, $this->loginForm->password);
		$identity->authenticateLdap();

		switch ($identity->errorCode)
		{
			case YumUserIdentity::ERROR_NONE:
				$duration = 3600 * 24 * 30; //30 days

				Yii::app()->user->login($identity, $duration);

				return $identity->user;
				break;
			case YumUserIdentity::ERROR_STATUS_INACTIVE:
				$this->loginForm->addError('status', Yum::t('Your account is not activated.'));
				break;
			case YumUserIdentity::ERROR_REMOVED:
				$this->loginForm->addError('status', Yum::t('Your account has been deleted.'));
				break;
			case YumUserIdentity::ERROR_STATUS_BANNED:
				$this->loginForm->addError('status', Yum::t('Your account is blocked.'));
				break;
			case YumUserIdentity::ERROR_PASSWORD_INVALID:
				Yum::log(Yum::t('Failed login attempt for {username} via LDAP', array(
								'{username}' => $this->loginForm->username)), 'error');

				if (!$this->loginForm->hasErrors())
					$this->loginForm->addError("password", Yum::t('Username or Password is incorrect'));
				break;
		}

		return false;
	}

	public function loginByFacebook() {
		if (!Yum::module()->loginType & UserModule::LOGIN_BY_FACEBOOK)
			throw new Exception('actionFacebook was called, but is not activated in application configuration');

		Yii::app()->user->logout();
		Yii::import('application.modules.user.vendors.facebook.*');
		$facebook = new Facebook(Yum::module()->facebookConfig);
		$fb_uid = $facebook->getUser();
		if ($fb_uid) {
			$profile = YumProfile::model()->findByAttributes(array('facebook_id' => $fb_uid));
			$user = ($profile) ? YumUser::model()->findByPk($profile->user_id) : null;
			try {
				$fb_user = $facebook->api('/me');
				if (isset($fb_user['email']))
					$profile = YumProfile::model()->findByAttributes(array('email' => $fb_user['email']));
				else
					return false;
				if ($user === null && $profile === null) {
					// New account
					$user = new YumUser;
					$user->username = 'fb_'.YumRegistrationForm::genRandomString(Yum::module()->usernameRequirements['maxLen'] - 3);
					$user->password = YumEncrypt::encrypt(YumEncrypt::generatePassword());
					$user->activationKey = YumEncrypt::encrypt(microtime().$user->password, $user->salt);
					$user->createtime = time();
					$user->superuser = 0;
					if ($user->save()) {
						$profile = new YumProfile;
						$profile->user_id = $user->id;
						$profile->facebook_id = $fb_user['id'];
						$profile->email = $fb_user['email'];
						$profile->save(false);
					}
				} else {
					//No superuser account can log in using Facebook
					$user = $profile->user;
					if ($user->superuser) {
						Yum::log('A superuser tried to login by facebook', 'error');
						return false;
					}
					//Current account and FB account blending
					$profile->facebook_id = $fb_uid;
					$profile->save(false);
					$user->username = 'fb_'.YumRegistrationForm::genRandomString(Yum::module()->usernameRequirements['maxLen'] - 3);

					$user->superuser = 0;
					$user->save();
				}

				$identity = new YumUserIdentity($fb_uid, $user->id);
				$identity->authenticateFacebook(true);

				switch ($identity->errorCode) {
					case YumUserIdentity::ERROR_NONE:
						$duration = 3600*24*30; //30 days
						Yii::app()->user->login($identity, $duration);
						Yum::log('User ' . $user->username .' logged in via facebook');
						return $user;
						break;
					case YumUserIdentity::ERROR_STATUS_INACTIVE:
						$user->addError('status', Yum::t('Your account is not activated.'));
						break;
					case YumUserIdentity::ERROR_STATUS_BANNED:
						$user->addError('status', Yum::t('Your account is blocked.'));
						break;
					case YumUserIdentity::ERROR_PASSWORD_INVALID:
						Yum::log(Yum::t('Failed login attempt for {username} via facebook', array(
										'{username}' => $user->username)), 'error');
						$user->addError('status', Yum::t('Password incorrect.'));
						break;
				}
				return false;
			} catch (FacebookApiException $e) {
				/* FIXME: Workaround for avoiding the 'Error validating access token.'
				 * inmediatly after a user logs out. This is nasty. Any other
				 * approach to solve this issue is more than welcomed.
				 */

				Yum::log('Failed login attempt for ' . $user->username . ' via facebook', 'error');
				return false;
			}
		}
		else
			return false;
	}

	public function loginByUsername() {
		if(Yum::module()->caseSensitiveUsers)
			$user = YumUser::model()->find('username = :username', array(
						':username' => $this->loginForm->username));
		else
			$user = YumUser::model()->find('upper(username) = :username', array(
						':username' => strtoupper($this->loginForm->username)));

		if($user)
			return $this->authenticate($user);
		else {
			Yum::log( Yum::t(
						'Non-existent user {username} tried to log in (Ip-Address: {ip})', array(
							'{ip}' => Yii::app()->request->getUserHostAddress(),
							'{username}' => $this->loginForm->username)), 'error');

			$this->loginForm->addError('password',
					Yum::t('Username or Password is incorrect'));
		}

		return false;
	}

	public function logFailedLoginAttempt($user) {
		Yum::log( Yum::t(
					'Failed login attempt for user {username} (Ip-Address: {ip})', array(
						'{ip}' => Yii::app()->request->getUserHostAddress(),
						'{username}' => $this->loginForm->username)), 'error');
		$user->failedloginattempts++;
		$user->save(false, array('failedloginattempts'));
	}

	public function authenticate($user) {
		$identity = new YumUserIdentity($user->username, $this->loginForm->password);
		$identity->authenticate();
		switch($identity->errorCode) {
			case YumUserIdentity::ERROR_NONE:
				$duration = $this->loginForm->rememberMe ? 3600*24*30 : 0; // 30 days
				Yii::app()->user->login($identity,$duration);
				if($user->failedloginattempts > 0)
					Yum::setFlash(Yum::t(
								'Warning: there have been {count} failed login attempts', array(
									'{count}' => $user->failedloginattempts)));
				$user->failedloginattempts = 0;
				$user->save(false, array('failedloginattempts'));
				return $user;
				break;
			case YumUserIdentity::ERROR_EMAIL_INVALID:
				$this->loginForm->addError("password",Yum::t('Username or Password is incorrect'));
				$this->logFailedLoginAttempts($user);
				break;
			case YumUserIdentity::ERROR_STATUS_INACTIVE:
				$this->loginForm->addError("status",Yum::t('This account is not activated.'));
				break;
			case YumUserIdentity::ERROR_STATUS_BANNED:
				$this->loginForm->addError("status",Yum::t('This account is blocked.'));
				break;
			case YumUserIdentity::ERROR_STATUS_REMOVED:
				$this->loginForm->addError('status', Yum::t('Your account has been deleted.'));
				break;
			case YumUserIdentity::ERROR_PASSWORD_INVALID:
				$this->logFailedLoginAttempt($user);

				if(!$this->loginForm->hasErrors())
					$this->loginForm->addError("password",Yum::t('Username or Password is incorrect'));
				break;
				return false;
		}
	}

	public function loginByEmail() {
		if(Yum::hasModule('profile')) {
			Yii::import('application.modules.profile.models.*');

			$profile = YumProfile::model()->find('email = :email', array(
						':email' => $this->loginForm->username));

			if($profile && $profile->user)
				return $this->authenticate($profile->user);
		} else
			throw new CException(Yum::t(
					'The profile submodule must be enabled to allow login by Email'));
	}

	public function loginByOpenid() {
		if (!Yum::module()->loginType & UserModule::LOGIN_BY_OPENID)
			throw new Exception('login by Open Id was called, but is not activated in application configuration');

		Yii::app()->user->logout();
		Yii::import('application.modules.user.vendors.openid.*');
		$openid = new EOpenID;
		$openid->authenticate($this->loginForm->username);
		return Yii::app()->user->login($openid);
	}

	public function loginByTwitter() {
		return false;
	}

	public function actionLogin() {
		// If the user is already logged in send them to the return Url 
		if (!Yii::app()->user->isGuest)
			$this->redirect(Yum::module()->returnUrl);   

		$this->layout = Yum::module()->loginLayout;
		$this->loginForm = new YumUserLogin('login');

		/**
		 * Login process starts here.
		 * Facebook doesn't need form validation. Neither Twitter I think.
		 * We will eventually get a bug here. If a user has already logged in
		 * both FB a Twitter and both login systems are activated, if he decides
		 * to use his Twitter account instead of his FB one the system will use
		 * the FB account info for login. Not critical. I still can sleep after
		 * knowing about this.
		 */
		$success = false;
		$action = 'login';
		$login_type = null;
		if (isset($_POST['YumUserLogin'])) {
			$this->loginForm->attributes = $_POST['YumUserLogin'];
			$t = Yum::module()->loginType;

			// validate user input for the rest of login methods
			if ($this->loginForm->validate()) {
				if ($t & UserModule::LOGIN_BY_USERNAME) {
					$success = $this->loginByUsername();
					if ($success)
						$login_type = 'username';
				}
				if ($t & UserModule::LOGIN_BY_EMAIL && !$success) {
					$success = $this->loginByEmail();
					if ($success)
						$login_type = 'email';
				}
				if ($t & UserModule::LOGIN_BY_OPENID && !$success) {
					$this->loginForm->setScenario('openid');
					$success = $this->loginByOpenid();
					if ($success)
						$login_type = 'openid';
				}
				if($t & UserModule::LOGIN_BY_LDAP && !$success) {
					$success = $this->loginByLdap();
					$action = 'ldap_login';
					$login_type = 'ldap';
				}
			}
			if ($t & UserModule::LOGIN_BY_FACEBOOK && !$success) {
				$success = $this->loginByFacebook();
				if ($success)
					$login_type = 'facebook';
			}
			if ($t & UserModule::LOGIN_BY_TWITTER && !$success) {
				$sucess = $this->loginByTwitter();
				if ($success)
					$login_type = 'twitter';
			}

			if ($success instanceof YumUser) {
				//cookie with login type for later flow control in app
				if ($login_type) {
					$cookie = new CHttpCookie('login_type', serialize($login_type));
					$cookie->expire = time() + (3600*24*30);
					Yii::app()->request->cookies['login_type'] = $cookie;
				}
				Yum::log(Yum::t(
							'User {username} successfully logged in (Ip: {ip})', array(
								'{ip}' => Yii::app()->request->getUserHostAddress(),
								'{username}' => $success->username)));
				if(Yum::module()->afterLogin !== false) 
					call_user_func(Yum::module()->afterLogin);

				$this->redirectUser($success);
			} else
				$this->loginForm->addError('username',
						Yum::t('Login is not possible with the given credentials'));
		}


		$this->render(Yum::module()->loginView, array(
					'model' => $this->loginForm));
	}

	public function redirectUser($user) {
		$user->lastvisit = time();
		$user->save(true, array('lastvisit'));

		Yii::app()->user->setState('first_login', true);
		if(isset($_POST) && isset($_POST['returnUrl']))
			$this->redirect(array($_POST['returnUrl']));

		if ($user->superuser && Yum::module()->returnAdminUrl) 
			$this->redirect(Yum::module()->returnAdminUrl);

		if(isset(Yii::app()->user->returnUrl))
			$this->redirect(Yii::app()->user->returnUrl);

		if ($user->isPasswordExpired())
			$this->redirect(array('passwordexpired'));

		if (Yum::module()->returnUrl !== '')
			$this->redirect(Yum::module()->returnUrl);
		else
			$this->redirect(Yii::app()->user->returnUrl);
		$this->redirect(Yum::module()->firstVisitUrl);
	}

public function actionLogout() {
	// If the user is already logged out send them to returnLogoutUrl
	if (Yii::app()->user->isGuest)
		$this->redirect(Yum::module()->returnLogoutUrl);

	//let's delete the login_type cookie
	$cookie=Yii::app()->request->cookies['login_type'];
	if ($cookie) {
		$cookie->expire = time() - (3600*72);
		Yii::app()->request->cookies['login_type'] = $cookie;
	}

	if($user = YumUser::model()->findByPk(Yii::app()->user->id)) {
		$username = $user->username;
		$user->logout();

		if (Yii::app()->user->name == 'facebook') {
			if (!Yum::module()->loginType & UserModule::LOGIN_BY_FACEBOOK)
				throw new Exception('actionLogout for Facebook was called, but is not activated in main.php');

			Yii::import('application.modules.user.vendors.facebook.*');
			require_once('Facebook.php');
			$facebook = new Facebook(Yum::module()->facebookConfig);
			$fb_cookie = 'fbs_'.Yum::module()->facebookConfig['appId'];
			$cookie = Yii::app()->request->cookies[$fb_cookie];
			if ($cookie) {
				$cookie->expire = time() -1*(3600*72);
				Yii::app()->request->cookies[$cookie->name] = $cookie;
				$servername= '.' . Yii::app()->request->serverName;
				setcookie ("$fb_cookie", "", time() - 3600);
				setcookie ("$fb_cookie", "", time() - 3600, "/", "$servername", 1);
			}
			$session = $facebook->getSession();
			Yum::log('Facebook logout from user '. $username);
			Yii::app()->user->logout();
			$this->redirect($facebook->getLogoutUrl(array('next' => $this->createAbsoluteUrl(Yum::module()->returnLogoutUrl), 'session_key' => $session['session_key'])));
		}
		else {
			Yum::log(Yum::t('User {username} logged off', array(
							'{username}' => $username)));

			Yii::app()->user->logout();
		}
	}
	$this->redirect(Yum::module()->returnLogoutUrl);
}
}
