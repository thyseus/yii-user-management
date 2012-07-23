<?php
class YumWebUser extends CWebUser
{
	public $_data;

	// Use this function to access the AR Model of the actually
	// logged in user, for example
	// echo Yii::app()->user->data()->profile->firstname;
	public function data() {
		if($this->_data instanceof YumUser)
			return $this->_data;
		else if($this->id && $this->_data = YumUser::model()->findByPk($this->id))
			return $this->_data;
		else
			return $this->_data = new YumUser();
	}

	public function checkAccess($operation, $params=array(), $allowCaching=true)
	{
		if(!Yum::hasModule('role') ||	Yum::module('role')->useYiiCheckAccess )
			return parent::checkAccess($operation, $params, $allowCaching);

		return $this->can($operation);	
	}

	public function can($action) {
		Yii::import('application.modules.role.models.*');
		foreach ($this->data()->getPermissions() as $permission)
			if ($permission == $action)
				return true;

		return false;
	}

	/**
	 * Checks if this (non-admin) User can administrate some users
	 */
	public static function hasUsers($uid = 0)
	{
		if($uid == 0)
			$uid = Yii::app()->user->id;

		$user = YumUser::model()->cache(500)->findByPk($uid);

		return isset($user->users) && $user->users !== array();
	}

	public static function hasRoles($uid = 0)
	{
		if($uid == 0)
			$uid = Yii::app()->user->id;

		$user = YumUser::model()->cache(500)->findByPk($uid);

		$flag = false;
		if(isset($user->roles))
			foreach($user->roles as $role) 
				if (isset($role->roles) && $role->roles !== array())
					$flag = true;

		return $flag;
	}

public function getRoles() {
	$t = ' ';
	$user = Yii::app()->user->data();
	$roles = $user->roles;
	if($user instanceof YumUser && $roles) 
		foreach($roles as $role)
			$t .= $role->title .' ';

	return $t;

}

	/**
	 * Checks if this (non-admin) User can administrate the given user
	 */
	public static function hasUser($username, $uid = 0)
	{
		if($uid == 0)
			$uid = Yii::app()->user->getId();

		// Every user can modify himself
		if($username == $uid)
			return true;

		$user = YumUser::model()->cache(500)->findByPk($uid);

		if(!is_array($username))
			$username = array ($username);

		if(isset($user->users)) 
			foreach($user->users as $userobj) 
			{
				if(in_array($userobj->username, $username) ||
					in_array($userobj->id, $username))
					return true;
			}
		return false;
	}

	/**
	 * Checks if the user has the given Role
	 * @mixed Role string or array of strings that should be checked
	 * @int (optional) id of the user that should be checked 
	 * @return bool Return value tells if the User has access or hasn't access.
	 */
	public function hasRole($role, $uid = 0) {
		if(Yum::hasModule('role')) {
			Yii::import('application.modules.role.models.*');

			if($uid == 0)
				$uid = Yii::app()->user->id;

			if(!is_array($role))
				$role = array ($role);

			if($uid && $user = YumUser::model()->with('roles')->find(
						't.id = '.$uid)) {
				// Check if a user has a active membership and, if so, add this
				// to the roles
				$roles = $user->roles;
				if(Yum::hasModule('membership'))
					$roles = array_merge($roles, $user->getActiveMemberships());

				if(isset($roles)) 
					foreach($roles as $roleobj) {
						if(in_array($roleobj->title, $role) ||
								in_array($roleobj->id, $role))
							return true;
					}
			}
		}

		return false;
	}

	public function loggedInAs() {
		if($this->isGuest)
			return Yum::t('Guest');
		else
			return $this->data()->username;
	}
	/**
	 * Return admin status.
	 * @return boolean
	 */
	public function isAdmin() {
		if($this->isGuest)
			return false;
		else 
			return Yii::app()->user->data()->superuser;
	}
}
?>
