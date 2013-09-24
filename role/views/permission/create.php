<div class="container">
<div class="span12">
<div class="row">

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'permission-create-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
	<label> <?php echo Yum::t('Do you want to grant this permission to a user or a role'); ?> </label>
	<?php echo $form->radioButtonList($model, 'type', array(
				'user' => Yum::t('User'),
				'role' => Yum::t('Role')),
			array('template' => '<div class="checkbox">{input}</div>{label}'
				)); ?>
			<?php echo $form->error($model,'type'); ?>
	</div>

	<div id="assignment_user">
	<div class="row">
	<?php echo $form->labelEx($model,'principal_id'); ?>
	<?php $this->widget('Relation', array(
				'model' => $model,
				'relation' => 'principal',
				'fields' => 'username',
				));?>
		<?php echo $form->error($model,'principal_id'); ?>

		<?php echo $form->labelEx($model,'subordinate_id'); ?>
		<?php $this->widget('Relation', array(
					'model' => $model,
					'allowEmpty' => true,
					'relation' => 'subordinate',
					'fields' => 'username',
					));?>

		<?php echo $form->error($model,'subordinate_id'); ?>
		</div>
	<div class="row">
		<?php echo $form->labelEx($model,'template'); ?>
		<?php echo $form->dropDownList($model,'template', array(
					'0' => Yum::t('No'),
					'1' => Yum::t('Yes'),
					)); ?>
		<?php echo $form->error($model,'template'); ?>
	</div>

		</div>

	<div id="assignment_role" style="display: none;">
	<div class="row">
	<?php echo $form->labelEx($model,'principal_id'); ?>
	<?php $this->widget('Relation', array(
				'model' => $model,
				'relation' => 'principal_role',
				'fields' => 'title',
				));?>
		<?php echo $form->error($model,'principal_id'); ?>

		<?php echo $form->labelEx($model,'subordinate_id'); ?>
		<?php $this->widget('Relation', array(
					'model' => $model,
					'allowEmpty' => true,
					'relation' => 'subordinate_role',
					'fields' => 'title',
					));?>

		<?php echo $form->error($model,'subordinate_id'); ?>
		</div>
		</div>



	<div class="row">
		<?php echo $form->labelEx($model,'action'); ?>
		<?php $this->widget('Relation', array(
					'model' => $model,
					'relation' => 'Action',
					'fields' => 'title',
					));?>
		<?php echo $form->error($model,'action'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comment'); ?>
		<?php echo $form->textArea($model,'comment'); ?>
		<?php echo $form->error($model,'comment'); ?>
	</div>



	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

</div>
</div>
</div>
<?php Yii::app()->clientScript->registerScript('type', "
$('#YumPermission_type_0').click(function() {
$('#assignment_role').hide();
$('#assignment_user').show();});

$('#YumPermission_type_1').click(function() {
$('#assignment_role').show();
$('#assignment_user').hide();});

");
?>

