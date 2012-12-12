<?php
$this->title = Yum::t('Update payment type').': '.$model->title;
$this->breadcrumbs=array(
	Yum::t('Payments')=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('app', 'Update'),
);


$this->renderPartial('_form', array(
			'model'=>$model));
