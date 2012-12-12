<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'translation-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
)); ?>


	<?php echo Yum::requiredFieldNote(); ?>

	<?php echo $form->errorSummary($models); ?>

	<div class="row">
		<?php echo $form->labelEx($models[0],'message'); ?>
		<?php echo $form->textField($models[0],'message'); ?>
		<?php echo $form->error($models[0],'message'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($models[0],'category'); ?>
		<?php echo $form->textField($models[0],'category'); ?>
		<?php echo $form->error($models[0],'category'); ?>
	</div>

	<hr />

	<?php foreach($models as $model) { ?>
	<div style="float: left; width: 200px;"> 
	<div class="row">
	<?php echo CHtml::label($model->language, 'translation_'.$model->language); ?>
	<?php echo CHtml::textField('translation_'.$model->language, $model->translation); ?>
	</div>

	</div>
	<?php } ?>

<div style="clear: both;"> </div>
<div class="row buttons">
<?php echo CHtml::submitButton($models[0]->isNewRecord 
		? Yum::t('Create') : Yum::t('Save')); ?>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
