<div class="form">

<? $form=$this->beginWidget('CActiveForm', array(
			'id'=>'yum-message-form',
			'action' => array('//message/message/compose'),
			'enableAjaxValidation'=>true,
			)); ?>

<? echo Yum::requiredFieldNote(); 

	echo CHtml::hiddenField('YumMessage[to_user_id]', $to_user_id);
	echo CHtml::hiddenField('YumMessage[answered]', $answer_to);
	echo Yum::t('This message will be sent to {username}', array(
				'{username}' => YumUser::model()->findByPk($to_user_id)->username));
?>

<div class="row">
<? echo $form->labelEx($model,'title'); ?>
<? echo $form->textField($model,'title',array('size'=>45,'maxlength'=>45)); ?>
<? echo $form->error($model,'title'); ?>
</div>

<div class="row">
<? echo $form->labelEx($model,'message'); ?>
<? echo $form->textArea($model,'message',array('rows'=>6, 'cols'=>50)); ?>
<? echo $form->error($model,'message'); ?>
</div>

<div class="row buttons">

<? echo CHtml::submitButton(Yum::t('Reply')); ?>

</div>

<? $this->endWidget(); ?>

</div><!-- form -->
