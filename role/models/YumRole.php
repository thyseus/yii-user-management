<?
class YumRole extends YumActiveRecord {
	private $_userRoleTable;
	private $_roleRoleTable;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		$this->_tableName = Yum::module('role')->roleTable;
		return $this->_tableName;
	}

	public function rules()
	{
		return array(
				array('title', 'required'),
				array('membership_priority', 'numerical'),
				array('price', 'numerical'),
				array('duration', 'numerical'),
				array('title, description', 'length', 'max' => '255'),
				);
	}

	public function scopes() {
		return array(
				'possible_memberships' => array(
					'condition' => 'membership_priority > 0'),
				);
	}

	public function relations()
	{
		return array(
				'activeusers'=>array(self::MANY_MANY, 'YumUser', Yum::module('role')->userRoleTable . '(role_id, user_id)', 'condition' => 'status = 3'),
				'users'=>array(self::MANY_MANY, 'YumUser', Yum::module('role')->userRoleTable. '(role_id, user_id)'),
				'permissions' => array(self::HAS_MANY, 'YumPermission', 'principal_id'),
				'memberships' => array(self::HAS_MANY, 'YumMembership', 'membership_id'),
				'managed_by' => array(self::HAS_MANY, 'YumPermission', 'subordinate_id'),

				);
	}

	public function activeMembership() {
		return YumMembership::model()->lastFirst()->find(
				'user_id = :user_id and membership_id = :role_id', array(	
					':user_id' => Yii::app()->user->id,
					':role_id' => $this->id));
	}

	public function activeUsers() {
		$users = $this->users;
		foreach($users as $key => $user)
			if(!$user->active())
				unset($users[$key]);

		return $users;
	}

	public function attributeLabels()
	{
		return array(
				'id'=>Yum::t("#"),
				'title'=>Yum::t("Title"),
				'description'=>Yum::t("Description"),
				'selectable'=>Yum::t("Selectable on registration"),
				'searchable'=>Yum::t("Searchable"),
				'price'=>Yum::t("Price"),
				'duration'=>Yum::t("Duration in days"),
				);
	}
}
