<div class="form">

<?php echo CHtml::beginForm(); ?>

<?php echo Yum::requiredFieldNote(); ?>

<?php echo CHtml::errorSummary($model); ?>

<div class="row">
<?php echo CHtml::activeLabelEx($model,'title'); ?>
<?php echo CHtml::activeTextField($model,'title',array('size'=>20,'maxlength'=>20)); ?>
<?php echo CHtml::error($model,'title'); ?>
</div>

<div class="row">
<?php echo CHtml::activeLabelEx($model,'description'); ?>
<?php echo CHtml::activeTextArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
<?php echo CHtml::error($model,'description'); ?>
</div>	


<?php if(Yum::hasModule('membership')) { ?>
<div class="row">
<?php echo CHtml::activeLabelEx($model,'membership_priority'); ?>
<?php echo CHtml::activeTextField($model, 'membership_priority'); ?>
<div class="hint">
<?php echo Yum::t('Leave empty or set to 0 to disable membership for this role.'); ?>
<?php echo Yum::t('Set to >0 to enable membership for this role and set a priority.'); ?>
<?php echo Yum::t('Higher is usually more worthy. This is used to determine downgrade possibilities.'); ?>
</div>
</div>
<div class="row">
<?php echo CHtml::activeLabelEx($model,'price'); ?>
<?php echo CHtml::activeTextField($model, 'price'); ?>
<?php echo CHtml::Error($model, 'price'); ?>
</div>
<div class="hint"> 
<?php echo Yum::t('How expensive is a membership? Set to 0 to disable membership for this role'); ?>
</div>

<div class="row">
<?php echo CHtml::activeLabelEx($model,'duration'); ?>
<?php echo CHtml::activeTextField($model, 'duration'); ?>
<?php echo CHtml::Error($model, 'duration'); ?>
</div>
<div class="hint"> 
<?php echo Yum::t('How many days will the membership be valid after payment?'); ?>

</div>
<div style="clear: both;"> </div>
<?php } ?>

<div class="row buttons">
<?php echo CHtml::submitButton($model->isNewRecord 
		? Yum::t('Create role') 
		: Yum::t('Save role')); ?>
</div>

<?php echo CHtml::endForm(); ?>
</div><!-- form -->

