<?
$this->breadcrumbs=array(
		Yum::t('Privacysettings')=>array('index'),
		$model->user->username=>array(
			'//user/user/view','id'=>$model->user_id),
		Yum::t( 'Update'),
		);

$this->title = Yum::t('Privacy settings for {username}', array(
			'{username}' => $model->user->username));

?>
<div class="form">
<p class="note">
<? Yum::requiredFieldNote(); ?>
</p>

<? $form=$this->beginWidget('CActiveForm', array(
			'id'=>'privacysetting-form',
			'enableAjaxValidation'=>true,
			)); 
echo $form->errorSummary($model);
?>

<div class="profile_field_selection">
<?
echo '<h3>' . Yum::t('Profile field public options') . '</h3>';
echo '<p>' . Yum::t('Select the fields that should be public') . ':</p>';
$i = 1;

$counter=0;

foreach(YumProfileField::model()->findAll() as $field) {
	$counter++;
	if ($counter==1)echo '<div class="float-left" style="width: 175px;">';
	
	printf('<div>%s<label class="profilefieldlabel" for="privacy_for_field_%d">%s</label></div>',
			CHtml::checkBox("privacy_for_field_{$i}",
				$model->public_profile_fields & $i),
			$i,
			Yum::t($field->title)
			
			);
	$i *= 2;
	
	if ($counter%4==0) echo '</div><div class="float-left" style="width: 175px;">';
}
if ($counter%4!=0) echo '</div>';
echo '<div class="clear"></div>';
?>
</div>


<? if(Yum::hasModule('friendship')) { ?>
<div class="row">
<? echo $form->labelEx($model,'message_new_friendship'); ?>
<? echo $form->dropDownList($model, 'message_new_friendship', array(
			0 => Yum::t('No'),
			1 => Yum::t('Yes'))); ?>
<? echo $form->error($model,'message_new_friendship'); ?>
</div>
<? } ?>

<div class="row">
<? echo $form->labelEx($model,'message_new_message'); ?>
<? echo $form->dropDownList($model, 'message_new_message', array(
			0 => Yum::t('No'),
			1 => Yum::t('Yes'))); ?>

<? echo $form->error($model,'message_new_message'); ?>
</div>

		<? if(Yum::module('profile')->enableProfileComments) { ?>

				<div class="row">
				<? 
				echo CHtml::activeLabelEx($profile, 'allow_comments'); 
			echo CHtml::activeDropDownList($profile, 'allow_comments',
					array(
						'0' => Yum::t( 'No'),
						'1' => Yum::t( 'Yes'),
						)
					);
			?>
				</div>

			<div class="row message_new_profilecomment">
				<? echo $form->labelEx($model,'message_new_profilecomment'); ?>
				<? echo $form->dropDownList($model, 'message_new_profilecomment', array(
							0 => Yum::t('No'),
							1 => Yum::t('Yes'))); ?>
				<? echo $form->error($model,'message_new_profilecomment'); ?>
				</div>

				<? } ?>


<? if(Yum::hasModule('friendship')) { ?>
	<div class="row">
	<? 
	echo CHtml::activeLabelEx($profile, 'show_friends'); 
	echo CHtml::activeDropDownList($profile, 'show_friends',
			array(
				'0' => Yum::t( 'do not make my friends public'),
				'2' => Yum::t( 'make my friends public'),
				)
			);
	?>
	</div>
<? } ?>

<? if(Yum::module()->enableOnlineStatus) { ?>
	<div class="row">
	<? 
	echo CHtml::activeLabelEx($model, 'show_online_status'); 
	echo CHtml::activeDropDownList($model, 'show_online_status',
			array(
				'0' => Yum::t( 'Do not show my online status'),
				'1' => Yum::t( 'Show my online status to everyone'),
				)
			);
	?>
	</div>
<? } ?>

	<div class="row">
	<? 
	echo CHtml::activeLabelEx($model, 'log_profile_visits'); 
	echo CHtml::activeDropDownList($model, 'log_profile_visits',
			array(
				'0' => Yum::t( 'Do not show the owner of a profile when i visit him'),
				'1' => Yum::t( 'Show the owner when i visit his profile'),
				)
			);
	?>
	</div>

<? if(Yum::hasModule('role')) { ?>
	<div class="row">
	<? 
	echo CHtml::activeLabelEx($model, 'appear_in_search'); 
	echo CHtml::activeDropDownList($model, 'appear_in_search',
			array(
				'0' => Yum::t( 'Do not appear in search'),
				'1' => Yum::t( 'Appear in search'),
				)
			);
	?>
	</div>
<? } ?>

<div class="row">
<? echo $form->labelEx($model,'ignore_users'); ?>
<? echo $form->textField($model, 'ignore_users',  array('size' => 100)); ?>
<? echo $form->error($model,'ignore_users'); ?>
<div class="hint">
<p> <? echo Yum::t('Separate usernames with comma to ignore specified users'); ?> </p>
</div>
</div>

<?
echo CHtml::Button(Yum::t( 'Cancel'), array(
			'submit' => array('//profile/profile/view')));
echo CHtml::submitButton(Yum::t('Save')); 
$this->endWidget(); ?>
</div> <!-- form -->


<? Yii::app()->clientScript->registerScript('profile_toggle', "
	if($('#YumProfile_allow_comments').val() == '0')
	$('.message_new_profilecomment').hide();

	$('#YumProfile_allow_comments').change(function () {
	if($(this).val() == '0')
	$('.message_new_profilecomment').hide(500);
	if($(this).val() == '1')
	$('.message_new_profilecomment').show(500);
});
");
?>
