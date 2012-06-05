<?php
$this->title = Yii::t("UserModule.user", 'Update profile field'). ' ' . $model->varname;
$this->breadcrumbs=array(
	Yii::t("UserModule.user", 'Profile fields')=>array('admin'),
	$model->title=>array('view','id'=>$model->id),
	Yii::t("UserModule.user", 'Update'));
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
