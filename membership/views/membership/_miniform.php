<div class="form">
<? $form=$this->beginWidget('CActiveForm', array(
	'id'=>'membership-form',
	'enableAjaxValidation'=>true,
)); 
	echo $form->errorSummary($model);
?>
<div class="row">
<? echo $form->labelEx($model,'type'); ?>
<? echo CHtml::activeDropDownList($model, 'type', array(
			'BASIS' => Yii::t('app', 'BASIS') ,
			'BUSINESS' => Yii::t('app', 'BUSINESS') ,
)); ?>
<? echo $form->error($model,'type'); ?>
</div>

<div class="row">
<? echo $form->labelEx($model,'fee'); ?>
<? echo $form->textField($model,'fee'); ?>
<? echo $form->error($model,'fee'); ?>
</div>

<div class="row">
<? echo $form->labelEx($model,'period'); ?>
<? echo $form->textField($model,'period'); ?>
<? echo $form->error($model,'period'); ?>
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
