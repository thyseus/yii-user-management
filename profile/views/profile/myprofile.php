<div id="profile">
<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yum::t('Profile');
$this->breadcrumbs=array(Yum::t('Profile'));
$this->title = Yum::t('Your profile');
if(Yum::hasModule('messages'))
$this->renderPartial('/messages/new_messages');?>


<div class="avatar">
<?php echo $model->renderAvatar(); ?>
</div>

<table class="dataGrid">
<?php if(!Yum::module()->loginType & UserModule::LOGIN_BY_EMAIL) {?>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('username')); ?>
</th>
    <td><?php echo CHtml::encode($model->username); ?>
</td>
</tr>
<?php
}
		$profileFields = YumProfileField::model()->forOwner()->sort()->with('group')->together()->findAll();
		if ($profileFields && Yum::hasModule('profile')) {
	foreach($profileFields as $field) {
		if($field->field_type == 'DROPDOWNLIST') {
			?>
			<tr>
				<th class="label"><?php echo CHtml::encode(Yum::t($field->title)); ?>
				</th>
				<td><?php
				if(is_object($model->profile->{ucfirst($field->varname)}))
					echo CHtml::encode($model->profile->{ucfirst($field->varname)}->{$field->related_field_name}); ?>
						</td>
						</tr>
				<?php
		} else {
			?>
				<tr>
				<th class="label"><?php echo CHtml::encode(Yum::t($field->title)); ?>
				</th>
				<td><?php echo CHtml::encode($model->profile->getAttribute($field->varname)); ?>
				</td>
				</tr>
				<?php
		}
	}
}
?>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('password')); ?>
</th>
<td><?php echo CHtml::link(Yum::t('Change password'),array(
			'//user/user/changepassword')); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('createtime')); ?>
</th>
    <td><?php echo date(UserModule::$dateFormat,$model->createtime); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('lastvisit')); ?>
</th>
    <td><?php echo date(UserModule::$dateFormat,$model->lastvisit); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('status')); ?>
</th>
    <td><?php echo CHtml::encode(YumUser::itemAlias("UserStatus",$model->status));
    ?>
</td>
</tr>
</table>

<div id="friends">
<h2> <?php echo Yum::t('My friends'); ?> </h2>
<?php
if(Yum::hasModule('friendship') && $model->friends)
{
foreach($friends as $friend) {
?>
<div id="friend">
<div id="avatar">
<?php
$model->renderAvatar($friend);
?>
<div id='user'>
<?php
echo CHtml::link(ucwords($friend->username),
		Yii::app()->createUrl('profile/profile/view',array(
				'id'=>$friend->id)));
?>
</div>
</div>
</div>
</div>
<?php
}
}else {
		echo Yum::t('You have no friends yet');
	}
?>
</div>
<div id="visits">
<h2> <?php echo Yum::t('This users have visited my profile'); ?> </h2>
<?php
	if($model->visits) {
		$format = Yum::module()->dateTimeFormat;
		echo '<table>';
		printf('<th>%s</th><th>%s</th><th>%s</th><th>%s</th><th>%s</th>',
			Yum::t('Visitor'),
			Yum::t('Time of first Visit'),
			Yum::t('Time of last Visit'),
			Yum::t('Num of Visits'),
			Yum::t('Message')
);

		foreach($model->visits as $visit) {
			if(isset($visit->visitor))  //we need this in case a user quits
			{
			printf('<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>',
					CHtml::link($visit->visitor->username, array(
							'//profile/profile/view', 'id' => $visit->visitor_id)),
					date($format, $visit->timestamp_first_visit),
					date($format, $visit->timestamp_last_visit),
					$visit->num_of_visits,
					CHtml::link(Yum::t('Write a message'), array(
							'//message/message/compose',
							'to_user_id' => $visit->visitor_id))
					);
			}
	}
		echo '</table>';
	} else {
		echo Yum::t('Nobody has visited your profile yet');
	}
?>
</div>
