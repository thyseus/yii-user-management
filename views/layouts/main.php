<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="language" content="en" />

  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/modules/user/assets/css/bootstrap.min.css" />

  <title>Yii User Management Demo Application></title>
</head>

<div class="navbar navbar-static-top">
    <div class="navbar-inner">
      <ul id="yw0" class="nav" role="menu">
      <?php if(Yii::app()->user->isGuest) { ?>
      <li> <a tabindex="4" href="<?php echo $this->createUrl(''); ?>">Welcome</a> </li>
      <li> <a tabindex="1" href="<?php echo $this->createUrl('//user/install'); ?>">Installation</a> </li>

      <?php if(Yii::app()->db->getSchema()->getTable('user')) { ?>
      <li> <a tabindex="2" href="<?php echo $this->createUrl('//registration/registration/registration'); ?>">Registration</a></li>
      <li> <a tabindex="2" href="<?php echo $this->createUrl('//registration/registration/recovery'); ?>">Password recovery</a></li>
      <li> <a tabindex="2" href="<?php echo $this->createUrl('//user/auth/login'); ?>">Login</a></li>
      <?php } ?>

      <?php } ?>
<?php if(!Yii::app()->user->isGuest) {  ?>
      <li> <?php echo CHtml::link(Yum::t('Stats'), array('//user/statistics/index')); ?> </li>
<ul class="nav">
<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown">
<?php echo Yum::t('Users'); ?><b class="caret"></b></a>
<ul class="dropdown-menu">
<li> <?php echo CHtml::link(Yum::t('Users'), array('//user/user/admin')); ?> </li>
<li> <?php echo CHtml::link(Yum::t('New User'), array('//user/user/create')); ?> </li>
</ul>
 </li>
</ul>
<ul class="nav">
<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown">
<?php echo Yum::t('Roles'); ?><b class="caret"></b></a>
<ul class="dropdown-menu">
<li> <?php echo CHtml::link(Yum::t('Roles'), array('//role/role/admin')); ?> </li>
<li> <?php echo CHtml::link(Yum::t('New Role'), array('//role/role/create')); ?> </li>
<li> <?php echo CHtml::link(Yum::t('New Action'), array('//role/action/create')); ?> </li>
<li> <?php echo CHtml::link(Yum::t('Grant Permission'), array('//role/permission/create')); ?> </li>
<li> <?php echo CHtml::link(Yum::t('Actions'), array('//role/action/admin')); ?> </li>
<li> <?php echo CHtml::link(Yum::t('Permission'), array('//role/permission/admin')); ?> </li>
</ul>
 </li>
</ul>
      <li> <?php echo CHtml::link(Yum::t('Profiles'), array('//profile/profile/admin')); ?> </li>
      <li> <?php echo CHtml::link(Yum::t('Avatars'), array('//avatar/avatar/admin')); ?> </li>
      <li> <?php echo CHtml::link(Yum::t('Visits'), array('//profile/profile/visits')); ?> </li>
      <li> <?php echo CHtml::link(Yum::t('Messages'), array('//message/message/index')); ?> </li>
      <li> <?php echo CHtml::link(Yum::t('Demo'), array('//user/user/generateData')); ?> </li>
      <li> <?php echo CHtml::link(Yum::t('I18n'), array('//user/translation/admin')); ?> </li>
      <li> <?php echo CHtml::link(Yum::t('Password'), array('//user/user/changePassword')); ?> </li>
      <li class="pull-right"> <?php echo CHtml::link(Yum::t('Logout'), array('//user/auth/logout')); ?> </li>
      <?php } ?>
      </ul>
      </div>
    </div>

<body class="container">

<div class="container">
  <?php echo $content; ?>
</div>

  <div class="clearfix"></div>

  <div id="footer">
    <?php echo Yum::powered(); ?> | <?php echo Yii::powered(); ?>
  </div>


</div>
<?php Yum::register('js/bootstrap.min.js'); ?>
</body>
</html>
