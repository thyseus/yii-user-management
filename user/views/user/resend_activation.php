<? 
$this->pageTitle=Yii::t("UserModule.user", "Activate");

$this->breadcrumbs=array(
	Yum::t('Login') => array('//user/user/login'),
	Yum::t('Activate'));

$this->title = Yum::t('Activate'); 
?>

<? 
if(Yii::app()->user->hasFlash('registration'))
{ 
?>
<div class="success">
<? echo Yii::app()->user->getFlash('registration'); ?>
</div>
<? 
}
?>

<? if($activateFromWeb): ?>
<div class="form">
<? echo CHtml::beginForm(array('registration/activation'),'GET',array()); ?> 

<div id="activatiion_code">
<div class="row">
<? echo Yii::t("UserModule.user", "Enter the activation code you received below."); ?>
</div>
<div class="row">
<? if(isset($form->email)){ 
echo CHtml::hiddenField('email',$form->email);  
 }else{ 
	echo CHtml::activeLabelEx($user,'email');
	echo CHtml::textField('email',$form->email);
		}
?>

<? echo CHtml::activeLabelEx($user,'activationkey'); ?>
<? echo CHtml::textField('activationkey'); //fixme ?> 
</div>
<div class="row_submit">
<? echo CHtml::submitButton(Yii::t("UserModule.user", "Activate")); ?>
</div>
</div>
<? echo CHtml::endForm(); ?>
</div> <!--form -->
<? endif;?>

<? echo $this->renderPartial('/user/_resend_activation_partial', array('user'=>$user,'form'=>$form)); ?>
