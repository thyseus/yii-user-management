<?php
if(Yum::module('message')->messageSystem != YumMessage::MSG_NONE 
		&& $model->id != Yii::app()->user->id) {

echo '<div style="display: none;" id="write_a_message">';

	$this->renderPartial(Yum::module()->messageComposeView, array(
				'model' => new YumMessage,
				'to_user_id' => $model->id), false, true);

echo '</div>';

	echo CHtml::link(Yum::t('Write a message to this User'), '',
			array('onclick'=>"$('#write_a_message').toggle(500);"));
}
?>
