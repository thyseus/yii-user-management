<?php 
$this->pageTitle = Yii::app()->name . ' - ' . Yum::t("change password");
echo '<h2>'. Yum::t('change password') .'</h2>';

$this->breadcrumbs = array(
	Yum::t("Change password"));

if(isset($expired) && $expired)
	$this->renderPartial('password_expired');
?>

<div class="form">
<?php echo CHtml::beginForm(); ?>
	<?php echo Yum::requiredFieldNote(); ?>
	<?php echo CHtml::errorSummary($form); ?>

	<?php if(!Yii::app()->user->isGuest) {
		echo '<div class="row">';
		echo CHtml::activeLabelEx($form,'currentPassword'); 
		echo CHtml::activePasswordField($form,'currentPassword'); 
		echo '</div>';
	} ?>

<?php $this->renderPartial(
		'application.modules.user.views.user.passwordfields', array(
			'form'=>$form)); ?>

	<div class="row submit">
	<?php echo CHtml::submitButton(Yum::t("Save")); ?>
	</div>

<?php echo CHtml::endForm(); ?>
</div><!-- form -->
