<?php

/**
 * This is the model class for a User in Yum.
 *
 */
class YumUser extends YumActiveRecord
{
  const STATUS_BANNED = -2; // Removed by Admin
  const STATUS_REMOVED = -1; // Removed by User himself
  const STATUS_INACTIVE = 0;
  const STATUS_ACTIVE = 1;

  public $username;
  public $password;
  public $activationKey;
  public $filter_role;
  public $password_changed = false; // flag for password change

  public function behaviors()
  {
    return array();
  }

  public static function model($className = __CLASS__)
  {
    return parent::model($className);
  }

  public function delete()
  {
    if (Yum::module()->trulyDelete) {
      if($this->profile)
        $this->profile->delete();
      return parent::delete();
    } else {
      $this->status = self::STATUS_REMOVED;
      return $this->save(false, array('status'));
    }
  }

  public function afterDelete()
  {
    if (Yum::hasModule('profiles') && $this->profile !== null)
      $this->profile->delete();

    Yum::log(Yum::t('User {username} (id: {id}) has been deleted', array(
      '{username}' => $this->username,
      '{id}' => $this->id)));
    return parent::afterDelete();
  }

  public function isOnline()
  {
    return $this->lastaction > time() - Yum::module()->offlineIndicationTime;
  }

  // If Online status is enabled, we need to set the timestamp of the
  // last action when a user does something
  public function setLastAction()
  {
    if (!Yii::app()->user->isGuest && !$this->isNewRecord) {
      $this->lastaction = time();
      return $this->save(false, array('lastaction'));
    }
  }

  public function getLogins()
  {
    $sql = "select count(*) from activities where user_id = {$this->id} and action = 'login'";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    return $result[0]['count(*)'];
  }

  public function logout()
  {
    if (Yum::module()->enableOnlineStatus && !Yii::app()->user->isGuest) {
      $this->lastaction = 0;
      $this->save(false, array('lastaction'));
    }
  }

  public function isActive()
  {
    return $this->status == YumUser::STATUS_ACTIVE;
  }

  // Which memberships are bought by the user
  public function getActiveMemberships()
  {
    if (!Yum::hasModule('membership'))
      return array();

    Yii::import('application.modules.role.models.*');
    Yii::import('application.modules.membership.models.*');

    $roles = array();

    if ($this->memberships)
      foreach ($this->memberships as $membership) {
        if ($membership->end_date > time())
          $roles[] = $membership->role;
      }

    return $roles;
  }

  public function search() {
    $criteria = new CDbCriteria;
    $sort = new CSort();

    if (Yum::hasModule('profile') && $this->profile) {
      $criteria->with = array('profile');
      $criteria->together = false;
      foreach(YumProfile::getProfileFields() as $column) {
        if ($this->profile->{$column})
          $criteria->compare(
            'profile.'.$column,
            $this->profile->{$column},
            true);
        $sort->attributes['profile.'.$column] = array(
          'asc'=>'profile.'.$column,
          'desc'=>'profile.'.$column.' DESC',
        );
      }
    }

    if (Yum::hasModule('role') && $this->filter_role) {
      $criteria->join = 'left join user_role on t.id = user_role.user_id';
      $criteria->addCondition('user_role.role_id = '.$this->filter_role);
    }

    $criteria->compare('t.id', $this->id, true);
    $criteria->compare('t.username', $this->username, true);
    $criteria->compare('t.status', $this->status);
    $criteria->compare('t.superuser', $this->superuser);
    $criteria->compare('t.createtime', $this->createtime, true);
    $criteria->compare('t.lastvisit', $this->lastvisit, true);

    $sort->attributes[] = '*'; 

    return new CActiveDataProvider(get_class($this), array(
      'criteria' => $criteria,
      'sort' => $sort,
      'pagination' => array('pageSize' => Yum::module()->pageSize),
    ));
  }

  public function beforeValidate() {
    if ($this->isNewRecord) 
      $this->createtime = time();

    return true;
  }

