<?php
$this->breadcrumbs=array(
	Yum::t('Actions')=>array('index'),
	Yum::t('Create'),
);

?>

<h1> <?php echo Yum::t('Create Action'); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
