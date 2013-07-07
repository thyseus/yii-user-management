<?php
$this->breadcrumbs=array(
'Payments'=>array('index'),
	$model->id,
	);
?>

<h1><?php echo Yii::t('app', 'View');?> Payment #<?php echo $model->id; ?></h1>

<?php
$locale = CLocale::getInstance(Yii::app()->language);

 $this->widget('zii.widgets.CDetailView', array(
'data'=>$model,
	'attributes'=>array(
		'title',
		'text',
),
	)); ?>


<ul>
<?php foreach($model->memberships as $foreignobj) { 

					printf('<li>%s</li>', CHtml::link($foreignobj->start, array('membership/view', 'id' => $foreignobj->id)));

					} ?></ul>
