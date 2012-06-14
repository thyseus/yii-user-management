<?
$this->breadcrumbs=array(
	Yum::t('Payments')=>array(Yii::t('app', 'index')),
	Yum::t('Create'),
);

?>

<h1> <? echo Yum::t('Create new payment type'); ?> </h1>
<?
$this->renderPartial('_form', array(
			'model' => $model,
			'buttons' => 'create'));

?>

