<?php
$this->breadcrumbs=array(
	Yum::t('Translation')=>array('admin'),
	sprintf('%s-%s-%s',
$models[0]->language,
$models[0]->category,
$models[0]->message),
	Yum::t('Update'),
);

?>

<h2>
<?php

if($models[0]->isNewRecord)
	echo Yum::t('New translation');
	else
	echo Yum::t('Update translation {message}', array(
				'{message}' => $models[0]->message)); ?></h2>

<?php echo $this->renderPartial('_form', array('models'=>$models)); ?>
