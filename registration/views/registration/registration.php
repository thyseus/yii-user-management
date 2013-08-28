<?php if(Yum::module()->enablepStrength) {  
Yum::register('js/pStrength.jquery.js'); 
Yii::app()->clientScript->registerScript('', "
	$('#YumRegistrationForm_password').pStrength({
		'onPasswordStrengthChanged' : function(passwordStrength, percentage) {
		$('#password-strength').html('".Yum::t('Password strength').":' + percentage + '%');
		},
});
");
}
?>
<h1> <?php echo Yum::t('Registration'); ?> </h1>

<?php $this->breadcrumbs = array(Yum::t('Registration')); ?>

<div class="form">
<?php $activeform = $this->beginWidget('CActiveForm', array(
			'id'=>'registration-form',
			'enableAjaxValidation'=>true,
			'enableClientValidation'=>true,
			'focus'=>array($form,'username'),
			));
?>

<div class="row">
<div class="span12">
<?php echo Yum::requiredFieldNote(); ?>
<?php echo CHtml::errorSummary(array($form, $profile)); ?>
</div>
</div>


<div class="row">
<div class="span5"> 
<?php echo $activeform->labelEx($profile,'firstname'); ?>
<?php echo $activeform->textField($profile,'firstname'); ?> 

<?php echo $activeform->labelEx($profile,'lastname'); ?>
<?php echo $activeform->textField($profile,'lastname'); ?>

<?php echo $activeform->labelEx($form,'username'); ?>
<?php echo $activeform->textField($form,'username'); ?> 
</div>
<div class="span5"> 
<?php echo $activeform->labelEx($profile,'email'); ?>
<?php echo $activeform->textField($profile,'email'); ?> 

<?php echo $activeform->labelEx($form,'password'); ?>
<?php echo $activeform->passwordField($form,'password'); ?>

<?php if(Yum::module()->displayPasswordStrength) { ?>
<div id="password-strength"></div>
<?php } ?>

<?php echo $activeform->labelEx($form,'verifyPassword'); ?>
<?php echo $activeform->passwordField($form,'verifyPassword'); ?>


</div>
</div>


<?php if(extension_loaded('gd') 
			&& Yum::module('registration')->enableCaptcha): ?>
	<div class="row">
    	<div class="span12">
		<?php echo CHtml::activeLabelEx($form,'verifyCode'); ?>
		<div>
		<?php $this->widget('CCaptcha'); ?>
		<?php echo CHtml::activeTextField($form,'verifyCode'); ?>
		</div>
		<p class="hint">
		<?php echo Yum::t('Please enter the letters as they are shown in the image above.'); ?>
		<br/><?php echo Yum::t('Letters are not case-sensitive.'); ?></p>
	</div></div>
	<?php endif; ?>

	<div class="row submit">
    <div class="span12">
		<?php echo CHtml::submitButton(Yum::t('Registration'), array('class'=>'btn')); ?>
        </div>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
