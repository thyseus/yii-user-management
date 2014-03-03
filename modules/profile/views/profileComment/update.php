<?php
$this->breadcrumbs=array(
	'Profile Comments'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('app', 'Update'),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'List') . ' ProfileComment', 'url'=>array('index')),
	array('label'=>Yii::t('app', 'Create') . ' ProfileComment', 'url'=>array('create')),
	array('label'=>Yii::t('app', 'View') . ' ProfileComment', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('app', 'Manage') . ' ProfileComment', 'url'=>array('admin')),
);
?>

<h1> <?php echo Yii::t('app', 'Update');?> ProfileComment #<?php echo $model->id; ?> </h1>
<?php
$this->renderPartial('_form', array(
			'model'=>$model));
?>
