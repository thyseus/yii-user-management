<?php
$this->breadcrumbs=array(
	Yum::t('Payments')=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('app', 'Update'),
);

?>

<h1> <?php echo Yum::t('Update payment');?>: <?php echo $model->title; ?> </h1>
<?php
$this->renderPartial('_form', array(
			'model'=>$model));
?>
