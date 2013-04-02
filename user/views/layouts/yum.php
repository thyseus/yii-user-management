<?php 
Yii::app()->clientScript->registerCssFile(
		Yii::app()->getAssetManager()->publish(
			Yii::getPathOfAlias('YumModule.assets.css').'/yum.css'));

$this->beginContent(Yum::module()->baseLayout); ?>

<div class="span8">
<?php
if (Yum::module()->debug) {
	echo CHtml::openTag('div', array('class' => 'yumwarning'));
	echo Yum::t(
			'You are running the Yii User Management Module {version} in Debug Mode!', array(
				'{version}' => Yum::module()->version));
	echo CHtml::closeTag('div');
}

 Yum::renderFlash(); 

if($this->title)
	printf('<h1> %s </h1>', $this->title);  
	echo $content;  
?>
</div>

<div class="span3">
<?php $this->renderMenu(); ?>
</div>

<div class="clearfix"></div>

<?php $this->endContent(); ?>
