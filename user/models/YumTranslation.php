<?
/** This is the Active Record class file of a translation string in 
	Yii-user-Management. Please note that it is highly suggested to use a cache
	when using translation strings coming from a database. */

class YumTranslation extends YumActiveRecord{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		$this->_tableName = Yum::module()->translationTable;	
		return $this->_tableName;
	}

	public function rules()
	{
		return array(
				array('message, translation, language', 'required'),
				array('category', 'default', 'setOnEmpty' => true, 'value' => null),
				array('message, translation, category', 'length', 'max'=>255),
				array('language', 'length', 'max'=>5),
				array('message, translation, language, category', 'safe', 'on'=>'search'),
				);
	}

	public function relations()
	{
		return array(
				);
	}

	public function attributeLabels()
	{
		return array(
				'message' => Yum::t('Message'),
				'translation' => Yum::t('Translation'),
				'language' => Yum::t('Language'),
				'category' => Yum::t('Category'),
				);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('message', $this->message, true);
		$criteria->compare('translation', $this->translation, true);
		$criteria->compare('language', $this->language, true);
		$criteria->compare('category', $this->category, true);

		return new CActiveDataProvider(get_class($this), array(
					'criteria'=>$criteria,
					));
	}
}
