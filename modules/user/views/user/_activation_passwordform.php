<?php echo CHtml::beginForm() ?>

<?php echo CHtml::errorSummary($form); ?>
<?php echo CHtml::hiddenField('email', $email); ?>
<?php echo CHtml::hiddenField('activationKey', $key); ?>
<?php echo CHtml::activeLabelEx($form,'password'); ?>
<?php echo CHtml::activePasswordField($form,'password'); ?>
<?php echo CHtml::activeLabelEx($form,'verifyPassword'); ?>
<?php echo CHtml::activePasswordField($form,'verifyPassword'); ?>
<?php echo CHtml::submitButton() ?>

<?php echo CHtml::endForm() ?>