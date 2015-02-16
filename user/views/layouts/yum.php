<?php
Yii::app()->clientScript->registerCssFile(
  Yii::app()->getAssetManager()->publish(
    Yii::getPathOfAlias('user.assets.css').'/yum.css'));

$this->beginContent(Yum::module()->baseLayout);

echo Yum::renderFlash();

echo $content;

$this->endContent();
?>
