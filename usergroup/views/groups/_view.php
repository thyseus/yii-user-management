<div class="view">

<h3> <? echo CHtml::encode($data->title); ?> </h3> 
	<b><? echo CHtml::encode($data->getAttributeLabel('owner_id')); ?>:</b>
<? if(isset($data->owner))
	echo CHtml::encode($data->owner->username); ?>
	<br />


	<b><? echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<? echo CHtml::encode(substr($data->description, 0, 200)) . '... '; ?>

	<br />
	<b><? echo Yum::t('Participant count'); ?> : </b>
	<? echo count($data->participants); ?>

	<br />
	<b><? echo Yum::t('Message count'); ?> : </b>
	<? echo $data->messagesCount; ?>

	<br />
	<br />

	<? echo CHtml::link(Yum::t('View Details'), array(
					'//usergroup/groups/view', 'id' => $data->id)); ?>
	<? 
	if(is_array($data->participants))
if(!(in_array(Yii::app()->user->id, $data->participants)))
	echo CHtml::link(Yum::t('Join group'), array(
				'//usergroup/groups/join', 'id' => $data->id)); ?>

	</div>
