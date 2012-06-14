<p class="note"><? echo Yii::t('app','Fields with');?> <span class="required">*</span> <? echo Yii::t('app','are required');?>.</p>


<? if(isset($_POST['returnUrl']))

		echo CHtml::hiddenField('returnUrl', $_POST['returnUrl']); ?>
<? echo $form->errorSummary($model); ?>

		<div class="row">
<? echo $form->labelEx($model,'language'); ?>
<? echo CHtml::activeDropDownList($model, 'language', array(
			'en' => Yum::t('en') ,
			'de' => Yum::t('de') ,
			'fr' => Yum::t('fr') ,
			'pl' => Yum::t('pl') ,
			'ru' => Yum::t('ru') ,
			'es' => Yum::t('es') ,
)); ?>
<? echo $form->error($model,'language'); ?>
</div>

		<div class="row">
<? echo $form->labelEx($model,'text_email_registration'); ?>
<? echo $form->textArea($model,'text_email_registration',array('rows'=>6, 'cols'=>50)); ?>
<? echo $form->error($model,'text_email_registration'); ?>
</div>

		<div class="row">
<? echo $form->labelEx($model,'subject_email_registration'); ?>
<? echo $form->textArea($model,'subject_email_registration',array('rows'=>6, 'cols'=>50)); ?>
<? echo $form->error($model,'subject_email_registration'); ?>
</div>

		<div class="row">
<? echo $form->labelEx($model,'text_email_recovery'); ?>
<? echo $form->textArea($model,'text_email_recovery',array('rows'=>6, 'cols'=>50)); ?>
<? echo $form->error($model,'text_email_recovery'); ?>
</div>

		<div class="row">
<? echo $form->labelEx($model,'text_email_activation'); ?>
<? echo $form->textArea($model,'text_email_activation',array('rows'=>6, 'cols'=>50)); ?>
<? echo $form->error($model,'text_email_activation'); ?>
</div>

	<div class="row">
<? echo $form->labelEx($model,'text_friendship_new'); ?>
<? echo $form->textArea($model,'text_friendship_new',array('rows'=>6, 'cols'=>50)); ?>
<? echo $form->error($model,'text_friendship_new'); ?>
</div>

	<div class="row">
<? echo $form->labelEx($model,'text_profilecomment_new'); ?>
<? echo $form->textArea($model,'text_profilecomment_new',array('rows'=>6, 'cols'=>50)); ?>
<? echo $form->error($model,'text_profilecomment_new'); ?>
</div>

	<div class="row">
<? echo $form->labelEx($model,'text_message_new'); ?>
<? echo $form->textArea($model,'text_message_new',array('rows'=>6, 'cols'=>50)); ?>
<? echo $form->error($model,'text_message_new'); ?>
</div>
	<div class="row">
<? echo $form->labelEx($model,'text_membership_ordered'); ?>
<? echo $form->textArea($model,'text_membership_ordered',array('rows'=>6, 'cols'=>50)); ?>
<? echo $form->error($model,'text_membership_ordered'); ?>
</div>
	<div class="row">
<? echo $form->labelEx($model,'text_payment_arrived'); ?>
<? echo $form->textArea($model,'text_payment_arrived',array('rows'=>6, 'cols'=>50)); ?>
<? echo $form->error($model,'text_payment_arrived'); ?>
</div>

