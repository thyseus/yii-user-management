<?php

class YumActivity extends YumActiveRecord{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		if(isset(Yum::module()->activitiesTable))
			$this->_tableName = Yum::module()->activitiesTable;
		elseif(isset(Yii::app()->modules['user']['activitiesTable']))
			$this->_tableName = Yii::app()->modules['user']['activitiesTable'];
		else
			$this->_tableName = '{{activities}}'; // fallback if nothing is set
		return Yum::resolveTableName($this->_tableName, $this->getDbConnection());
	}

	public function rules()
	{
		return array(
			array('timestamp', 'required'),
			array('user_id, action', 'default', 'setOnEmpty' => true, 'value' => null),
			array('timestamp, user_id', 'numerical', 'integerOnly'=>true),
			array('action', 'length', 'max'=>20),
			array('id, timestamp, user_id, action, message', 'safe'),
		);
	}

	public function relations()
	{
		return array(
			'user' => array(self::BELONGS_TO, 'YumUser', 'user_id')
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => Yum::t('id'),
			'timestamp' => Yum::t('timestamp'),
			'user_id' => Yum::t('User'),
			'action' => Yum::t('Action'),
			'remote_addr' => Yum::t('Connected from IP'),
			'http_user_agent' => Yum::t('Used browser(HTTP_USER_AGENT)'),
		);
	}

	public function __toString() {
		return $this->action;

	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('timestamp', $this->timestamp);
		$criteria->compare('user_id', $this->user_id);
		$criteria->compare('action', $this->action, true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
