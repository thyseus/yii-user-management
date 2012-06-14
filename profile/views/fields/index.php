<?
$this->title = Yii::t("UserModule.user", 'List profile field');
$this->breadcrumbs=array(Yii::t("UserModule.user", 'Profile fields'));

$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
