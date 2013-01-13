<?php
	$this->title = Yum::t('Manage Permissions');
	$this->breadcrumbs=array(
		Yum::t('Permissions')=>array('index'),
		Yum::t('Manage'),
		);

	$this->widget('zii.widgets.grid.CGridView', array(
			'id'=>'action-grid',
			'dataProvider'=>$model->search(),
			'filter'=>$model,
			'columns' => array(
				array(
					'name' => 'type',
					'value' => '$data->type',
					'filter' => array(
						'type' => Yum::t('User'),
						'role' => Yum::t('Role'),
						)
					),
				array(
					'filter' => false,
					'name' => 'principal',
					'value' => '$data->type == "user" ? $data->principal->username : @$data->principal_role->title'
					),
				'Action.title',
				'Action.comment',
			array(
					'class'=>'CButtonColumn',
					'template' => '{delete}',
					),
				),

			)
		);

