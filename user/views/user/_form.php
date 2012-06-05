<div class="form">
<?php 

$form = $this->beginWidget('CActiveForm', array(
			'id'=>'user-form',
			'enableAjaxValidation'=>false));
?>

<div class="note">
<?php echo Yum::requiredFieldNote(); ?>

<?php
$models = array($model, $passwordform);
if(isset($profile) && $profile !== false)
	$models[] = $profile;
	echo CHtml::errorSummary($models);
	?>
	</div>

<div style="float: right; margin: 10px;">
<div class="row">
<?php echo $form->labelEx($model, 'superuser');
echo $form->dropDownList($model, 'superuser',YumUser::itemAlias('AdminStatus'));
echo $form->error($model, 'superuser'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'status');
echo $form->dropDownList($model,'status',YumUser::itemAlias('UserStatus'));
echo $form->error($model,'status'); ?>
</div>
<?php if(Yum::hasModule('role')) { 
	Yii::import('application.modules.role.models.*');
?>
<div class="row roles">
<p> <?php echo Yum::t('User belongs to these roles'); ?> </p>

	<?php $this->widget('YumModule.components.Relation', array(
				'model' => $model,
				'relation' => 'roles',
				'style' => 'dropdownlist',
				'fields' => 'title',
				'showAddButton' => false
				)); ?>
</div>
<?php } ?>

</div>


<div class="row">
<?php echo $form->labelEx($model, 'username');
echo $form->textField($model, 'username');
echo $form->error($model, 'username'); ?>
</div>


<div class="row">
<p> Leave password <em> empty </em> to 
<?php echo $model->isNewRecord 
? 'generate a random Password' 
: 'keep it <em> unchanged </em>'; ?> </p>
<?php $this->renderPartial('/user/passwordfields', array(
			'form'=>$passwordform)); ?>
</div>
<?php if(Yum::hasModule('profile')) 
$this->renderPartial('application.modules.profile.views.profile._form', array(
			'profile' => $profile)); ?>

<div class="row buttons">
<?php echo CHtml::submitButton($model->isNewRecord
			? Yum::t('Create')
			: Yum::t('Save')); ?>
</div>

<?php $this->endWidget(); ?>
</div>
	<div style="clear:both;"></div>
