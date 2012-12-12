<?php Yum::register('css/yum.css');

$this->breadcrumbs=array(
		Yum::t('Usergroups')=>array('index'),
		$model->title,
		);
 ?>

<h3> <?php echo $model->title;  ?> </h3>

<p> <?php echo $model->description; ?> </p>

<?php

if($model->owner)
	printf('%s: %s',
			Yum::t('Owner'),
			CHtml::link($model->owner->username, array(
					'//profile/profile/view', 'id' => $model->owner_id)));

printf('<h4> %s </h4>', Yum::t('Participants'));

$this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$model->getParticipantDataProvider(),
    'itemView'=>'_participant', 
)); 

?>

 <div style="clear: both;"> </div> 
<?php
printf('<h3> %s </h3>', Yum::t('Messages'));

$this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$model->getMessageDataProvider(),
    'itemView'=>'_message', 
)); 

?>

<?php echo CHtml::link(Yum::t('Write a message'), '', array(
			'onClick' => "$('#usergroup_message').toggle(500)")); ?>

<div style="display:none;" id="usergroup_message">
<h3> <?php echo Yum::t('Write a message'); ?> </h3>
<?php $this->renderPartial('_message_form', array('group_id' => $model->id)); ?>
</div>

<div style="clear: both;"> </div>



