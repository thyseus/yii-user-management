<?
$this->title = Yum::t('Create new payment type');
$this->breadcrumbs=array(
	Yum::t('Payments')=>array(Yii::t('app', 'index')),
	Yum::t('Create'),
);

$this->renderPartial('_form', array(
			'model' => $model,
			'buttons' => 'create'));
