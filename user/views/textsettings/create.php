<?
$this->breadcrumbs=array(
	Yum::t('Yum Text Settings')=>array(Yii::t('app', 'index')),
	Yum::t('Create'),
);
?>

<h1> <? echo Yum::t('New text Configuration'); ?></h1>
<div class="form">

<? $form=$this->beginWidget('CActiveForm', array(
	'id'=>'yum-text-settings-form',
	'enableAjaxValidation'=>true,
)); 

echo $this->renderPartial('/settings/_form', array(
	'model'=>$model,
	'form' =>$form
	)); ?>

<div class="row buttons">
	<?
	$url = array(Yii::app()->request->getQuery('returnTo'));
	if(empty($url[0])) 
		$url = array('/textsettings/admin');
echo CHtml::Button(Yii::t('app', 'Cancel'), array('submit' => $url)); ?>&nbsp;
<? echo CHtml::submitButton(Yii::t('app', 'Create')); ?>
</div>

<? $this->endWidget(); ?>

</div>
