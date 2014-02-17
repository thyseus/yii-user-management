<?php 
$this->title = Yum::t('Your message has been sent');
$this->breadcrumbs=array(
	Yum::t('Messages')=>array('index'),
	Yum::t('Success'));
?>

<p> <?php echo CHtml::link(Yum::t('Back to inbox'), array('index')); ?> </p> 
