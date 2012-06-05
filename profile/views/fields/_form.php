<div class="form">

<?php echo CHtml::beginForm(); ?>

	<p class="note"><?php echo Yum::requiredFieldNote(); ?></p>

	<?php echo CHtml::errorSummary($model); ?>
	
	<div class="row">
		<?php echo CHtml::activeLabelEx($model,'varname'); ?>
		<?php echo CHtml::activeTextField($model,'varname',array('size'=>60,'maxlength'=>50,$model->id!==null?'readonly':'')); ?>
		<?php echo CHtml::error($model,'varname'); ?>
		<p class="hint"><?php echo Yum::t('Allowed are lowercase letters and digits.'); ?></p>
	</div>

	<div class="row">
	<?php echo CHtml::activeLabelEx($model,'title'); ?>
	<?php echo CHtml::activeTextField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
	<?php echo CHtml::error($model,'title'); ?>
		<p class="hint"><?php echo Yum::t('Field name on the language of "sourceLanguage".'); ?></p>
	</div>
	
	<div class="row">
	<?php echo CHtml::activeLabelEx($model,'hint'); ?>
	<?php echo CHtml::activeTextField($model,'hint',array('size'=>60)); ?>
	<?php echo CHtml::error($model,'hint'); ?>
		<p class="hint"><?php echo Yum::t('Hint displayed to user e.g "You can enter more values and separate them using comma".'); ?></p>
	</div>	
	
	<div class="row">
		<?php echo CHtml::activeLabelEx($model,'field_type'); ?>
		<?php echo (($model->id)
				? CHtml::activeTextField($model,'field_type',array(
						'size'=>60,
						'maxlength'=>50,
						'readonly'=>true))
				: CHtml::activeDropDownList($model,
					'field_type',
					YumProfileField::itemAlias('field_type'))); ?>
		<?php echo CHtml::error($model,'field_type'); ?>
		<p class="hint"><?php echo Yum::t('Column field type in the database'); ?></p>
	</div>

	<div class="row">
		<?php echo CHtml::activeLabelEx($model,'field_size'); ?>
		<?php echo CHtml::activeTextField($model,'field_size',array($model->id!==null?'readonly':'')); ?>
		<?php echo CHtml::error($model,'field_size'); ?>
		<p class="hint"><?php echo Yum::t('Field size in the database.'); ?></p>
	</div>

	<div class="row">
		<?php echo CHtml::activeLabelEx($model,'field_size_min'); ?>
		<?php echo CHtml::activeTextField($model,'field_size_min'); ?>
		<?php echo CHtml::error($model,'field_size_min'); ?>
		<p class="hint"><?php echo Yum::t('The minimum value of the field (form validator).'); ?></p>
	</div>

	<div class="row">
		<?php echo CHtml::activeLabelEx($model,'required'); ?>
		<?php echo CHtml::activeDropDownList($model,'required',YumProfileField::itemAlias('required')); ?>
		<?php echo CHtml::error($model,'required'); ?>
		<p class="hint"><?php echo Yum::t('Required field (form validator).'); ?></p>
	</div>

	<div class="row">
		<?php echo CHtml::activeLabelEx($model,'match'); ?>
		<?php echo CHtml::activeTextField($model,'match',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo CHtml::error($model,'match'); ?>
		<p class="hint"><?php echo Yum::t("Regular expression (example: '/^[A-Za-z0-9\s,]+$/u')."); ?></p>
	</div>

	<div class="row">
		<?php echo CHtml::activeLabelEx($model,'range'); ?>
		<?php echo CHtml::activeTextField($model,'range',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo CHtml::error($model,'range'); ?>
		<p class="hint"><?php echo Yum::t('Predefined values (example: 1, 2, 3, 4, 5;).'); ?></p>
	</div>

	<div class="row">
		<?php echo CHtml::activeLabelEx($model,'error_message'); ?>
		<?php echo CHtml::activeTextField($model,'error_message',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo CHtml::error($model,'error_message'); ?>
		<p class="hint"><?php echo Yum::t('Error message when validation fails.'); ?></p>
	</div>

	<div class="row">
		<?php echo CHtml::activeLabelEx($model,'other_validator'); ?>
		<?php echo CHtml::activeTextField($model,'other_validator',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo CHtml::error($model,'other_validator'); ?>
	</div>

	<div class="row">
		<?php echo CHtml::activeLabelEx($model,'default'); ?>
		<?php echo CHtml::activeTextField($model,'default',array('size'=>60,'maxlength'=>255,$model->id!==null?'readonly':''));?>
		<?php echo CHtml::error($model,'default'); ?>
		<p class="hint"><?php echo Yum::t('The value of the default field (database).'); ?></p>
	</div>

	<div class="row">
		<?php echo CHtml::activeLabelEx($model,'position'); ?>
		<?php echo CHtml::activeTextField($model,'position'); ?>
		<?php echo CHtml::error($model,'position'); ?>
		<p class="hint"><?php echo Yii::t("UserModule.user",'Display order of fields.'); ?></p>
	</div>

	<div class="row">
		<?php echo CHtml::activeLabelEx($model,'visible'); ?>
		<?php echo CHtml::activeDropDownList($model,'visible',YumProfileField::itemAlias('visible')); ?>
		<?php echo CHtml::error($model,'visible'); ?>
	</div>

	<div class="row buttons">
	<?php echo CHtml::submitButton($model->isNewRecord 
			? Yum::t('Create') 
			: Yum::t('Save')); ?>
	</div>

<?php echo CHtml::endForm(); ?>

</div><!-- form -->
