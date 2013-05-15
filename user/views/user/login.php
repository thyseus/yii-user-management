<?php
$this->pageTitle = Yum::t('Login');
$this->title = Yum::t('Login');
$this->breadcrumbs=array(Yum::t('Login'));

echo CHtml::beginForm(array('//user/auth/login'));  

if(isset($_GET['action']))
	echo CHtml::hiddenField('returnUrl', urldecode($_GET['action']));

?>

<div class="form">

<div class="alert">
<?php echo CHtml::errorSummary($model); ?>
</div>

<p> <?php echo Yum::t(
		'Please fill out the following form with your login credentials:'); ?> </p>

<div class="row">
	<?php 
if(Yum::module()->loginType & UserModule::LOGIN_BY_USERNAME)
	echo CHtml::activeLabelEx($model,'username'); 
if(Yum::module()->loginType & UserModule::LOGIN_BY_EMAIL)
	printf ('<label for="YumUserLogin_username">%s <span class="required">*</span></label>', Yum::t('E-Mail address')); 
	?>

		<?php echo CHtml::activeTextField($model,'username') ?>
</div>

<div class="row">
		<?php echo CHtml::activeLabelEx($model,'password'); ?>
		<?php echo CHtml::activePasswordField($model,'password'); ?>
</div>
		
	
	<p class="hint">
	<?php 
	if(Yum::hasModule('registration') && Yum::module('registration')->enableRegistration)
	echo CHtml::link(Yum::t("Registration"),
			Yum::module('registration')->registrationUrl);
	if(Yum::hasModule('registration') 
			&& Yum::module('registration')->enableRegistration
			&& Yum::module('registration')->enableRecovery)
	echo ' | ';
	if(Yum::hasModule('registration') 
			&& Yum::module('registration')->enableRecovery) 
	echo CHtml::link(Yum::t("Lost password?"),
			Yum::module('registration')->recoveryUrl);
	?>
</p>

<div class="buttons">
<?php echo CHtml::submitButton(Yum::t('Login'), array('class' => 'btn')); ?>
</div>

</div>

<?php echo CHtml::endForm(); ?>

<?
$form = new CForm(array(
			'elements'=>array(
				'username'=>array(
					'type'=>'text',
					'maxlength'=>32,
					),
				'password'=>array(
					'type'=>'password',
					'maxlength'=>32,
					),
				'rememberMe'=>array(
					'type'=>'checkbox',
					)
				),

			'buttons'=>array(
				'login'=>array(
					'type'=>'submit',
					'label'=>'Login',
					),
				),
			), $model);
?>

