<?php

/* 
	 This Controller handles the authorization of users. 
	 Yii User Management provides login by username.
	 If using the profile submodule, we can also login by email address.
	 When using hybridauth (see docs/hybridauth.txt) we can use all
	 social networks provided by hybridauth.
 */

class YumAuthController extends YumController {
	public $defaultAction = 'login';
	public $loginForm = null;

	public function actions() {
		return array(
				'captcha' => array(
					'class' => 'CCaptchaAction',
					'backColor' => 0xFFFFFF,
					),
				);
	}

	public function accessRules() {
		return array(
				array('allow',
					'actions'=>array('login', 'captcha'),
					'users'=>array('*'),
					),
				array('allow',
					'actions'=>array('logout'),
					'users'=>array('@'),
					),
				array('deny',
					'users'=>array('*'),
					),
				);
	}

	public function getUser($user) {
		if(Yum::module()->caseSensitiveUsers)
			return YumUser::model()->find('username = :username', array(
						':username' => $user));
		else
			return YumUser::model()->find('upper(username) = :username', array(
						':username' => strtoupper($user)));
	}

  public function getUserByEmail($email) {
    $profile = YumProfile::model()->find('email = :email', array(
      ':email' => $email));
    if($profile && $profile->user)
      return $profile->user;
  }


	public function loginByUsername() {
		$user = $this->getUser($this->loginForm->username);
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

	public function loginByHybridAuth($provider) {
		if(!Yum::module()->loginType & UserModule::LOGIN_BY_HYBRIDAUTH)
			throw new CException(400, 'Hybrid authentification is not allowed');

		if(!Yum::hasModule('profile'))
			throw new CException(400, 'Hybrid auth needs the profile submodule to be enabled');

		Yii::import('application.modules.user.vendors.hybridauth.Hybrid.Auth', true);
		Yii::import('application.modules.profile.models.*');

		require_once(Yum::module()->hybridAuthConfigFile);

		try {
			$hybridauth = new Hybrid_Auth(Yum::module()->hybridAuthConfigFile);
			$providers = Yum::module()->hybridAuthProviders;

			if(count($providers) == 0)
				throw new CException('No Hybrid auth providers enabled in configuration file');

			if(!in_array($provider, $providers))
				throw new CException('Requested provider is not enabled in configuration file');

			$success = $hybridauth->authenticate($provider);

			if($success && $success->isUserConnected()) {
				// User found and authenticated at foreign party. Is he already 
				// registered at our application?
				$hybridAuthProfile = $success->getUserProfile();

				$user = $this->getUserByEmail($hybridAuthProfile->email);

				if(!$user && !YumProfile::model()->findByAttributes(array(
								'email' => $hybridAuthProfile->email))) {
					// No, he is not, so we register the user and sync the profile fields
					$user = new YumUser();
					if(!$user->registerByHybridAuth($hybridAuthProfile)) {
						Yum::setFlash(Yum::t('Registration by external provider failed'));
						$this->redirect(Yum::module()->returnUrl);
					} else Yum::setFlash('Registration successful');
				} 

				$identity = new YumUserIdentity($user->username, null);

				if($identity->authenticate(true)) {
					Yum::log(Yum::t('User {username} logged in by hybrid {provider}', array(
									'{username}' => $hybridAuthProfile->displayName,
									'{email}' => $hybridAuthProfile->displayName,
									'{provider}' => $provider)));

					Yii::app()->user->login($identity, Yum::module()->cookieDuration);
				} else
					Yum::setFlash(Yum::t('Login by external provider failed'));

				$this->redirect(Yum::module()->returnUrl);
			}
		} catch (Exception $e) {
			if(Yum::module()->debug)
				throw new CException($e->getMessage());
			else 
				throw new CHttpException(403, Yum::t('Permission denied'));
		}
	}

	public function logFailedLoginAttempts($user) {
		Yum::log(
				Yum::t(
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
			case YumUserIdentity::ERROR_EMAIL_INVALID || YumUserIdentity::ERROR_PASSWORD_INVALID:
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
			case YumUserIdentity::ERROR_NONE:
				$duration = $this->loginForm->rememberMe ? Yum::module()->cookieDuration : 0; 
				Yii::app()->user->login($identity, $duration);

				if($user->failedloginattempts > 0) {
					Yum::setFlash(Yum::t(
								'Warning: there have been {count} failed login attempts', array(
									'{count}' => $user->failedloginattempts)));
					$user->failedloginattempts = 0;
					$user->save(false, array('failedloginattempts'));
				}
				return $user;
				break;
		}
	}

	public function actionLogin($hybridauth = false) {
		// If the user is already logged in send them to the return Url 
		if (!Yii::app()->user->isGuest)
			$this->redirect(Yum::module()->returnUrl);   

		$this->layout = Yum::module()->loginLayout;

		if($hybridauth)
			$this->loginByHybridAuth($hybridauth);

		$this->loginForm = new YumUserLogin('login');

		if(Yum::module()->captchaAfterUnsuccessfulLogins !== false &&
				Yii::app()->user->getState('yum-login-attempts') 
				>= Yum::module()->captchaAfterUnsuccessfulLogins)
		$this->loginForm->scenario = 'captcha';


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
			} 

			if ($success !== false && $success instanceof YumUser) {
				//cookie with login type for later flow control in app
				if ($login_type) {
					$cookie = new CHttpCookie('login_type', serialize($login_type));
					$cookie->expire = time() + Yum::module()->cookieDuration;
					Yii::app()->request->cookies['login_type'] = $cookie;
				}
				Yum::log(Yum::t(
							'User {username} successfully logged in by {login_type} (Ip: {ip})', array(
								'{login_type}' => $login_type,
								'{ip}' => Yii::app()->request->getUserHostAddress(),
								'{username}' => $success->username)));

				// call a function if defined in module configuration
				if(Yum::module()->afterLogin !== false) 
					call_user_func(Yum::module()->afterLogin);

				Yii::app()->user->setState('yum-login-attempts', 0);
				$this->redirectUser($success);
			} else {
				$this->loginForm->addError('username',
						Yum::t('Login is not possible with the given credentials'));
				Yii::app()->user->setState('yum-login-attempts',
						Yii::app()->user->getState('yum-login-attempts', 0) + 1);
			}
		}

		if(Yum::module()->captchaAfterUnsuccessfulLogins !== false &&
				Yii::app()->user->getState('yum-login-attempts') 
				>= Yum::module()->captchaAfterUnsuccessfulLogins)
		$this->loginForm->scenario = 'captcha';

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

		// let's delete the login_type cookie
		$cookie = Yii::app()->request->cookies['login_type'];
		if ($cookie) {
			$cookie->expire = time() - Yum::module()->cookieDuration;
			Yii::app()->request->cookies['login_type'] = $cookie;
		}

		if($user = YumUser::model()->findByPk(Yii::app()->user->id)) {
			$user->logout();

			Yum::log(Yum::t('User {username} logged off', array(
							'{username}' => $user->username)));

			Yii::app()->user->logout();
		}
		$this->redirect(Yum::module()->returnLogoutUrl);
	}
}
