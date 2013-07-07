<?php
$this->breadcrumbs=array(
	Yum::t('Payments')=>array(Yii::t('app', 'index')),
	Yum::t('Create'),
);

?>

<h1> <?php echo Yum::t('Create new payment type'); ?> </h1>
<?php
$this->renderPartial('_form', array(
			'model' => $model,
			'buttons' => 'create'));

?>

