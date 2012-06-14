<? 
$this->pageTitle = Yum::t('Password recovery');

$this->breadcrumbs=array(
	Yum::t('Login') => Yum::module()->loginUrl,
	Yum::t('Restore'));

?>
<? if(Yum::hasFlash()) {
echo '<div class="success">';
echo Yum::getFlash(); 
echo '</div>';
} else {
echo '<h2>'.Yum::t('Password recovery').'</h2>';
?>

<div class="form">
<? echo CHtml::beginForm(); ?>

	<? echo CHtml::errorSummary($form); ?>
	
	<div class="row">
		<? echo CHtml::activeLabel($form,'login_or_email'); ?>
		<? echo CHtml::activeTextField($form,'login_or_email') ?>
		<p class="hint"><? echo Yum::t("Please enter your user name or email address."); ?></p>
	</div>
	
	<div class="row submit">
		<? echo CHtml::submitButton(Yum::t('Restore')); ?>
	</div>

<? echo CHtml::endForm(); ?>
</div><!-- form -->
<? } ?>
