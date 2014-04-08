<?php
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

<?php

$this->pageTitle = Yum::t('Login');
$this->title = Yum::t('Login');
$this->breadcrumbs=array(Yum::t('Login'));

echo CHtml::beginForm(array('//user/auth/login'));
?>


<?php if($model->hasErrors()) { ?>
<div class="alert">
<?php echo CHtml::errorSummary($model); ?>
</div>
<?php } ?>

<div class="row-fluid">
<div class="span5 loginform">
<p> <?php echo Yum::t(
  'Please fill out the following form with your login credentials:'); ?> </p>


<?php
  printf ('<label for="YumUserLogin_username">%s: <span class="required">*</span></label>', Yum::t('Login as'));
?>

<?php echo CHtml::activeDropDownList($model,
  'username', CHtml::listData(
    YumUser::model()->findAll(
      'status > 0'), 'username', 'username'));

printf ('<p class="hint">%s</p>', Yum::t('No password necessary since debug mode is active'));
?>
</div>
</div>

<?php if(Yum::module()->loginType & UserModule::LOGIN_BY_HYBRIDAUTH
&& Yum::module()->hybridAuthProviders) { ?>
<div class="row-fluid">
  <div class="span5 hybridauth">
<?php echo Yum::t('You can also login by') . ': <br />';
foreach(Yum::module()->hybridAuthProviders as $provider)
  echo CHtml::link(
    CHtml::image(
      Yii::app()->getAssetManager()->publish(
        Yii::getPathOfAlias(
          'user.assets.images').'/'.strtolower($provider).'.png'),
      $provider) . $provider, $this->createUrl(
        '//user/auth/login', array('hybridauth' => $provider)), array(
          'class' => 'social')) . '<br />'; 
?>
</div>
</div>
<?php } ?>
<div class="row-fluid">
<div class="span12">

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

</div>
</div>

<div class="row-fluid">
<div class="span3">
<div class="buttons">

<p><?php echo CHtml::submitButton(Yum::t('Login'), array('class' => 'btn')); ?> </p>

</div>

<div class="alert alert-error">
	Click <?   echo CHtml::link(Yum::t("Registration"),
    Yum::module('registration')->registrationUrl); ?> if you are not registered.

</div>


</div>
</div>
</div>

<?php echo CHtml::endForm(); ?>

