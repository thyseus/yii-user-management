<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="language" content="en" />

  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />

  <title>Yii User Management Demo Application></title>
</head>

<body>

<div class="container" id="page">

  <div id="header">
    <div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
  </div><!-- header -->

  <div id="mainmenu">
<?php $this->widget('zii.widgets.CMenu',array(
  'items'=>array(
    array('label'=>'Demo Application', 'url'=>array('/site/index')),
    array('label'=>'Login', 'url'=>array('//user/auth/login'), 'visible'=>Yii::app()->user->isGuest),
    array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('//user/auth/logout'), 'visible'=>!Yii::app()->user->isGuest)
  ),
)); ?>
  </div><!-- mainmenu -->
  <?php if(isset($this->breadcrumbs)):?>
<?php $this->widget('zii.widgets.CBreadcrumbs', array(
  'links'=>$this->breadcrumbs,
)); ?><!-- breadcrumbs -->
  <?php endif?>

  <?php echo $content; ?>

  <div class="clear"></div>

  <div id="footer">
    <?php echo Yii::powered(); ?>
  </div><!-- footer -->

</div><!-- page -->

</body>
</html>
