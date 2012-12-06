<?
$this->title = Yum::t('Create Action');
$this->breadcrumbs=array(
	Yum::t('Actions')=>array('index'),
	Yum::t('Create'),
);
$this->renderPartial('_form', array('model'=>$model));
