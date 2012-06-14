<?
$this->breadcrumbs=array(
	Yum::t('Payments')=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('app', 'Update'),
);

?>

<h1> <? echo Yum::t('Update payment');?>: <? echo $model->title; ?> </h1>
<?
$this->renderPartial('_form', array(
			'model'=>$model));
?>
