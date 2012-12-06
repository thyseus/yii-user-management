<?
$this->title = Yum::t($model->title);
$this->breadcrumbs=array(
	Yum::t('Actions')=>array('index'),
	$model->title,
);

 $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'comment',
		'subject',
	),
));
