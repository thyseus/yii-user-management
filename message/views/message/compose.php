<?php 
if(!$this->title) 
	$this->title = Yum::t('Compose new message'); 
if($this->breadcrumbs == array())
	$this->breadcrumbs = array(Yum::t('Messages'), Yum::t('Compose'));
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'yum-message-form',
			'action' => array('//message/message/compose'),
			'enableAjaxValidation'=>true,
			'enableClientValidation'=>true,
			)); ?>

<?php echo Yum::requiredFieldNote(); 

echo $form->errorSummary($model); 

echo CHtml::hiddenField('YumMessage[answered]', $answer_to);

if($to_user_id) {
	echo CHtml::hiddenField('YumMessage[to_user_id]', $to_user_id);
	echo Yum::t('This message will be sent to {username}', array(
				'{username}' => YumUser::model()->findByPk($to_user_id)->username));
} else {
	echo $form->label($model, 'to_user_id');
	echo $form->dropDownList($model, 'to_user_id', 
			CHtml::listData(Yii::app()->user->data()->getFriends(), 'id', 'username'));
	echo '<div class="hint">'.Yum::t('Only your friends are shown here').'</div>';

}
?>
<div class="row">
<?php echo $form->labelEx($model,'title'); ?>
<?php echo $form->textField($model,'title',array('size'=>45,'maxlength'=>45)); ?>
<?php echo $form->error($model,'title'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'message'); ?>
<?php echo $form->textArea($model,'message',array('rows'=>6, 'cols'=>50)); ?>
<?php echo $form->error($model,'message'); ?>
</div>

<div class="row buttons">

<?php echo CHtml::submitButton($model->isNewRecord 
			? Yum::t('Send') 
			: Yum::t('Save'));
?>

</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
