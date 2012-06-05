<?php
/**
 */

Yii::import('application.modules.user.components.Compare');
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

	public function behaviors()  {
		return array_merge(parent::behaviors(), array(
					'Compare' => array(
						'class' => 'Compare')));
	}

	public function afterSave() {
		if($this->isNewRecord) 
			Yii::log(Yum::t( 'A profile been created: {profile}', array(
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

		if($privacy = @YumUser::model()->cache(500)->with('privacy')->findByPk($this->user_id)->privacy->public_profile_fields) {
			$i = 1;
			foreach(YumProfileField::model()->cache(500)->findAll() as $field) {
				if($i & $privacy && $field->visible != 0)
					$fields[] = $field;
				$i*=2;
			}
		}

		return $fields;
	}

	/**
	 * Returns resolved table name (incl. table prefix when it is set in db configuration)
	 * Following algorith of searching valid table name is implemented:
	 *  - try to find out table name stored in currently used module
	 *  - if not found try to get table name from UserModule configuration
	 *  - if not found user default {{profiles}} table name
	 * @return string
	 */
	public function tableName()
	{
		if (isset(Yum::module('profile')->profileTable))
			$this->_tableName = Yum::module('profile')->profileTable;
		else
			$this->_tableName = '{{profiles}}'; // fallback if nothing is set

		return Yum::resolveTableName($this->_tableName,$this->getDbConnection());
	}

	public function rules()
	{
		$required = array();
		$numerical = array();
		$rules = array();
		$safe = array();

		foreach (self::$fields as $field) {
			$field_rule = array();

			if ($field->required == 1)
				array_push($required, $field->varname);

			if ($field->field_type == 'int'
					|| $field->field_type == 'FLOAT'
					|| $field->field_type =='INTEGER'
					|| $field->field_type =='BOOLEAN')
				array_push($numerical, $field->varname);

			if ($field->field_type == 'DROPDOWNLIST')
				array_push($safe, $field->varname);

			if ($field->field_type == 'VARCHAR' || $field->field_type == 'TEXT') {
				$field_rule = array($field->varname,
						'length',
						'max'=>$field->field_size,
						'min' => $field->field_size_min);

				if ($field->error_message)
					$field_rule['message'] = Yum::t($field->error_message);

				array_push($rules,$field_rule);
			}

			if ($field->match) {
				$field_rule = array($field->varname,
						'match',
						'pattern' => $field->match);

				if ($field->error_message)
					$field_rule['message'] = Yum::t( $field->error_message);

				array_push($rules,$field_rule);
			}

			if ($field->range) {
				// allow using commas and semicolons
				$range=explode(';',$field->range);
				if(count($range)===1)
					$range=explode(',',$field->range);
				$field_rule = array($field->varname,'in','range' => $range);

				if ($field->error_message)
					$field_rule['message'] = Yum::t( $field->error_message);
				array_push($rules,$field_rule);
			}

			if ($field->other_validator) {
				$field_rule = array($field->varname,
						$field->other_validator);

				if ($field->error_message)
					$field_rule['message'] = Yum::t( $field->error_message);
				array_push($rules, $field_rule);
			}

		}

		array_push($rules,
				array(implode(',',$required), 'required'));
		array_push($rules,
				array(implode(',',$numerical), 'numerical', 'integerOnly'=>true));
		array_push($rules,
				array(implode(',',$safe), 'safe'));

		$rules[] = array('allow_comments, show_friends', 'numerical');
		$rules[] = array('email', 'unique');
		$rules[] = array('email', 'CEmailValidator');
		$rules[] = array('privacy', 'safe');

		return $rules;
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
