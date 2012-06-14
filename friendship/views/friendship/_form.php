<div class="form">

<? $form=$this->beginWidget('CActiveForm', array(
	'id'=>'groups-form',
	'enableAjaxValidation'=>false,
)); ?>



	<? echo $form->errorSummary($model); ?>

	<div class="row">
	<? echo $form->label($model,'inviter_id'); ?>
	<? echo $form->textField($model->inviter,'username',array(
				'size'=>20,'maxlength'=>25,'readonly'=>'readonly')); ?>
		<? echo $form->error($model,'inviter_id'); ?>
	</div>

	<div class="row">
		<? echo $form->label($model,'status'); ?>
		<? 
		echo CHtml::activeDropDownList($model,
		'status',array('0'=>'No friendship requested','1'=>'Confirmation pending','2'=>'Friendship confirmed','3'=>'Friendship rejected'));
		?>
		<? echo $form->error($model,'status'); ?>
	</div>



	<div class="row">
		<? echo $form->label($model,'friend_id'); ?>
		<? echo $form->textField($model->invited,'username',array(
					'size'=>20,'maxlength'=>25,'readonly'=>'readonly')); ?>
		<? echo $form->error($model,'friend_id'); ?>
	</div>

			<div class="row">
		<? echo $form->label($model,'message'); ?>
		<? echo $form->textArea($model,'message'); ?>
		<? echo $form->error($model,'message'); ?>
	</div>
	

	
	<div class="row buttons">
		<? echo CHtml::submitButton($model->isNewRecord ? Yii::t('App', 'Create') : Yii::t('App', 'Save')); ?>
	</div>

<? $this->endWidget(); ?>

</div><!-- form -->
