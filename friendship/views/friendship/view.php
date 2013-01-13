<?php
$this->breadcrumbs=array(
	'Groups'=>array('index'),
);
?>

<h1>View Friendship #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'inviter.username',
		'status',
		'invited.username',
		'acknowledgetime',
		'requesttime',
		'updatetime',
		'message',
		
	),
)); ?>
