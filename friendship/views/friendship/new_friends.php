<?php 
$user = YumUser::model()->findByPk(Yii::app()->user->id);

if($user->friendship_requests) {
	$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=> Yum::t('New friendship requests')));
	foreach($user->friendship_requests as $friendship) {
		printf('<li> %s: %s </li>',
				date(Yum::module()->dateTimeFormat, $friendship->requesttime),
				CHtml::link($friendship->inviter->username, array(
						'//profile/profile/view', 'id' => $friendship->inviter->id)));
	}
	echo CHtml::link(Yum::t('Manage friends'), array(
				'//friendship/friendship/admin'));
	$this->endWidget();
}
?>

