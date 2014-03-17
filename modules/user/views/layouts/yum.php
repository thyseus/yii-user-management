<?php 
Yii::app()->clientScript->registerCssFile(
  Yii::app()->getAssetManager()->publish(
    Yii::getPathOfAlias('user.assets.css').'/yum.css'));

$this->beginContent(Yum::module()->baseLayout); ?>

<div class="span12">
<?php
if (Yum::module()->debug) {
  echo CHtml::openTag('div', array('class' => 'container yumwarning'));
  echo Yum::t(
    'You are running the Yii User Management Module {version} in Debug Mode!', array(
      '{version}' => Yum::module()->version));
  echo CHtml::closeTag('div');
}
?>

<div class="container">
<?php echo Yum::renderFlash(); ?>
</div>

<div class="container">
<?php echo $content; ?>
</div>
</div>

<?php $this->endContent(); ?>
