<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'action-form',
	'enableAjaxValidation'=>false,
)); 

echo Yum::requiredFieldNote();
?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comment'); ?>
		<?php echo $form->textArea($model,'comment',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'comment'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'subject'); ?>
		<?php echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'subject'); ?>
	</div>

	<div class="row buttons">
	<?php echo CHtml::submitButton($model->isNewRecord 
			? Yum::t('Create') 
			: Yum::t('Save')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
