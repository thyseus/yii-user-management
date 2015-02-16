<?php
$this->breadcrumbs=array(
	Yum::t('Payments')=>array(Yii::t('app', 'index')),
	Yum::t('Manage'),
);
		?>

<h1> <?php echo Yum::t('Manage payments'); ?> </h1>

<?php
$locale = CLocale::getInstance(Yii::app()->language);

 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'payment-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'title',
		'text',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
