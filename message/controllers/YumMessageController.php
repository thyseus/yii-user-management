<?php
/* This is the controller for the internal messaging System of
 * the Yii User Management Module. */

Yii::import('application.modules.user.controllers.YumController');
Yii::import('application.modules.message.models.YumMessage');

class YumMessageController extends YumController {
	public function accessRules() {
		return array(
			array('allow',
				'actions' => array('view', 'compose', 'index',
					'delete', 'sent', 'success', 'users', 'markRead'),
				'users'=>array('@'),
				),
			array('allow',
				'actions' => array('sendDigest'),
				'users'=>array('admin'),
				),
			array('deny',
				'users'=>array('*')
			)
		);
	}	

	public function actionUsers() {
		if(Yii::app()->request->isAjaxRequest)
			echo json_encode(CHtml::listData(YumUser::model()->findAll(), 'id', 'username'));
	}

	public function actionMarkRead() {
		$model = $this->loadModel('YumMessage');
		$model->message_read = true;
		$model->save();
		Yum::setFlash(Yum::t('Message "{message}" was marked as read', array(
					'{message}' => $model->title
					)));
		$this->redirect(array(
					'//profile/profile/view', 'id' => $model->from_user_id));
	}

	public function actionView() {
		$model = $this->loadModel('YumMessage');

		// If the model is a draft and i am not the author of the message, throw 403
		if($model->draft && $model->from_user_id != Yii::app()->user->id) 
			throw new CHttpException(403);

		// Only allow to view the message if i am either the recipient or the author
		if($model->to_user_id == Yii::app()->user->id
				|| $model->from_user_id == Yii::app()->user->id) {
		// If the recipient reads the message the first time, set the
		// message_read boolean 
			if(!$model->message_read 
					&& $model->to_user_id == Yii::app()->user->id) {
				$model->message_read = true;
				$model->save(false, array('message_read'));
			}
			$this->render('view',array('model'=>$model));
		} else
			throw new CHttpException(403);

	}

	public function actionCompose($to_user_id = null, $answer_to = 0) {
		$model = new YumMessage;
		$this->performAjaxValidation('YumMessage', 'yum-message-form');

		if(isset($_POST['YumMessage'])) {
			$model->attributes = $_POST['YumMessage'];
			$model->from_user_id = Yii::app()->user->id;
			$model->validate();
			if(!$model->hasErrors()) {
				$model->save();
				Yum::setFlash(Yum::t('Message "{message}" has been sent to {to}', array(
								'{message}' => $model->title,
								'{to}' => YumUser::model()->findByPk($model->to_user_id)->username
								))); 
				$this->redirect(Yum::module('message')->inboxRoute);
			}
		}

		$fct = 'render';
		if(Yii::app()->request->isAjaxRequest)
			$fct = 'renderPartial';	

		$this->$fct('compose',array(
			'model'=>$model,
			'to_user_id' => $to_user_id,
			'answer_to' => $answer_to,
		));
	}

	public function actionSuccess() {
		$this->renderPartial('success');
	}

	public function actionDelete() {
			$this->loadModel('YumMessage')->delete();
			if(!isset($_POST['ajax']))
				$this->redirect(Yum::module('message')->inboxRoute);
	}

	public function actionIndex()
	{
		$model = new YumMessage;

		$this->render(Yum::module('message')->inboxView, array(
					'model'=> $model));
	}

	public function actionSent()
	{
		$model = new YumMessage;

		$this->render('sent',array(
					'model'=> $model));
	}

	public function actionSendDigest() {
		$message = '';

		$recipients = array();
		if(isset($_POST['sendDigest'])) {
			foreach(YumMessage::model()->with('to_user')->findAll('not message_read') as $message) {
				if((is_object($message->to_user) && $message->to_user->notifyType == 'Digest')
						|| Yum::module('message')->notifyType == 'Digest') { 
					$this->mailMessage($message);
					$recipients[] = $message->to_user->profile->email;
				}
			}
			if(count($recipients) == 0)
				$message = Yum::t('No messages are pending. No message has been sent.'); 
			else {
				$message = Yum::t('Digest has been sent to {users} users:', array('{users}' => count($recipients)));
				$message .= '<ul>';
				foreach($recipients as $recipient) {
					$message .= sprintf('<li> %s </li>', $recipient);
				}
				$message .= '</ul>';
			}
		}
		$this->render('send_digest', array('message' => $message));
	}
}
