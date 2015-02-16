<?php

class YumAction extends YumActiveRecord{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
			$this->_tableName = Yum::module('role')->actionTable;

		return $this->_tableName;
	}

	public function rules() {
		return array(
			array('title', 'required'),
			array('comment, subject', 'default', 'setOnEmpty' => true, 'value' => null),
			array('title, subject', 'length', 'max'=>255),
			array('comment', 'safe'),
			array('id, title, comment, subject', 'safe', 'on'=>'search'),
		);
	}

  // return all users that have the possibility to run this action
  public function getUsers() {
    $users = array();

    foreach($this->permissions as $permission) {
      if($permission->type == 'role')
        foreach(YumRole::model()->findByPk($permission->principal_id)->users as $user)
          $users[$user->id] = $user;
      else if($permission->type == 'user')
        $users[$permission->principal_id] = $permission->principal;

      return $users;
    }
  }

	public function relations()
	{
		return array(
			'permissions' => array(self::HAS_MANY, 'YumPermission', 'principal_id')
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => Yum::t('ID'),
			'title' => Yum::t('Title'),
			'comment' => Yum::t('Comment'),
			'subject' => Yum::t('Subject'),
		);
	}

	public function __toString() {
		return $this->title;

	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('title', $this->title, true);
		$criteria->compare('comment', $this->comment, true);
		$criteria->compare('subject', $this->subject, true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
