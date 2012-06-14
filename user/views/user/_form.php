<div class="form">
<? 

$form = $this->beginWidget('CActiveForm', array(
			'id'=>'user-form',
			'enableAjaxValidation'=>false));
?>

<div class="note">
<? echo Yum::requiredFieldNote(); ?>

<?
$models = array($model, $passwordform);
if(isset($profile) && $profile !== false)
	$models[] = $profile;
	echo CHtml::errorSummary($models);
	?>
	</div>

<div style="float: right; margin: 10px;">
<div class="row">
<? echo $form->labelEx($model, 'superuser');
echo $form->dropDownList($model, 'superuser',YumUser::itemAlias('AdminStatus'));
echo $form->error($model, 'superuser'); ?>
</div>

<div class="row">
<? echo $form->labelEx($model,'status');
echo $form->dropDownList($model,'status',YumUser::itemAlias('UserStatus'));
echo $form->error($model,'status'); ?>
</div>
<? if(Yum::hasModule('role')) { 
	Yii::import('application.modules.role.models.*');
?>
<div class="row roles">
<p> <? echo Yum::t('User belongs to these roles'); ?> </p>

	<? $this->widget('YumModule.components.Relation', array(
				'model' => $model,
				'relation' => 'roles',
				'style' => 'dropdownlist',
				'fields' => 'title',
				'showAddButton' => false
				)); ?>
</div>
<? } ?>

</div>


<div class="row">
<? echo $form->labelEx($model, 'username');
echo $form->textField($model, 'username');
echo $form->error($model, 'username'); ?>
</div>


<div class="row">
<p> Leave password <em> empty </em> to 
<? echo $model->isNewRecord 
? 'generate a random Password' 
: 'keep it <em> unchanged </em>'; ?> </p>
<? $this->renderPartial('/user/passwordfields', array(
			'form'=>$passwordform)); ?>
</div>
<? if(Yum::hasModule('profile')) 
$this->renderPartial('application.modules.profile.views.profile._form', array(
			'profile' => $profile)); ?>

<div class="row buttons">
<? echo CHtml::submitButton($model->isNewRecord
			? Yum::t('Create')
			: Yum::t('Save')); ?>
</div>

<? $this->endWidget(); ?>
</div>
	<div style="clear:both;"></div>
