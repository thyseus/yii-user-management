<p class="note"><?php echo Yii::t('app','Fields with');?> <span class="required">*</span> <?php echo Yii::t('app','are required');?>.</p>


<?php if(isset($_POST['returnUrl']))

		echo CHtml::hiddenField('returnUrl', $_POST['returnUrl']); ?>
<?php echo $form->errorSummary($model); ?>

		<div class="row">
<?php echo $form->labelEx($model,'language'); ?>
<?php echo CHtml::activeDropDownList($model, 'language', array(
			'en' => Yum::t('en') ,
			'de' => Yum::t('de') ,
			'fr' => Yum::t('fr') ,
			'pl' => Yum::t('pl') ,
			'ru' => Yum::t('ru') ,
			'es' => Yum::t('es') ,
)); ?>
<?php echo $form->error($model,'language'); ?>
</div>

		<div class="row">
<?php echo $form->labelEx($model,'text_email_registration'); ?>
<?php echo $form->textArea($model,'text_email_registration',array('rows'=>6, 'cols'=>50)); ?>
<?php echo $form->error($model,'text_email_registration'); ?>
</div>

		<div class="row">
<?php echo $form->labelEx($model,'subject_email_registration'); ?>
<?php echo $form->textArea($model,'subject_email_registration',array('rows'=>6, 'cols'=>50)); ?>
<?php echo $form->error($model,'subject_email_registration'); ?>
</div>

		<div class="row">
<?php echo $form->labelEx($model,'text_email_recovery'); ?>
<?php echo $form->textArea($model,'text_email_recovery',array('rows'=>6, 'cols'=>50)); ?>
<?php echo $form->error($model,'text_email_recovery'); ?>
</div>

		<div class="row">
<?php echo $form->labelEx($model,'text_email_activation'); ?>
<?php echo $form->textArea($model,'text_email_activation',array('rows'=>6, 'cols'=>50)); ?>
<?php echo $form->error($model,'text_email_activation'); ?>
</div>

	<div class="row">
<?php echo $form->labelEx($model,'text_friendship_new'); ?>
<?php echo $form->textArea($model,'text_friendship_new',array('rows'=>6, 'cols'=>50)); ?>
<?php echo $form->error($model,'text_friendship_new'); ?>
</div>

	<div class="row">
<?php echo $form->labelEx($model,'text_profilecomment_new'); ?>
<?php echo $form->textArea($model,'text_profilecomment_new',array('rows'=>6, 'cols'=>50)); ?>
<?php echo $form->error($model,'text_profilecomment_new'); ?>
</div>

	<div class="row">
<?php echo $form->labelEx($model,'text_message_new'); ?>
<?php echo $form->textArea($model,'text_message_new',array('rows'=>6, 'cols'=>50)); ?>
<?php echo $form->error($model,'text_message_new'); ?>
</div>
	<div class="row">
<?php echo $form->labelEx($model,'text_membership_ordered'); ?>
<?php echo $form->textArea($model,'text_membership_ordered',array('rows'=>6, 'cols'=>50)); ?>
<?php echo $form->error($model,'text_membership_ordered'); ?>
</div>
	<div class="row">
<?php echo $form->labelEx($model,'text_payment_arrived'); ?>
<?php echo $form->textArea($model,'text_payment_arrived',array('rows'=>6, 'cols'=>50)); ?>
<?php echo $form->error($model,'text_payment_arrived'); ?>
</div>

