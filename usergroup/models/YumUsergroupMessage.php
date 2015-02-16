<?php

class YumUsergroupMessage extends YumActiveRecord{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return Yum::module('usergroup')->usergroupMessageTable;
	}

	public function beforeValidate() {
		if($this->isNewRecord)
			$this->createtime = time();

		return parent::beforeValidate();

	}

	public function rules()
	{
		return array(
			array('author_id, group_id, createtime, title, message', 'required'),
			array('id, author_id, group_id, createtime', 'length', 'max'=>11),
			array('title', 'length', 'max'=>255),
			array('id, author_id, group_id, createtime, title, message', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'author' => array(self::BELONGS_TO, 'YumUser', 'author_id'),
			'group' => array(self::BELONGS_TO, 'YumUsergroup', 'group_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => Yum::t('ID'),
			'author_id' => Yum::t('Author'),
			'group_id' => Yum::t('Group'),
			'createtime' => Yum::t('Createtime'),
			'title' => Yum::t('Title'),
			'message' => Yum::t('Message'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('author_id', $this->author_id, true);
		$criteria->compare('group_id', $this->group_id, true);
		$criteria->compare('createtime', $this->createtime, true);
		$criteria->compare('title', $this->title, true);
		$criteria->compare('message', $this->message, true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
