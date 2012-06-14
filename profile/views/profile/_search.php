<div class="wide form">

<? $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<? echo $form->label($model,'id'); ?>
		<? echo $form->textField($model,'id',array('size'=>25,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<? echo $form->label($model,'user_id'); ?>
		<? echo $form->textField($model,'user_id',array('size'=>25,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<? echo $form->label($model,'timestamp'); ?>
		<? echo $form->textField($model,'timestamp',array('size'=>25,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<? echo $form->label($model,'privacy'); ?>
		<? echo $form->textField($model,'privacy',array('size'=>25,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<? echo $form->label($model,'email'); ?>
		<? echo $form->textField($model,'email',array('size'=>25,'maxlength'=>255)); ?>
	</div>

	<div class="row buttons">
		<? echo CHtml::submitButton('Search'); ?>
	</div>

<? $this->endWidget(); ?>

</div><!-- search-form -->
