<?php
$this->breadcrumbs=array(
	Yum::t('Actions')=>array('index'),
	Yum::t('Manage'),
);

?>
<h1> <?php echo Yum::t('Manage Actions'); ?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
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
