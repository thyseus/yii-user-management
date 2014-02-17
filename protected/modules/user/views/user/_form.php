<div class="span12">
<div class="form">
<?php 
$form = $this->beginWidget('CActiveForm', array(
			'id'=>'user-form',
			'enableAjaxValidation'=>false,
			'enableClientValidation'=>true,
));
?>

<?php
// If errors occured, display errors for all involved models
$models = array($user, $passwordform);
if(isset($profile) && $profile !== false)
	$models[] = $profile;
	$hasErrors = false;
	foreach($models as $m)
if($m->hasErrors())
	$hasErrors = true;
	if($hasErrors) {
		echo '<div class="alert alert-error">';
		echo CHtml::errorSummary($models);
		echo '</div>';
	}
	?>

<?php echo Yum::requiredFieldNote(); ?>
<div class="span5">

<div class="row">
<?php echo $form->labelEx($user, 'username');
echo $form->textField($user, 'username');
echo $form->error($user, 'username'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($user,'status');
echo $form->dropDownList($user,'status',YumUser::itemAlias('UserStatus'));
echo $form->error($user,'status'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($user, 'superuser');
echo $form->dropDownList($user, 'superuser',YumUser::itemAlias('AdminStatus'));
echo $form->error($user, 'superuser'); ?>
</div>

<p> Leave password <em> empty </em> to 
<?php echo $user->isNewRecord 
? 'generate a random Password' 
: 'keep it <em> unchanged </em>'; ?> </p>
<?php $this->renderPartial('/user/passwordfields', array(
			'form'=>$passwordform)); ?>

<?php if(Yum::hasModule('role')) { 
	Yii::import('application.modules.role.models.*');
?>
<div class="row roles">
<label> <?php echo Yum::t('User belongs to these roles'); ?> </label>

<?php $this->widget('YumModule.components.select2.ESelect2', array(
				'model' => $user,
				'attribute' => 'roles',
				'htmlOptions' => array(
					'multiple' => 'multiple',
					'style' => 'width:220px;'),
				'data' => CHtml::listData(YumRole::model()->findAll(), 'id', 'title'),
				)); ?>
</div>
<?php } ?>

</div>

<div class="span6">
<?php if(Yum::hasModule('profile')) 
$this->renderPartial(Yum::module('profile')->profileFormView, array(
			'profile' => $profile)); ?>
</div>

<div class="clearfix"></div>

<div class="row buttons">
<?php echo CHtml::submitButton($user->isNewRecord
			? Yum::t('Create')
			: Yum::t('Save')); ?>
</div>

<?php $this->endWidget(); ?>
</div>
</div>
<div class="clearfix"></div>
