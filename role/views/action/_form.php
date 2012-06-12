<div class="form">

<? $form=$this->beginWidget('CActiveForm', array(
	'id'=>'action-form',
	'enableAjaxValidation'=>false,
)); 

echo Yum::requiredFieldNote();
?>

	<? echo $form->errorSummary($model); ?>

	<div class="row">
		<? echo $form->labelEx($model,'title'); ?>
		<? echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<? echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<? echo $form->labelEx($model,'comment'); ?>
		<? echo $form->textArea($model,'comment',array('rows'=>6, 'cols'=>50)); ?>
		<? echo $form->error($model,'comment'); ?>
	</div>

	<div class="row">
		<? echo $form->labelEx($model,'subject'); ?>
		<? echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>255)); ?>
		<? echo $form->error($model,'subject'); ?>
	</div>

	<div class="row buttons">
	<? echo CHtml::submitButton($model->isNewRecord 
			? Yum::t('Create') 
			: Yum::t('Save')); ?>
	</div>

<? $this->endWidget(); ?>

</div><!-- form -->
