<div class="form">

<? $form=$this->beginWidget('CActiveForm', array(
	'id'=>'translation-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
)); ?>


	<? echo Yum::requiredFieldNote(); ?>

	<? echo $form->errorSummary($models); ?>

	<div class="row">
		<? echo $form->labelEx($models[0],'message'); ?>
		<? echo $form->textField($models[0],'message'); ?>
		<? echo $form->error($models[0],'message'); ?>
	</div>

	<div class="row">
		<? echo $form->labelEx($models[0],'category'); ?>
		<? echo $form->textField($models[0],'category'); ?>
		<? echo $form->error($models[0],'category'); ?>
	</div>

	<hr />

	<? foreach($models as $model) { ?>
	<div style="float: left; width: 200px;"> 
	<div class="row">
	<? echo CHtml::label($model->language, 'translation_'.$model->language); ?>
	<? echo CHtml::textField('translation_'.$model->language, $model->translation); ?>
	</div>

	</div>
	<? } ?>

<div style="clear: both;"> </div>
<div class="row buttons">
<? echo CHtml::submitButton($models[0]->isNewRecord 
		? Yum::t('Create') : Yum::t('Save')); ?>
</div>

<? $this->endWidget(); ?>

</div><!-- form -->
