<?
$this->title = Yii::t("UserModule.user", 'Create profile field'); 
$this->breadcrumbs=array(
	Yii::t("UserModule.user", 'Profile fields')=>array('admin'),
	Yii::t("UserModule.user", 'Create'));
?>

<? echo $this->renderPartial('_form', array('model'=>$model)); ?>
