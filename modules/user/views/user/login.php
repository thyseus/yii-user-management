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


$this->pageTitle = Yum::t('Login');
$this->title = Yum::t('Login');
$this->breadcrumbs=array(Yum::t('Login'));

echo CHtml::beginForm(array('//user/auth/login'));

if(isset($_GET['action']))
  echo CHtml::hiddenField('returnUrl', urldecode($_GET['action']));
?>




<div class="row-fluid-fluid">

<?php if($model->hasErrors()) { ?>
<div class="alert">
	<?php echo CHtml::errorSummary($model); ?>
</div>
<?php } ?>


<div class="span6 loginform">
<p> <?php echo Yum::t(
  'Please fill out the following form with your login credentials:'); ?> </p>

<?php
  if(Yum::module()->loginType & UserModule::LOGIN_BY_USERNAME)
    echo CHtml::activeLabelEx($model,'username');
if(Yum::module()->loginType & UserModule::LOGIN_BY_EMAIL)
  printf ('<label for="YumUserLogin_username">%s <span class="required">*</span></label>', Yum::t('E-Mail address')); 
?>

    <?php echo CHtml::activeTextField($model,'username') ?>

    <?php echo CHtml::activeLabelEx($model,'password'); ?>
    <?php echo CHtml::activePasswordField($model,'password'); ?>


<?php if ($model->scenario == 'captcha' && CCaptcha::checkRequirements()) { ?>
    <?php echo CHtml::activeLabel($model, 'verifyCode'); ?>
    <?php $this->widget('CCaptcha'); ?>
    <?php echo CHtml::activeTextField($model, 'verifyCode'); ?>

    <?php echo CHtml::error($model, 'verifyCode'); ?>
<?php } ?>


</div>

<?php if(Yum::module()->loginType & UserModule::LOGIN_BY_HYBRIDAUTH 
&& Yum::module()->hybridAuthProviders) { ?>
  <div class="span6 hybridauth">
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
<p><?php echo CHtml::submitButton(Yum::t('Login'), array('class' => 'btn')); ?></p>
</div>
<div class="alert alert-danger"> You can register <?php echo CHtml::link('here', Yum::module('registration')->registrationUrl);?></div>
</div>
</div>

<?php echo CHtml::endForm(); ?>

