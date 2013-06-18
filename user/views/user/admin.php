<?php
$this->title = Yum::t('Manage users');

$this->breadcrumbs = array(
		Yum::t('Users'),
		Yum::t('Manage'));

echo Yum::renderFlash();

$columns = array(
		array('class'=>'zii.widgets.grid.CButtonColumn'),
		array(
			'name'=>'id',
			'filter' => false,
			'type'=>'raw',
			'value'=>'CHtml::link($data->id,
				array("//user/user/update","id"=>$data->id))',
			),
		array(
			'name'=>'username',
			'type'=>'raw',
			'value'=>'CHtml::link(CHtml::encode($data->username),
				array("//user/user/view","id"=>$data->id))',
			),
		);

if(Yum::hasModule('profile') && isset($profile))
foreach(Yum::module('profile')->gridColumns as $column)
$columns[] = array(
		'header' => Yum::t($column),
		'filter' => CHtml::textField('YumProfile['.$column.']', $profile->$column),
		'name' => 'profile.'.$column,
		);

$columns[] = array(
		'name'=>'createtime',
		'filter' => false,
		'value'=>'date(UserModule::$dateFormat,$data->createtime)',
		);
$columns[] = array(
		'name'=>'lastvisit',
		'filter' => false,
		'value'=>'date(UserModule::$dateFormat,$data->lastvisit)',
		);
$columns[] = array(
		'name'=>'status',
		'filter' => array(
			'0' => Yum::t('Not active'),
			'1' => Yum::t('Active'),
			'-1' => Yum::t('Banned'),
			'-2' => Yum::t('Deleted')),
		'value'=>'YumUser::itemAlias("UserStatus",$data->status)',
		);
$columns[] = array(
		'name'=>'superuser',
		'filter' => array(0 => Yum::t('No'), 1 => Yum::t('Yes')),
		'value'=>'YumUser::itemAlias("AdminStatus",$data->superuser)',
		);

$columns[] = array(
		'name'=>Yum::t('Roles'),
		'type' => 'raw',
		'visible' => Yum::hasModule('role'),
		'filter' => false,
		'value'=>'$data->getRoles()',
		);

$this->widget('zii.widgets.grid.CGridView',array(
			'dataProvider'=>$model->search(),
			'filter' => $model,
			'columns'=>$columns,
			)
		); ?>

<?php echo CHtml::link(Yum::t('Create new User'), array(
			'//user/user/create'), array('class' => 'btn')); ?>

