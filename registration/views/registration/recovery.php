<?php 
$this->pageTitle = Yum::t('Password recovery');

$this->breadcrumbs=array(
	Yum::t('Login') => Yum::module()->loginUrl,
	Yum::t('Restore'));

?>
<?php if(Yum::hasFlash()) {
echo '<div class="success">';
echo Yum::getFlash(); 
echo '</div>';
} else {
echo '<h2>'.Yum::t('Password recovery').'</h2>';
?>

<div class="form">
<?php echo CHtml::beginForm(); ?>

	<?php echo CHtml::errorSummary($form); ?>
	
	<div class="row">
		<?php echo CHtml::activeLabel($form,'login_or_email'); ?>
		<?php echo CHtml::activeTextField($form,'login_or_email') ?>
		<p class="hint"><?php echo Yum::t("Please enter your user name or email address."); ?></p>
	</div>
	
	<div class="row submit">
		<?php echo CHtml::submitButton(Yum::t('Restore')); ?>
	</div>

<?php echo CHtml::endForm(); ?>
</div><!-- form -->
<?php } ?>
