<?php
$this->breadcrumbs=array(
	Yum::t('Actions')=>array('index'),
	$model->title,
);

?>

<h1> <?php echo $model->title; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'comment',
		'subject',
	),
)); ?>
