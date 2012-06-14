<?
$this->breadcrumbs=array(
	Yum::t('Actions')=>array('index'),
	$model->title,
);

?>

<h1> <? echo $model->title; ?></h1>

<? $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'comment',
		'subject',
	),
)); ?>
