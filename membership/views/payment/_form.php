<div class="form">
<p class="note">
<?php echo Yum::requiredFieldNote(); ?>
</p>

<?php $form=$this->beginWidget('CActiveForm', array(
'id'=>'payment-form',
	'enableAjaxValidation'=>true,
	)); 
	echo $form->errorSummary($model);
?>
	<div class="row">
<?php echo $form->labelEx($model,'title'); ?>
<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
<?php echo $form->error($model,'title'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'text'); ?>
<?php echo $form->textArea($model,'text',array('rows'=>6, 'cols'=>50)); ?>
<?php echo $form->error($model,'text'); ?>
</div>


<?php
echo CHtml::Button(Yum::t('Cancel'), array(
			'submit' => array('payment/admin'))); 
echo CHtml::submitButton($model->isNewRecord
		?Yum::t('Create payment type')
		:Yum::t('Save payment type')
		); 
$this->endWidget(); ?>
</div> <!-- form -->
