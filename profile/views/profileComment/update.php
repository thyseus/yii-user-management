<?
$this->title = Yum::t('app', 'Update')." ProfileComment #".$model->id;
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

$this->renderPartial('_form', array(
			'model'=>$model));
