<?php 
$this->pageTitle = Yum::t( "Profile");
$this->breadcrumbs=array(
		Yum::t('Edit profile'));
$this->title = Yum::t('Edit profile');
?>

<div class="form">

<?php $form=$this->beginWidget('zii.widgets.CActiveForm', array(
    'id'=>'profile-form',
)); ?>

<?php echo Yum::requiredFieldNote(); ?>

<?php echo $form->errorSummary(array($user, $profile)); ?>

<?php if(Yum::module()->loginType & UserModule::LOGIN_BY_USERNAME) { ?>

<?php echo $form->LabelEx($user,'username'); ?>
<?php echo $form->activeTextField($user,'username',array(
			'size'=>20,'maxlength'=>20)); ?>
<?php echo $form->error($user,'username'); ?>

<?php } ?> 

<?php if(isset($profile) && is_object($profile)) 
	$this->renderPartial('/profile/_form', array('profile' => $profile, 'form'=>$form)); ?>
	
	<?php

	if(Yum::module('profile')->enablePrivacySetting)
		echo CHtml::button(Yum::t('Privacy settings'), array(
					'submit' => array('/profile/privacy/update'))); ?>

	<?php 
		if(Yum::hasModule('avatar'))
			echo CHtml::button(Yum::t('Upload avatar Image'), array(
				'submit' => array('/avatar/avatar/editAvatar'), 'class'=>'btn')); ?>

	<?php echo CHtml::submitButton($user->isNewRecord 
			? Yum::t('Create my profile') 
			: Yum::t('Save profile changes'), array('class'=>'btn')); ?>


	<?php $this->endWidget(); ?>

	</div><!-- form -->
