<?
$this->breadcrumbs=array(
	'Groups'=>array('index'),
);
?>

<h1>View Friendship #<? echo $model->id; ?></h1>

<? $this->widget('zii.widgets.CDetailView', array(
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
