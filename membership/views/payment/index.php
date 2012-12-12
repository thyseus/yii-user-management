<?php
$this->breadcrumbs = array(
	'Payments',
	Yii::t('app', 'Index'),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'Create') . ' Payment', 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Manage') . ' Payment', 'url'=>array('admin')),
);
?>

<h1>Payments</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