  // Sets a new password. Password can not be empty. If the model already
  // exists in the database, we save the new password by save(), otherwise we
  // only set the fields. Returns $this so this method can be chained.
  public function setPassword($password) {
    if ($password) {
      $this->lastpasswordchange = time();
      $this->password = $password;
      $this->password_changed = true;
      if ($this->validate()) {
        $this->password = CPasswordHelper::hashPassword(
          $password,
          Yum::module()->passwordHashCost);
        if(!$this->isNewRecord)
          $this->save(false, array('password'));
      }
    }
    return $this;
  }

  public function afterSave()
  {
    if (Yum::hasModule('profile') 
      && Yum::module('profile')->enablePrivacySetting) {
        // create a new privacy setting, if not already available
        $setting = YumPrivacySetting::model()->findByPk($this->id);
        if (!$setting) {
          $setting = new YumPrivacySetting();
          $setting->user_id = $this->id;
          $setting->save();
        }

        if ($this->isNewRecord) {
          Yum::log(Yum::t('A user has been created: user: {user}', array(
            '{user}' => json_encode($this->attributes))));


        }
      }
    return parent::afterSave();
  }

  /**
   * Returns resolved table name (incl. table prefix when it is set in db configuration)
   * Following algorith of searching valid table name is implemented:
   *  - try to find out table name stored in currently used module
   *  - if not found try to get table name from UserModule configuration
   *  - if not found user default {{users}} table name
   * @return string
   */
  public function tableName()
  {
    $this->_tableName = Yum::module()->userTable;

    return $this->_tableName;
  }

  public function rules() {
    $usernameRequirements = Yum::module()->usernameRequirements;
    $passwordRequirements = Yum::module()->passwordRequirements;

    $passwordrule = array_merge(array('password', 'YumPasswordValidator'),
      $passwordRequirements);

    $rules[] = $passwordrule;

    if($usernameRequirements) {
      $rules[] = array('username', 'length',
        'max' => $usernameRequirements['maxLen'],
        'min' => $usernameRequirements['minLen'],
        'message' => Yum::t(
          'Username length needs to be between {minLen} and {maxlen} characters', array(
            '{minLen}' => $usernameRequirements['minLen'],
            '{maxLen}' => $usernameRequirements['maxLen'])));
      $rules[] = array(
        'username',
        'match',
        'pattern' => $usernameRequirements['match'],
        'message' => Yum::t($usernameRequirements['dontMatchMessage']));
    }

    $rules[] = array('username', 'unique',
      'message' => Yum::t('This username already exists'));
      
    $rules[] = array('status', 'in', 'range' => array(0, 1, 2, 3, -1, -2));
    $rules[] = array('superuser', 'in', 'range' => array(0, 1));
    $rules[] = array('username, createtime, lastvisit, lastpasswordchange, superuser, status', 'required');
    $rules[] = array('notifyType, avatar', 'safe');
    $rules[] = array('password', 'required', 'on' => array('insert', 'registration'));
    $rules[] = array('createtime, lastvisit, lastaction, superuser, status', 'numerical', 'integerOnly' => true);

    if (Yum::hasModule('avatar')) {
      // require an avatar image in the avatar upload screen
      $rules[] = array('avatar', 'required', 'on' => 'avatarUpload');

      // if automatic scaling is deactivated, require the exact size	
      $rules[] = array('avatar', 'EPhotoValidator',
        'allowEmpty' => true,
        'mimeType' => array('image/jpeg', 'image/png', 'image/gif'),
        'maxWidth' => Yum::module('avatar')->avatarMaxWidth,
        'maxHeight' => Yum::module('avatar')->avatarMaxWidth,
        'minWidth' => 50,
        'minHeight' => 50,
        'on' => 'avatarSizeCheck');
    }


    if (Yum::hasModule('role')) 
      $rules[] = array('filter_role', 'safe');

    return $rules;
  }

  public function assignRole($role_title) {
    Yii::import('application.modules.role.models.*');
    if($this->isNewRecord || !$this->id)
      return false;

    if($this->hasRole($role_title))
      return true;

    $role = YumRole::model()->find('title = :title', array(
      ':title' => $role_title));

    if($role)
      return Yii::app()->db->createCommand(sprintf(
        'insert into %s (user_id, role_id) values(%s, %s)',
        Yum::module('role')->userRoleTable,
        $this->id,
        $role->id))->execute(); 
    else 
      return false;
  }

