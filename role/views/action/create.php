<?
$this->breadcrumbs=array(
	Yum::t('Actions')=>array('index'),
	Yum::t('Create'),
);

?>

<h1> <? echo Yum::t('Create Action'); ?></h1>

<? echo $this->renderPartial('_form', array('model'=>$model)); ?>
