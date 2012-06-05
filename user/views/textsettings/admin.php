<?php
$this->title = Yum::t( 'Manage text settings');
$this->breadcrumbs=array(
	Yum::t('User administration panel')=>array('//user/user/admin'),
	Yum::t( 'Yum Text Settings'),
	Yum::t( 'Manage'),

);

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'yum-text-settings-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'language',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
