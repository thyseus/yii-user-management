<div class="form">
<p class="note">
<? echo Yii::t('app','Fields with');?> <span class="required">*</span> <? echo Yii::t('app','are required');?>.
</p>

<? $form=$this->beginWidget('CActiveForm', array(
'id'=>'membership-form',
	'enableAjaxValidation'=>true,
	)); 
	echo $form->errorSummary($model);
?>
	<div class="row">
<? echo $form->labelEx($model,'type'); ?>
<? echo CHtml::activeRadioButtonList($model, 'type', CHtml::listData(
YumRole::model()->findAll('price != 0'), 'id', 'title')); ?>
<? echo $form->error($model,'type'); ?>
</div>

<?
echo CHtml::Button(Yii::t('app', 'Cancel'), array(
			'submit' => array('membership/index'))); 
echo CHtml::submitButton(Yum::t('Buy membership')); 
$this->endWidget(); ?>
</div> <!-- form -->
