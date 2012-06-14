<? 
Yii::app()->clientScript->registerCssFile(
		Yii::app()->getAssetManager()->publish(
			Yii::getPathOfAlias('application.modules.user.assets.css').'/yum.css'));

$module = Yum::module();
$this->beginContent($module->baseLayout); ?>

<div id="usermenu">

<? Yum::renderFlash(); ?>
<? $this->renderMenu(); ?>
</div>

<div id="usercontent">
<?
if (Yum::module()->debug) {
	echo CHtml::openTag('div', array(
				'style' => 'background-color: red;color:white;padding:5px;'));
	echo Yum::t('You are running the Yii User Management Module {version} in Debug Mode!', array(
				'{version}' => Yum::module()->version));
	echo CHtml::closeTag('div');
}
?>

<? 
if($this->title)
	printf('<h2> %s </h2>', $this->title);  ?>
	<? echo $content;  ?>
</div>

<? $this->endContent(); ?>
