<?php
/**
 * This is the model class for table "{{profile_field}}".
 *
 * The followings are the available columns in table '{{profile_field}}':
 * Fields:
 * @property integer $id
 * @property string $varname
 * @property string $title
 * @property string $hint
 * @property string $field_type
 * @property integer $field_size
 * @property integer $field_size_min
 * @property integer $required
 * @property string $match
 * @property string $range
 * @property string $error_message
 * @property string $other_validator
 * @property string $default
 * @property integer $position
 * @property integer $visible
 *
 * Relations
 *
 * Scopes:
 * @method YumProfileField forAll
 * @method YumProfileField forUser
 * @method YumProfileField forOwner
 * @method YumProfileField sort
 */
class YumProfileField extends YumActiveRecord
{
	const VISIBLE_HIDDEN=0;
	const VISIBLE_ONLY_OWNER=1;
	const VISIBLE_REGISTER_USER=2;
	const VISIBLE_USER_DECISION=3;
	const VISIBLE_ALL=4;

	/**
     * Returns the static model of the specified AR class.
	 * @param string $className
	 * @return YumProfileField
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function isPublic($user = null) {
		if($user == null)
			$user = Yii::app()->user->id;

		if(!$this->visible)
			return false;

		if($privacy = YumUser::model()->findByPk($user)->privacy) {
			if($privacy->public_profile_fields & pow(2, $this->id))
				return true;
		}

		return false;
	}


	/**
	 * Returns resolved table name (incl. table prefix when it is set in db configuration)
	 * Following algorithm of searching valid table name is implemented:
	 *  - try to find out table name stored in currently used module
	 *  - if not found try to get table name from UserModule configuration
	 *  - if not found user default {{profile_field}} table name
	 * @return string
	 */
  	public function tableName()
  	{
    	if (isset(Yum::module('profile')->profileFieldsTable))
      		$this->_tableName = Yum::module('profile')->profileFieldsTable;
    	elseif (isset(Yii::app()->modules['user']['profileFieldsTable']))
      		$this->_tableName = Yii::app()->modules['user']['profileFieldsTable'];
    	else
      		$this->_tableName = '{{profile_field}}'; // fallback if nothing is set

    	return Yum::resolveTableName($this->_tableName,$this->getDbConnection());
  	}

	public function rules()
	{
		return array(
			array('varname, title, field_type', 'required'),
			array('varname', 'match', 'pattern' => '/^[a-z_0-9]+$/u','message' => Yii::t("UserModule.user", "Incorrect symbol's. (a-z)")),
			array('varname', 'unique', 'message' => Yii::t("UserModule.user", "This field already exists.")),
			array('varname, field_type', 'length', 'max'=>50),
			array('field_size, field_size_min, required, position, visible', 'numerical', 'integerOnly'=>true),
			array('hint','safe'),
			array('related_field_name, title, match, range, error_message, other_validator, default', 'length', 'max'=>255),
		);
	}


	public function relations()
	{
		return array();
	}

	public function attributeLabels()
	{
		return array(
			'id' => Yum::t('#'),
			'varname' => Yum::t('Variable name'),
			'title' => Yum::t('Title'),
			'hint' => Yum::t('Hint'),
			'field_type' => Yum::t('Field type'),
			'field_size' => Yum::t('Field size'),
			'field_size_min' => Yum::t('Field size min'),
			'required' => Yum::t('Required'),
			'match' => Yum::t('Match'),
			'range' => Yum::t('Range'),
			'error_message' => Yum::t('Error message'),
			'other_validator' => Yum::t('Other validator'),
			'default' => Yum::t('Default'),
			'position' => Yum::t('Position'),
			'visible' => Yum::t('Visible'),
		);
	}

	public function scopes()
    {
        return array(
            'forAll'=>array(
                'condition'=>'visible='.self::VISIBLE_ALL,
            ),
            'forUser'=>array(
                'condition'=>'visible>='.self::VISIBLE_REGISTER_USER,
            ),
            'forOwner'=>array(
                'condition'=>'visible>='.self::VISIBLE_ONLY_OWNER,
            ),
        );
    }


	public static function itemAlias($type,$code=NULL) {
		$_items = array(
			'field_type' => array(
				'INTEGER' => Yum::t('INTEGER'),
				'VARCHAR' => Yum::t( 'VARCHAR'),
				'TEXT'=> Yum::t( 'TEXT'),
				'DATE'=> Yum::t( 'DATE'),
				'DROPDOWNLIST' => Yum::t('DROPDOWNLIST'),
				'FLOAT'=> Yum::t('FLOAT'),
				'BOOL'=> Yum::t('BOOL'),
				'BLOB'=> Yum::t('BLOB'),
				'BINARY'=> Yum::t('BINARY'),
				'FILE'=> 'FILE',
			),
			'required' => array(
				'0' => Yum::t('No'),
				'1' => Yum::t('Yes'),
			),
			'visible' => array(
				self::VISIBLE_USER_DECISION => Yum::t('Let the user choose in privacy settings'),
				self::VISIBLE_ALL => Yum::t('For all'),
				self::VISIBLE_REGISTER_USER => Yum::t('Registered users'),
				self::VISIBLE_ONLY_OWNER => Yum::t('Only owner'),
				self::VISIBLE_HIDDEN => Yum::t('Hidden'),
			),
		);
		if (isset($code))
			return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
		else
			return isset($_items[$type]) ? $_items[$type] : false;
	}
}
