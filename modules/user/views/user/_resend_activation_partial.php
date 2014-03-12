<div class="form">
<?php echo CHtml::beginForm(array('registration/ResendActivation'),'POST',array()); ?>

	<div id="email">
	<?php if(isset($form->email)){
echo CHtml::hiddenField('email',$form->email);
 }else{
	echo CHtml::activeLabelEx($user,'email');
	echo CHtml::textField('email',$form->email);
		}
?>
	</div>
	<div id="resend_activation_text">
	<?php echo Yii::t("UserModule.user", "If you failed to recieve the activation email, click the Resend Activation button."); ?>
	</div>
	<div class="row_submit">
		<?php echo CHtml::submitButton(Yii::t("UserModule.user", "Resend Activation")); ?>
	</div>

<?php echo CHtml::endForm(); ?>
</div><!-- form -->

