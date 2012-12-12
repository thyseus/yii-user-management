<div class="form">
<p class="note">
<?php echo Yii::t('app','Fields with');?> <span class="required">*</span> <?php echo Yii::t('app','are required');?>.
</p>

<?php $form=$this->beginWidget('CActiveForm', array(
'id'=>'membership-form',
	'enableAjaxValidation'=>true,
	)); 
	echo $form->errorSummary($model);
?>
	<div class="row">
<?php echo $form->labelEx($model,'type'); ?>
<?php echo CHtml::activeRadioButtonList($model, 'type', CHtml::listData(
YumRole::model()->findAll('price != 0'), 'id', 'title')); ?>
<?php echo $form->error($model,'type'); ?>
</div>

<?php
echo CHtml::Button(Yii::t('app', 'Cancel'), array(
			'submit' => array('membership/index'))); 
echo CHtml::submitButton(Yum::t('Buy membership')); 
$this->endWidget(); ?>
</div> <!-- form -->
