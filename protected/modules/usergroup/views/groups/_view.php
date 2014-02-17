<div class="view">

<h3> <?php echo CHtml::encode($data->title); ?> </h3> 
	<b><?php echo CHtml::encode($data->getAttributeLabel('owner_id')); ?>:</b>
<?php if(isset($data->owner))
	echo CHtml::encode($data->owner->username); ?>
	<br />


	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode(substr($data->description, 0, 200)) . '... '; ?>

	<br />
	<b><?php echo Yum::t('Participant count'); ?> : </b>
	<?php echo count($data->participants); ?>

	<br />
	<b><?php echo Yum::t('Message count'); ?> : </b>
	<?php echo $data->messagesCount; ?>

	<br />
	<br />

	<?php echo CHtml::link(Yum::t('View Details'), array(
					'//usergroup/groups/view', 'id' => $data->id)); ?>
	<?php 
	if(is_array($data->participants) &&
			in_array(Yii::app()->user->id, $data->participants))
	echo CHtml::link(Yum::t('Leave group'), array(
				'//usergroup/groups/leave', 'id' => $data->id)); 
	else
	echo CHtml::link(Yum::t('Join group'), array(
				'//usergroup/groups/join', 'id' => $data->id)); ?>

	</div>