  public function hasRole($role_title) {
    Yii::import('application.modules.role.models.*');

    if (!Yum::hasModule('role'))
      return false;


    $roles = $this->roles;

    if(Yum::hasModule('membership')) {
      foreach($this->getActiveMemberships() as $membership)
        $roles[] = $membership;
    }

    foreach ($roles as $role)
      if ((is_numeric($role) && $role == $role_title) 
        || ($role->id == $role_title || $role->title == $role_title))
        return true;

    return false;
  }

  public function getRoles()
  {
    if (Yum::hasModule('role')) {
      Yii::import('application.modules.role.models.*');
      $roles = '';
      foreach ($this->roles as $role)
        $roles .= ' ' . $role->title;
      foreach ($this->getActiveMemberships() as $role)
        $roles .= ' ' . $role->title;

      return $roles;
    }
  }

  // We retrieve the permissions from:
  // 1.) All direct given permissions ($this->permissions)
  // 2.) All direct given permissions to a role the user belongs
  // 3.) All active memberships
  public function getPermissions($subaction = null) {
    if (!Yum::hasModule('role') || !$this->id)
      return array();

    Yii::import('application.modules.role.models.*');
    $roles = $this->roles;

    if (Yum::hasModule('membership'))
      $roles = array_merge($roles, $this->getActiveMemberships());

    $role_ids = array();

    foreach ($roles as $role) 
      $role_ids[] = $role->id;

    $cmd = Yii::app()->db->createCommand()
      ->select('id, action.title')
      ->from('permission')
      ->join('action', 'action.id = permission.action')
      ->where(array('and', "type = 'role'",
        array('in', 'principal_id', $role_ids)));

    // If a subaction is given, we filter by subaction
    if($subaction) {
      $subaction_id = YumAction::model()->findByAttributes(array('title' => $subaction));
      if($subaction_id)
        $subaction_id = $subaction_id->id;
      $cmd->where(array('and', "type = 'role'",
        "permission.subaction = '${subaction_id}'",
        array('in', 'principal_id', $role_ids)));
    }

    return $cmd->queryAll();
  }

  // checks if the user can access a give action.
  // when a subaction is specified, both actions need to be 
  // fulfilled (for example action 'forum', subaction 'read')
  public function can($action, $subaction = null) {
    $permissions = $this->getPermissions($subaction);

    foreach($permissions as $permission)
      if($permission['id'] == $action || $permission['title'] == $action)
        return true;

    return false;
  }

	// possible relations are cached because they depend on the active submodules
	// and it takes many expensive milliseconds to evaluate them all the time
	public function relations() {
		$relations = Yii::app()->cache->get('yum_user_relations');
		if($relations === false) {
			$relations = array();

			if (Yum::hasModule('role')) {
				Yii::import('application.modules.role.models.*');
				$relations['permissions'] = array(
						self::HAS_MANY, 'YumPermission', 'principal_id');

				$relations['managed_by'] = array(
						self::HAS_MANY, 'YumPermission', 'subordinate_id');

				$relations['roles'] = array(
						self::MANY_MANY, 'YumRole',
						Yum::module('role')->userRoleTable . '(user_id, role_id)');
			}

			if (Yum::hasModule('message')) {
				Yii::import('application.modules.message.models.*');
				$relations['messages'] = array(
						self::HAS_MANY, 'YumMessage', 'to_user_id',
						'order' => 'timestamp DESC');

				$relations['unread_messages'] = array(
						self::HAS_MANY, 'YumMessage', 'to_user_id',
						'condition' => 'message_read = 0',
						'order' => 'timestamp DESC');

				$relations['sent_messages'] = array(
						self::HAS_MANY, 'YumMessage', 'from_user_id');

			}
			if (Yum::hasModule('profile')) {
				Yii::import('application.modules.profile.models.*');
				$relations['visits'] = array(
						self::HAS_MANY, 'YumProfileVisit', 'visited_id');
				$relations['visited'] = array(
						self::HAS_MANY, 'YumProfileVisit', 'visitor_id');
				$relations['profile'] = array(
						self::HAS_ONE, 'YumProfile', 'user_id');
				$relations['privacy'] = array(
						self::HAS_ONE, 'YumPrivacySetting', 'user_id');
			}

			if (Yum::hasModule('friendship')) {
				$relations['friendships'] = array(
						self::HAS_MANY, 'YumFriendship', 'inviter_id');
				$relations['friendships2'] = array(
						self::HAS_MANY, 'YumFriendship', 'friend_id');
				$relations['friendship_requests'] = array(
						self::HAS_MANY, 'YumFriendship', 'friend_id',
						'condition' => 'status = 1'); // 1 = FRIENDSHIP_REQUEST
			}

			if (Yum::hasModule('membership')) {
				Yii::import('application.modules.membership.models.*');
				$relations['memberships'] = array(
						self::HAS_MANY, 'YumMembership', 'user_id');
			}

			Yii::app()->cache->set('yum_user_relations', $relations, 3600);
		}

		return $relations;
	}

