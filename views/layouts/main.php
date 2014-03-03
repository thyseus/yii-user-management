<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="language" content="en" />

  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/modules/user/assets/css/bootstrap.min.css" />

  <title>Yii User Management Demo Application></title>
</head>

<body>

<header class="jumbotron subhead">
    <div class="container">
        <h1>Yii User Management Module</h1>
    </div>
</header>

<div class="container">
  <div class="navbar">
    <div class="navbar-inner">
      <div class="container">
      <a class="btn btn-navbar" data-toggle="collapse" data-target="#yw1">
      <ul id="yw0" class="nav" role="menu">
      <li> <a tabindex="4" href="<?php echo $this->createUrl(''); ?>">Welcome</a> </li>
      <li> <a tabindex="1" href="<?php echo $this->createUrl('//user/install'); ?>">Installation</a> </li>
      <li> <a tabindex="2" href="<?php echo $this->createUrl('//user/auth/login'); ?>">Login</a></li>
      <li> <a tabindex="3" href="<?php echo $this->createUrl('//user/auth/logout'); ?>">Logout</a></li>
      </ul>
      </div>
    </div>
  </div>

  <?php echo $content; ?>

  <div class="clear"></div>

  <div id="footer">
    <?php echo Yii::powered(); ?>
  </div><!-- footer -->

</div><!-- page -->

</body>
</html>
