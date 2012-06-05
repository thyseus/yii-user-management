<?php

class YumGroupParticipation extends YumActiveRecord{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		if(isset(Yum::module()->userUsergroupTable))
			$this->_tableName = Yum::module()->userUsergroupTable;
		elseif(isset(Yii::app()->modules['user']['userUsergroupTable']))
			$this->_tableName = Yii::app()->modules['user']['userUsergroupTable'];
		else
			$this->_tableName = '{{user_has_usergroup}}'; // fallback if nothing is set
		return Yum::resolveTableName($this->_tableName, $this->getDbConnection());
	}

	public function rules()
	{
		return array(
			array('user_id, group_id, jointime', 'required'),
			array('user_id, group_id', 'length', 'max'=>10),
			array('jointime', 'numerical'),
			array('user_id, group_id, jointime', 'safe', 'on'=>'search'),
		);
	}

	public function beforeValidate() {
		$this->jointime = time();
		return parent::beforeValidate();
	}

	public function relations()
	{
		return array(
			'group' => array(self::BELONGS_TO, 'YumUsergroup', 'group_id'),
			'user' => array(self::BELONGS_TO, 'YumUser', 'user_id')
		);
	}

	public function attributeLabels()
	{
		return array(
			'user_id' => Yum::t('User'),
			'group_id' => Yum::t('Group'),
		);
	}


	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('user_id', $this->user_id, true);
		$criteria->compare('group_id', $this->group_id, true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
