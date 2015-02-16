<div class="container">
<div class="row">
<div class="span12">


<?php
$this->title = Yum::t('Manage users');

$this->breadcrumbs = array(
		Yum::t('Users'),
		Yum::t('Manage'));

echo CHtml::link(Yum::t('Create new User'), array(
			'//user/user/create'), array('class' => 'btn')); 

$columns = array(
		array(
			'class'=>'zii.widgets.grid.CButtonColumn',
			'headerHtmlOptions' => array('class' => 'span1'),
			),
		array(
			'name'=>'id',
			'filter' => false,
			'type'=>'raw',
		'headerHtmlOptions' => array('class' => 'span1'),
			'value'=>'CHtml::link($data->id,
				array("//user/user/update","id"=>$data->id))',
			),
		array(
			'name'=>'username',
			'type'=>'raw',
		'headerHtmlOptions' => array('class' => 'span1'),
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
		'headerHtmlOptions' => array('class' => 'span1'),
		);

$columns[] = array(
		'name'=>'createtime',
		'filter' => false,
		'value'=>'date(UserModule::$dateFormat,$data->createtime)',
		'headerHtmlOptions' => array('class' => 'span1'),
		);
$columns[] = array(
		'name'=>'lastvisit',
		'filter' => false,
		'value'=>'date(UserModule::$dateFormat,$data->lastvisit)',
		'headerHtmlOptions' => array('class' => 'span1'),
		);
$columns[] = array(
		'name'=>'status',
		'filter' => array(
			'0' => Yum::t('Not active'),
			'1' => Yum::t('Active'),
			'-1' => Yum::t('Banned'),
			'-2' => Yum::t('Deleted')),
		'value'=>'YumUser::itemAlias("UserStatus",$data->status)',
		'headerHtmlOptions' => array('class' => 'span1'),
		);
$columns[] = array(
		'name'=>'superuser',
		'filter' => array(0 => Yum::t('No'), 1 => Yum::t('Yes')),
		'value'=>'YumUser::itemAlias("AdminStatus",$data->superuser)',
		'headerHtmlOptions' => array('class' => 'span1'),
		);

if(Yum::hasModule('role'))
$columns[] = array(
		'header'=>Yum::t('Roles'),
		'name'=>'filter_role',
		'type' => 'raw',
		'visible' => Yum::hasModule('role'),
		'filter' => CHtml::listData(YumRole::model()->findAll(), 'id', 'title'),
		'value'=>'$data->getRoles()',
		'headerHtmlOptions' => array('class' => 'span1'),
		);

$this->widget('zii.widgets.grid.CGridView',array(
			'dataProvider'=>$model->search(),
			'filter' => $model,
			'columns'=>$columns,
			'htmlOptions' => array('class' => 'table table-striped table-condensed admin-user'),
			)
		); ?>



</div>
</div>
</div>
