<?
$this->title = Yum::t('Manage roles'); 

$this->breadcrumbs=array(
	Yum::t('Roles')=>array('index'),
	Yum::t('Manage'),
);

?>

<? $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		array(
			'name' => 'title',
			'type' => 'raw',
			'value'=> 'CHtml::link(CHtml::encode($data->title),
				array(Yum::route("role/view"),"id"=>$data->id))',
		),
		'price',
		'is_membership_possible',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
