<?php
$this->breadcrumbs=array(
	Yum::t('Yum Text Settings')=>array(Yii::t('app', 'index')),
	Yum::t('Create'),
);
?>

<h1> <?php echo Yum::t('New text Configuration'); ?></h1>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'yum-text-settings-form',
	'enableAjaxValidation'=>true,
)); 

echo $this->renderPartial('/settings/_form', array(
	'model'=>$model,
	'form' =>$form
	)); ?>

<div class="row buttons">
	<?php
	$url = array(Yii::app()->request->getQuery('returnTo'));
	if(empty($url[0])) 
		$url = array('/textsettings/admin');
echo CHtml::Button(Yii::t('app', 'Cancel'), array('submit' => $url)); ?>&nbsp;
<?php echo CHtml::submitButton(Yii::t('app', 'Create')); ?>
</div>

<?php $this->endWidget(); ?>

</div>
