<?
$this->title = Yum::t('Users');
$this->breadcrumbs=array(Yum::t("Users"));
?>

<? $this->widget('zii.widgets.grid.CGridView', array(
			'dataProvider'=>$dataProvider,
			'columns'=>array(
		array(
			'name' => 'username',
			'type'=>'raw',
			'value' => 'CHtml::link(CHtml::encode($data->username),
				array("//profile/profile/view","id"=>$data->id))',
			),
		array(
			'name' => 'createTime',
			'value' => 'date(UserModule::$dateFormat,$data->createTime)',
		),
		array(
			'name' => 'lastVisit',
			'value' => 'date(UserModule::$dateFormat,$data->lastVisit)',
		),
	),
)); ?>


