<?
$this->breadcrumbs=array(
	'Usergroups'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	Yii::t('app', 'Update'),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'List') . ' Usergroup', 'url'=>array('index')),
	array('label'=>Yii::t('app', 'Create') . ' Usergroup', 'url'=>array('create')),
	array('label'=>Yii::t('app', 'View') . ' Usergroup', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('app', 'Manage') . ' Usergroup', 'url'=>array('admin')),
);
?>

<h1> <? echo Yii::t('app', 'Update');?> Usergroup #<? echo $model->id; ?> </h1>
<?
$this->renderPartial('_form', array(
			'model'=>$model));
?>
