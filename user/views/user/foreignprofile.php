<?
$this->pageTitle=Yii::t('UserModule.user', "Profile");
$this->title = Yii::t('UserModule.user', 'Profile of ') . $model->username;
$this->breadcrumbs = array(Yii::t('UserModule.user', "Profile"), $model->username); 
?>

<? if(Yii::app()->user->hasFlash('profileMessage')): ?>
<div class="success">
<? echo Yii::app()->user->getFlash('profileMessage'); ?>
</div>
<? endif; ?>

<table class="dataGrid">
<tr>
	<th class="label"><? echo CHtml::encode($model->getAttributeLabel('username')); ?></th>
    <td><? echo CHtml::encode($model->username); ?>
</td>
</tr>
<? 
		$profileFields=YumProfileField::model()->forOwner()->sort()->findAll();
		if ($profileFields) {
			foreach($profileFields as $field) {
			?>
<tr>
	<th class="label"><? echo CHtml::encode(Yii::t('UserModule.user', $field->title)); ?></th>
    <td><? echo CHtml::encode($profile->getAttribute($field->varname)); ?>
</td>
</tr>
			<?
			}
		}
?>
<tr>
	<th class="label"><? echo CHtml::encode($model->getAttributeLabel('createTime')); ?></th>
    <td><? echo date(UserModule::$dateFormat,$model->createTime); ?>
</td>
</tr>
<tr>
	<th class="label"><? echo CHtml::encode($model->getAttributeLabel('lastVisit')); ?></th>
    <td><? echo date(UserModule::$dateFormat,$model->lastVisit); ?>
</td>
</tr>
</table>
