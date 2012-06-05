<?php
$this->title = Yii::t('UserModule.user', 'Text settings');
$this->breadcrumbs = array(
	Yii::t('UserModule.user','User administration panel')=>array('//user/user/admin'),
	Yii::t('UserModule.user', 'Yum Text Settings'),
	Yii::t('UserModule.user', 'Index'),
);

$this->menu=array(
	array('label'=>Yii::t('UserModule.user', 'Create new text setting'), 'url'=>array('create')),
	array('label'=>Yii::t('UserModule.user', 'Manage text settings'), 'url'=>array('admin')),
);
?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
