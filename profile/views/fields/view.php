<?
$this->title = Yii::t("UserModule.user", 'Profile field {fieldname}', array(
			'{fieldname}'=>$model->varname));

$this->breadcrumbs=array(
	Yii::t("UserModule.user", 'Profile fields')=>array('admin'),
	Yii::t("UserModule.user", $model->title));

?>

<? $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'varname',
		'title',
		'hint',
		'field_type',
		'field_size',
		'field_size_min',
		'required',
		'match',
		'range',
		'error_message',
		'other_validator',
		'default',
		'position',
		'visible',
	),
)); ?>
