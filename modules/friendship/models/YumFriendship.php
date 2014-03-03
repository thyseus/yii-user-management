<?php

class YumFriendship extends YumActiveRecord {
	const FRIENDSHIP_NONE = 0; 
	const FRIENDSHIP_REQUEST = 1;
	const FRIENDSHIP_ACCEPTED = 2;
	const FRIENDSHIP_REJECTED = 3;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function requestFriendship($inviter, $invited, $message = null) {
		if(!is_object($inviter))
			$inviter = YumUser::model()->findByPk($inviter);

		if(!is_object($invited))
			$invited = YumUser::model()->findByPk($invited);

		if($inviter->id == $invited->id)
			return false;

		$friendship_status = $inviter->isFriendOf($invited);

		if($friendship_status !== false)  {
			if($friendship_status == 1)
				$this->addError('invited_id', Yum::t('Friendship request already sent'));
			if($friendship_status == 2)
				$this->addError('invited_id', Yum::t('Users already are friends'));
			if($friendship_status == 3)
				$this->addError('invited_id', Yum::t('Friendship request has been rejected '));

			return false;
		}

		$this->inviter_id = $inviter->id;
		$this->friend_id = $invited->id;
		$this->acknowledgetime = 0;
		$this->requesttime = time();
		$this->updatetime = time();

		if($message !== null)
			$this->message = $message;
		$this->status = 1;
		return $this->save();
	} 

	// How many friendship requests have been made in month $month of year $year?
	public static function countRequest($month = null, $year = null) {
		$timestamp = mktime(0, 0, 0, $month, 1, $year);
		$timestamp2 = mktime(0, 0, 0, $month + 1, 1, $year);
		if($month === null) {
			$timestamp = 0;
			$timestamp2 = time();
		}


		$sql = "select count(*) from friendship where requesttime > {$timestamp} and requesttime < {$timestamp2}";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		return $result[0]['count(*)'];
	}

	public function acceptFriendship() {
		$this->acknowledgetime = time();
		$this->status = 2;
		if(Yum::hasModule('message') 
				&& isset($this->inviter->privacy) 
				&& $this->inviter->privacy->message_new_friendship) {
			Yii::import('application.modules.message.models.YumMessage');
			YumMessage::write($this->inviter, $this->invited,
					Yum::t('Your friendship request has been accepted'),
					strtr(
						'Your friendship request to {username} has been accepted', array(
							'{username}' => $this->inviter->username))); 
		}
		$this->save(false, array('acknowledgetime', 'status'));

	} 

	public function getFriend() {
		if($this->friend_id == Yii::app()->user->id)
			return $this->inviter->username;
		else
			return $this->invited->username;
	}

	public function getStatus() {
		switch($this->status) {
			case '0':
				return Yum::t('No friendship requested');
			case '1':
				return Yum::t('Confirmation pending');
			case '2':
				return Yum::t('Friendship confirmed');
			case '3':
				return Yum::t('Friendship rejected');

		}
	}

	public function rejectFriendship() {
		$this->acknowledgetime = time();
		$this->status = 3;
		return($this->save());
	} 

	public function ignoreFriendship() {
		$this->acknowledgetime = time();
		$this->status = 0;
		return($this->save());
	} 

	public function tableName()
	{
		$this->_tableName = Yum::module('friendship')->friendshipTable;

		return $this->_tableName;
	}

	public function rules()
	{
		return array(
				array('inviter_id, friend_id, status, requesttime, acknowledgetime, updatetime', 'required'),
				array('inviter_id, friend_id, status, requesttime, acknowledgetime, updatetime', 'numerical', 'integerOnly'=>true),
				array('message', 'length', 'max'=>255),
				array('inviter_id, friend_id, status, message, requesttime, acknowledgetime, updatetime', 'safe', 'on'=>'search'),
				);
	}

	public function relations()
	{
		return array(
				'inviter' => array(self::BELONGS_TO, 'YumUser', 'inviter_id'),
				'invited' => array(self::BELONGS_TO, 'YumUser', 'friend_id'),
				);
	}

	public function attributeLabels()
	{
		return array(
				'inviter_id' => Yum::t('Inviter'),
				'friend_id' => Yum::t('Friend'),
				'status' => Yum::t('Status'),
				'message' => Yum::t('Message'),
				'requesttime' => Yum::t('Requesttime'),
				'acknowledgetime' => Yum::t('Acknowledgetime'),
				'updatetime' => Yum::t('Updatetime'),
				);
	}

	public function beforeSave() {
		$this->updatetime = time();

		// If the user has activated email receiving, send a email
		if($this->isNewRecord)
			if($user = YumUser::model()->findByPk($this->friend_id))  {
				if(Yum::hasModule('message')
						&& $user->privacy 
						&& $user->privacy->message_new_friendship) {
					Yii::import('application.modules.message.models.YumMessage');
					YumMessage::write($user, $this->inviter,
							Yum::t('New friendship request from {username}', array(
									'{username}' => $this->inviter->username)),
							strtr(
								'A new friendship request from {username} has been made: {message} <a href="{link_friends}">Manage my friends</a><br /><a href="{link_profile}">To the profile</a>', array(
									'{username}' => $this->inviter->username,
									'{link_friends}' => Yii::app()->controller->createUrl('//friendship/friendship/index'),
									'{link_profile}' => Yii::app()->controller->createUrl('//profile/profile/view'),
									'{message}' => $this->message)));
				}
			}
		return parent::beforeSave();
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('inviter_id', $this->inviter_id);
		$criteria->compare('friend_id', $this->friend_id);
		$criteria->compare('status', $this->status);
		$criteria->compare('message', $this->message, true);
		$criteria->compare('requesttime', $this->requesttime);
		$criteria->compare('acknowledgetime', $this->acknowledgetime);
		$criteria->compare('updatetime', $this->updatetime);

		return new CActiveDataProvider(get_class($this), array(
					'criteria'=>$criteria,
					));
	}

	public static function areFriends($uid1, $uid2) {
		if(is_numeric($uid1) && is_numeric($uid2)) {
			$friendship = YumFriendship::model()->find('status = 2 and inviter_id = '.$uid1 . ' and friend_id = '.$uid2);
			if($friendship)
				return true;

			$friendship = YumFriendship::model()->find('status = 2 and inviter_id = '.$uid2 . ' and friend_id = '.$uid1);
			if($friendship)
				return true;
		} 
		return false;

	}
}
