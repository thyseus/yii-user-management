<? echo CHtml::beginForm() ?>
<? echo CHtml::errorSummary($form); ?>
<div class="row">
<? echo CHtml::hiddenField('email', $email); ?>
<? echo CHtml::hiddenField('activationkey', $key); ?>
</div>

<div class="row">
<? echo CHtml::activeLabelEx($form,'password'); ?>
<? echo CHtml::activePasswordField($form,'password'); ?>
</div>

<div class="row">
<? echo CHtml::activeLabelEx($form,'verifyPassword'); ?>
<? echo CHtml::activePasswordField($form,'verifyPassword'); ?>
</div>

<div class="row">
<? echo CHtml::submitButton() ?>
</div>
<? echo CHtml::endForm() ?>