	public function isFriendOf($invited_id)
	{
		foreach ($this->getFriendships() as $friendship) {
			if ($friendship->inviter_id == $this->id && $friendship->friend_id == $invited_id)
				return $friendship->status;
		}

		return false;
	}

	public function getFriendships()
	{
		$condition = 'inviter_id = :uid or friend_id = :uid';
		return YumFriendship::model()->findAll($condition, array(':uid' => $this->id));
	}

	// Friends can not be retrieve via the relations() method because a friend
	// can either be in the invited_id or in the friend_id column.
	// set $everything to true to also return pending and rejected friendships
	public function getFriends($everything = false)
	{
		if ($everything)
			$condition = 'inviter_id = :uid';
		else
			$condition = 'inviter_id = :uid and status = 2';

		$friends = array();
		Yii::import('application.modules.friendship.models.YumFriendship');
		$friendships = YumFriendship::model()->findAll($condition, array(
					':uid' => $this->id));
		if ($friendships != NULL && !is_array($friendships))
			$friendships = array($friendships);

		if ($friendships)
			foreach ($friendships as $friendship)
				$friends[] = YumUser::model()->findByPk($friendship->friend_id);

		if ($everything)
			$condition = 'friend_id = :uid';
		else
			$condition = 'friend_id = :uid and status = 2';

		$friendships = YumFriendship::model()->findAll($condition, array(
					':uid' => $this->id));

		if ($friendships != NULL && !is_array($friendships))
			$friendships = array($friendships);


		if ($friendships)
			foreach ($friendships as $friendship)
				$friends[] = YumUser::model()->findByPk($friendship->inviter_id);

		return $friends;
	}

	public function registerByHybridAuth($hybridAuthProfile) {
		Yii::import('application.modules.profile.models.*');
		$profile = new YumProfile();

		$profile->firstname = $hybridAuthProfile->firstName;
		$profile->lastname = $hybridAuthProfile->lastName;
		$profile->email = $hybridAuthProfile->email;

		$this->username = $hybridAuthProfile->email;
		$this->status = 1;
		$this->createtime = time();
		$this->password = md5(time()); // obfuscated password

		$this->save(false);
		$profile->user_id = $this->id;
		$profile->save(false);

		if(Yum::hasModule('role'))
			foreach(Yum::module('registration')->defaultHybridAuthRoles as $role) 
				Yii::app()->db->createCommand(sprintf(
							'insert into %s (user_id, role_id) values(%s, %s)',
							Yum::module('role')->userRoleTable,
							$this->id,
							$role))->execute(); 

		return true;
	}

	// Registers a user 
	public function register($username = null,
			$password = null,
			$profile = null) {
		if (!($profile instanceof YumProfile)) 
			return false;

		if ($username !== null && $password !== null) {
			// Password equality is checked in Registration Form
			$this->username = $username;
			$this->setPassword($password);
		}
		$this->activationKey = $this->generateActivationKey(false);
		$this->createtime = time();
		$this->lastvisit = 0;
		$this->superuser = 0;

		// Users stay banned until they confirm their email address.
		$this->status = YumUser::STATUS_INACTIVE;

		// If the avatar module and avatar->enableGravatar is activated, we assume
		// the user wants to use his Gravatar automatically after registration
		if(Yum::hasModule('avatar') && Yum::module('avatar')->enableGravatar)
			$this->avatar = 'gravatar';

		if ($this->validate() && $profile->validate()) {
			$this->save();
			$profile->user_id = $this->id;
			$profile->save();
			$this->profile = $profile;

			if(Yum::hasModule('role'))
				foreach(Yum::module('registration')->defaultRoles as $role) 
					Yii::app()->db->createCommand(sprintf(
								'insert into %s (user_id, role_id) values(%s, %s)',
								Yum::module('role')->userRoleTable,
								$this->id,
								$role))->execute(); 

			Yum::log(Yum::t('User {username} registered. Generated activation Url is {activation_url} and has been sent to {email}',
						array(
							'{username}' => $this->username,
							'{email}' => $profile->email,
							'{activation_url}' => $this->getActivationUrl()))
					);

			return $this;
		}

		return false;
	}

