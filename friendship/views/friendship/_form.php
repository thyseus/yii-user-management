<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'groups-form',
	'enableAjaxValidation'=>false,
)); ?>



	<?php echo $form->errorSummary($model); ?>

	<div class="row">
	<?php echo $form->label($model,'inviter_id'); ?>
	<?php echo $form->textField($model->inviter,'username',array(
				'size'=>20,'maxlength'=>25,'readonly'=>'readonly')); ?>
		<?php echo $form->error($model,'inviter_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php 
		echo CHtml::activeDropDownList($model,
		'status',array('0'=>'No friendship requested','1'=>'Confirmation pending','2'=>'Friendship confirmed','3'=>'Friendship rejected'));
		?>
		<?php echo $form->error($model,'status'); ?>
	</div>



	<div class="row">
		<?php echo $form->label($model,'friend_id'); ?>
		<?php echo $form->textField($model->invited,'username',array(
					'size'=>20,'maxlength'=>25,'readonly'=>'readonly')); ?>
		<?php echo $form->error($model,'friend_id'); ?>
	</div>

			<div class="row">
		<?php echo $form->label($model,'message'); ?>
		<?php echo $form->textArea($model,'message'); ?>
		<?php echo $form->error($model,'message'); ?>
	</div>
	

	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('App', 'Create') : Yii::t('App', 'Save')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
