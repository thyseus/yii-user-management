<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'membership-form',
	'enableAjaxValidation'=>true,
)); 
	echo $form->errorSummary($model);
?>
<div class="row">
<?php echo $form->labelEx($model,'type'); ?>
<?php echo CHtml::activeDropDownList($model, 'type', array(
			'BASIS' => Yii::t('app', 'BASIS') ,
			'BUSINESS' => Yii::t('app', 'BUSINESS') ,
)); ?>
<?php echo $form->error($model,'type'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'fee'); ?>
<?php echo $form->textField($model,'fee'); ?>
<?php echo $form->error($model,'fee'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'period'); ?>
<?php echo $form->textField($model,'period'); ?>
<?php echo $form->error($model,'period'); ?>
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
