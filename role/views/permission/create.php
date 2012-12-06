<?php
$this->title = Yum::t('Grant New Permissions');
$this->breadcrumbs=array(
		Yum::t('Permissions')=>array('index'),
		Yum::t('Grant'),
		);
?>
<div class="form">
<? $form=$this->beginWidget('CActiveForm', array(
	'id'=>'permission-create-form',
	'enableAjaxValidation'=>true,
)); ?>
	<p class="note">Fields with <span class="required">*</span> are required.</p>
	<? echo $form->errorSummary($model); ?>
	<div class="row">
	<label> <? echo Yum::t('Do you want to grant this permission to a user or a role'); ?> </label>
<br/>
	<? echo $form->radioButtonList($model, 'type', array(
				'user' => Yum::t('User'),
				'role' => Yum::t('Role')),
			array('template' => '<div class="checkbox">{input}</div>{label}'
				));
	   echo $form->error($model,'type');
	?>
	</div>
<br/>
	<div id="assignment_user">
	<div class="row">
	<? echo $form->labelEx($model,'principal_id');
	   $this->widget('Relation', array(
				'model' => $model,
				'relation' => 'principal',
				'fields' => 'username',
				));
		echo $form->error($model,'principal_id');
?>
	</div>
	<div class="row">
<?		echo $form->labelEx($model,'subordinate_id');
		$this->widget('Relation', array(
					'model' => $model,
					'allowEmpty' => true,
					'relation' => 'subordinate',
					'fields' => 'username',
					));

		 echo $form->error($model,'subordinate_id');
?>
	</div>
<br/>
	<div class="row">
		<? echo $form->labelEx($model,'template');
		   echo $form->dropDownList($model,'template', array(
					'0' => Yum::t('No'),
					'1' => Yum::t('Yes'),
					));
		   echo $form->error($model,'template');
		 ?>
	</div>
	</div> <!-- end assignment_user -->

	<div id="assignment_role" style="display: none;">
	<div class="row">
	<? echo $form->labelEx($model,'principal_id');
	   $this->widget('Relation', array(
				'model' => $model,
				'relation' => 'principal_role',
				'fields' => 'title',
				));
		echo $form->error($model,'principal_id');
?>
	</div>
	<div class="row">
<?		echo $form->labelEx($model,'subordinate_id');
		$this->widget('Relation', array(
					'model' => $model,
					'allowEmpty' => true,
					'relation' => 'subordinate_role',
					'fields' => 'title',
					));

		echo $form->error($model,'subordinate_id');
	?>
	</div>
	</div>  <!-- end assignment_user -->

<br/> <!-- common fields -->
	<div class="row">
		<? echo $form->labelEx($model,'action');
  		   $this->widget('Relation', array(
					'model' => $model,
					'relation' => 'Action',
					'fields' => 'title',
					));
		   echo $form->error($model,'action');
		?>
	</div>
	<div class="row">
		<? echo $form->labelEx($model,'comment');
		   echo $form->textArea($model,'comment');
		   echo $form->error($model,'comment');
		?>
	</div>
<br/>
	<div class="row buttons">
		<? echo CHtml::submitButton('Submit'); ?>
	</div>

<? $this->endWidget(); ?>
</div><!-- form -->
<? Yii::app()->clientScript->registerScript('type', "
$('#YumPermission_type_0').click(function() {
$('#assignment_role').hide();
$('#assignment_user').show();});

$('#YumPermission_type_1').click(function() {
$('#assignment_role').show();
$('#assignment_user').hide();});
");
