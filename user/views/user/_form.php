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
<div class="row">
<div class="span6">

<?php echo $form->labelEx($user, 'username');
echo $form->textField($user, 'username');
echo $form->error($user, 'username'); ?>

<?php echo $form->labelEx($user,'status');
echo $form->dropDownList($user,'status',YumUser::itemAlias('UserStatus'));
echo $form->error($user,'status'); ?>


<?php echo $form->labelEx($user, 'superuser');
echo $form->dropDownList($user, 'superuser',YumUser::itemAlias('AdminStatus'));
echo $form->error($user, 'superuser'); ?>


<p> Leave password <em> empty </em> to 
<?php echo $user->isNewRecord 
? 'generate a random Password' 
: 'keep it <em> unchanged </em>'; ?> </p>
<?php $this->renderPartial('/user/passwordfields', array(
			'form'=>$passwordform)); ?>

<?php if(Yum::hasModule('role')) { 
	Yii::import('user.role.models.*');
?>

<label> <?php echo Yum::t('User belongs to these roles'); ?> </label>

<?php $this->widget('user.components.select2.ESelect2', array(
				'model' => $user,
				'attribute' => 'roles',
				'htmlOptions' => array(
					'multiple' => 'multiple',
					'style' => 'width:220px;'),
				'data' => CHtml::listData(YumRole::model()->findAll(), 'id', 'title'),
				)); ?>
<?php } ?>

</div>

<div class="span6">
<?php if(Yum::hasModule('profile'))
$this->renderPartial(Yum::module('profile')->profileFormView, array(
  'form' => $form,
  'profile' => $profile)); ?>
</div>



<?php echo CHtml::submitButton($user->isNewRecord
			? Yum::t('Create')
			: Yum::t('Save')); ?>

</div>


<?php $this->endWidget(); ?>

