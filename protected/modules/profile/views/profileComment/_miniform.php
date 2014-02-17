<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'profile-comment-form',
	'enableAjaxValidation'=>true,
)); 
	echo $form->errorSummary($model);
?>
<div class="row">
<?php echo $form->labelEx($model,'user_id'); ?>
<?php echo $form->textField($model,'user_id'); ?>
<?php echo $form->error($model,'user_id'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'profile_id'); ?>
<?php echo $form->textField($model,'profile_id'); ?>
<?php echo $form->error($model,'profile_id'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'comment'); ?>
<?php echo $form->textArea($model,'comment',array('rows'=>6, 'cols'=>50)); ?>
<?php echo $form->error($model,'comment'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'createtime'); ?>
<?php echo $form->textField($model,'createtime'); ?>
<?php echo $form->error($model,'createtime'); ?>
</div>


<?php
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
