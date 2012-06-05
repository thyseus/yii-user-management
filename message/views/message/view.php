<?php
$this->title = $model->title;
$this->breadcrumbs=array(Yum::t('Messages')=>array('index'),$model->title);
?>

<h2> <?php echo Yum::t('Message from') .  ' <em>' . $model->from_user->username . '</em>';

echo ': ' . $model->title; ?> 
</h2>

<hr />

<div class="message">
<?php echo $model->message; ?>
</div>

<hr />
<?php
echo CHtml::link(Yum::t('Back to inbox'), array(
			'//message/message/index')) . '<br />';

if(Yii::app()->user->id != $model->from_user_id) {
	echo CHtml::link(Yum::t('Reply to message'), '', array(
				'onclick' => "$('.reply').toggle(500)"));

	echo '<div class="reply" style="display: none;">';
	$reply = new YumMessage;

	if(substr($model->title, 0, 3) != 'Re:')
		$reply->title = 'Re: ' . $model->title;

	$this->renderPartial('reply', array(
				'to_user_id' => $model->from_user_id,
				'answer_to' => $model->id,
				'model' => $reply));
	echo '</div>';
}
?>
