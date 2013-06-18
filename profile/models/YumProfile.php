<?

class YumProfile extends YumActiveRecord
{
	const PRIVACY_PRIVATE = 'private';
	const PRIVACY_PUBLIC = 'public';

	/**
	 * @var array of YumProfileFields
	 */
	static $fields=null;

	public function init()
	{
		parent::init();
		// load profile fields only once
		$this->loadProfileFields();
	}

	public function afterSave() {
		if($this->isNewRecord) 
			Yii::log(Yum::t( 'A profile been created: {profile}', array(
							'{profile}' => json_encode($this->attributes))));
		else
			Yii::log(Yum::t( 'A profile been update: {profile}', array(
							'{profile}' => json_encode($this->attributes))));

		return parent::afterSave();
	}

	public function recentComments($count = 3) {
		$criteria = new CDbCriteria;
		$criteria->condition = 'id = ' .$this->id;
		$criteria->order = 'createtime DESC';
		$criteria->limit = $count;
		return YumProfileComment::model()->findAll($criteria);
	}

	public function beforeValidate() {
		if($this->isNewRecord)
			$this->timestamp = time();
		return parent::beforeValidate();
	}

	/**
	 * @param string $className
	 * @return YumProfile
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	// All fields that the user has activated in his privacy settings will
	// be obtained and returned for the use in the profile view
	public function getPublicFields() {
		if(!Yum::module('profile')->enablePrivacySetting)
			return false;

		$fields = array();

		if($privacy = YumUser::model()
				->cache(500)
				->with('privacy')
				->findByPk($this->user_id)
				->privacy->public_profile_fields) {
			$i = 1;
			foreach(YumProfileField::model()->cache(3600)->findAll() as $field) {
				if(
						(($i & $privacy) 
						 && $field->visible != YumProfileField::VISIBLE_HIDDEN) 
						|| $field->visible == YumProfileField::VISIBLE_PUBLIC)
					$fields[] = $field;
				$i*=2;
			}
		}
		return $fields;
	}

	/**
	 * Returns resolved table name 
	 * @return string
	 */
	public function tableName()
	{
		$this->_tableName = Yum::module('profile')->profileTable;
		return $this->_tableName;
	}

	// define your project-specific profile field rules in your 
	// config/main.php 
	public function rules()
	{
		return Yum::module('profile')->profileRules();

	}

	public function relations()
	{
		$relations = array(
				'user' => array(self::BELONGS_TO, 'YumUser', 'user_id'),
				'comments' => array(self::HAS_MANY, 'YumProfileComment', 'profile_id'),
				);

		$fields = Yii::app()->db->cache(3600)->createCommand(
				"select * from ".YumProfileField::model()->tableName()." where field_type = 'DROPDOWNLIST'")->queryAll();

		foreach($fields as $field) {
			$relations[ucfirst($field['varname'])] = array(
					self::BELONGS_TO, ucfirst($field['varname']), $field['varname']);

		}

		return $relations;
	}

	// Retrieve a list of all users that have commented my profile
	// Do not show my own profile visit
	public function getProfileCommentators() {
		$commentators = array();
		foreach($this->comments as $comment)
			if($comment->user_id != Yii::app()->user->id)
				$commentators[$comment->user_id] = $comment->user;

		return $commentators;
	}

	public function getProfileFields() {
		$fields = array();

		if(self::$fields)
			foreach(self::$fields as $field) {
				$varname = $field->varname;
				$fields[$varname] = Yum::t($varname);
			}
		return $fields;
	}

	public function name() {
		return sprintf('%s %s', $this->firstname, $this->lastname);
	}

	public function attributeLabels()
	{
		$labels = array(
				'id' => Yum::t('Profile ID'),
				'user_id' => Yum::t('User ID'),
				'privacy' => Yum::t('Privacy'),
				'show_friends' => Yum::t('Show friends'),
				'allow_comments' => Yum::t('Allow profile comments'),
				);

		if(self::$fields)
			foreach (self::$fields as $field)
				$labels[$field->varname] = Yum::t($field->title);

		return $labels;
	}

	/**
	 * Load profile fields.
	 * Overwrite this method to get another set of fields
	 * Makes use of cache so the amount of sql queries per request is reduced
	 * @since 0.6
	 * @return array of YumProfileFields or empty array
	 */
	public function loadProfileFields()
	{
		if(self::$fields===null)
		{
			self::$fields=YumProfileField::model()->cache(3600)->findAll();
			if(self::$fields==null)
				self::$fields=array();
		}
		return self::$fields;
	}

}
