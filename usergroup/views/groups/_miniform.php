<div class="form">
<? $form=$this->beginWidget('CActiveForm', array(
	'id'=>'usergroup-form',
	'enableAjaxValidation'=>true,
)); 
	echo $form->errorSummary($model);
?>
<div class="row">
<? echo $form->labelEx($model,'owner_id'); ?>
<? echo $form->textField($model,'owner_id'); ?>
<? echo $form->error($model,'owner_id'); ?>
</div>

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
echo CHtml::Button(
	Yii::t('app', 'Cancel'),
	array(
		'onClick' => "$('#".$relation."_dialog').dialog('close');"
	));
echo CHtml::Button(
	Yii::t('app', 'Create'),
	array(
		'id' => "submit_".$relation
	));
$this->endWidget(); 

?></div> <!-- form -->
