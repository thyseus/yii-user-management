<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'yum-message-form',
			'action' => array('//message/message/compose'),
			'enableAjaxValidation'=>true,
			)); ?>

<?php echo Yum::requiredFieldNote(); 

	echo CHtml::hiddenField('YumMessage[to_user_id]', $to_user_id);
	echo CHtml::hiddenField('YumMessage[answered]', $answer_to);
	echo Yum::t('This message will be sent to {username}', array(
				'{username}' => YumUser::model()->findByPk($to_user_id)->username));
?>

<div class="row">
<?php echo $form->labelEx($model,'title'); ?>
<?php echo $form->textField($model,'title',array('size'=>45,'maxlength'=>45)); ?>
<?php echo $form->error($model,'title'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'message'); ?>
<?php echo $form->textArea($model,'message',array('rows'=>6, 'cols'=>50)); ?>
<?php echo $form->error($model,'message'); ?>
</div>

<div class="row buttons">

<?php echo CHtml::submitButton(Yum::t('Reply')); ?>

</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
