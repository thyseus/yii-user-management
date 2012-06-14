<div class="form">

<? echo CHtml::beginForm(); ?>

	<p class="note"><? echo Yum::requiredFieldNote(); ?></p>

	<? echo CHtml::errorSummary($model); ?>
	
	<div class="row">
		<? echo CHtml::activeLabelEx($model,'varname'); ?>
		<? echo CHtml::activeTextField($model,'varname',array('size'=>60,'maxlength'=>50,$model->id!==null?'readonly':'')); ?>
		<? echo CHtml::error($model,'varname'); ?>
		<p class="hint"><? echo Yum::t('Allowed are lowercase letters and digits.'); ?></p>
	</div>

	<div class="row">
	<? echo CHtml::activeLabelEx($model,'title'); ?>
	<? echo CHtml::activeTextField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
	<? echo CHtml::error($model,'title'); ?>
		<p class="hint"><? echo Yum::t('Field name on the language of "sourceLanguage".'); ?></p>
	</div>
	
	<div class="row">
	<? echo CHtml::activeLabelEx($model,'hint'); ?>
	<? echo CHtml::activeTextField($model,'hint',array('size'=>60)); ?>
	<? echo CHtml::error($model,'hint'); ?>
		<p class="hint"><? echo Yum::t('Hint displayed to user e.g "You can enter more values and separate them using comma".'); ?></p>
	</div>	
	
	<div class="row">
		<? echo CHtml::activeLabelEx($model,'field_type'); ?>
		<? echo (($model->id)
				? CHtml::activeTextField($model,'field_type',array(
						'size'=>60,
						'maxlength'=>50,
						'readonly'=>true))
				: CHtml::activeDropDownList($model,
					'field_type',
					YumProfileField::itemAlias('field_type'))); ?>
		<? echo CHtml::error($model,'field_type'); ?>
		<p class="hint"><? echo Yum::t('Column field type in the database'); ?></p>
	</div>

	<div class="row">
		<? echo CHtml::activeLabelEx($model,'field_size'); ?>
		<? echo CHtml::activeTextField($model,'field_size',array($model->id!==null?'readonly':'')); ?>
		<? echo CHtml::error($model,'field_size'); ?>
		<p class="hint"><? echo Yum::t('Field size in the database.'); ?></p>
	</div>

	<div class="row">
		<? echo CHtml::activeLabelEx($model,'field_size_min'); ?>
		<? echo CHtml::activeTextField($model,'field_size_min'); ?>
		<? echo CHtml::error($model,'field_size_min'); ?>
		<p class="hint"><? echo Yum::t('The minimum value of the field (form validator).'); ?></p>
	</div>

	<div class="row">
		<? echo CHtml::activeLabelEx($model,'required'); ?>
		<? echo CHtml::activeDropDownList($model,'required',YumProfileField::itemAlias('required')); ?>
		<? echo CHtml::error($model,'required'); ?>
		<p class="hint"><? echo Yum::t('Required field (form validator).'); ?></p>
	</div>

	<div class="row">
		<? echo CHtml::activeLabelEx($model,'match'); ?>
		<? echo CHtml::activeTextField($model,'match',array('size'=>60,'maxlength'=>255)); ?>
		<? echo CHtml::error($model,'match'); ?>
		<p class="hint"><? echo Yum::t("Regular expression (example: '/^[A-Za-z0-9\s,]+$/u')."); ?></p>
	</div>

	<div class="row">
		<? echo CHtml::activeLabelEx($model,'range'); ?>
		<? echo CHtml::activeTextField($model,'range',array('size'=>60,'maxlength'=>255)); ?>
		<? echo CHtml::error($model,'range'); ?>
		<p class="hint"><? echo Yum::t('Predefined values (example: 1, 2, 3, 4, 5;).'); ?></p>
	</div>

	<div class="row">
		<? echo CHtml::activeLabelEx($model,'error_message'); ?>
		<? echo CHtml::activeTextField($model,'error_message',array('size'=>60,'maxlength'=>255)); ?>
		<? echo CHtml::error($model,'error_message'); ?>
		<p class="hint"><? echo Yum::t('Error message when validation fails.'); ?></p>
	</div>

	<div class="row">
		<? echo CHtml::activeLabelEx($model,'other_validator'); ?>
		<? echo CHtml::activeTextField($model,'other_validator',array('size'=>60,'maxlength'=>255)); ?>
		<? echo CHtml::error($model,'other_validator'); ?>
	</div>

	<div class="row">
		<? echo CHtml::activeLabelEx($model,'default'); ?>
		<? echo CHtml::activeTextField($model,'default',array('size'=>60,'maxlength'=>255,$model->id!==null?'readonly':''));?>
		<? echo CHtml::error($model,'default'); ?>
		<p class="hint"><? echo Yum::t('The value of the default field (database).'); ?></p>
	</div>

	<div class="row">
		<? echo CHtml::activeLabelEx($model,'position'); ?>
		<? echo CHtml::activeTextField($model,'position'); ?>
		<? echo CHtml::error($model,'position'); ?>
		<p class="hint"><? echo Yii::t("UserModule.user",'Display order of fields.'); ?></p>
	</div>

	<div class="row">
		<? echo CHtml::activeLabelEx($model,'visible'); ?>
		<? echo CHtml::activeDropDownList($model,'visible',YumProfileField::itemAlias('visible')); ?>
		<? echo CHtml::error($model,'visible'); ?>
	</div>

	<div class="row buttons">
	<? echo CHtml::submitButton($model->isNewRecord 
			? Yum::t('Create') 
			: Yum::t('Save')); ?>
	</div>

<? echo CHtml::endForm(); ?>

</div><!-- form -->
