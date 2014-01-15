<div class="form">
<p class="note">
<?php echo Yum::t('Fields with <span class="required">*</span> are required.');?>
</p>

<?php $form=$this->beginWidget('CActiveForm', array(
'id'=>'usergroup-form',
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
<?php echo $form->labelEx($model,'description'); ?>
<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
<?php echo $form->error($model,'description'); ?>
</div>

<?php
echo CHtml::Button(Yum::t('Cancel'), array(
			'submit' => array('groups/index'))); 
echo CHtml::submitButton($model->isNewRecord ? Yum::t('Create') : Yum::t('Save')); 
$this->endWidget(); ?>
</div> <!-- form -->
