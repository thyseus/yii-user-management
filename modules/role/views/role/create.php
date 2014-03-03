<?php
$this->title = Yum::t('Create role');

$this->breadcrumbs=array(
	Yum::t('Roles')=>array('index'),
	Yum::t('Create'));

?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
