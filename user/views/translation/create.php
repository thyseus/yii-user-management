<?
$this->breadcrumbs=array(
	Yum::t('Translation')=>array('index'),
	Yum::t('Create'),
);

?>

<h2> <? echo Yum::t('Create translation'); ?> </h2>

<? echo $this->renderPartial('_form', array('model'=>$model)); ?>
