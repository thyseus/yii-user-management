<div class="form">
<p class="note">
<? echo Yum::requiredFieldNote(); ?>
</p>

<? $form=$this->beginWidget('CActiveForm', array(
'id'=>'payment-form',
	'enableAjaxValidation'=>true,
	)); 
	echo $form->errorSummary($model);
?>
	<div class="row">
<? echo $form->labelEx($model,'title'); ?>
<? echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
<? echo $form->error($model,'title'); ?>
</div>

<div class="row">
<? echo $form->labelEx($model,'text'); ?>
<? echo $form->textArea($model,'text',array('rows'=>6, 'cols'=>50)); ?>
<? echo $form->error($model,'text'); ?>
</div>


<?
echo CHtml::Button(Yum::t('Cancel'), array(
			'submit' => array('payment/admin'))); 
echo CHtml::submitButton($model->isNewRecord
		?Yum::t('Create payment type')
		:Yum::t('Save payment type')
		); 
$this->endWidget(); ?>
</div> <!-- form -->
