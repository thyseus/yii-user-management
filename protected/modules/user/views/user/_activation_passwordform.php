<?php echo CHtml::beginForm() ?>
<?php echo CHtml::errorSummary($form); ?>
<div class="row">
<?php echo CHtml::hiddenField('email', $email); ?>
<?php echo CHtml::hiddenField('activationKey', $key); ?>
</div>

<div class="row">
<?php echo CHtml::activeLabelEx($form,'password'); ?>
<?php echo CHtml::activePasswordField($form,'password'); ?>
</div>

<div class="row">
<?php echo CHtml::activeLabelEx($form,'verifyPassword'); ?>
<?php echo CHtml::activePasswordField($form,'verifyPassword'); ?>
</div>

<div class="row">
<?php echo CHtml::submitButton() ?>
</div>
<?php echo CHtml::endForm() ?>

