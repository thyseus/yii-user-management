<?php if(Yum::module()->enablepStrength) {  
Yum::register('js/pStrength.jquery.js'); 
Yii::app()->clientScript->registerScript('', "
	$('#YumUserChangePassword_password').pStrength({
		'onPasswordStrengthChanged' : function(passwordStrength, percentage) {
		$('#password-strength').html('".Yum::t('Password strength').":' + percentage + '%');
		},
});
");
}
?>

<div class="row">
<?php echo CHtml::activeLabelEx($form,'password'); ?>
<?php echo CHtml::activePasswordField($form,'password'); ?>
</div>

<?php if(Yum::module()->displayPasswordStrength) { ?>
<div id="password-strength"></div>
<?php } ?>


<div class="row">
<?php echo CHtml::activeLabelEx($form,'verifyPassword'); ?>
<?php echo CHtml::activePasswordField($form,'verifyPassword'); ?>
</div>

