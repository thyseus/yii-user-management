<?php
$this->breadcrumbs=array(
	Yum::t('Usergroups')=>array('index'),
        $model->title=>array('view','id'=>$model->id),
        Yum::t('Update')
);

$this->menu=array(
	array('label'=>Yum::t('List Usergroup'), 'url'=>array('index')),
	array('label'=>Yum::t('Create Usergroup'), 'url'=>array('create')),
	array('label'=>Yum::t('View Usergroup'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yum::t('Manage Usergroup'), 'url'=>array('admin')),
);
?>

<h1> <?php echo Yum::t('Update Usergroup'); ?> #<?php echo $model->id; ?> </h1>
<?php
$this->renderPartial('_form', array(
			'model'=>$model));