	public function getActivationUrl()
	{
		/**
		 * Quick check for a enabled Registration Module
		 */
		if (Yum::hasModule('registration')) {
			$activationUrl = Yum::module('registration')->activationUrl;
			if (is_array($activationUrl) && isset($this->profile)) {
				$activationUrl = $activationUrl[0];
				$params['email'] = $this->profile->email;
				$params['key'] = urlencode($this->activationKey);

				return Yii::app()->controller->createAbsoluteUrl($activationUrl, $params);
			}
		}
		return Yum::t('Activation Url cannot be retrieved');
	}

	public function isPasswordExpired()
	{
		$distance = Yum::module('user')->password_expiration_time * 60 * 60;
		return $this->lastpasswordchange - $distance > time();
	}

	/**
	 * Activation of an user account.
	 * If everything is set properly, and the emails exists in the database,
	 * and is associated with a correct user, and this user has the status
	 * NOTACTIVE and the given activationKey is identical to the one in the
	 * database then generate a new Activation key to avoid double activation,
	 * set the status to ACTIVATED and save the data
	 * Error Codes:
	 * -1 : User is not inactive, it can not be activated
	 * -2 : Wrong activation key
	 * -3 : Profile found, but no user - database inconsistency?
	 */
	public static function activate($email, $key) {
		Yii::import('application.modules.profile.models.*');

		if ($profile = YumProfile::model()->find("email = :email", array(
						':email' => $email))) {
			if ($user = $profile->user) {
				if ($user->status != self::STATUS_INACTIVE)
					return -1;
				if ($user->activationKey == urldecode($key)) {
					$user->activationKey = $user->generateActivationKey(true);
					$user->status = self::STATUS_ACTIVE;
					if ($user->save(false, array('activationKey', 'status'))) {
						Yum::log(Yum::t('User {username} has been activated', array(
										'{username}' => $user->username)));
						if (Yum::hasModule('message')
								&& Yum::module('registration')->enableActivationConfirmation) {
							Yii::import('application.modules.message.models.YumMessage');
							YumMessage::write($user, 1,
									Yum::t('Your activation succeeded'),
									strtr(
										'The activation of the account {username} succeeded. Please use <a href="{link_login}">this link</a> to go to the login page', array(
											'{username}' => $user->username,
											'{link_login}' =>
											Yii::app()->controller->createUrl('//user/user/login'))));
						}

						return $user;
					}
				} else return -2;
			} else return -3;
		}
		return false;
	}

	/**
	 * @params boolean $activate Whether to generate activation key when user is
	 * registering first time (false)
	 * or when it is activating (true)
	 * @params string $password password entered by user
	 * @param array $params, optional, to allow passing values outside class in inherited classes
	 * By default it uses password and microtime combination to generated activation key
	 * When user is activating, activation key becomes micortime()
	 * @return string
	 */
	public function generateActivationKey($activate = false) {
		if($activate) {
			$this->activationKey = $activate;
			$this->save(false, array('activationKey'));
		} else
			$this->activationKey = CPasswordHelper::hashPassword(
					microtime() . $this->password, Yum::module()->passwordHashCost);

		if(!$this->isNewRecord)
			$this->save(false, array('activationKey'));

		return $this->activationKey;
	}

	public function attributeLabels()
	{
		return array(
				'id' => Yum::t('#'),
				'username' => Yum::t("Username"),
				'password' => Yum::t("Password"),
				'verifyPassword' => Yum::t("Retype password"),
				'verifyCode' => Yum::t("Verification code"),
				'activationKey' => Yum::t("Activation key"),
				'createtime' => Yum::t("Registration date"),
				'lastvisit' => Yum::t("Last visit"),
				'lastaction' => Yum::t("Online status"),
				'superuser' => Yum::t("Superuser"),
				'status' => Yum::t("Status"),
				'avatar' => Yum::t("Avatar image"),
				);
	}

