<div class="form">
<? $form=$this->beginWidget('CActiveForm', array(
	'id'=>'profile-comment-form',
	'enableAjaxValidation'=>true,
)); 
	echo $form->errorSummary($model);
?>
<div class="row">
<? echo $form->labelEx($model,'user_id'); ?>
<? echo $form->textField($model,'user_id'); ?>
<? echo $form->error($model,'user_id'); ?>
</div>

<div class="row">
<? echo $form->labelEx($model,'profile_id'); ?>
<? echo $form->textField($model,'profile_id'); ?>
<? echo $form->error($model,'profile_id'); ?>
</div>

<div class="row">
<? echo $form->labelEx($model,'comment'); ?>
<? echo $form->textArea($model,'comment',array('rows'=>6, 'cols'=>50)); ?>
<? echo $form->error($model,'comment'); ?>
</div>

<div class="row">
<? echo $form->labelEx($model,'createTime'); ?>
<? echo $form->textField($model,'createTime'); ?>
<? echo $form->error($model,'createTime'); ?>
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
