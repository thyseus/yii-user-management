<div class="row buttons">
	<?
	if(isset($_GET['returnTo']))
		$url = array($_GET['returnTo']);
	if(!isset($url)) 
		$url = array('profilecomment/admin');
echo CHtml::Button(Yii::t('app', 'Cancel'), array('submit' => $url)); ?>&nbsp;
<? echo CHtml::submitButton(Yii::t('app', 'Create')); ?>
</div>


