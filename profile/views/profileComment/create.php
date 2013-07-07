<div class="form">
<p class="note"> <?php echo Yum::requiredFieldNote(); ?> </p>

<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'profile-comment-form',
			'enableAjaxValidation'=>true,
			)); 
echo $form->errorSummary($comment);

echo CHtml::hiddenField('YumProfileComment[profile_id]', $profile->id); ?>

<div class="row">
<?php echo $form->labelEx($comment,'comment'); ?>
<?php echo $form->textArea($comment,'comment',array('rows'=>6, 'cols'=>50)); ?>
<?php echo $form->error($comment,'comment'); ?>
</div>

<?php
echo CHtml::Button(Yum::t('Write comment'), array(
			'id' => 'write_comment',
			));

Yii::app()->clientScript->registerScript("write_comment", " 
		$('#write_comment').unbind('click');
		$('#write_comment').click(function(){
			jQuery.ajax({'type':'POST',
				'url':'".$this->createUrl('//profile/comments/create')."',
				'cache':false,
				'data':jQuery(this).parents('form').serialize(),
				'success':function(html){
				$('#profile').html(html);
				}});
			return false;});
		");


$this->endWidget(); ?>

</div>
