<?
$this->breadcrumbs=array(
	Yum::t('Actions')=>array('index'),
	Yum::t('Manage'),
);

?>
<h1> <? echo Yum::t('Manage Actions'); ?></h1>

<? $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'action-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'title',
		'comment',
		'subject',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
