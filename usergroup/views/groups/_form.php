<div class="form">
<p class="note">
<? echo Yii::t('app','Fields with');?> <span class="required">*</span> <? echo Yii::t('app','are required');?>.
</p>

<? $form=$this->beginWidget('CActiveForm', array(
'id'=>'usergroup-form',
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
<? echo $form->labelEx($model,'description'); ?>
<? echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
<? echo $form->error($model,'description'); ?>
</div>

<?
echo CHtml::Button(Yum::t('Cancel'), array(
			'submit' => array('groups/index'))); 
echo CHtml::submitButton(Yum::t('Save')); 
$this->endWidget(); ?>
</div> <!-- form -->
