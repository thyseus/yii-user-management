<? 
$messages = YumMessage::model()->findAll(
		'to_user_id = :to and message_read = 0',
		array( ':to' => Yii::app()->user->id)
		);

if(count($messages) > 0) {
	if(Yum::module('message')->messageSystem == YumMessage::MSG_PLAIN) 
		$this->renderPartial(
				'application.modules.message.views.message.new_messages_plain', array(
					'message' => $message));
	else if(Yum::module('message')->messageSystem == YumMessage::MSG_DIALOG)
		$this->renderPartial(
				'application.modules.message.views.message.new_messages_dialog', array(
					'message' => $message));
}
?>
