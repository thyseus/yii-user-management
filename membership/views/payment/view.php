<?
$this->breadcrumbs=array(
'Payments'=>array('index'),
	$model->id,
	);
?>

<h1><? echo Yii::t('app', 'View');?> Payment #<? echo $model->id; ?></h1>

<?
$locale = CLocale::getInstance(Yii::app()->language);

 $this->widget('zii.widgets.CDetailView', array(
'data'=>$model,
	'attributes'=>array(
		'title',
		'text',
),
	)); ?>


<ul>
<? foreach($model->memberships as $foreignobj) { 

					printf('<li>%s</li>', CHtml::link($foreignobj->start, array('membership/view', 'id' => $foreignobj->id)));

					} ?></ul>
