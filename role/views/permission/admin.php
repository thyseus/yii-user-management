<div class="container">
<div class="span12">
<div class="row">

<?php
$this->breadcrumbs=array(
		Yum::t('Permissions')=>array('index'),
		Yum::t('Manage'),
		);

?>

<h1> <?php echo Yum::t('Manage permissions'); ?> </h1>

<?php
echo CHtml::link(Yum::t('Assign permission'), array(
			'//role/permission/create'), array('class' => 'btn')); 

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
			'htmlOptions' => array('class' => 'table table-striped table-condensed admin-user'),
			)
		); ?>
</div>
</div>
</div>
