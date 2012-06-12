<?
$this->title = Yum::t('Request friendship for user {username}', array(
			'{username}' => $invited->username));
$this->breadcrumbs = array(
		Yum::t('Friendship'),
		Yum::t('Invitation'), $invited->username);

$friendship_status = $invited->isFriendOf(Yii::app()->user->id);
	if($friendship_status !== false)  {
		if($friendship_status == 1)
			echo Yum::t('Friendship request already sent');
		if($friendship_status == 2)
			echo Yum::t('You already are friends');
		if($friendship_status == 3)
			echo Yum::t('Friendship request has been rejected');

		return false;
	} else {
		if(isset($friendship))
			echo CHtml::errorSummary($friendship);

		echo CHtml::beginForm(array('friendship/invite'));
		echo CHtml::hiddenField('user_id', $invited->id);
		echo CHtml::label(Yum::t('Please enter a request Message up to 255 characters'), 'message');
		echo '<br />';
		echo CHtml::textArea('message', '', array('cols' =>60, 'rows' => 10));
		echo '<br />';
		echo CHtml::submitButton(Yum::t('Send invitation'));
		echo CHtml::endForm();
	}
?>

