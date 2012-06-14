<?
/**
 * This is the model class for table profile field table
 *
 * All available profile fields for the application are stored in this
 * table. Please make sure to add additional fields by the yum profile
 * field admin backend to ensure that the profile columns and the profile
 * field table is in sync.
 */
class YumProfileField extends YumActiveRecord
{
	const VISIBLE_HIDDEN=0;
	const VISIBLE_ONLY_OWNER=1;
	const VISIBLE_REGISTER_USER=2;
	const VISIBLE_USER_DECISION=3;
	const VISIBLE_PUBLIC=4; // Field is public even if the user decides to hide it

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

	public function tableName()
	{
		$this->_tableName = Yum::module('profile')->profileFieldTable;
		return $this->_tableName;
	}
	public function scopes()
	{
		return array(
				'forAll'=>array(
					'condition'=>'visible='.self::VISIBLE_PUBLIC,
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
					self::VISIBLE_PUBLIC => Yum::t('For all'),
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
?>
