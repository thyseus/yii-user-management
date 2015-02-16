<div class="container">
<?php
Yii::app()->clientScript->registerCssFile(
  Yii::app()->getAssetManager()->publish(
    Yii::getPathOfAlias('user.assets.css').'/yum.css'));

$this->beginContent(Yum::module()->baseLayout);

Yum::renderFlash();

echo $content;
?>

<div class="clearfix"></div>
</div>
<?php $this->endContent(); ?>
