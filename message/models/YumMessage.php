<?php

/**
 * This is the model class for the Message subsystem of the Yii User 
 * Management module
 *
 */
class YumMessage extends YumActiveRecord
{
	const MSG_NONE = 'None';
	const MSG_PLAIN = 'Plain';
	const MSG_DIALOG = 'Dialog';

	// set $omit_mail to true to avoid e-mail notification of the 
	// received message. It is mainly user for the privacy settings
	// (receive profile comment email/friendship request email/...)
	public $omit_mail = false;

	/**
	 * @param string $className
	 * @return YumMessage
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function beforeValidate() {
		if(parent::beforeValidate()) {
			$this->timestamp = time();

			$to_user = YumUser::model()->findByPk($this->to_user_id);
			if($to_user && isset($to_user->privacy)) {
				if(in_array($this->from_user->username, $to_user->privacy->getIgnoredUsers()))
					$this->addError('to_user_id', Yum::t('One of the recipients ({username}) has ignored you. Message will not be sent!', array('{username}' => $to_user->username)));
			}
			return true;
		}
		return false;
	} 

	public function afterSave() {
		// If the user has activated email receiving, send a email
		if($this->to_user->privacy && $this->to_user->privacy->message_new_message) {
			Yum::log( Yum::t(
						'Message id {id} has been sent from user {from_user_id} to user {to_user_id}', array(
						'{id}' => $this->id,
						'{from_user_id}' => $this->from_user_id,
						'{to_user_id}' => $this->to_user_id,
						)));

			YumMailer::send($this->to_user->profile->email,
					$this->title,
					$this->message);
}
		return parent::afterSave();
	}  

	// Small wrapper function to quickly send messages from inside the workflow
	// $to - recipient of the message. either the uid, the username or an 
	//			 YumUser object instance
	// $from - Who wrote the message? Again, uid, username or YumUser object
	// $subject - Subject
	// $body - The message
	// $mail - Should the mail also be send by email, defaults to true
	//
	// Example usage: YumMessage::write(1, 2, 'Hello', 'Body'); 
	// Will write a message from admin to demo 
	public static function write($to, $from, $subject, $body, $mail = true) {
		$message = new YumMessage();

		if(!$mail)
			$message->omit_mail = true;

		if(is_object($from))
			$message->from_user_id = (int) $from->id;
		else if(is_numeric($from))
			$message->from_user_id = $from;
		else if(is_string($from) 
				&& $user = YumUser::model()->find("username = '{$from}'"))
			$message->from_user_id = $user->id;
		else
			return false;

		if(is_object($to))
			$message->to_user_id = (int) $to->id;
		else if(is_numeric($to))
			$message->to_user_id = $to;
		else if(is_string($to) 
				&& $user = YumUser::model()->find("username = '{$to}'"))
			$message->to_user_id = $user->id;
		else 
			return false;

		$message->title = $subject;
		$message->message = $body;

		return $message->save();
	}

	// How many messages have been written in month $month of year $year?
	public static function countWritten($month = null, $year = null) {
		$timestamp = mktime(0, 0, 0, $month, 1, $year);
		$timestamp2 = mktime(0, 0, 0, $month + 1, 1, $year);
		if($month === null) {
			$timestamp = 0;
			$timestamp2 = time();
		}

		$sql = "select count(*) from {$this->tableName()} where timestamp > {$timestamp} and timestamp < {$timestamp2}";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		return $result[0]['count(*)'];
	}

	public function search($sent = false) {
		$criteria = new CDbCriteria;

		// FIXME: its not elegant to ask for $_GET in the model, but is there
		// a better way to accomplish this?:
		if(!isset($_GET['YumMessage_sort']))
			$criteria->order = 'timestamp DESC';

		if($sent)	
			$criteria->addCondition('from_user_id = '. Yii::app()->user->id);
		else
			$criteria->addCondition('to_user_id = '. Yii::app()->user->id);

		return new CActiveDataProvider('YumMessage', array(
					'criteria' => $criteria,
					'pagination' => array(
						'pageSize' => Yum::module()->pageSize,
						),
					));
	}

	/**
	 * Returns resolved table name (incl. table prefix when it is set in db configuration)
	 * Following algorith of searching valid table name is implemented:
	 *  - try to find out table name stored in currently used module
	 *  - if not found try to get table name from UserModule configuration
	 *  - if not found user default {{message}} table name
	 * @return string
	 */
	public function tableName()
	{
		if (isset(Yum::module('message')->messageTable))
			$this->_tableName = Yum::module('message')->messageTable;
		else
			$this->_tableName = '{{message}}'; // fallback if nothing is set

		return Yum::resolveTableName($this->_tableName,$this->getDbConnection());
	}

	public function rules()
	{
		return array(
				array('from_user_id, to_user_id, title', 'required'),
				array('from_user_id, draft, message_read, answered', 'numerical', 'integerOnly'=>true),
				array('title', 'length', 'max'=>255),
				array('message', 'safe'),
				);
	}

	public function getTitle()
	{
		if($this->message_read)
			$title = $this->title;
		else
			$title = '<strong>' . $this->title . '</strong>';

		// Pseduo-threaded view
		if($this->answered > 0)
			$title = '<span style="padding-left:25px;">'.$title.'</span>';
		return $title;
	}

	public function getStatus() {
		if($this->from_user_id == Yii::app()->user->id)
			return Yum::t('sent');
		if($this->answered)
			return Yum::t('answered');
		if($this->message_read)
			return Yum::t('read');
		else
			return Yum::t('new');
	}

	public function unread($id = false) 
	{
		if(!$id)
			$id = Yii::app()->user->id;

		$this->getDbCriteria()->mergeWith(array(
					'condition' => "to_user_id = {$id} and message_read = 0"
				));
		return $this;
	}

	// Always show the newest message at the top
/*  public function defaultScope()
	{
		return array(
				'order'=>'timestamp DESC'
				);
	} */
	public function scopes() {
		$id = Yii::app()->user->id;
		return array(
				'all' => array(
					'condition' => "to_user_id = {$id} or from_user_id = {$id}"), 
				'read' => array(
					'condition' => "to_user_id = {$id} and message_read = 1"),
				'sent' => array(
					'condition' => "from_user_id = {$id}"),
				'answered' => array(
					'condition' => "to_user_id = {$id} and answered > 0"),
				);
	}

	public function limit($limit=10)
	{
		$this->getDbCriteria()->mergeWith(array(
					'order'=>'timestamp DESC',
					'limit'=>$limit,
					));
		return $this;
	}

	public function getDate()
	{
		return date(Yii::app()->getModule('user')->dateTimeFormat, $this->timestamp);
	}

	public function beforeDelete() {
		if($this->to_user_id != Yii::app()->user->id)
			throw new CHttpException(403);
		return parent::beforeDelete();
	}

	public function relations()
	{
		return array(
				'from_user' => array(self::BELONGS_TO, 'YumUser', 'from_user_id'),
				'to_user' => array(self::BELONGS_TO, 'YumUser', 'to_user_id'),
				);
	}

	public function attributeLabels()
	{
		return array(
				'id' => Yum::t('#'),
				'from_user_id' => Yum::t('From'),
				'to_user_id' => Yum::t('To'),
				'title' => Yum::t('Title'),
				'message' => Yum::t('Message'),
				'timestamp' => Yum::t('Time sent'),
				);
	}

}
