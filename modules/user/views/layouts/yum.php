<?php 
	Yii::app()->clientScript->registerCssFile(
  	Yii::app()->getAssetManager()->publish(
    	Yii::getPathOfAlias('user.assets.css').'/yum.css'));
	$this->beginContent(Yum::module()->baseLayout); ?>
<?php
	if (Yum::module()->debug) {
	  echo CHtml::openTag('div', array('class' => 'alert alert-danger'));
	  echo sprintf(
		'You are running the Yii User Management Module %s in Debug Mode!',
		Yum::module()->version);
	  echo CHtml::closeTag('div');
	}
?>

<?php echo Yum::renderFlash(); ?>
<?php echo $content; ?>
<?php $this->endContent(); ?>