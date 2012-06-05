<?php

class YumTextSettings extends YumActiveRecord
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
            if (isset(Yum::module()->textSettingsTable))
                $this->_tableName = Yum::module()->textSettingsTable;
            elseif (isset(Yii::app()->modules['user']['textSettingsTable']))
                $this->_tableName = Yii::app()->modules['user']['textSettingsTable'];
            else
                $this->_tableName = '{{yumtextsettings}}'; // fallback if nothing is set
            return Yum::resolveTableName($this->_tableName, $this->getDbConnection());
	}

	public function rules() {
		return array(
				array('
					text_friendship_new,
					text_profilecomment_new,
					text_email_registration,
					subject_email_confirmation,
					text_email_recovery,
					text_email_activation,
					text_membership_ordered,
					text_payment_arrived', 'safe'),
				array('language', 'length', 'max'=>5),
				);
	}

	public static function getText($column, $trans = array(), $language = NULL) {
		if(!is_array($trans))
			return false;

		if(is_null($language))
			$language = Yii::app()->language;

		if($text = YumTextSettings::model()->find('language = :language', array(
						':language' => $language)));

		if(isset($text->$column))
			return strtr($text->$column, $trans);

		return false;
	}

	public function relations() {
		return array();
	}

	public function attributeLabels()
	{
		return array(
			'id' => Yum::t( 'ID'),
			'language' => Yum::t( 'Language'),
			'text_email_registration' => Yum::t( 'Text Email Registration'),
			'subject_email_registration' => Yum::t( 'Subject of Email Registration'),
			'text_email_recovery' => Yum::t( 'Text Email Recovery'),
			'text_email_activation' => Yum::t( 'Text Email Activation'),
			'text_friendship_new' => Yum::t( 'Text for new friendship request'),
			'text_profilecomment_new' => Yum::t( 'Text for new profile comment'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);

		$criteria->compare('language',$this->language,true);
		$criteria->compare('text_email_registration',$this->text_email_registration,true);
		$criteria->compare('text_email_recovery',$this->text_email_recovery,true);
		$criteria->compare('text_email_activation',$this->text_email_activation,true);
		$criteria->compare('text_friendship_new',$this->text_friendship_new,true);
		$criteria->compare('text_profilecomment_new',$this->text_profilecomment_new,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
