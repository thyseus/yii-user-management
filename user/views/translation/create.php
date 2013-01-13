<?php
$this->breadcrumbs=array(
	Yum::t('Translation')=>array('index'),
	Yum::t('Create'),
);

?>

<h2> <?php echo Yum::t('Create translation'); ?> </h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
