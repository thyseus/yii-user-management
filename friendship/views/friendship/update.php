<?
$this->breadcrumbs=array(
	Yum::t('Friendships')=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);
?>

<h1>Update Friendship #<? echo $model->id; ?></h1>

<? echo $this->renderPartial('_form', array('model'=>$model)); ?>
