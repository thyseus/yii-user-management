<?php 
$this->pageTitle = Yum::t("change password");
echo '<h1>'. Yum::t('change password') .'</h1>';

$this->breadcrumbs = array(
	Yum::t("Change password"));

if(isset($expired) && $expired)
	$this->renderPartial('password_expired');
?>


<?php echo CHtml::beginForm(); ?>
	<?php echo Yum::requiredFieldNote(); ?>
	<?php echo CHtml::errorSummary($form); ?>

	<?php if(!Yii::app()->user->isGuest) {
		echo CHtml::activeLabelEx($form,'currentPassword'); 
		echo CHtml::activePasswordField($form,'currentPassword'); 
	} ?>

<?php $this->renderPartial(
		'user.views.user.passwordfields', array(
			'form'=>$form)); ?>

	<div class="submit">
	<?php echo CHtml::submitButton(Yum::t("Save"), array('class' => 'btn')); ?>
	</div>

<?php echo CHtml::endForm(); ?>