	public function withRoles($roles)
	{
		if(!is_array($roles))
			$roles = array($roles);

		$this->with('roles');
		$this->getDbCriteria()->addInCondition('roles.id', $roles);
		return $this;
	}

	public function scopes()
	{
		return array(
				'active' => array('condition' => 'status=' . self::STATUS_ACTIVE,),
				'inactive' => array('condition' => 'status=' . self::STATUS_INACTIVE,),
				'banned' => array('condition' => 'status=' . self::STATUS_BANNED,),
				'superuser' => array('condition' => 'superuser = 1',),
				'public' => array(
					'join' => 'LEFT JOIN privacysetting on t.id = privacysetting.user_id',
					'condition' => 'appear_in_search = 1',),
				);
	}

	public static function itemAlias($type, $code = NULL)
	{
		$_items = array(
				'UserStatus' => array(
					'0' => Yum::t('Not active'),
					'1' => Yum::t('Active'),
					'-1' => Yum::t('Banned'),
					'-2' => Yum::t('Deleted'),
					),
				'AdminStatus' => array(
					'0' => Yum::t('No'),
					'1' => Yum::t('Yes'),
					),
				);
		if (isset($code))
			return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
		else
			return isset($_items[$type]) ? $_items[$type] : false;
	}

	/**
	 * Get all users with a specified role.
	 * @param string $roleTitle title of role to be searched
	 * @return array users with specified role. Null if none are found.
	 */
	public static function getUsersByRole($roleTitle)
	{
		Yii::import('application.modules.role.models.*');
		$role = YumRole::model()->findByAttributes(array('title' => $roleTitle));
		return $role ? $role->users : null;
	}

	/**
	 * Return admins.
	 * @return array syperusers names
	 */
	public static function getAdmins()
	{
		$admins = YumUser::model()->active()->superuser()->findAll();
		$returnarray = array();
		foreach ($admins as $admin)
			array_push($returnarray, $admin->username);
		return $returnarray;
	}

	public function getGravatarHash() {
		return md5(strtolower(trim($this->profile->email)));		
	}

	public function syncRoles($roles = null) {
		if(Yum::hasModule('role')){ 
			Yii::import('application.modules.role.models.*');

				$query = sprintf("delete from %s where user_id = %s",
						Yum::module('role')->userRoleTable,
						$this->id
						);
			$result = Yii::app()->db->createCommand($query)->execute();
			if($roles)
				foreach($roles as $role) {
					$query = sprintf("insert into %s (user_id, role_id) values(%s, %s)",
							Yum::module('role')->userRoleTable,
							$this->id,
							$role
							);
					$result = Yii::app()->db->createCommand($query)->execute();
				}
		}
	}

	public function getAvatar($thumb = false)
	{
		if (Yum::hasModule('avatar') && $this->profile) {
			$options = array();
			if ($thumb)
				$options = array('class' => 'avatar', 'style' => 'width: ' . Yum::module('avatar')->avatarThumbnailWidth . 'px;');
			else
				$options = array('class' => 'avatar', 'style' => 'width: ' . Yum::module('avatar')->avatarDisplayWidth . 'px;');

			$return = '<div class="avatar">';

			if(Yum::module('avatar')->enableGravatar && $this->avatar == 'gravatar') 
				return CHtml::image(
						'http://www.gravatar.com/avatar/'. $this->getGravatarHash(),
						Yum::t('Avatar image'),
						$options);

			if (isset($this->avatar) && $this->avatar)
				$return .= CHtml::image(Yii::app()->baseUrl . '/'
						. $this->avatar, 'Avatar', $options);
			else
				$return .= CHtml::image(Yii::app()->getAssetManager()->publish(
							Yii::getPathOfAlias('YumAssets.images') . ($thumb
								? '/no_avatar_available_thumb.jpg' : '/no_avatar_available.jpg'),
							Yum::t('No image available'),
							$options));
			$return .= '</div><!-- avatar -->';
			return $return;
		}
	}
}
