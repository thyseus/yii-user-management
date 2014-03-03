<?php
$this->title = Yum::t('Sent messages');

$this->breadcrumbs=array(
	Yum::t('Messages')=>array('index'),
	Yum::t('Sent messages'));

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'yum-sent-message-grid',
	'dataProvider' => $model->search(true),
	'columns'=>array(
		array(
			'name' => 'to_user_id',
			'type' => 'raw',
			'value' => 'isset($data->to_user) ? CHtml::link($data->to_user->username, array("//profile/profile/view", "id" => $data->to_user->username)) : ""',
			),
		array(
			'type' => 'raw',
			'name' => 'title',
			'value' => 'CHtml::link($data->title, array("view", "id" => $data->id))',
		),
		array(
			'name' => 'timestamp',
			'value' => '$data->getDate()',
		),
		array(
			'class'=>'CButtonColumn',
			'template' => '{view}',
		),
	),
)); ?>
