<?php

class YumMembership extends YumActiveRecord{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		if (isset(Yum::module('membership')->membershipTable))
			$this->_tableName = Yum::module('membership')->membershipTable;
		else
			$this->_tableName = '{{membership}}'; // fallback if nothing is set

		return Yum::resolveTableName($this->_tableName,$this->getDbConnection());
	}

	public function activate() {
		$this->end_date = time() + ($this->role->duration * 365 * 60 * 60);
		$this->payment_date = time();
		$this->save();
	}

	public function daysLeft() {
		$difference = abs($this->end_date - time());
		return sprintf('%d', (int) $difference / 86400 + 1);
	}

	public function beforeValidate() {
		if($this->isNewRecord) {
			$this->user_id = Yii::app()->user->id;		
			$this->order_date = time();
		}

		return parent::beforeValidate();
	}

	public function scopes()
	{
		return array('lastFirst' => array('order' => 'id DESC'));
	}


	public function afterSave() {
		return parent::afterSave();
	}

	public function primaryKey() {
		return 'id';
	}

	public function timeLeft() {
		if($this->end_date < time())
			return Yum::t('Expired');

		$seconds = time() - $this->end_date;

		$delay = array();

		foreach( array( 86400, 3600, 60) as $increment) {
			$difference = abs(round($seconds / $increment));
			$seconds %= $increment;

			$delay[] = $difference;

		}

		$timeleft = Yum::t('{days} D, {hours} H, {minutes} M', array(
					'{days}' => $delay[0],
					'{hours}' => $delay[1],
					'{minutes}' => $delay[2],
					));

		// Mark memberships that expire in less than 30 days red 
		if($delay[0] < 30)
			return '<div style="background-color: red;margin: 2px;">'.$timeleft.'</div>';
		else
			return $timeleft;


	}

	public function rules()
	{
		return array(
				array('membership_id, user_id, payment_id, order_date', 'required'),
				array('end_date', 'default', 'setOnEmpty' => true, 'value' => null),
				array('membership_id, user_id, payment_id, order_date, end_date, payment_date', 'numerical', 'integerOnly'=>true),
				array('id, membership_id, user_id, payment_id, order_date, end_date, payment_date', 'safe', 'on'=>'search'),
				);
	}

	public function relations()
	{
		return array(
				'user' => array(self::BELONGS_TO, 'YumUser', 'user_id'),
				'role' => array(self::BELONGS_TO, 'YumRole', 'membership_id'),
				'payment' => array(self::BELONGS_TO, 'YumPayment', 'payment_id'),
				);
	}

	public function attributeLabels()
	{
		return array(
				'id' => Yum::t('Order number'),
				'is_membership_possible' => Yum::t('Membership is possible'),
				'membership_id' => Yum::t('Membership'),
				'user_id' => Yum::t('User'),
				'payment_id' => Yum::t('Payment'),
				'order_date' => Yum::t('Order date'),
				'end_date' => Yum::t('End date'),
				'payment_date' => Yum::t('Payment date'),
				);
	}

	public function sendPaymentConfirmation () {
		Yii::import('application.modules.message.models.*');
		return YumMessage::write($this->user, 1,
				Yum::t('Payment arrived'),
				YumTextSettings::getText('text_payment_arrived', array(
						'{payment_date}' => date(Yum::module()->dateTimeFormat, $this->payment_date),
						'{id}' => $this->id,
						)));

	}

	public function confirmPayment() {
		$this->payment_date = time();
		$this->end_date = $this->payment_date + ($this->role->duration * 86400);

		if($this->save(false, array('payment_date', 'end_date'))) {
			return $this->sendPaymentConfirmation();
		} else
		return false;
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('membership_id', $this->membership_id);
		$criteria->compare('user_id', $this->user_id);
		$criteria->compare('payment_id', $this->payment_id);
		$criteria->compare('order_date', $this->order_date);

		if($this->payment_date == 'not_payed') 
			$criteria->addCondition('payment_date is null');

		$criteria->with = array('user', 'role', 'payment');

		return new CActiveDataProvider(get_class($this), array(
					'criteria'=>$criteria,
					));
	}
}	
