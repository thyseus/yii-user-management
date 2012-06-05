<?php
$this->title = Yum::t('Update role');

$this->breadcrumbs=array(
	Yum::t('Roles')=>array('index'),
	Yum::t('Update'));

?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
