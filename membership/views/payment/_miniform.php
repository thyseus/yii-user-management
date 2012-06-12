<div class="form">
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
