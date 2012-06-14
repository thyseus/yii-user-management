<? 
Yii::app()->clientScript->registerCssFile(
		Yii::app()->getAssetManager()->publish(
			Yii::getPathOfAlias('YumAssets').'/css/yum.css'));

$module = Yii::app()->getModule('user');
$this->beginContent($module->baseLayout); ?>

<div id="usermenu">
<? Yum::renderFlash(); ?>
<? 
if(Yum::hasModule('message')) {
	Yii::import('application.modules.message.components.*');
	$this->widget('MessageWidget');
}
if(Yum::hasModule('profile') && Yum::module('profile')->enableProfileVisitLogging) {
	Yii::import('application.modules.profile.components.*');
	$this->widget('ProfileVisitWidget'); 
}
$this->renderMenu(); ?>

</div>

<div id="usercontent">
<? echo $content;  ?>
</div>

<? $this->endContent(); ?>
