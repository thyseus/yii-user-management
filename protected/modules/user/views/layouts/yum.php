<?php 
Yii::app()->clientScript->registerCssFile(
		Yii::app()->getAssetManager()->publish(
			Yii::getPathOfAlias('YumModule.assets.css').'/yum.css'));

$this->beginContent(Yum::module()->baseLayout); ?>

<div class="span12">
<?php
if (Yum::module()->debug) {
	echo CHtml::openTag('div', array('class' => 'yumwarning'));
	echo Yum::t(
			'You are running the Yii User Management Module {version} in Debug Mode!', array(
				'{version}' => Yum::module()->version));
	echo CHtml::closeTag('div');
}

Yum::renderFlash(); 

if(!Yii::app()->user->isGuest)
	echo $this->renderMenu();
echo $content;  
?>
</div>

<?php $this->endContent(); ?>
