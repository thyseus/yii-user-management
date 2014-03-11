<?php $this->pageTitle=Yii::app()->name; ?>

<header class="jumbotron subhead">
    <div class="container">
        <h2>Yii User Management Module</h1>
    </div>
</header>

<p> This is the <?php echo CHtml::link( 'Yii User Management',
  'https://github.com/thyseus/yii-user-management'); ?> Demo Application. </p>

<p> <?php echo CHtml::link('Start the Installation', array('//user/install')); ?>.

<p> Also see: </p>

<ul>
<li> <a href="<?php echo Yii::app()->baseUrl; ?>/README.md">Yum README.md file</a> </li>
<li> <a href="http://www.yiiframework.com/doc/">Yii documentation</a> </li>
<li> <a href="http://www.yiiframework.com/forum/">Yii forum</a> </li>
<li> <a href="http://www.github.com/thyseus/yii-user-management">Yum on github</a> </li>
</ul>
